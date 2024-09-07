<?php

namespace App\Http\Controllers\Contract;

use App\Supplier;
use App\Models\UnitPenalty;
use App\Models\BiomassaContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\BiomassaAdjusmentClause;

class BiomassaAdjusmentClauseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$contractId)
    {
        $adjusments = BiomassaAdjusmentClause::query();

        $data['contract'] = BiomassaContract::where('id', $contractId)->first();
        $data['adjusments'] = $adjusments->where('contract_id',$contractId)->latest()->paginate(10)->appends(request()->query());
        // dd($data);
        return view('contracts.biomassa-contracts.adjusment-clause.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($contractId)
    {
        $data['contract'] = BiomassaContract::where('id', $contractId)->first();
        $data['units'] = UnitPenalty::all();
        return view('contracts.biomassa-contracts.adjusment-clause.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$contractId)
    {
        DB::beginTransaction();
        try {

            BiomassaAdjusmentClause::create($request->all());

            DB::commit();
            return redirect(route('contracts.biomassa-contracts.adjusment-clause.index',['contractId'=>$contractId]))->with('success', 'Klausul penyesuaian kontrak baru berhasil di buat.');
            
        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Klausul penyesuaian kontrak baru gagal di buat');
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
        $data['adjusment'] = BiomassaAdjusmentClause::where('id', $id)->first();
        $data['units'] = UnitPenalty::all();
        return view('contracts.biomassa-contracts.adjusment-clause.edit',$data);
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
        DB::beginTransaction();
        try {
            BiomassaAdjusmentClause::where('id',$id)->update($request->except(['_token','_method']));

            DB::commit();
            return redirect(route('contracts.biomassa-contracts.adjusment-clause.index',['contractId'=>$contractId]))->with('success', 'Spesifikasi kontrak baru berhasil di ubah.');
            
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
        BiomassaAdjusmentClause::where('id', $id)->delete();
        return redirect(route('contracts.biomassa-contracts.adjusment-clause.index',['contractId'=>$contractId]))->with('success', 'Klausul Penyesuaian Kontrak Batu Bara berhasil di hapus.');
    }
}
