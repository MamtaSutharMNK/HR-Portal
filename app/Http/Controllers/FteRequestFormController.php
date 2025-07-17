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
use App\Models\EmployeeLevel;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RequestFormRequest;
use App\Models\UserHasRole;
use App\Mail\FteRejectionMail;
use App\Mail\FteRequestClose;
use App\Models\ActionLog;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;


class FteRequestFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::where('status',1)->get();
        $branches = RequestingBranch::where('status',1)->get();
        $employeeLevels = EmployeeLevel::all();

        return view('fte_request',['branches'=>$branches, 'departments'=>$departments,'employeeLevels'=>$employeeLevels]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $viewType = $request->query('view');

        $role = UserHasRole::where('user_id', Auth::user()->id)->first();
        $departments = Department::where('status',1)->get();
        
        $query = RequestForm::query();
        if ($role->role_id !== User::ADMIN) {
            $query->where('user_id', Auth::id())->orwhere('manager_email_l1', Auth::user()->email)
            ->orwhere('manager_email_l2', Auth::user()->email)
            ->orwhere('manager_email_l3', Auth::user()->email)
            ->orwhere('hr_email_l1', Auth::user()->email)
            ->orwhere('hr_email_l2', Auth::user()->email)
            ->orwhere('hr_email_l3', Auth::user()->email);
        }

        if ($viewType === 'manager') {
            $managerStatus = [RequestForm::IN_PROGRESS];
            $data = (clone $query)->whereIn('status', $managerStatus)->orderBy('created_at', 'desc')->get();
            return view('fte_list.manager_index', compact('data'));
        }
    
        if ($viewType === 'hr') {
            $hrStatus = [RequestForm::CLOSED, RequestForm::DONE,RequestForm::SCREENING,RequestForm::INTERVIEWING,RequestForm::HIRING];
            $data = (clone $query)->whereIn('status', $hrStatus)->orderBy('created_at', 'desc')->get();
            return view('fte_list.hr_Index', compact('data'));
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
                'employment_category' => isset($request->employment_category) ? implode(',', $request->employment_category) : null,
                'work_location' => $request->work_location ?? null,
                'target_by_when' => $request->target_by_when ?? null,
                'department_function' => $request->department_function,
                'employee_level_id' => $request->employee_level,
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
            $bcc = $request->hr_email_l1;
            Mail::to($to)
                    ->cc($to)
                    ->bcc($bcc)
                    ->send(new FteRequestMail($requestData));

            return redirect()->route('index')->with('success', 'Form submitted successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
            dd($e->getMessage());
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = RequestForm::where('id', $id)->with(['department','jobDetail','requestingBranch','employeeLevel','actionLog.user:id,name','actionLog.requestForm'])->first();
        return view('fte_list.show',['data'=>$data]);
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
            $mail = Auth::user()->email;
            $hrMail = Auth::user()->email;
            $currentStatus = $requestForm->status;
            $currentMailStatus = $requestForm->mail_status;
            $message = '';

            if ($request->action === 'accept') {

                if ($currentMailStatus === RequestForm::MAIL_PENDING) {
                    $mail = $requestForm->manager_email_l1;
                    $hrMail = $requestForm->hr_email_l1;
                    $requestForm->mail_status = RequestForm::LEVEL1_MAIL_APPROVAL;
                    $message = 'Approved By Level1';
                    
                    if ($requestForm->approval_level == 1) {
                        $requestForm->status = RequestForm::CLOSED;
                        $mail = $requestForm->hr_email_l1;
                    }
                } 
                elseif ($currentMailStatus === RequestForm::LEVEL1_MAIL_APPROVAL) {
                    $mail = $requestForm->manager_email_l2;
                    $hrMail = $requestForm->hr_email_l2;
                    $requestForm->mail_status = RequestForm::LEVEL2_MAIL_APPROVAL;
                    $message = 'Approved By Level 2';
                    
                    if ($requestForm->approval_level == 2) {
                        $requestForm->status = RequestForm::CLOSED;
                        $mail = $requestForm->hr_email_l2;
                    }
                } 
                elseif ($currentMailStatus === RequestForm::LEVEL2_MAIL_APPROVAL) {
                    $mail = $requestForm->manager_email_l3;
                    $hrMail = $requestForm->hr_email_l3;
                    $requestForm->mail_status = RequestForm::LEVEL3_MAIL_APPROVAL;
                    $message = 'Approved By Level 3';
                
                    $requestForm->status = RequestForm::CLOSED;
                    $mail = $requestForm->hr_email_l3;
                }

            }

            if ($request->action === 'reject') {
                        
                if ($requestForm->mail_status === RequestForm::MAIL_PENDING) {
                    $requestForm->mail_status = RequestForm::LEVEL1_MAIL_REJECT;
                    $requestForm->status = RequestForm:: CLOSED;
                    $message = 'Rejected By Level 1 Manager';
                } 
                elseif ($requestForm->mail_status === RequestForm::LEVEL1_MAIL_APPROVAL) {
                    $requestForm->mail_status = RequestForm::LEVEL2_MAIL_REJECT;
                    $requestForm->status = RequestForm:: CLOSED;
                    $message = 'Rejected By Level 2 Manager';
                } 
                elseif ($requestForm->mail_status === RequestForm::LEVEL2_MAIL_APPROVAL) {
                    $requestForm->mail_status = RequestForm::LEVEL3_MAIL_REJECT;
                    $requestForm->status = RequestForm:: CLOSED;
                    $message = 'Rejected By Level 3 Manager';
                }

                $requestForm->reason = $request->reason;

            }

            if ($request->action != 'status-change') {
                $requestForm->save();

                if ($request->action === 'accept') {
                    Mail::to($mail)
                    ->cc($hrMail)
                    ->send(new FteRequestMail($requestForm));
                } elseif ($request->action === 'reject') {
                    Mail::to($mail)
                    ->cc($hrMail)
                    ->send(new FteRejectionMail($requestForm));
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

                    // Mail::to($mail)
                    // ->cc($hrMail)
                    // ->send(new FteRequestMail($requestForm));
               
                    ActionLog::create([
                        'fte_request_id' => $request->id,
                        'status'         => $mappedStatus,
                        'action_by'      => Auth::user()->id,
                        'reason'         => $request->reason,     
                        'description'    => $request->status,      
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => ucfirst($request->status) . ' status updated successfully.'
                    ]);
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function upload(Request $request)
    {
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
    }


    public function ajaxList(Request $request)
    {
        $view = $request->get('view');

        $query = RequestForm::with('department');

        $role = UserHasRole::where('user_id', Auth::id())->first();
        if ($role->role_id !== User::ADMIN) {
            $query->where('user_id', Auth::id())
                ->orWhere('manager_email_l1', Auth::user()->email)
                ->orWhere('manager_email_l2', Auth::user()->email)
                ->orWhere('manager_email_l3', Auth::user()->email)
                ->orWhere('hr_email_l1', Auth::user()->email)
                ->orWhere('hr_email_l2', Auth::user()->email)
                ->orWhere('hr_email_l3', Auth::user()->email);
        }

        if ($view === 'manager') {
            $query->whereIn('status', [RequestForm::IN_PROGRESS]);
        } elseif ($view === 'hr') {
            $query->whereIn('status', [
                RequestForm::CLOSED,
                RequestForm::DONE,
                RequestForm::SCREENING,
                RequestForm::INTERVIEWING,
                RequestForm::HIRING
            ]);
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
                $viewUrl = route('fte_request.show', $row->id);
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
    }
    



    public function fetchData($id){
        $form = RequestForm::select('id','no_of_positions','position_filled')->findOrFail($id);

        return response()->json($form);
    }

    public function updatePosition(Request $request, $id)
    {
        $request->validate(['position_filled' => 'required|integer|min:0']);

        $form = RequestForm::select('id', 'no_of_positions', 'position_filled')->findOrFail($id);

        $updatedCount = $form->position_filled + $request->position_filled;

        if ($updatedCount > $form->no_of_positions) {
            return response()->json(['message' => 'Filled position cannot exceed total.'], 422);
        }

        $form->update(['position_filled' => $updatedCount]);

        if ($updatedCount === $form->no_of_positions) {
            $form->update(['status' => RequestForm::DONE]);
        }

        return response()->json(['message' => 'Updated successfully']);
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