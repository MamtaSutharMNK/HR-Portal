<?php

namespace App\Http\Controllers;

use App\Mail\FteRequestMail;
use Illuminate\Http\Request;
use App\Models\RequestForm;
use App\Models\JobDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;
use App\Models\User;
use App\Models\Department;
use App\Models\RequestingBranch;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RequestFormRequest;
use App\Models\UserHasRole;
use App\Mail\FteRejectionMail;
use App\Models\ActionLog;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Mail\FteUserNotificationMail;
use App\Mail\FteUserNotificationRejectMail;
use App\Mail\PositionFilledMail;
use App\Mail\PositionStatusMail;




class FteRequestFormController extends Controller
{
       /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $viewType = $request->query('view');
            $role = UserHasRole::where('user_id', Auth::id())->first();
            $departments = Department::where('status', 1)->get();

            $userEmail = Auth::user()->email;

            if ($viewType === 'manager') {
                $query = RequestForm::query();

                if ($role->role_id !== User::ADMIN) {
                    $query->where(function ($q) use ($userEmail) {

                        $q->orWhere(function ($sub) use ($userEmail) {
                            $sub->where('manager_email_l1', $userEmail)
                                ->whereIn('mail_status', [RequestForm::MAIL_PENDING,RequestForm::LEVEL1_MAIL_APPROVAL,RequestForm::LEVEL2_MAIL_APPROVAL]);
                        });

                        $q->orWhere(function ($sub) use ($userEmail) {
                            $sub->where('manager_email_l2', $userEmail)
                                ->whereIn('mail_status', [RequestForm::LEVEL1_MAIL_APPROVAL,RequestForm::LEVEL2_MAIL_APPROVAL]);
                        });

                        $q->orWhere(function ($sub) use ($userEmail) {
                            $sub->where('manager_email_l3', $userEmail)
                                ->whereIn('mail_status', [
                                    RequestForm::LEVEL2_MAIL_APPROVAL
                                ]);
                        });
                    });
                }

                $data = $query->orderBy('created_at', 'desc')->get();
                return view('fte_list.manager_index', compact('data', 'departments'));
            }

