<?php

namespace App\Http\Controllers\InitialData;

use App\Http\Controllers\Controller;
use App\Models\ElectricityProduction;
use App\Models\SettingBpb;
use Illuminate\Http\Request;

class ElectricityProductionController extends Controller
{
    public function index(Request $request){
        $data['year'] = $request->input('year');
        if ($data['year']) {
            $data['electric_production'] = ElectricityProduction::where('year',$data['year'])->orderBy('year','desc')->first();
        }else{
            $data['electric_production'] = ElectricityProduction::orderBy('year','desc')->first();
        }
        return view('initial-data.electricity-production.index', $data);
    }

    public function create(Request $request){

        return view('initial-data.electricity-production.create');
    }

    public function edit(Request $request, $uuid){
        $data['electric_production'] = ElectricityProduction::where([
            'uuid' => $uuid,
        ])->first();
        return view('initial-data.electricity-production.edit', $data);
    }

    public function  store(Request $request){

        $request->validate([
            'planning_january' => 'nullable|numeric',
            'actual_january' => 'nullable|numeric',
            'planning_february' => 'nullable|numeric',
            'actual_february' => 'nullable|numeric',
            'planning_march' => 'nullable|numeric',
            'actual_march' => 'nullable|numeric',
            'planning_april' => 'nullable|numeric',
            'actual_april' => 'nullable|numeric',
            'planning_may' => 'nullable|numeric',
            'actual_may' => 'nullable|numeric',
            'planning_june' => 'nullable|numeric',
            'actual_june' => 'nullable|numeric',
            'planning_july' => 'nullable|numeric',
            'actual_july' => 'nullable|numeric',
            'planning_august' => 'nullable|numeric',
            'actual_august' => 'nullable|numeric',
            'planning_september' => 'nullable|numeric',
            'actual_september' => 'nullable|numeric',
            'planning_october' => 'nullable|numeric',
            'actual_october' => 'nullable|numeric',
            'planning_november' => 'nullable|numeric',
            'actual_november' => 'nullable|numeric',
            'planning_december' => 'nullable|numeric',
            'actual_december' => 'nullable|numeric',
        ]);

        ElectricityProduction::create([
            'setting_bpb_uuid' => 1,
            'planning_january' => $request->planning_january,
            'actual_january' => $request->actual_january,
            'planning_february' => $request->planning_february,
            'actual_february' => $request->actual_february,
            'planning_march' => $request->planning_march,
            'actual_march' => $request->actual_march,
            'planning_april' => $request->planning_april,
            'actual_april' => $request->actual_april,
            'planning_may' => $request->planning_may,
            'actual_may' => $request->actual_may,
            'planning_june' => $request->planning_june,
            'actual_june' => $request->actual_june,
            'planning_july' => $request->planning_july,
            'actual_july' => $request->actual_july,
            'planning_august' => $request->planning_august,
            'actual_august' => $request->actual_august,
            'planning_september' => $request->planning_september,
            'actual_september' => $request->actual_september,
            'planning_october' => $request->planning_october,
            'actual_october' => $request->actual_october,
            'planning_november' => $request->planning_november,
            'actual_november' => $request->actual_november,
            'planning_december' => $request->planning_december,
            'actual_december' => $request->actual_december,
            'year' => $request->year
        ]);

        return redirect()->route('initial-data.electricity-production.index')->with('success', 'Data berhasil ditambah.');
    }

    public function  update(Request $request, $uuid){
        $request->validate([
            'planning_january' => 'nullable|numeric',
            'actual_january' => 'nullable|numeric',
            'planning_february' => 'nullable|numeric',
            'actual_february' => 'nullable|numeric',
            'planning_march' => 'nullable|numeric',
            'actual_march' => 'nullable|numeric',
            'planning_april' => 'nullable|numeric',
            'actual_april' => 'nullable|numeric',
            'planning_may' => 'nullable|numeric',
            'actual_may' => 'nullable|numeric',
            'planning_june' => 'nullable|numeric',
            'actual_june' => 'nullable|numeric',
            'planning_july' => 'nullable|numeric',
            'actual_july' => 'nullable|numeric',
            'planning_august' => 'nullable|numeric',
            'actual_august' => 'nullable|numeric',
            'planning_september' => 'nullable|numeric',
            'actual_september' => 'nullable|numeric',
            'planning_october' => 'nullable|numeric',
            'actual_october' => 'nullable|numeric',
            'planning_november' => 'nullable|numeric',
            'actual_november' => 'nullable|numeric',
            'planning_december' => 'nullable|numeric',
            'actual_december' => 'nullable|numeric',
        ]);

        ElectricityProduction::where('uuid', $uuid)->update([
            'planning_january' => $request->planning_january,
            'actual_january' => $request->actual_january,
            'planning_february' => $request->planning_february,
            'actual_february' => $request->actual_february,
            'planning_march' => $request->planning_march,
            'actual_march' => $request->actual_march,
            'planning_april' => $request->planning_april,
            'actual_april' => $request->actual_april,
            'planning_may' => $request->planning_may,
            'actual_may' => $request->actual_may,
            'planning_june' => $request->planning_june,
            'actual_june' => $request->actual_june,
            'planning_july' => $request->planning_july,
            'actual_july' => $request->actual_july,
            'planning_august' => $request->planning_august,
            'actual_august' => $request->actual_august,
            'planning_september' => $request->planning_september,
            'actual_september' => $request->actual_september,
            'planning_october' => $request->planning_october,
            'actual_october' => $request->actual_october,
            'planning_november' => $request->planning_november,
            'actual_november' => $request->actual_november,
            'planning_december' => $request->planning_december,
            'actual_december' => $request->actual_december,
            'year' => $request->year
        ]);

        return redirect()->route('initial-data.electricity-production.index')->with('success', 'Data berhasil diupdate.');
    }
}
