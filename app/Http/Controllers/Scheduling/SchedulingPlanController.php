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
        $data['scheduling'] = SchedulingPlanDetail::where([['id', '>=', $id], ['scheduling_plan_id', '=', $data['detail']->scheduling_plan_id], ['dock_id', '=', $data['detail']->dock_id]])->get();
        $data['docks'] = Dock::orderBy('name', 'asc')->get();

        $data['total'] = 0;
        $data['start_date'] = null;
        $data['end_date'] = null;
        if (!empty($data['scheduling'])) {
            $data['start_date'] = $data['scheduling'][0]->start_date;
            $data['end_date'] = $data['scheduling'][count($data['scheduling']) - 1]->end_date;

            // Hitung total kapasitas
            foreach ($data['scheduling'] as $scheduling) {
                $data['total'] += $scheduling->capacity;
            }
        }
        return view('scheduling.edit', $data);
    }

    public function store(Request $request)
    {
        // Ambil data dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $capacities = $request->input('capacity');
        $speeds = $request->input('speed');
        $dock = $request->input('dock');
        $calor = $request->input('calor');

        $scheduling = SchedulingPlan::create([
            'ship_id' => $request->ship,
            'calor' => $request->calor,
            'supplier_id' => $request->supplier,
        ]);

        $result = $this->processDateData($scheduling, $startDate, $endDate, $capacities, $dock, $speeds);

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

        SchedulingPlanDetail::where('scheduling_plan_id', $scheduling->id)
            ->where('id', '>=', $id)
            ->delete();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $capacities = $request->input('capacity');
        $dock = $detail->dock_id;
        $speeds = $request->input('speed');

        $result = $this->processDateData($scheduling, $startDate, $endDate, $capacities, $dock, $speeds);


        if(count($result) > 0){
            SchedulingPlanDetail::insert($result);
        }

        $startDate = $request->input('start_date_new');
        $endDate = $request->input('end_date_new');
        $capacities = $request->input('capacity_new');
        $dock = $request->input('new_dock');
        $speeds = $request->input('speed_new');

        if($startDate != null && $endDate != null){
            $result = $this->processDateData($scheduling, $startDate, $endDate, $capacities, $dock, $speeds);

            if(count($result) > 0){
                SchedulingPlanDetail::insert($result);
            }
        }

        return redirect(route('administration.dashboard'))->with('success', 'Rencana jadwal baru berhasil dibuat.');
    }

    private function processDateData($scheduling, $startDate, $endDate, $capacities, $dock, $speed)
    {
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        $result = [];

        // Loop through each day in the date range
        for ($date = $startDate->copy(); $date->lt($endDate->copy()->addDay()); $date->addDay()) {
            // Mengatur format tanggal agar sesuai dengan kunci di array kapasitas
            $formattedDate = $date->translatedFormat('j F Y'); // e.g., "13 Oktober 2024"
            if (!isset($capacities[$formattedDate]) || $capacities[$formattedDate] == null ||
                !isset($speed[$formattedDate]) || $speed[$formattedDate] == null) {
                    continue;
            }

            if (isset($capacities[$formattedDate]) && $capacities[$formattedDate] !== null &&
                isset($speed[$formattedDate]) && $speed[$formattedDate] !== null) {
                if ($date->isSameDay($startDate) && $date->isSameDay($endDate)) {
                    // Jika tanggal mulai dan akhir pada hari yang sama
                    $result[] = [
                        'scheduling_plan_id' => $scheduling->id,
                        'start_date' => $startDate->format('Y-m-d H:i:s'),
                        'end_date' => $endDate->format('Y-m-d H:i:s'),
                        'capacity' => $capacities[$formattedDate] ?? null,
                        'speed' => $speed[$formattedDate] ?? null,
                        'dock_id' => $dock,
                    ];
                } elseif ($date->isSameDay($startDate)) {
                    // Untuk hari mulai (tanggal pertama)
                    $result[] = [
                        'scheduling_plan_id' => $scheduling->id,
                        'start_date' => $startDate->format('Y-m-d H:i:s'),
                        'end_date' => $date->copy()->endOfDay()->format('Y-m-d H:i:s'),
                        'capacity' => $capacities[$formattedDate] ?? null,
                        'speed' => $speed[$formattedDate] ?? null,
                        'dock_id' => $dock,
                    ];
                } elseif ($date->isSameDay($endDate)) {
                    // Untuk hari akhir (tanggal terakhir)
                    $result[] = [
                        'scheduling_plan_id' => $scheduling->id,
                        'start_date' => $date->copy()->startOfDay()->format('Y-m-d H:i:s'),
                        'end_date' => $endDate->format('Y-m-d H:i:s'),
                        'capacity' => $capacities[$formattedDate] ?? null,
                        'speed' => $speed[$formattedDate] ?? null,
                        'dock_id' => $dock,
                    ];
                } else {
                    // Untuk hari di antara tanggal mulai dan tanggal akhir (hari penuh)
                    $result[] = [
                        'scheduling_plan_id' => $scheduling->id,
                        'start_date' => $date->copy()->startOfDay()->format('Y-m-d H:i:s'),
                        'end_date' => $date->copy()->endOfDay()->format('Y-m-d H:i:s'),
                        'capacity' => $capacities[$formattedDate] ?? null,
                        'speed' => $speed[$formattedDate] ?? null,
                        'dock_id' => $dock,
                    ];
                }
            }
        }

        return $result;



    }
}
