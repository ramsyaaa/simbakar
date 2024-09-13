<?php

namespace App\Http\Controllers\Contract;

use App\Supplier;
use App\Models\BiomassaContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SpesificationContractBiomassa;

class SpesificationBiomassaContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$contractId)
    {
        $biomassas = SpesificationContractBiomassa::query();

        $data['contract'] = BiomassaContract::where('id', $contractId)->first();
        $data['biomassas'] = $biomassas->where('contract_id',$contractId)->latest()->paginate(10)->appends(request()->query());
        // dd($data);
        return view('contracts.biomassa-contracts.spesification.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($contractId)
    {
        $data['contract'] = BiomassaContract::where('id', $contractId)->first();
        return view('contracts.biomassa-contracts.spesification.create',$data);
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
            
            SpesificationContractBiomassa::create($request->all());

            DB::commit();
            return redirect(route('contracts.biomassa-contracts.spesification.index',['contractId'=>$request->contract_id]))->with('success', 'Spesifikasi kontrak baru gagal di buat.');
            
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
    public function edit($contractId,$id)
    {
        $data['contract'] = BiomassaContract::where('id', $contractId)->first();
        $data['biomassa'] = SpesificationContractBiomassa::where('id', $id)->first();
        return view('contracts.biomassa-contracts.spesification.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $contractId,$id)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            
            SpesificationContractBiomassa::where('id',$id)->update($request->except(['_token','_method']));

            DB::commit();
            return redirect(route('contracts.biomassa-contracts.spesification.index',['contractId'=>$request->contract_id]))->with('success', 'Spesifikasi kontrak baru berhasil di ubah.');
            
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
    public function destroy($contractId,$id)
    {
        SpesificationContractBiomassa::where('id', $id)->delete();
        return redirect(route('contracts.biomassa-contracts.spesification.index',['contractId'=>$contractId]))->with('success', 'Spesifikasi Kontrak Batu Bara berhasil di hapus.');
    }
}
