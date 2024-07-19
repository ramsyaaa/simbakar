<?php

namespace App\Http\Controllers\Coal;

use App\Dock;
use App\Ship;
use App\Supplier;
use Carbon\Carbon;
use App\LoadingCompany;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use App\Models\KindDisruption;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CoalUnloadingDisruption;

class CoalUnloadingDisruptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$unloadingId)
    {
        $unloadings = CoalUnloadingDisruption::query();
        $data['unloading'] = CoalUnloading::where('id',$unloadingId)->first();
        $data['unloadings'] = $unloadings->where('unloading_id',$unloadingId)->latest()->paginate(10)->appends(request()->query());
        return view('coals.unloading-disruptions.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($unloadingId)
    {

        $data['unloading'] = CoalUnloading::where('id',$unloadingId)->first();
        $data['disruptions'] = KindDisruption::all();
        return view('coals.unloading-disruptions.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$unloadingId)
    {
        DB::beginTransaction();
        try {
            
            CoalUnloadingDisruption::create($request->all());

            DB::commit();
            return redirect(route('coals.unloadings.disruptions.index',['unloadingId' => $unloadingId]))->with('success', 'Gangguan Pembongkaran Batu Bara berhasil di buat.');
            
        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Gangguan Pembongkaran Batu Bara gagal di buat');
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
    public function edit($unloadingId,$id)
    {  
        $data['unloading'] = CoalUnloading::where('id',$unloadingId)->first();
        $data['disruptions'] = KindDisruption::all();
        $data['unloadDisruption'] = CoalUnloadingDisruption::where('id', $id)->first();

        return view('coals.unloading-disruptions.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$unloadingId,$id)
    {
        DB::beginTransaction();
        try {
            CoalUnloadingDisruption::where('id',$id)->update($request->except(['_token','_method']));

            DB::commit();
            return redirect(route('coals.unloadings.disruptions.index',['unloadingId' => $unloadingId]))->with('success', 'Pembongkaran Batu Bara berhasil di ubah.');
            
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
        CoalUnloadingDisruption::where('id', $id)->delete();
        return redirect(route('coals.unloadings.disruptions.index'))->with('success', 'Pembongkaran Batu Bara berhasil di hapus.');
    }
}
