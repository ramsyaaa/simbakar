<?php

namespace App\Http\Controllers\Contract\Adendum;

use App\Supplier;
use App\Models\Adendum;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AdendumSpesificationContractCoal;

class AdendumSpesificationCoalContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$adendumId)
    {
        $coals = AdendumSpesificationContractCoal::query();

        $data['adendum'] = Adendum::where('id', $adendumId)->first();
        $data['contract'] = CoalContract::where('id', $data['adendum']->id)->first();
        $data['coals'] = $coals->where('adendum_id',$adendumId)->latest()->paginate(10)->appends(request()->query());
        return view('contracts.adendum-coal-contracts.spesification.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($adendumId)
    {
        $data['adendum'] = Adendum::where('id', $adendumId)->first();
        $data['contract'] = CoalContract::where('id', $data['adendum']->contract_id)->first();
        return view('contracts.adendum-coal-contracts.spesification.create',$data);
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
            $adendum = Adendum::where('id',$request->adendum_id)->first()
            ;
            AdendumSpesificationContractCoal::create($request->all());

            DB::commit();
            return redirect(route('contracts.adendum-coal-contracts.spesification.index',['adendumId'=> $adendum->id]))->with('success', 'Spesifikasi kontrak baru berhasil di buat.');
            
        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Spesifikasi kontrak baru gagal di buat');
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
    public function edit($adendumId,$id)
    {
        $data['adendum'] = Adendum::where('id', $adendumId)->first();
        $data['contract'] = CoalContract::where('id', $data['adendum']->contract_id)->first();
        $data['coal'] = AdendumSpesificationContractCoal::where('id', $id)->first();
        return view('contracts.adendum-coal-contracts.spesification.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $adendumId,$id)
    {
        DB::beginTransaction();
        try {
            
            AdendumSpesificationContractCoal::where('id',$id)->update($request->except(['_token','_method']));

            DB::commit();
            return redirect(route('contracts.adendum-coal-contracts.spesification.index',['adendumId'=>$adendumId]))->with('success', 'Spesifikasi kontrak baru berhasil di ubah.');
            
        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Spesifikasi kontrak baru gagal di ubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($adendumId,$id)
    {
        AdendumSpesificationContractCoal::where('id', $id)->delete();
        return redirect(route('contracts.adendum-coal-contracts.spesification.index',['adendumId'=>$adendumId]))->with('success', 'Spesifikasi Kontrak Batu Bara berhasil di hapus.');
    }
}
