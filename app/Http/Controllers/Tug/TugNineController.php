<?php

namespace App\Http\Controllers\Tug;


use App\Unit;

use App\Models\Tug;
use App\Models\CoalUsage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TugNineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCoal(Request $request)
    {
        $tugs = CoalUsage::query();
        $tugs->with('unit')->when($request->date, function ($query) use ($request) {
            $date = explode('-', $request->date);
            $query->whereYear('usage_date', $date[0]);
            $query->whereMonth('usage_date', $date[1]);
        })->when($request->unit, function ($query) use ($request) {
            $query->where('unit_id', $request->unit);
        });
        $data['units'] = Unit::all();
        $data['tugs'] = $tugs->latest()->paginate(10)->appends(request()->query());
        return view('inputs.tug-9.index',$data);

    }

}
