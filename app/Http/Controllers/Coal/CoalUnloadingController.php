<?php

namespace App\Http\Controllers\Coal;

use App\Dock;
use App\Ship;
use App\Supplier;
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
            $query->whereYear('unloading_date', $date[0]);
            $query->whereMonth('unloading_date', $date[1]);
        });
        $data['unloadings'] = $unloadings->latest()->paginate(10)->appends(request()->query());
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
            $lastUnloadingToday = CoalUnloading::whereDate('created_at', Carbon::today())->get()->count() + 1;

            $countTug = sprintf("%02d", $lastUnloadingToday);
            $tugNumber = 'B.'.date('Ymd').'.'.$countTug;

            $lastUnloadingYear = CoalUnloading::whereYear('created_at',date('Y'))->get()->count() + 1;
            $bpbNumber = 'B.'.date('Ymd').'.'.$lastUnloadingYear;

            $requestData = $request->all();
            $requestData['tug_number'] = $tugNumber;
            $requestData['bpb_number'] = $bpbNumber;
            $requestData['form_part_number'] = '18.01.0009';
            $requestData['unit'] = 'Kg';

            
            $unloading = CoalUnloading::create($requestData);

            Tug::create([
                'tug' => 3,
                'tug_number' => $tugNumber,
                'bpb_number' => $bpbNumber,
                'type_tug' => 'coal-unloading',
                'usage_amount' => $requestData['bl'],
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
        $data['companies'] = LoadingCompany::all();
        $data['suppliers'] = Supplier::all();
        $data['docks'] = Dock::all();
        $data['ships'] = Ship::all();
        $data['unloading'] = CoalUnloading::where('id', $id)->first();
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
            CoalUnloading::where('id',$id)->update($request->except(['_token','_method']));

            Tug::where('type_tug','coal-unloading')->where('coal_unloading_id',$id)->update([
         
                'usage_amount' => $request->bl,
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
