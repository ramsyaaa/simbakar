<?php

namespace App\Http\Controllers\Scheduling;

use App\Dock;
use App\Http\Controllers\Controller;
use App\SchedulingPlan;
use App\SchedulingPlanDetail;
use App\Ship;
use App\Supplier;
use Carbon\Carbon;
use DB;
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
        $types = $request->input('type');
        $dock = $request->input('dock');
        $calor = $request->input('calor');

        $scheduling = SchedulingPlan::create([
            'ship_id' => $request->ship,
            'calor' => $request->calor,
            'supplier_id' => $request->supplier,
        ]);

        $repeat = "run";
        $formattedStartDate = date("Y-m-d H:i:s", strtotime($startDate));
        $formattedEndDate = date("Y-m-d H:i:s", strtotime($endDate));
        $scheduling_id = $scheduling->id;

        while($repeat == "run"){
            $firstRecord = SchedulingPlanDetail::whereBetween('start_date', [$formattedStartDate, $formattedEndDate])->where([['dock_id', '=', $dock], ['scheduling_plan_id', '!=', $scheduling_id]])->first();
            if($firstRecord != null){
                $response = $this->calculateLoadData($firstRecord->id, $firstRecord->dock_id, $formattedEndDate);
                
                $formattedStartDate = $response['start_date'];
                $formattedEndDate = $response['end_date'];
                $scheduling_id = $response["scheduling_id"];
            }else{
                $repeat = "not run";
                break;
            }
        }

        $result = $this->processDateData($scheduling, $startDate, $endDate, $capacities, $dock, $speeds, $types);

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
        $types = $request->input('type');

        $result = $this->processDateData($scheduling, $startDate, $endDate, $capacities, $dock, $speeds, $types);


        if(count($result) > 0){
            SchedulingPlanDetail::insert($result);
        }

        $startDate = $request->input('start_date_new');
        $endDate = $request->input('end_date_new');
        $capacities = $request->input('capacity_new');
        $dock = $request->input('dock_new');
        $speeds = $request->input('speed_new');
        $types = $request->input('type_new');

        if($startDate != null && $endDate != null){
            $repeat = "run";
            $formattedStartDate = date("Y-m-d H:i:s", strtotime($startDate));
            $formattedEndDate = date("Y-m-d H:i:s", strtotime($endDate));
            $scheduling_id = $scheduling->id;

            while($repeat == "run"){
                $firstRecord = SchedulingPlanDetail::whereBetween('start_date', [$formattedStartDate, $formattedEndDate])->where([['dock_id', '=', $dock], ['scheduling_plan_id', '!=', $scheduling_id]])->first();
                if($firstRecord != null){
                    $response = $this->calculateLoadData($firstRecord->id, $firstRecord->dock_id, $formattedEndDate);
                    
                    $formattedStartDate = $response['start_date'];
                    $formattedEndDate = $response['end_date'];
                    $scheduling_id = $response["scheduling_id"];
                }else{
                    $repeat = "not run";
                    break;
                }
            }
            
            $result = $this->processDateData($scheduling, $startDate, $endDate, $capacities, $dock, $speeds, $types);

            if(count($result) > 0){
                SchedulingPlanDetail::insert($result);
            }
        }

        return redirect(route('administration.dashboard'))->with('success', 'Rencana jadwal baru berhasil dibuat.');
    }

    private function processDateData($scheduling, $startDate, $endDate, $capacities, $dock, $speed, $types)
    {
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        $result = [];

        // Loop through each day in the date range
        $i = 0;
        for ($date = $startDate->copy(); $date->lt($endDate->copy()->addDay()); $date->addDay()) {
            // Mengatur format tanggal agar sesuai dengan kunci di array kapasitas
            $formattedDate = $date->translatedFormat('j F Y'); // e.g., "13 Oktober 2024"
            if (!isset($capacities[$i]) || $capacities[$i] == null ||
                !isset($speed[$i]) || $speed[$i] == null ||
                !isset($types[$i]) || $types[$i] == null) {
                    continue;
            }

            if (isset($capacities[$i]) && $capacities[$i] !== null &&
                isset($speed[$i]) && $speed[$i] !== null &&
                isset($types[$i]) && $types[$i] !== null) {
                if ($date->isSameDay($startDate) && $date->isSameDay($endDate)) {
                    // Jika tanggal mulai dan akhir pada hari yang sama
                    $result[] = [
                        'scheduling_plan_id' => $scheduling->id,
                        'start_date' => $startDate->format('Y-m-d H:i:s'),
                        'end_date' => $endDate->format('Y-m-d H:i:s'),
                        'capacity' => $capacities[$i] ?? null,
                        'speed' => $speed[$i] ?? null,
                        'type' => $types[$i] ?? null,
                        'dock_id' => $dock,
                    ];
                } elseif ($date->isSameDay($startDate)) {
                    // Untuk hari mulai (tanggal pertama)
                    $result[] = [
                        'scheduling_plan_id' => $scheduling->id,
                        'start_date' => $startDate->format('Y-m-d H:i:s'),
                        'end_date' => $date->copy()->endOfDay()->format('Y-m-d H:i:s'),
                        'capacity' => $capacities[$i] ?? null,
                        'speed' => $speed[$i] ?? null,
                        'type' => $types[$i] ?? null,
                        'dock_id' => $dock,
                    ];
                } elseif ($date->isSameDay($endDate)) {
                    // Untuk hari akhir (tanggal terakhir)
                    $result[] = [
                        'scheduling_plan_id' => $scheduling->id,
                        'start_date' => $date->copy()->startOfDay()->format('Y-m-d H:i:s'),
                        'end_date' => $endDate->format('Y-m-d H:i:s'),
                        'capacity' => $capacities[$i] ?? null,
                        'speed' => $speed[$i] ?? null,
                        'type' => $types[$i] ?? null,
                        'dock_id' => $dock,
                    ];
                } else {
                    // Untuk hari di antara tanggal mulai dan tanggal akhir (hari penuh)
                    $result[] = [
                        'scheduling_plan_id' => $scheduling->id,
                        'start_date' => $date->copy()->startOfDay()->format('Y-m-d H:i:s'),
                        'end_date' => $date->copy()->endOfDay()->format('Y-m-d H:i:s'),
                        'capacity' => $capacities[$i] ?? null,
                        'speed' => $speed[$i] ?? null,
                        'type' => $types[$i] ?? null,
                        'dock_id' => $dock,
                    ];
                }
            }

            $i++;
        }

        return $result;



    }

    private function calculateLoadData($id_schedule_detail, $dock_id, $latest_end_date) {
        $schedule_detail = SchedulingPlanDetail::where([
            'id' => $id_schedule_detail
        ])->first();

        $all_schedule_detail_data = SchedulingPlanDetail::where([
            'scheduling_plan_id' => $schedule_detail->scheduling_plan_id,
            'dock_id' => $dock_id,
        ])->get();

        $scheduling = SchedulingPlan::where([
            'id' => $schedule_detail->scheduling_plan_id,
        ])->first();

        $dock = Dock::where([
            'id' => $dock_id,
        ])->first();

        $totalCapacity = $all_schedule_detail_data->sum('capacity');
        $dockRate = $dock->load_rate != null ? $dock->load_rate : 0;
        $duration_after_load = $dock->duration_after_load != null ? $dock->duration_after_load : 0;
        $duration_before_load = $dock->duration_before_load != null ? $dock->duration_before_load : 0;
        $startDateValue = Carbon::parse($latest_end_date)->addHours($duration_after_load + $duration_before_load);

        // Konversi start date ke timestamp
        $startDate = strtotime($startDateValue);
    
        // Buat timestamp untuk jam 23:59 di hari yang sama
        $endOfDay = strtotime(date('Y-m-d 23:59:00', $startDate));
    
        // Hitung selisih waktu dalam detik
        $timeDifferenceSec = $endOfDay - $startDate;
    
        // Konversi selisih waktu menjadi jam desimal
        $hoursRemainingDecimal = $timeDifferenceSec / 3600;
    
        // Hitung maksimal kapasitas yang bisa di-load pada hari pertama
        $maximumLoad = $hoursRemainingDecimal * $dockRate;
    
        // Hitung total load pada hari pertama
        $totalLoadFirstDay = min($maximumLoad, $totalCapacity);
        $firstDayTotalHours = round($hoursRemainingDecimal, 2);
    
        // Array untuk menampung hasil perhitungan per hari
        $loadData = [
            [
                'total' => round($totalLoadFirstDay, 2),
                'persentase' => 100,
                'type' => 'persentase',
                'total_jam' => $firstDayTotalHours
            ]
        ];
    
        // Hitung sisa kapasitas setelah hari pertama
        $remainingCapacity = $totalCapacity - $totalLoadFirstDay;
    
        if ($remainingCapacity > 0) {
            $days = 1; // Hari pertama sudah dihitung, mulai dari hari berikutnya
            while ($remainingCapacity > 0) {
                // Hitung waktu yang dibutuhkan untuk memuat sisa kapasitas per hari
                $loadForTheDay = min($remainingCapacity, $dockRate * 24); // 24 jam dalam sehari
                $totalHoursForDay = $loadForTheDay / $dockRate; // Jam yang dibutuhkan pada hari tersebut
    
                // Tambahkan ke array loadData
                $loadData[] = [
                    'total' => round($loadForTheDay, 2),
                    'persentase' => 100,
                    'type' => 'persentase',
                    'total_jam' => round($totalHoursForDay, 2)
                ];
    
                // Kurangi sisa kapasitas
                $remainingCapacity -= $loadForTheDay;
    
                $days++; // Hitung hari selanjutnya
            }
        }
    
        // Hitung total jam yang digunakan dari awal hingga akhir
        $totalHoursUsed = 0;
        foreach ($loadData as $day) {
            $totalHoursUsed += $day['total_jam'];
        }
    
        // Hitung end_date dalam bentuk timestamp
        $endDate = $startDate + ($totalHoursUsed * 3600);
    
        // Pisahkan data ke dalam masing-masing array
        $capacities = array_column($loadData, 'total'); // Mengambil nilai total
        $speeds = array_column($loadData, 'persentase'); // Mengambil nilai persentase
        $types = array_column($loadData, 'type'); // Mengambil nilai type

        $startDate = date('Y-m-d H:i:s', $startDate);
        $formattedStartDate = strtotime($startDate);
        $formattedStartDate = date('Y-m-d\TH:i', $formattedStartDate);
        $endDate = date('Y-m-d H:i:s', $endDate);
        $formattedEndDate = strtotime($endDate);
        $formattedEndDate = date('Y-m-d\TH:i', $formattedEndDate);

        SchedulingPlanDetail::where([
            'scheduling_plan_id' => $schedule_detail->scheduling_plan_id,
            'dock_id' => $dock_id,
        ])->delete();

        $result = $this->processDateData($scheduling, $formattedStartDate, $formattedEndDate, $capacities, $dock, $speeds, $types);
        foreach ($result as &$item) {
            $item['dock_id'] = $dock_id;
        }

        if(count($result) > 0){
            SchedulingPlanDetail::insert($result);
        }
    
        // Kembalikan hasil
        return [
            'end_date' => $endDate,
            'start_date' => $startDate,
            'scheduling_id' => $scheduling->id,
        ];
    }
       
}
