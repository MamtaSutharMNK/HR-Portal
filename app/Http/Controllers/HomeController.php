<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Manager;
use App\Models\User;
use App\Models\Department;
use App\Models\JobRole;

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

    

}
