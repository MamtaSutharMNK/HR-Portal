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
    public function create()
    {
        $role = UserHasRole::where('user_id', Auth::user()->id)->first();
        $departments = Department::where('status',1)->get();

        if($role->role_id == User::ADMIN){
            $data = RequestForm::orderBy('created_at', 'desc')->get();
        }else{
            $data = RequestForm::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        }
        return view('fte_list.index',['data'=>$data]);
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
                'manager_name' => $request->manager_name,
                'manager_email' => $request->manager_email,
                'hr_email' => $request->hr_email,
                'level2_email' => $request->level2_email ?? null,
                'level3_email' => $request->level3_email ?? null,
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

            $to = $request->manager_email;
            $bcc = $request->hr_email;
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
        $data = RequestForm::where('id', $id)->with(['department','jobDetail','requestingBranch','employeeLevel','actionLog.user:id,name'])->first();
        return view('fte_list.show',['data'=>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $data = RequestForm::with(['department', 'jobDetail', 'requestingBranch', 'employeeLevel'])->findOrFail($id);
        $data = RequestForm::where('id', $id)->with('department','jobDetail','requestingBranch','employeeLevel')->first();

        $departments = Department::where('status', 1)->get();
        $branches = RequestingBranch::where('status', 1)->get();
        $employeeLevels = EmployeeLevel::all();

        return view('fte_list.edit', ['data' => $data,'departments' => $departments,'branches' => $branches,'employeeLevels' => $employeeLevels]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    //     $request->validate([
    //     'date_of_request' => 'required|date',
    //     'requested_by' => 'required|string|max:255',
    //     'department_id' => 'nullable|integer',
    //     'branch_id' => 'nullable|integer',
    //     'manager_email' => 'nullable|email',
    //     'hr_email' => 'nullable|email',
    //     'ctc_start_range' => 'nullable|numeric',
    //     'ctc_end_range' => 'nullable|numeric',
    //     // Add more validation rules as needed
    // ]);

    $fte = RequestForm::findOrFail($id);
    $fte->update([
        'date_of_request' => $request->date_of_request,
        'requested_by' => $request->requested_by,
        'department_id' => $request->department_id,
        'branch_id' => $request->branch_id,
        'manager_name' => $request->manager_name,
        'manager_email' => $request->manager_email,
        'hr_email' => $request->hr_email,
        'level2_email' => $request->level2_email,
        'level3_email' => $request->level3_email,
        'no_of_positions' => $request->no_of_positions,
        'position_filled' => $request->position_filled,
        'type_of_employment' => is_array($request->type_of_employment) ? implode(',', $request->type_of_employment) : $request->type_of_employment,
        'employment_category' => is_array($request->employment_category) ? implode(',', $request->employment_category) : $request->employment_category,
        'work_location' => $request->work_location,
        'target_by_when' => $request->target_by_when,
        'department_function' => $request->department_function,
        'employee_level' => $request->employee_level,
        'currency' => $request->currency,
        'ctc_type' => $request->ctc_type,
        'ctc_start_range' => $request->ctc_start_range,
        'ctc_end_range' => $request->ctc_end_range,
        'justification_details' => $request->justification_details,
        'replacing_employee' => $request->replacing_employee,
        'consequences_of_not_hiring' => $request->consequences_of_not_hiring,
        'requisition_type' => is_array($request->requisition_type) ? implode(',', $request->requisition_type) : $request->requisition_type
    ]);
    if ($fte->jobDetail) {
        $fte->jobDetail->update([
            'job_title' => $request->job_title,
            'education' => $request->education,
            'experience' => $request->experience,
            'key_skills' => $request->key_skills,
            'language_required' => $request->language_required,
            'certifications' => $request->certifications,
            'job_description' => $request->job_description
        ]);
    }

    ActionLog::create([
        'fte_request_id' => $id,
        'action_by'      => Auth::user()->id,
        'description'    => 'Update FTE Form'
    ]);

    return redirect()->route('fte_request.create')->with('success', 'FTE Request updated successfully.');

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

            if ($request->action === 'accept') {

                $requestForm->mail_status = RequestForm::MANAGER_MAIL_APPROVAL;
                $mail = $requestForm->hr_email;
                $requestForm->status = RequestForm::IN_PROGRESS;
                if ($requestForm->status === RequestForm::MAIL_PENDING) {
                    $mail = $requestForm->manager_email;
                    $requestForm->mail_status = RequestForm::MANAGER_MAIL_APPROVAL;
                    $message =  'Approved By Manager';
                } elseif ($requestForm->status === RequestForm::MANAGER_MAIL_APPROVAL) {
                    $mail = $requestForm->level2_email;
                    $requestForm->mail_status = RequestForm::LEVEL2_MAIL_APPROVAL; 
                    $message =  'Approved By Level 2';
                } elseif ($requestForm->status === RequestForm::LEVEL2_MAIL_APPROVAL) {
                    $mail = $requestForm->level3_email;
                    $requestForm->mail_status = RequestForm::LEVEL3_MAIL_APPROVAL; 
                    $message =  'Approved By Level 3';
                }

                $requestForm->save();

                Mail::to($mail)
                ->cc($requestForm->hr_email)
                ->send(new FteRequestMail($requestForm));
                return response()->json(['success' => true, 'message' => 'Approved Successfully']);

                ActionLog::create([
                    'fte_request_id' => $request->id,
                    'status'         => $requestForm->status,
                    'action_by'      => Auth::user()->id,
                    'description'    => $message
                ]);
            }

            // Reject Logic
            if ($request->action === 'reject') {
            
                $requestForm->status = RequestForm::IN_PROGRESS;
                $requestForm->mail_status = RequestForm::MANAGER_MAIL_REJECT;
                $mail = $requestForm->hr_email;
                $message =  'Rejected';
                if ($requestForm->status === RequestForm::MAIL_PENDING) {
                    $mail = $requestForm->manager_email;
                    $requestForm->mail_status = RequestForm::MANAGER_MAIL_REJECT; 
                    $message =  'Rejected By MANAGER';
                }elseif ($requestForm->status === RequestForm::MANAGER_MAIL_APPROVAL) {
                    $mail = $requestForm->level2_email;
                    $requestForm->mail_status = RequestForm::LEVEL2_MAIL_REJECT;
                    $message =  'Rejected By Level 2'; 
                } elseif ($requestForm->status === RequestForm::LEVEL2_MAIL_APPROVAL) {
                    $mail = $requestForm->level3_email;
                    $requestForm->mail_status = RequestForm::LEVEL3_MAIL_REJECT; 
                    $message =  'Rejected By Level 3';
                }

                $requestForm->reason = $request->reason;
                $requestForm->save();

                Mail::to($mail)
                    ->cc($requestForm->hr_email)
                    ->send(new FteRejectionMail($requestForm));

                ActionLog::create([
                    'fte_request_id' => $request->id,
                    'status'         => $requestForm->status,
                    'action_by'      => Auth::user()->id,
                    'reason'         => $request->reason,
                    'description'    => $message
                ]);

                return response()->json(['success' => true, 'message' => 'Request rejected. User notified.']);
            }

            return response()->json(['success' => false, 'message' => 'Invalid action.'], 400);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function changeStatus(Request $request)
    {
        
        try {
            $requestForm = RequestForm::findOrFail($request->id);
            if($request->action == 'close'){
                $requestForm->status = RequestForm::CLOSED;
                $desc = 'FTE Closed';
            }else{
                $requestForm->status = RequestForm::DONE;
                $desc = 'FTE Done';
            }
            $requestForm->save();

            Mail::to($requestForm->manager_email)
            ->cc($requestForm->hr_email)
            ->send(new FteRequestClose($requestForm));

            ActionLog::create([
                'fte_request_id' => $request->id,
                'action_by'      => Auth::user()->id,
                'description'    => $desc,
                'status'        => $requestForm->status,
                'reason'         => $message
            ]);
            return response()->json(['success' => true, 'message' => 'Request Closed.']);

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

        // Save to public/uploads directory
        $path = $file->storeAs('public/uploads', $filename);
        $url = Storage::url($path);

        $mime = $file->getMimeType();

        // Check if the file is an image
        if (Str::startsWith($mime, 'image/')) {
            return response()->json([
                'url' => $url // CKEditor will auto-insert the <img>
            ]);
        } else {
            // For docs, pdfs, etc., insert a download link
            return response()->json([
                'default' => "<p><a href='$url' target='_blank' rel='noopener'>Download File</a></p>"
            ]);
        }
    }

    return response()->json(['error' => 'No file uploaded.'], 400);
}
}
