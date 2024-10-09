<?php

namespace App\Http\Controllers\Scheduling;

use App\Dock;
use App\Http\Controllers\Controller;
use App\SchedulingPlan;
use App\SchedulingPlanDetail;
use App\Ship;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SchedulingPlanController extends Controller
{
    public function create(){
        $data['ships'] = Ship::orderBy('name', 'asc')->get();
        $data['docks'] = Dock::orderBy('name', 'asc')->get();
        $data['suppliers'] =Supplier::orderBy('name', 'asc')->get();
        return view('scheduling.create', $data);
    }

    public function edit($id){
        $data['detail'] = SchedulingPlanDetail::with(['schedulingPlan.ship'])->findOrFail($id);
        $data['docks'] = Dock::orderBy('name', 'asc')->get();
        return view('scheduling.edit', $data);
    }

    public function store(Request $request)
    {
        // Ambil data dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $capacities = $request->input('capacity');
        $dock = $request->input('dock');

        $scheduling = SchedulingPlan::create([
            'ship_id' => $request->ship,
        ]);

        $result = $this->processDateData($scheduling, $startDate, $endDate, $capacities, $dock);

        if(count($result) > 0){
            SchedulingPlanDetail::insert($result);
        }

        return redirect(route('administration.dashboard'))->with('success', 'Rencana jadwal baru berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        // Ambil data dari request
        $detail = SchedulingPlanDetail::findOrFail($id);
        $scheduling = SchedulingPlan::where('id', $detail->scheduling_plan_id)->first();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $capacities = $request->input('capacity');
        $dock = $request->input('dock');

        $result = $this->processDateData($scheduling, $startDate, $endDate, $capacities, $dock);

        SchedulingPlanDetail::where('scheduling_plan_id', $scheduling->id)
            ->where('start_date', '>', $startDate)
            ->delete();

        if($detail->start_date == $startDate){
            SchedulingPlanDetail::where('id', $id)->delete();
        }else{
            SchedulingPlanDetail::where('id', $id)->update([
                'end_date' => $startDate
            ]);
        }


        if(count($result) > 0){
            SchedulingPlanDetail::insert($result);
        }

        return redirect(route('administration.dashboard'))->with('success', 'Rencana jadwal baru berhasil dibuat.');
    }

    private function processDateData($scheduling, $startDate, $endDate, $capacities, $dock)
    {
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        $result = [];

        // Loop through each day in the date range
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                // Mengatur format tanggal agar sesuai dengan kunci di array kapasitas
                $formattedDate = $date->translatedFormat('j F Y'); // e.g., "8 Oktober 2024"

                // Menentukan waktu mulai dan waktu selesai tergantung pada posisi tanggal
                if ($date->isSameDay($startDate) && $date->isSameDay($endDate)) {
                    // Jika tanggal mulai dan akhir pada hari yang sama
                    $result[] = [
                        'scheduling_plan_id' => $scheduling->id,
                        'start_date' => $startDate->format('Y-m-d H:i:s'),
                        'end_date' => $endDate->format('Y-m-d H:i:s'),
                        'capacity' => $capacities[$formattedDate] ?? null,
                        'dock_id' => $dock,
                    ];
                } elseif ($date->isSameDay($startDate)) {
                    // Untuk hari mulai
                    $result[] = [
                        'scheduling_plan_id' => $scheduling->id,
                        'start_date' => $startDate->format('Y-m-d H:i:s'),
                        'end_date' => $date->copy()->endOfDay()->format('Y-m-d H:i:s'),
                        'capacity' => $capacities[$formattedDate] ?? null,
                        'dock_id' => $dock,
                    ];
                } elseif ($date->isSameDay($endDate)) {
                    // Untuk hari akhir
                    $result[] = [
                        'scheduling_plan_id' => $scheduling->id,
                        'start_date' => $date->copy()->startOfDay()->format('Y-m-d H:i:s'),
                        'end_date' => $endDate->format('Y-m-d H:i:s'),
                        'capacity' => $capacities[$formattedDate] ?? null,
                        'dock_id' => $dock,
                    ];
                } else {
                    // Untuk hari di antara tanggal mulai dan tanggal akhir
                    $result[] = [
                        'scheduling_plan_id' => $scheduling->id,
                        'start_date' => $date->copy()->startOfDay()->format('Y-m-d H:i:s'),
                        'end_date' => $date->copy()->endOfDay()->format('Y-m-d H:i:s'),
                        'capacity' => $capacities[$formattedDate] ?? null,
                        'dock_id' => $dock,
                    ];
                }
            }

        return $result;
    }
}
