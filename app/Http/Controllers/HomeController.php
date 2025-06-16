<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Manager;
use App\Models\User;
use App\Models\Department;
use App\Models\JobRole;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index');
    }

     public function fteRequest()
    {
        $currencies = Currency::where('status',1)->get();
        $manager = Manager::where('status',1)->get();
        $country = Country::where('status',1)->get();
        $departments = Department::where('status',1)->get();
        $jobroles = JobRole::all();

        return view('fte_request',['currencies'=>$currencies,'managers'=>$manager,'countries'=>$country, 'departments'=>$departments ,'jobroles' =>$jobroles]);
    }

}
