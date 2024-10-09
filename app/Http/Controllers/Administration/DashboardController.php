<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\SchedulingPlanDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $data['scheduling_plan'] = SchedulingPlanDetail::with('dock') // Eager loading relasi 'dock'
            ->whereMonth('start_date', $currentMonth)
            ->whereYear('start_date', $currentYear)
            ->get()
            ->groupBy(function ($item) {
                return $item->dock->name; // Mengelompokkan berdasarkan nama 'dock'
            })
            ->map(function ($group) {
                return $group->groupBy('scheduling_plan_id'); // Mengelompokkan ulang berdasarkan 'scheduling_plan_id'
            });

        return view('dashboard', $data);
    }
}
