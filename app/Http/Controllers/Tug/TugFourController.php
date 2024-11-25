<?php

namespace App\Http\Controllers\Tug;

use App\Bunkers;
use Carbon\Carbon;
use App\Models\Tug;
use App\PersonInCharge;
use Illuminate\Http\Request;
use App\Models\GeneralManager;
use App\Http\Controllers\Controller;

class TugFourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tugs = Tug::query();
        $tugs->where('tug',3)
        ->when($request->date, function ($query) use ($request) {
            $date = explode('-', $request->date);
            $query->whereYear('receipt_date', $date[0]);
            $query->whereMonth('receipt_date', $date[1]);
        })->when($request->fuel, function ($query) use ($request) {
            $query->where('type_fuel', $request->fuel);
        });
        $data['tugs'] = $tugs->latest()->paginate(10)->appends(request()->query());
        return view('inputs.tug-4.index',$data);

    }
    public function detail($id){

        $tug = Tug::where('id',$id)->first();
        $data['pics'] = PersonInCharge::where('status',1)->get();
        $data['managers'] = GeneralManager::all();
        $data['bunkers'] = Bunkers::all();

        $array = json_decode($tug->user_inspections);
        $inspections = $array == null ? [] : $array;

        $data['inspections'] = PersonInCharge::whereIn('id',$inspections)->get();
        $data['tug'] = $tug;

        Carbon::setLocale('id');
        // Buat objek Carbon dari data tanggal
        $carbonDate = Carbon::now();
            
        // Tampilkan hari dalam bahasa Indonesia
        $day = $carbonDate->isoFormat('dddd'); 
        $data['day'] = $day;
        return view('inputs.tug-4.detail',$data);
    }

    public function edit($id){

        $data['tug'] = Tug::where('id',$id)->first();
        $data['pics'] = PersonInCharge::where('status',1)->get();
        $data['managers'] = GeneralManager::all();
        $data['bunkers'] = Bunkers::all();

        return view('inputs.tug-4.edit',$data);
    }

    public function update(Request $request,$id){
        
        $tug = Tug::where('id',$id)->first();
        $tug->tug_number = $request->tug_number;
        $tug->bpb_number = $request->bpb_number;
        $tug->inspection_date = $request->inspection_date;
        $tug->user_inspections = $request->user_inspections;
        $tug->general_manager = $request->general_manager;
        $tug->bunker_id = $request->bunker_id;
        $tug->save();


        return redirect(route('inputs.tug-4.index'))->with('success', 'TUG 4 berhasil diupdate.');
    }

    public function destroy($id)
    {
        Tug::where('id', $id)->delete();
        return redirect(route('inputs.tug-4.index'))->with('success', 'Pembongkaran Batu Bara berhasil di hapus.');
    }
}