            if ($viewType === 'hr') {
                $query = RequestForm::query();

                if ($role->role_id !== User::ADMIN) {
                    $query->where(function ($q) use ($userEmail) {
                        $q->orWhere('user_id', Auth::id())
                        ->orWhere('manager_email_l1', $userEmail)
                        ->orWhere('manager_email_l2', $userEmail)
                        ->orWhere('manager_email_l3', $userEmail)
                        ->orWhere('hr_email_l1', $userEmail);
                    });
                }

                $excludedStatus = [RequestForm::IN_PROGRESS];
                $data = $query->whereNotIn('status', $excludedStatus)
                            ->orderBy('created_at', 'desc')
                            ->get();

                return view('fte_list.hr_Index', compact('data', 'departments'));
            }

        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try{
            $departments = Department::where('status',1)->get();
            $branches = RequestingBranch::where('status',1)->get();

            return view('fte_request',['branches'=>$branches, 'departments'=>$departments]);
        }catch (\Exception $e) {
        return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
    }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestFormRequest $request)
    {
         
        try {
            $validated = $request->validated();

            $dateOfRequest = $validated['date_of_request'] ?? now();
            $requestUuid =  substr(Uuid::uuid4()->toString(), 0, 7);
            $userId = Auth::user()->id;
            
            $requestData = RequestForm::create([
                'user_id' => $userId,
                'request_uuid' => $requestUuid,
                'date_of_request' => $dateOfRequest,
                'department_id' => $request->department_id ?? null,
                'branch_id' => $request->branch_id ?? null,
                'country' => $request->country,
                'requested_by' => $request->requested_by,
                'approval_level' => $request->approval_level,
                'manager_email_l1' => $request->manager_email_l1,
                'hr_email_l1' => $request->hr_email_l1 ,
                'manager_email_l2' => $request->manager_email_l2 ?? null,
                'hr_email_l2' => $request->hr_email_l2 ?? null,
                'manager_email_l3' => $request->manager_email_l3 ?? null,
                'hr_email_l3' => $request->hr_email_l3 ?? null,
                'no_of_positions' => $request->no_of_positions,
                'type_of_employment' => isset($request->type_of_employment) ? implode(',', $request->type_of_employment) : null,
                'work_location' => $request->work_location ?? null,
                'target_by_when' => $request->target_by_when ?? null,
                'currency' => $request->currency,
                'ctc_type' => $request->ctc_type,
                'ctc_start_range' => $request->ctc_start_range,
                'ctc_end_range' => $request->ctc_end_range,
                'experience' => $request->experience ?? null,
                'requisition_type' => isset($request->requisition_type) ? implode(',', $request->requisition_type) : null,
                'justification_details' => $request->justification_details ?? null,
                'replacing_employee' => $request->replacing_employee ?? null,
                'consequences_of_not_hiring' => $request->consequences_of_not_hiring ?? null,
                'status' => 1,
                'mail_status' => 0,
            ]);
           
            $jobDetail = JobDetail::create([
                'fte_request_id' => $requestUuid,
                'job_title' => $request->job_title,
                'education' => $request->education ?? null,
                'key_skills' => $request->key_skills ?? null,
                'certifications' => $request->certifications ?? null,
                'job_description' => $request->job_description ?? null,
                'language_required' => $request->language_required ?? null,
                'experience' => $request->experience ?? null,
            ]);

            $to = $request->manager_email_l1;
            $cc = $request->hr_email_l1;
            Mail::to($to)
                    ->cc($cc)
                    ->send(new FteRequestMail($requestData , $to));

            return redirect()->route('index')->with('success', 'Form submitted successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $data = RequestForm::where('id', $id)->with(['department','jobDetail','requestingBranch','actionLog.user:id,name','actionLog.requestForm'])->first();
        
        if ($data) {
            return view('fte_list.show',['data'=>$data, 'view' => $request->query('view'),]);
        }else{
            return redirect()->route('fte_request.index')->with('error', 'Request not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RequestFormRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(Request $request)
    {
        try {
            $requestForm = RequestForm::findOrFail($request->id);
            $currentUser = Auth::user()->email;
            $mail = "";
            $hrMail = "";
            $currentStatus = $requestForm->status;
            $currentMailStatus = $requestForm->mail_status;
            $message = '';
            $cc = [];

            if ($request->action === 'accept') {
                if ($requestForm->approval_level == RequestForm::LEVEL_1) {
                    if ($currentMailStatus === RequestForm::MAIL_PENDING) {

                        $mail = $requestForm->hr_email_l1;
                        $hrMail = $requestForm->hr_email_l1;
                        $requestForm->status = RequestForm::CLOSED;
                        $requestForm->mail_status = RequestForm::LEVEL1_MAIL_APPROVAL;
                        $message = 'Approved by Level 1';
                    }
                }

                elseif ($requestForm->approval_level == RequestForm::LEVEL_2) {
                    if ($currentMailStatus === RequestForm::MAIL_PENDING) {

                        $mail = $requestForm->manager_email_l2; 
                        $hrMail = $requestForm->hr_email_l1;
                        $requestForm->mail_status = RequestForm::LEVEL1_MAIL_APPROVAL;
                        $message = 'Approved by Level 1 - Sent to Manager 2';
                    }
                    elseif ($currentMailStatus === RequestForm::LEVEL1_MAIL_APPROVAL) {

                        $mail = $requestForm->hr_email_l1; 
                        $hrMail = $requestForm->hr_email_l1;
                        $requestForm->status = RequestForm::CLOSED;
                        $requestForm->mail_status = RequestForm::LEVEL2_MAIL_APPROVAL;
                        $message = 'Approved by Level 2';
                    }
                }

                elseif ($requestForm->approval_level == RequestForm::LEVEL_3) {
                    if ($currentMailStatus === RequestForm::MAIL_PENDING) {
                       
                        $mail = $requestForm->manager_email_l2; 
                        $hrMail = $requestForm->hr_email_l1;
                        $requestForm->mail_status = RequestForm::LEVEL1_MAIL_APPROVAL;
                        $message = 'Approved by Level 1 - Sent to Manager 2';
                    }
                    elseif ($currentMailStatus === RequestForm::LEVEL1_MAIL_APPROVAL) {
                        
                        $mail = $requestForm->manager_email_l3; 
                        $hrMail = $requestForm->hr_email_l1;
                        $requestForm->mail_status = RequestForm::LEVEL2_MAIL_APPROVAL;
                        $message = 'Approved by Level 2 - Sent to Manager 3';
                    }
                    elseif ($currentMailStatus === RequestForm::LEVEL2_MAIL_APPROVAL) {
                       
                        $mail = $requestForm->hr_email_l1; 
                        $hrMail = $requestForm->hr_email_l1;
                        $requestForm->status = RequestForm::CLOSED;
                        $requestForm->mail_status = RequestForm::LEVEL3_MAIL_APPROVAL;
                        $message = 'Approved by Level 3';
                    }
                }
            }

            if ($request->action === 'reject') {
                if ($requestForm->approval_level == RequestForm::LEVEL_1) {
                    if ($currentMailStatus === RequestForm::MAIL_PENDING) {
                        $requestForm->mail_status = RequestForm::LEVEL1_MAIL_REJECT;
                        $mail = $requestForm->user->email;
                        $message = 'Rejected by Level 1 Manager';
                    }
                }
                elseif ($requestForm->approval_level == RequestForm::LEVEL_2) {
                    if ($currentMailStatus === RequestForm::LEVEL1_MAIL_APPROVAL) {
                        $requestForm->mail_status = RequestForm::LEVEL2_MAIL_REJECT;
                        $mail = $requestForm->user->email;
                        $cc[] = $requestForm->manager_email_l1;
                        $message = 'Rejected by Level 2 Manager';
                    }
                }
                elseif ($requestForm->approval_level == RequestForm::LEVEL_3) {
                    if ($currentMailStatus === RequestForm::LEVEL2_MAIL_APPROVAL) {
                        $requestForm->mail_status = RequestForm::LEVEL3_MAIL_REJECT;
                        $mail = $requestForm->user->email;
                        $cc[] = $requestForm->manager_email_l2;
                        $cc[] = $requestForm->manager_email_l1;
                        $message = 'Rejected by Level 3 Manager';
                    }
                }

                $requestForm->status = RequestForm::CLOSED;
                $requestForm->reason = $request->reason;
            }

            if ($request->action != 'status-change') {
                $requestForm->save();
                $creatorEmail = $requestForm->user->email;
              
                if ($request->action === 'accept') {
                    Mail::to($creatorEmail)
                    ->cc($hrMail)
                    ->send(new FteUserNotificationMail($requestForm, $creatorEmail));

                    Mail::to($mail)
                    ->cc($hrMail)
                    ->send(new FteRequestMail($requestForm, $mail));

                } 
                elseif ($request->action === 'reject') {
                    Mail::to($mail)
                    ->cc($cc)
                    ->send(new FteRejectionMail($requestForm, $mail));
                } 
                    
                ActionLog::create([
                    'fte_request_id' => $request->id,
                    'status'         => $requestForm->status,
                    'action_by'      => Auth::user()->id,
                    'reason'         => $request->reason ?? NULL,
                    'description'    => $message
                ]);
            }
    
            if ($request->action === 'status-change') {
                    $statusMap = [
                        'screening'    => RequestForm::SCREENING,
                        'interviewing' => RequestForm::INTERVIEWING,
                        'hiring'       => RequestForm::HIRING,
                        'done'         => RequestForm::DONE,
                    ];
                
                    $mappedStatus = $statusMap[$request->status];
                    $requestForm->status = $mappedStatus;
                    $requestForm->save();
               
                    ActionLog::create([
                        'fte_request_id' => $request->id,
                        'status'         => $mappedStatus,
                        'action_by'      => Auth::user()->id,
                        'reason'         => $request->reason,     
                        'description'    => $request->status,      
                    ]);
                    $userEmail = $requestForm->user->email;
                    $managerMail = $requestForm->manager_email_l1;

                    Mail::to($userEmail)
                        ->cc($hrMail)
                        ->send(new PositionStatusMail($requestForm,$userEmail));

                    if($request->status == "done"){
                        Mail::to($managerMail)
                            ->send(new PositionStatusMail($requestForm, $managerMail));
                    }    

                    return response()->json([
                        'success' => true,
                        'message' => ucfirst($request->status) . ' status updated successfully.'
                    ]);
            }

            return response()->json(['success' => true,'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function upload(Request $request)
    {
        try{
            if ($request->hasFile('upload')) {
                $file = $request->file('upload');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $extension;

                $path = $file->storeAs('public/uploads', $filename);
                $url = Storage::url($path);

                $mime = $file->getMimeType();
        
                if (Str::startsWith($mime, 'image/')) {
                    return response()->json([
                        'url' => $url 
                    ]);
                } else {
                    return response()->json([
                        'default' => "<p><a href='$url' target='_blank' rel='noopener'>Download File</a></p>"
                    ]);
                }
            }

            return response()->json(['error' => 'No file uploaded.'], 400);
        }catch(\Exception $e){
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function ajaxList(Request $request)
    {
        try {
            $view = $request->get('view');

            $query = RequestForm::with('department');
            $role = UserHasRole::where('user_id', Auth::id())->first();
            $userEmail = Auth::user()->email;

            if ($role->role_id !== User::ADMIN) {
                $query->where(function ($q) use ($userEmail, $view) {
                    if ($view === 'manager') {

                        $q->orWhere('user_id', Auth::id());
                        $q->orWhere('hr_email_l1', $userEmail);
                        // M1
                        $q->orWhere(function ($sub) use ($userEmail) {
                            $sub->where('manager_email_l1', $userEmail)
                                ->whereIn('mail_status', [RequestForm::MAIL_PENDING,RequestForm::LEVEL1_MAIL_APPROVAL,RequestForm::LEVEL2_MAIL_APPROVAL]);
                        });
                        // M2
                        $q->orWhere(function ($sub) use ($userEmail) {
                            $sub->where('manager_email_l2', $userEmail)
                                ->whereIn('mail_status', [RequestForm::LEVEL1_MAIL_APPROVAL,RequestForm::LEVEL2_MAIL_APPROVAL]);
                        });

                        // M3
                        $q->orWhere(function ($sub) use ($userEmail) {
                            $sub->where('manager_email_l3', $userEmail)
                                ->whereIn('mail_status', [RequestForm::LEVEL2_MAIL_APPROVAL]);
                        });
                    }
                    elseif ($view === 'hr') {
                        $q->orWhere('user_id', Auth::id())
                        ->orWhere('manager_email_l1', $userEmail)
                        ->orWhere('manager_email_l2', $userEmail)
                        ->orWhere('manager_email_l3', $userEmail)
                        ->orWhere('hr_email_l1', $userEmail);
                    }
                });
            }

            if ($view === 'manager') {
                $query->whereIn('status', [RequestForm::IN_PROGRESS]);
            } elseif ($view === 'hr') {
                $query->whereNotIn('status', [RequestForm::IN_PROGRESS]);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('department_name', fn($row) => $row->department->name ?? 'N/A')
                ->addColumn('status_label', function ($row) use ($view) {
                    if ($view === 'manager') {
                        $color = RequestForm::STATUS_COLORS[RequestForm::IN_PROGRESS] ?? 'primary';
                        return '<span class="badge badge-' . $color . '">IN PROGRESS</span>';
                    }
                    $color = RequestForm::STATUS_COLORS[$row->status] ?? 'secondary';
                    $label = RequestForm::STATUS_BY_ID[$row->status] ?? 'UNKNOWN';
                    return '<span class="badge badge-' . $color . '">' . strtoupper($label) . '</span>';
                })
                ->addColumn('mail_status_label', fn($row) =>
                    '<span class="badge badge-' . RequestForm::MAIL_STATUS_COLORS[$row->mail_status] . '">' .
                    RequestForm::STATUS_BY_MAIL_ID[$row->mail_status] . '</span>'
                )
                ->addColumn('action', function ($row) use ($view) {
                    $viewUrl = route('fte_request.show', ['fte_request' => $row->id, 'view' => request('view')]);
                    $currentEmail = Auth::user()->email;
                    $hrEmails = [$row->hr_email_l1, $row->hr_email_l2, $row->hr_email_l3];

                    $rejectedStatuses = [
                        RequestForm::LEVEL1_MAIL_REJECT,
                        RequestForm::LEVEL2_MAIL_REJECT,
                        RequestForm::LEVEL3_MAIL_REJECT,
                        RequestForm::HR_MAIL_REJECT,
                    ];

                    $isRejected = in_array($row->mail_status, $rejectedStatuses);
                    $isCurrentHR = in_array($currentEmail, $hrEmails);

                    $actionHtml = '
                        <style>
                            .drop-menu { width: 10%; }
                            .btn-group .dropdown { margin-right: 5px; }
                            .dropdown-menu {
                                position: absolute !important;
                                will-change: transform;
                                z-index: 1060 !important;
                            }
                            .drop-menu {
                                min-width: 140px !important; 
                            }
                        </style>

                        <div class="btn-group" role="group">
                            <div class="dropdown">
                                <button class="btn btn-sm dropdown-color dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-cog mr-1"></i> Action
                                </button>
                                <div class="dropdown-menu drop-menu">
                                    <a class="dropdown-item" href="' . $viewUrl . '">
                                        <i class="fas fa-eye mr-2 text-primary"></i>View
                                    </a>';

                    if ($view === 'hr' && $isCurrentHR && !$isRejected) {
                        $actionHtml .= '
                            <a class="dropdown-item edit-request-btn" href="#" data-id="' . $row->id . '">
                                <i class="fas fa-edit mr-2 text-info"></i>Modify
                            </a>';
                    }

                    $actionHtml .= '</div></div>';

                    if ($view === 'hr' && $isCurrentHR && !$isRejected) {
                        $actionHtml .= '
                        <div class="dropdown">
                            <button class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-sync mr-2"></i>Update Status
                            </button>
                            <div class="dropdown-menu drop-menu">
                                <a class="dropdown-item update-status-btn" href="#"
                                    data-status="screening" data-id="' . $row->id . '" data-toggle="modal" data-target="#statusUpdateModal">
                                    <i class="fas fa-search mr-2 text-info"></i>Screening
                                </a>
                                <a class="dropdown-item update-status-btn" href="#"
                                    data-status="interviewing" data-id="' . $row->id . '" data-toggle="modal" data-target="#statusUpdateModal">
                                    <i class="fas fa-comments mr-2 text-primary"></i>Interviewing
                                </a>
                                <a class="dropdown-item update-status-btn" href="#"
                                    data-status="hiring" data-id="' . $row->id . '" data-toggle="modal" data-target="#statusUpdateModal">
                                    <i class="fas fa-user-check mr-2 text-primary"></i>Hiring
                                </a>
                                <a class="dropdown-item update-status-btn" href="#"
                                    data-status="done" data-id="' . $row->id . '" data-toggle="modal" data-target="#statusUpdateModal">
                                    <i class="fas fa-clipboard-check mr-2 text-success"></i>Done
                                </a>
                            </div>
                        </div>';
                    }

                    $actionHtml .= '</div>'; 
                    return $actionHtml;
                })
                ->rawColumns(['status_label', 'mail_status_label', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    
    public function fetchData($id)
    {
        $form = RequestForm::select('id','no_of_positions','position_filled')->findOrFail($id);

        return response()->json($form);
    }

    public function updatePosition(Request $request, $id)
    {
        try{
            $request->validate(['position_filled' => 'required|integer|min:0']);

            $form = RequestForm::findOrFail($id);
            $UserEmail = $form->user->email;
            $hrmail = $form->hr_email_l1;
            $managerEmail = $form->manager_email_l1;

            $updatedCount = $form->position_filled + $request->position_filled;

            if ($updatedCount > $form->no_of_positions) {
                return response()->json(['message' => 'Filled position cannot exceed total.'], 422);
            }

            $form->update(['position_filled' => $updatedCount]);

            if ($updatedCount === $form->no_of_positions) {
                $form->update(['status' => RequestForm::DONE]);
            }

            Mail::to($UserEmail)
                        ->cc($hrmail)
                        ->send(new PositionFilledMail($form,$UserEmail));
            Mail::to($managerEmail)
                        ->cc($hrmail)
                        ->send(new PositionFilledMail($form,$managerEmail));

            return response()->json(['message' => 'Updated successfully']);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }

    // Card status
    public function getByStatus(Request $request)
    {
        $status = $request->input('status');
        
        $requests = RequestForm::where('status', $status)
            ->select(['request_id', 'department', 'department_function']) 
            ->get();
        
        return response()->json([
            'data' => $requests
        ]);
    }

}