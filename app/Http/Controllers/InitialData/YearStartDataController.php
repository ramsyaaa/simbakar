<?php

namespace App\Http\Controllers\InitialData;

use App\Http\Controllers\Controller;
use App\Models\YearStartData;
use Illuminate\Http\Request;

class YearStartDataController extends Controller
{
    public function index(Request $request){
        $data['start_years'] = YearStartData::all()->groupBy('type');
        return view('initial-data.year-start.index', $data);
    }

    public function edit(Request $request, $uuid){
        $data['start_year'] = YearStartData::where([
            'uuid' => $uuid,
        ])->first();
        return view('initial-data.year-start.edit', $data);
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
