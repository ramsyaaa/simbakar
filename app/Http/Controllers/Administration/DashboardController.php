<?php

namespace App\Http\Controllers\Administration;

use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\SchedulingPlanDetail;
use App\Http\Controllers\Controller;

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

        $data['suppliers'] = Supplier::get();
        return view('dashboard', $data);
    }
}
