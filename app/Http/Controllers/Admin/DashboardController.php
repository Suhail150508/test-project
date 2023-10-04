<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use Rainwater\Active\Active;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function path($link)
    {
        return "admin.dashboard.{$link}";
    }

    public function index()
    {
        $data = [];

        /*Application::query()
            ->whereBetween('created_at',['2020-01-01','2020-12-31'])
            ->groupBy('created_at')
            ->get();*/

        /*$months = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $group_by_month = [];

        foreach($months as $key => $month){
            $group_by_month[$key] = Application::query()
                ->whereBetween('created_at',[date('Y').'-'.$month.'-01',date('Y').'-'.$month.'-31'])
                ->get()->count();
        }
        $data['all_applications_this_year'] = Application::query()
            ->whereBetween('created_at',[date('Y').'-01-01',date('Y').'-12-31'])
            ->get()
            ->count();
        $data['group_by_month_this_year'] = $group_by_month;

        foreach($months as $key => $month){
            $group_by_month[$key] = Application::query()
                ->whereBetween('created_at',[(date('Y')-1).'-'.$month.'-01',(date('Y')-1).'-'.$month.'-31'])
                ->get()->count();
        }
        $data['all_applications_previous_year'] = Application::query()
            ->whereBetween('created_at',[(date('Y')-1).'-01-01',(date('Y')-1).'-12-31'])
            ->get()
            ->count();
        $data['group_by_month_previous_year'] = $group_by_month;

        $data['group_by_status'] = [$data['new_applications'],$data['pending_applications'],$data['inspection_applications'], $data['processing_applications'],$data['approval_applications'],$data['approved_applications'],$data['returned_applications']];
        $data['all_proposed'] = Application::query()->where('type','proposed')->count();
        $data['all_existing'] = $data['all_applications'] - $data['all_proposed'];*/

//        $data['active_users'] = Active::query()->latest('last_activity')->users()->take(10)->get();
        $data['active_users'] = Auth::user()->take(10)->get();
//dd($data['active_users']);
        return view($this->path('index'),$data);
    }
}
