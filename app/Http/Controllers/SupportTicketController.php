<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportTicket;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Log; 
use Mews\Purifier\Facades\Purifier;
use App\Models\SupportTicketAttachment;
use Illuminate\Support\Facades\Mail;
use App\Mail\SupportTicketNotification;
use App\Mail\TicketDoneMail;
use App\Mail\TicketClosedMail;
use App\Models\UserHasRole;
use App\Models\User;




class SupportTicketController extends Controller
{
    public function index()
    {
        try{
            $departmentEmails = [
                '1' => env('ADMIN_SUPPORT_EMAIL'),
                '2' => env('HR_SUPPORT_EMAIL'),
                '3' => env('IT_SUPPORT_EMAIL'),
            ];
            $role = UserHasRole::where('user_id', Auth::id())->first();


            $query = SupportTicket::with(['user', 'department']);

            if ($role->role_id === User::ADMIN) {
                $tickets = $query->orderByDesc('created_at')->get();
            } else {
                $user = Auth::user();
                $accessibleDeptIds = collect($departmentEmails)
                    ->filter(fn($email) => $email === $user->email)
                    ->keys()
                    ->toArray();

                $tickets = $query->where(function ($q) use ($user, $accessibleDeptIds) {
                    $q->where('user_id', $user->id);

                    if (!empty($accessibleDeptIds)) {
                        $q->orWhereIn('department_id', $accessibleDeptIds);
                    }
                })
                ->orderByDesc('created_at')
                ->get();
            }
            return view('support_tickets.index', compact('tickets'));
        }catch(\Exception $e){
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('support_tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'department_id' => 'required|string',
                'issue_category_id' => 'required|string',
                'issue_type' => 'required|string',
                'description' => 'required|string',
                'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xlsx,xls|max:5120',
                'newCategoryName' => 'nullable|string',
                'newTypeName' => 'nullable|string',
                'reason'=>'nullable|string'
            ]);


            $uuid = substr(md5(uniqid()), 0, 8);
            $lastTicket = SupportTicket::orderByDesc('id')->first();
            $nextId = $lastTicket ? $lastTicket->id + 1 : 1;
            $ticketNo = 'STK' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

            $ticket = new SupportTicket();
            $ticket->uuid = $uuid;
            $ticket->ticket_no = $ticketNo;
            $ticket->department_id = $validated['department_id'];
            $ticket->description = $validated['description'];
            $ticket->user_id = Auth::id();
            $ticket->status = '0';

            if (str_starts_with($validated['issue_category_id'], 'temp-cat-')) {
                $ticket->temp_issue_cat = $validated['newCategoryName'];
                $ticket->issue_category_id = null; 
            } else {
                $ticket->issue_category_id = $validated['issue_category_id'];
            }

            if (str_starts_with($validated['issue_type'], 'temp-type-')) {
                $ticket->temp_issue_type = $validated['newTypeName'];
                $ticket->issue_type_id = null; 
            } else {
                $ticket->issue_type_id = $validated['issue_type'];
            }

            $ticket->save();

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $filename = $file->getClientOriginalName();
                    $path = $file->storeAs("support_tickets/{$uuid}", $filename,'public');
                    $fullPath = storage_path('app/public/'.$path);
                
                    SupportTicketAttachment::create([
                        'support_ticket_id' => $ticket->id,
                        'file_path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                        'file_size' => $file->getSize(),
                        'mime_type' => $file->getMimeType()
                    ]);
                }
            }
            $departmentEmails = [
                '1' => env('ADMIN_SUPPORT_EMAIL'),
                '2' => env('HR_SUPPORT_EMAIL'),
                '3' => env('IT_SUPPORT_EMAIL'),
            ];

            $recipientEmail = $departmentEmails[$request->department_id] ?? env('HR_SUPPORT_EMAIL');
            $ticket->load(['issueCategory', 'issueType', 'department', 'user', 'attachments']);

            Mail::to($recipientEmail)
            ->cc($departmentEmails[1])
            ->send(new SupportTicketNotification($ticket));

            return redirect()->route('support_tickets.index')->with('success', 'Support ticket created successfully.');
        }catch(\Exception $e){
                return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = SupportTicket::with(['user','issueCategory','issueType','attachments'])->findOrFail($id);

        return view('support_tickets.show', ['ticket' => $ticket]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $ticket = SupportTicket::findOrFail($id);

            if ($request->has('action')) {
                switch ($request->action) {
                    case 'close':
                        $ticket->status ='3';
                        break;
                    case 'done':
                        $ticket->status = '2';
                        break;
                }

                $ticket->reason = $request->reason;
                $ticket->save();

                $departmentEmails = [
                '1' => env('ADMIN_SUPPORT_EMAIL'),
                '2' => env('HR_SUPPORT_EMAIL'),
                '3' => env('IT_SUPPORT_EMAIL'),
                ];
                if ($request->action === 'close')
                    {
                        $recipientEmail = $departmentEmails[$ticket->department_id] ?? env('DEFAULT_DEPARTMENT_EMAIL');
                        Mail::to($recipientEmail)
                        ->send(new TicketClosedMail($ticket));
                    }

                if ($request->action === 'done') 
                    {
                        Mail::to($ticket->user->email)
                        ->send(new TicketDoneMail($ticket));
                    }

                return response()->json(['message' => 'Ticket updated successfully.']);
            }
        } catch(\Exception $e){
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
