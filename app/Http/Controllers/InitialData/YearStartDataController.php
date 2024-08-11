<?php

namespace App\Http\Controllers\InitialData;

use App\Http\Controllers\Controller;
use App\Models\YearStartData;
use Illuminate\Http\Request;

class YearStartDataController extends Controller
{
    public function index(Request $request){
        
        $start_years = YearStartData::orderBy('year','desc')->get()->groupBy('type');
        $data['start_years'] = $start_years->isEmpty() == true ? null : $start_years;
        return view('initial-data.year-start.index', $data);
    }

    public function create(Request $request){

        return view('initial-data.year-start.create');
    }

    public function edit(Request $request, $uuid){
        $data['start_year'] = YearStartData::where([
            'uuid' => $uuid,
        ])->first();
        return view('initial-data.year-start.edit', $data);
    }

    public function  store(Request $request){

        $request->validate([
            'planning' => 'nullable|numeric',
            'actual' => 'nullable|numeric',
        ]);

        YearStartData::create([
            'setting_bpb_uuid' => 1,
            'type' => $request->type,
            'planning' => $request->planning,
            'actual' => $request->actual,
            'year' => $request->year,
        ]);

        return redirect(route('initial-data.year-start.index'))->with('success', 'Data berhasil ditambah.');
    }

    public function  update(Request $request, $uuid){
        $request->validate([
            'planning' => 'nullable|numeric',
            'actual' => 'nullable|numeric',
        ]);

        YearStartData::where('uuid', $uuid)->update([
            'planning' => $request->planning,
            'actual' => $request->actual,
        ]);

        return redirect(route('initial-data.year-start.index'))->with('success', 'Data berhasil diupdate.');
    }
}
