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

use App\Models\JobRole;
use Illuminate\Support\Facades\Auth;



class FteRequestFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::where('status',1)->get();
        $branches = RequestingBranch::where('status',1)->get();

        $jobroles = JobRole::all();

        return view('fte_request',['branches'=>$branches, 'departments'=>$departments ,'jobroles' =>$jobroles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        $departments = Department::where('status',1)->get();
        $jobroles = JobRole::all();

        $data = RequestForm::where('user_id', Auth::user()->id)->where('status', 1)->orderBy('created_at', 'desc')->get();

        return view('fte_list.index',['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // try {

            $dateOfRequest = $validated['date_of_request'] ?? now();
            $requestUuid =  substr(Uuid::uuid4()->toString(), 0, 7);
            $userId = Auth::user()->id;
            // $requestData = RequestForm::create([
            //     'user_id' => $userId,
            //     'request_uuid' => $requestUuid,
            //     'date_of_request' => $dateOfRequest,
            //     'requested_by' => $request->requested_by,
            //     'manager_id' => $request->manager_id,
            //     'country_id' => $request->country_id,
            //     'function_id' => $request->function_id,
            //     'department_id' => $request->department_id,
            //     'currency_id' => $request->currency_id ?? null,
            //     'no_of_positions' => $request->no_of_positions,
            //     'location_type' => isset($request->location_type) ? implode(',', $request->location_type) : null,   
            //     'type_of_employment' => isset($request->type_of_employment) ? implode(',', $request->type_of_employment) : null,
            //     'employment_category' => isset($request->employment_category) ? implode(',', $request->employment_category) : null,
            //     'requisition_type' => isset($request->requisition_type) ? implode(',', $request->requisition_type) : null,
            //     'recruitment_source' => isset($request->recruitment_source) ? implode(',', $request->recruitment_source) : null,
            //     'work_permit' => $request->work_permit ?? null,
            //     'relocation_support' => $request->relocation_support ?? null,
            //     'work_location' => $request->work_location ?? null,
            //     'target_start_date' => $request->target_start_date ?? null,
            //     'ctc_type' => $request->ctc_type,
            //     'ctc_start_range' => $request->ctc_start_range,
            //     'ctc_end_range' => $request->ctc_end_range,
            //     'justification_details' => $request->justification_details ?? null,
            //     'replacing_employee' => $request->replacing_employee ?? null,
            //     'consequences_of_not_hiring' => $request->consequences_of_not_hiring ?? null,
            
            // ]);
            // dd($request->all());
            $requestData = RequestForm::create([
                'user_id' => $userId,
                'request_uuid' => $requestUuid,
                'date_of_request' => $dateOfRequest,
                'department_id' => $request->department_id ?? null,
                'branch_id' => $request->branch_id ?? null,
                'country' => $request->country,
                'requested_by' => $request->requested_by,
                'manager_name' => $request->manager_name,
                'manager_email' => $request->manager_email,
                'no_of_positions' => $request->no_of_positions,
                'type_of_employment' => isset($request->type_of_employment) ? implode(',', $request->type_of_employment) : null,
                'employment_category' => isset($request->employment_category) ? implode(',', $request->employment_category) : null,
                'work_location' => $request->work_location ?? null,
                'target_by_when' => $request->target_by_when ?? null,
                'department_function' => $request->department_function,
                'employee_level' => $request->employee_level,
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
                'fte_request_id' => $requestData->id,
                'job_title' => $request->job_title,
                'education' => $request->education ?? null,
                'key_skills' => $request->key_skills ?? null,
                'certifications' => $request->certifications ?? null,
                'job_description' => $request->job_description ?? null,
                'language_required' => $request->language_required ?? null,
                'experience' => $request->experience ?? null,
            ]);

            $to = env('CFO_MAIL');
            $bcc = env('HR_MAIL','CTO_MAIL');
            Mail::to('Ramnath.Thirunathan@mnkgcs.com')
                    ->cc($to)
                    ->bcc($bcc)
                    ->send(new FteRequestMail($requestData));

            return redirect()->route('index')->with('success', 'Form submitted successfully.');
        // } catch (Exception $e) {
        //     return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        //     dd($e->getMessage());
        // }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $data = RequestForm::where('id', $id)->with('department','jobDetail','requestingBranch')->first();
       
        return view('fte_list.show',['data'=>$data]);
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

            $requestForm->mail_status = 1;
            $mail = env('HR_MAIL');
            if ($currentUser === env('CFO_MAIL') && $requestForm->mail_status == RequestForm::MAIL_PENDING) {
                $requestForm->mail_status = 1; // CFO_Mail_APPROVAL
                $mail = env('CFO_MAIL');
            }

            if ($currentUser === env('CTO_MAIL') && $requestForm->mail_status == RequestForm::CFO_Mail_APPROVAL) {
                $requestForm->mail_status = 3; // CTO_Mail_APPROVAL
                $mail = env('CTO_MAIL');
            }

            if ($currentUser === env('HR_MAIL')) {
                $mail = env('HR_MAIL');
                if($requestForm->mail_status == RequestForm::MAIL_PENDING){
                    $requestForm->mail_status = 1;
                }elseif($requestForm->mail_status == RequestForm::CFO_Mail_APPROVAL){
                    $requestForm->mail_status = 3;
                }else{
                    $requestForm->mail_status = 5; 
                }
            }

            $requestForm->save();

            Mail::to($mail)
            ->cc(env('HR_MAIL'))
            ->send(new FteRequestMail($requestForm));
            return response()->json(['success' => true, 'message' => 'Approved Successfully']);
        }

        // Reject Logic
        if ($request->action === 'reject') {
            if ($currentUser === env('CFO_MAIL')) {
                $requestForm->mail_status = 2; // CFO_Mail_REJECT
            } elseif ($currentUser === env('CTO_MAIL')) {
                $requestForm->mail_status = 4; // CTO_Mail_REJECT
            } elseif ($currentUser === env('HR_MAIL')) {
                $requestForm->mail_status = 6; // HR_Mail_REJECT
            }

            $requestForm->save();

            // Notify user of rejection
            // Mail::to($requestForm->user->email)->send(new FteRequestMail($requestForm));
            return response()->json(['success' => true, 'message' => 'Request rejected. User notified.']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid action.'], 400);

    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}
}
