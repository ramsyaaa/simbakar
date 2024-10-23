<?php

namespace App\Http\Controllers\Coal;

use App\Dock;
use App\Ship;
use App\Loading;
use App\Supplier;
use App\Unloading;
use Carbon\Carbon;
use App\Models\Tug;
use App\LoadingCompany;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CoalUnloadingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $unloadings = CoalUnloading::query();
        $unloadings->when($request->date, function ($query) use ($request) {
            $date = explode('-', $request->date);
            $query->whereYear('receipt_date', $date[0]);
            $query->whereMonth('receipt_date', $date[1]);
        });
        $data['unloadings'] = $unloadings->orderBy('tug_number','desc')->paginate(10)->appends(request()->query());
        // dd($data);
        return view('coals.unloadings.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['companies'] = LoadingCompany::all();
        $data['suppliers'] = Supplier::all();
        $data['docks'] = Dock::all();
        $data['ships'] = Ship::all();
        return view('coals.unloadings.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $date = Carbon::parse($request->end_date_month); // Mengubah string menjadi instance Carbon
            $formattedDate = $date->format('Y-m-d'); 
            $formattedYear = $date->format('Y'); 

            $lastUnloadingToday = CoalUnloading::whereDate('receipt_date', $formattedDate)->get()->count() + 1;

            $countTug = sprintf("%02d", $lastUnloadingToday);
            $tugNumber = 'B.'.$date->format('Ymd').'.'.$countTug;

            $loading = $request->loading_date_month.' '.$request->loading_date_hour.':'.$request->loading_date_minute;
            $loading_date = Carbon::parse($loading)->format('Y-m-d H:i:s');

            $dock_ship = $request->dock_ship_date_date_month.' '.$request->dock_ship_date_hour.':'.$request->dock_ship_date_minute;       
            $dock_ship_date= Carbon::parse($dock_ship)->format('Y-m-d H:i:s');

            $arrived = $request->arrived_date_month.' '.$request->arrived_date_hour.':'.$request->arrived_date_minute;

            $arrived_date= Carbon::parse($arrived)->format('Y-m-d H:i:s');
            
            $unloading = $request->unloading_date_month.' '.$request->unloading_date_hour.':'.$request->unloading_date_minute;
            $unloading_date= Carbon::parse($unloading)->format('Y-m-d H:i:s');

            $end = $request->end_date_month.' '.$request->end_date_hour.':'.$request->end_date_minute;
            $end_date= Carbon::parse($end)->format('Y-m-d H:i:s');

            $departure = $request->departure_date_month.' '.$request->departure_date_hour.':'.$request->departure_date_minute;
            $departure_date= Carbon::parse($departure)->format('Y-m-d H:i:s');

            $lastUnloadingYear = CoalUnloading::whereYear('receipt_date',$formattedYear)->get()->count() + 1;
            $bpbNumber = 'B.'.$formattedYear.'.'.$lastUnloadingYear;

            $requestData = $request->all();
            $requestData['tug_number'] = $tugNumber;
            $requestData['bpb_number'] = $bpbNumber;
            $requestData['loading_date'] = $loading_date;
            $requestData['dock_ship_date'] = $dock_ship_date;
            $requestData['arrived_date'] = $arrived_date;
            $requestData['unloading_date'] = $unloading_date;
            $requestData['end_date'] = $end_date;
            $requestData['departure_date'] = $departure_date;
            $requestData['receipt_date'] = $end_date;
            $requestData['form_part_number'] = '18.01.0009';
            $requestData['unit'] = 'Kg';


            $unloading = CoalUnloading::create($requestData);

            $unloadingData = Unloading::create([
                'coal_unloading_id' => $unloading->id,
            ]);

            Tug::create([
                'tug' => 3,
                'tug_number' => $tugNumber,
                'bpb_number' => $bpbNumber,
                'type_tug' => 'coal-unloading',
                'usage_amount' =>0,
                'unit' => 'Kg',
                'type_fuel' => 'Batu Bara',
                'coal_unloading_id' => $unloading->id,
            ]);

            DB::commit();
            return redirect(route('coals.unloadings.index'))->with('success', 'Pembongkaran Batu Bara berhasil di buat.');

        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Pembongkaran Batu Bara gagal di buat');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unloading = CoalUnloading::where('id', $id)->first();
        $unloading['loading_date_month'] = Carbon::parse($unloading->loading_date)->format('Y-m-d');
        $unloading['loading_date_hour'] = Carbon::parse($unloading->loading_date)->format('H');
        $unloading['loading_date_minute'] = Carbon::parse($unloading->loading_date)->format('i');

        $unloading['unloading_date_month'] = Carbon::parse($unloading->unloading_date)->format('Y-m-d');
        $unloading['unloading_date_hour'] = Carbon::parse($unloading->unloading_date)->format('H');
        $unloading['unloading_date_minute'] = Carbon::parse($unloading->unloading_date)->format('i');

        $unloading['dock_ship_date_month'] = Carbon::parse($unloading->dock_ship_date)->format('Y-m-d');
        $unloading['dock_ship_date_hour'] = Carbon::parse($unloading->dock_ship_date)->format('H');
        $unloading['dock_ship_date_minute'] = Carbon::parse($unloading->dock_ship_date)->format('i');

        $unloading['arrived_date_month'] = Carbon::parse($unloading->arrived_date)->format('Y-m-d');
        $unloading['arrived_date_hour'] = Carbon::parse($unloading->arrived_date)->format('H');
        $unloading['arrived_date_minute'] = Carbon::parse($unloading->arrived_date)->format('i');

        $unloading['unloading_date_month'] = Carbon::parse($unloading->unloading_date)->format('Y-m-d');
        $unloading['unloading_date_hour'] = Carbon::parse($unloading->unloading_date)->format('H');
        $unloading['unloading_date_minute'] = Carbon::parse($unloading->unloading_date)->format('i');

        $unloading['end_date_month'] = Carbon::parse($unloading->end_date)->format('Y-m-d');
        $unloading['end_date_hour'] = Carbon::parse($unloading->end_date)->format('H');
        $unloading['end_date_minute'] = Carbon::parse($unloading->end_date)->format('i');

        $unloading['departure_date_month'] = Carbon::parse($unloading->departure_date)->format('Y-m-d');
        $unloading['departure_date_hour'] = Carbon::parse($unloading->departure_date)->format('H');
        $unloading['departure_date_minute'] = Carbon::parse($unloading->departure_date)->format('i');

        $data['companies'] = LoadingCompany::all();
        $data['suppliers'] = Supplier::all();
        $data['docks'] = Dock::all();
        $data['ship'] = Ship::where('id',$unloading->ship_id)->first();
        $data['loading'] = Loading::where('id',$unloading->analysis_loading_id)->first();
        $data['unloading'] = $unloading;
        return view('coals.unloadings.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        DB::beginTransaction();
        try {

            $requestData = $request->except(['_token','_method']);

            $loading = $request->loading_date_month.' '.$request->loading_date_hour.':'.$request->loading_date_minute;
            $loading_date = Carbon::parse($loading)->format('Y-m-d H:i:s');

            $dock_ship = $request->dock_ship_date_date_month.' '.$request->dock_ship_date_hour.':'.$request->dock_ship_date_minute;       
            $dock_ship_date= Carbon::parse($dock_ship)->format('Y-m-d H:i:s');

            $arrived = $request->arrived_date_month.' '.$request->arrived_date_hour.':'.$request->arrived_date_minute;

            $arrived_date= Carbon::parse($arrived)->format('Y-m-d H:i:s');
            
            $unloading = $request->unloading_date_month.' '.$request->unloading_date_hour.':'.$request->unloading_date_minute;
            $unloading_date= Carbon::parse($unloading)->format('Y-m-d H:i:s');

            $end = $request->end_date_month.' '.$request->end_date_hour.':'.$request->end_date_minute;
            $end_date= Carbon::parse($end)->format('Y-m-d H:i:s');

            $departure = $request->departure_date_month.' '.$request->departure_date_hour.':'.$request->departure_date_minute;
            $departure_date= Carbon::parse($departure)->format('Y-m-d H:i:s');

            $requestData['loading_date'] = $loading_date;
            $requestData['dock_ship_date'] = $dock_ship_date;
            $requestData['arrived_date'] = $arrived_date;
            $requestData['unloading_date'] = $unloading_date;
            $requestData['end_date'] = $end_date;
            $requestData['departure_date'] = $departure_date;
            $requestData['receipt_date'] = $end_date;

            CoalUnloading::where('id',$id)->update([
                'analysis_loading_id' => $requestData['analysis_loading_id'] ?? null,
                'load_company_id' => $requestData['load_company_id'],
                'supplier_id' => $requestData['supplier_id'],
                'dock_id' => $requestData['dock_id'],
                'ship_id' => $requestData['ship_id'],
                'bl' => $requestData['bl'],
                'loading_date' => $requestData['loading_date'], 
                'arrived_date' => $requestData['arrived_date'], 
                'dock_ship_date' => $requestData['dock_ship_date'], 
                'unloading_date' => $requestData['unloading_date'], 
                'end_date' => $requestData['end_date'], 
                'departure_date' => $requestData['departure_date'], 
                'note' => $requestData['note'], 
            ]);

            DB::commit();
            return redirect(route('coals.unloadings.index'))->with('success', 'Pembongkaran Batu Bara berhasil di ubah.');

        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Pembongkaran Batu Bara gagal di ubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CoalUnloading::where('id', $id)->delete();
        return redirect(route('coals.unloadings.index'))->with('success', 'Pembongkaran Batu Bara berhasil di hapus.');
    }
}
