<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestForm;
use Illuminate\Support\Facades\DB;
use App\Models\UserHasRole;
use Illuminate\Support\Facades\Auth;
use App\Models\User;



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
        $query = RequestForm::query();
        
        $role = UserHasRole::where('user_id', Auth::id())->first();
        if ($role->role_id !== User::ADMIN)
        {
            $query->where('user_id', Auth::id());
        }
        
        $statusCounts = $query->clone()->selectRaw('status, COUNT(*) as count')->groupBy('status')->pluck('count', 'status')->toArray();
        
        $emailStatusCounts = $query->clone()->selectRaw('mail_status, COUNT(*) as count')->groupBy('mail_status')->pluck('count', 'mail_status')->toArray();

        $userName = Auth::user()->name;
        return view('index', ['status' => RequestForm::STATUS_BY_ID,'statusCount' => $statusCounts,'emailStatusCounts' => $emailStatusCounts,'emailStatus' => RequestForm::EMAIL_STATUS_LABELS,'userName'=>$userName]);
    }
}
