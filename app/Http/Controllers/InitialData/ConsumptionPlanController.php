<?php

namespace App\Http\Controllers\InitialData;

use App\Http\Controllers\Controller;
use App\Models\ConsumptionPlan;
use App\Models\SettingBpb;
use Illuminate\Http\Request;

class ConsumptionPlanController extends Controller
{
    public function index(Request $request){
        $data['year'] = $request->input('year') ? $request->input('year') : date('Y');
        if ($data['year']) {
            $data['consumption_plans'] = ConsumptionPlan::where([
                'year' => $data['year'],
            ])->get()->groupBy('type');
        }else{
            $data['consumption_plans'] = ConsumptionPlan::orderBy('year','desc')->get()->groupBy('type');
        }

        return view('initial-data.consumption-plans.index', $data);
    }

    public function create(Request $request){
        return view('initial-data.consumption-plans.create');
    }

    public function edit(Request $request, $uuid){
        $data['consumption_plan'] = ConsumptionPlan::where([
            'uuid' => $uuid,
        ])->first();
        return view('initial-data.consumption-plans.edit', $data);
    }

    public function  store(Request $request){
        $request->validate([
            'planning_january' => 'nullable|numeric',
            'planning_february' => 'nullable|numeric',
            'planning_march' => 'nullable|numeric',
            'planning_april' => 'nullable|numeric',
            'planning_may' => 'nullable|numeric',
            'planning_june' => 'nullable|numeric',
            'planning_july' => 'nullable|numeric',
            'planning_august' => 'nullable|numeric',
            'planning_september' => 'nullable|numeric',
            'planning_october' => 'nullable|numeric',
            'planning_november' => 'nullable|numeric',
            'planning_december' => 'nullable|numeric',
        ]);

        ConsumptionPlan::create([
            'setting_bpb_uuid' => 1,
            'planning_january' => $request->planning_january,
            'planning_february' => $request->planning_february,
            'planning_march' => $request->planning_march,
            'planning_april' => $request->planning_april,
            'planning_may' => $request->planning_may,
            'planning_june' => $request->planning_june,
            'planning_july' => $request->planning_july,
            'planning_august' => $request->planning_august,
            'planning_september' => $request->planning_september,
            'planning_october' => $request->planning_october,
            'planning_november' => $request->planning_november,
            'planning_december' => $request->planning_december,
            'type' => $request->type,
            'year' => $request->year,
        ]);

        return redirect()->route('initial-data.consuption-plan.index')->with('success', 'Data berhasil ditambah.');
    }

    public function  update(Request $request, $uuid){
        $request->validate([
            'planning_january' => 'nullable|numeric',
            'planning_february' => 'nullable|numeric',
            'planning_march' => 'nullable|numeric',
            'planning_april' => 'nullable|numeric',
            'planning_may' => 'nullable|numeric',
            'planning_june' => 'nullable|numeric',
            'planning_july' => 'nullable|numeric',
            'planning_august' => 'nullable|numeric',
            'planning_september' => 'nullable|numeric',
            'planning_october' => 'nullable|numeric',
            'planning_november' => 'nullable|numeric',
            'planning_december' => 'nullable|numeric',
        ]);

        ConsumptionPlan::where('uuid', $uuid)->update([
            'planning_january' => $request->planning_january,
            'planning_february' => $request->planning_february,
            'planning_march' => $request->planning_march,
            'planning_april' => $request->planning_april,
            'planning_may' => $request->planning_may,
            'planning_june' => $request->planning_june,
            'planning_july' => $request->planning_july,
            'planning_august' => $request->planning_august,
            'planning_september' => $request->planning_september,
            'planning_october' => $request->planning_october,
            'planning_november' => $request->planning_november,
            'planning_december' => $request->planning_december,
            'type' => $request->type,
            'year' => $request->year,
        ]);

        return redirect()->route('initial-data.consuption-plan.index')->with('success', 'Data berhasil diupdate.');
    }
}
