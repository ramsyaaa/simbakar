<?php

namespace App\Http\Controllers\Tug;


use App\Unit;

use App\BbmUsage;
use App\Models\Tug;
use App\HeavyEquipment;
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

    public function detailCoal(Request $request,$id)
    {
        $tugs = CoalUsage::where('id',$id)->first();
        $data['units'] = Unit::all();
        $data['tug'] = $tugs;
        return view('inputs.tug-9.detail',$data);

    }

    public function indexUnit(Request $request)
    {
        $tugs = BbmUsage::query();
        $tugs->where('bbm_use_for','unit')->with('unit')->when($request->date, function ($query) use ($request) {
            $date = explode('-', $request->date);
            $query->whereYear('use_date', $date[0]);
            $query->whereMonth('use_date', $date[1]);
        })->when($request->unit, function ($query) use ($request) {
            $query->where('unit_uuid', $request->unit);
        });
        $data['units'] = Unit::all();
        $data['tugs'] = $tugs->latest()->paginate(10)->appends(request()->query());
        return view('inputs.tug-9.indexUnit',$data);

    }

    public function detailUnit(Request $request,$id)
    {
        $tugs = BbmUsage::where('id',$id)->first();
        $data['units'] = Unit::all();
        $data['tug'] = $tugs;
        return view('inputs.tug-9.detailUnit',$data);

    }

    public function indexHeavy(Request $request)
    {
        $tugs = BbmUsage::query();
        $tugs->where('bbm_use_for','heavy_equipment')->with('heavyEquipment')->when($request->date, function ($query) use ($request) {
            $date = explode('-', $request->date);
            $query->whereYear('use_date', $date[0]);
            $query->whereMonth('use_date', $date[1]);
        })->when($request->heavy, function ($query) use ($request) {
            $query->where('heavy_equipment_uuid', $request->heavy);
        });
        $data['heavies'] = HeavyEquipment::all();
        $data['tugs'] = $tugs->latest()->paginate(10)->appends(request()->query());
        
        return view('inputs.tug-9.indexHeavy',$data);
    }
    
    public function detailHeavy(Request $request,$id)
    {
        $tugs = BbmUsage::where('id',$id)->first();
        $data['heavies'] = HeavyEquipment::all();
        $data['tug'] = $tugs;

        return view('inputs.tug-9.detailHeavy',$data);

    }

    public function indexOther(Request $request)
    {
        $tugs = BbmUsage::query();
        $tugs->where('bbm_use_for','other')->with('heavyEquipment')->when($request->date, function ($query) use ($request) {
            $date = explode('-', $request->date);
            $query->whereYear('use_date', $date[0]);
            $query->whereMonth('use_date', $date[1]);
        });
        $data['tugs'] = $tugs->latest()->paginate(10)->appends(request()->query());
        return view('inputs.tug-9.indexOther',$data);

    }

    public function detailOther(Request $request,$id)
    {
        $tugs = BbmUsage::where('id',$id)->first();
        $data['tug'] = $tugs;
        return view('inputs.tug-9.detailOther',$data);

    }

}
