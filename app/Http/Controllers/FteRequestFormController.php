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
use App\Models\Country;
use App\Models\Currency;
use App\Models\Manager;
use App\Models\User;
use App\Models\Department;
use App\Models\JobRole;
use Illuminate\Support\Facades\Auth;


class FteRequestFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Currency::where('status',1)->get();
        $manager = Manager::where('status',1)->get();
        $country = Country::where('status',1)->get();
        $departments = Department::where('status',1)->get();
        $jobroles = JobRole::all();

        return view('fte_request',['currencies'=>$currencies,'managers'=>$manager,'countries'=>$country, 'departments'=>$departments ,'jobroles' =>$jobroles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currencies = Currency::where('status',1)->get();
        $manager = Manager::where('status',1)->get();
        $country = Country::where('status',1)->get();
        $departments = Department::where('status',1)->get();
        $jobroles = JobRole::all();

        $data = RequestForm::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

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
        
            $requestData = RequestForm::create([
                'request_uuid' => $requestUuid,
                'date_of_request' => $dateOfRequest,
                'requested_by' => $request->requested_by,
                'manager_id' => $request->manager_id,
                'country_id' => $request->country_id,
                'function_id' => $request->function_id,
                'department_id' => $request->department_id,
                'currency_id' => $request->currency_id ?? null,
                'no_of_positions' => $request->no_of_positions,
                'location_type' => isset($request->location_type) ? implode(',', $request->location_type) : null,   
                'type_of_employment' => isset($request->type_of_employment) ? implode(',', $request->type_of_employment) : null,
                'employment_category' => isset($request->employment_category) ? implode(',', $request->employment_category) : null,
                'requisition_type' => isset($request->requisition_type) ? implode(',', $request->requisition_type) : null,
                'recruitment_source' => isset($request->recruitment_source) ? implode(',', $request->recruitment_source) : null,
                'work_permit' => $request->work_permit ?? null,
                'relocation_support' => $request->relocation_support ?? null,
                'work_location' => $request->work_location ?? null,
                'target_start_date' => $request->target_start_date ?? null,
                'ctc_type' => $request->ctc_type,
                'ctc_start_range' => $request->ctc_start_range,
                'ctc_end_range' => $request->ctc_end_range,
                'justification_details' => $request->justification_details ?? null,
                'replacing_employee' => $request->replacing_employee ?? null,
                'consequences_of_not_hiring' => $request->consequences_of_not_hiring ?? null,
            
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

            $to = env('CTO_MAIL');
            $bcc = env('HR_MAIL','CFO_MAIL');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
