<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestForm;
use Illuminate\Support\Facades\DB;


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
        $statuses = RequestForm::STATUS_BY_ID;
        $statusCounts = RequestForm::selectRaw('status, COUNT(*) as count')->groupBy('status')->pluck('count', 'status')->toArray();
        $emailStatusCounts = RequestForm::selectRaw('mail_status, COUNT(*) as count')->groupBy('mail_status')
            ->pluck('count', 'mail_status')->toArray();

        return view('index',['status' => $statuses,'statusCount'=> $statusCounts,
        'emailStatusCounts'=>$emailStatusCounts,'emailStatus' => RequestForm::EMAIL_STATUS_LABELS]);
    }
}
