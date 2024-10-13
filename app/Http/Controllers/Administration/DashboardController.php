<?php

namespace App\Http\Controllers\Administration;

use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\SchedulingPlanDetail;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request){
        if (isset($request->filter_typeSchedule)) {
            // Cek apakah filter_typeSchedule adalah 'month'
            if ($request->filter_typeSchedule === 'month') {
                // Ambil bulan dan tahun dari input 'month_schedule'
                $monthYear = $request->input('month_schedule'); // Ambil nilai dari input
                if ($monthYear) {
                    $data['month_value'] = $monthYear;
                    // Pisahkan bulan dan tahun
                    [$year, $month] = explode('-', $monthYear);

                    // Hitung jumlah hari dalam bulan dan tahun yang dipilih
                    $data['totalDay'] = Carbon::createFromDate($year, $month)->daysInMonth;
                    $data['type'] = 'month';
                    $data['text_title'] = Carbon::createFromDate($year, $month)->translatedFormat('F') . ' ' . $year;
                    $data['start_date_filter'] = Carbon::createFromDate($year, $month, 1)->toDateString();

                    // Ambil data scheduling_plan berdasarkan bulan dan tahun dari input
                    $data['scheduling_plan'] = SchedulingPlanDetail::with(['dock', 'schedulingPlan.supplier', 'schedulingPlan.ship']) // Eager loading relasi 'dock'
                        ->whereMonth('start_date', $month)
                        ->whereYear('start_date', $year)
                        ->get()
                        ->groupBy(function ($item) {
                            return $item->dock->name; // Mengelompokkan berdasarkan nama 'dock'
                        })
                        ->map(function ($group) {
                            return $group->groupBy('scheduling_plan_id'); // Mengelompokkan ulang berdasarkan 'scheduling_plan_id'
                        });
                }else{
                    return redirect()->back();
                }
            }elseif ($request->filter_typeSchedule === 'month between') {
                // Set variabel untuk menyimpan nilai tanggal mulai dan akhir
                $start_date_schedule = trim($request->start_date_schedule);
                $end_date_schedule = trim($request->end_date_schedule);

                // Mengonversi string tanggal ke objek Carbon dengan parse
                $start_date = Carbon::parse($start_date_schedule)->startOfDay();
                $end_date = Carbon::parse($end_date_schedule)->endOfDay();

                // Hitung jumlah hari dalam rentang tanggal yang diberikan
                $data['totalDay'] = Carbon::createFromFormat('Y-m-d', $start_date_schedule)->diffInDays(Carbon::createFromFormat('Y-m-d', $end_date_schedule)) + 1;
                $data['type'] = 'month between';
                $data['text_title'] = 'Range Date: ' . Carbon::parse($start_date_schedule)->translatedFormat('F d, Y') . ' - ' . Carbon::parse($end_date_schedule)->translatedFormat('F d, Y');
                $data['month_value'] = null; // Null karena tidak relevan untuk rentang bulan
                $data['start_date_filter'] = $start_date_schedule; // Menyimpan tanggal awal

                // Ambil data scheduling_plan berdasarkan tanggal yang diberikan
                $data['scheduling_plan'] = SchedulingPlanDetail::with(['dock', 'schedulingPlan.supplier', 'schedulingPlan.ship']) // Eager loading relasi 'dock'
                    ->where(function ($query) use ($start_date, $end_date) {
                        // Filter data berdasarkan start_date berada di antara start_date dan end_date
                        $query->whereBetween('start_date', [$start_date, $end_date]);
                    })
                    ->get()
                    ->groupBy(function ($item) {
                        return $item->dock->name; // Mengelompokkan berdasarkan nama 'dock'
                    })
                    ->map(function ($group) {
                        return $group->groupBy('scheduling_plan_id'); // Mengelompokkan ulang berdasarkan 'scheduling_plan_id'
                    });
            }
        } else {
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $data['totalDay'] = Carbon::createFromDate($currentYear, $currentMonth)->daysInMonth;
            $data['type'] = 'month';
            $data['text_title'] = Carbon::createFromDate($currentYear, $currentMonth)->translatedFormat('F') . ' ' . $currentYear;
            $data['month_value'] = $currentYear . '-' . str_pad($currentMonth, 2, '0', STR_PAD_LEFT);
            $data['start_date_filter'] = Carbon::createFromDate($currentYear, $currentMonth, 1)->toDateString();
            $data['scheduling_plan'] = SchedulingPlanDetail::with(['dock', 'schedulingPlan.supplier', 'schedulingPlan.ship']) // Eager loading relasi 'dock'
                ->whereMonth('start_date', $currentMonth)
                ->whereYear('start_date', $currentYear)
                ->get()
                ->groupBy(function ($item) {
                    return $item->dock->name; // Mengelompokkan berdasarkan nama 'dock'
                })
                ->map(function ($group) {
                    return $group->groupBy('scheduling_plan_id'); // Mengelompokkan ulang berdasarkan 'scheduling_plan_id'
                });
        }



        $data['suppliers'] = Supplier::get();
        return view('dashboard', $data);
    }
}
