<?php

namespace App\Http\Controllers\Contract;

use App\Supplier;
use Illuminate\Http\Request;
use App\Models\BiomassaContract;
use Illuminate\Support\Facades\DB;
use App\Models\BiomassaSubSupplier;
use App\Http\Controllers\Controller;

class BiomassaSubSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$contractId)
    {
        $sub = BiomassaSubSupplier::query();
        $data['suppliers'] = Supplier::all();
        $data['contract'] = BiomassaContract::where('id', $contractId)->first();
        $data['subs'] = $sub->where('contract_id',$contractId)->latest()->paginate(10)->appends(request()->query());
        // dd($data);
        return view('contracts.biomassa-contracts.sub-supplier.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($contractId)
    {
        $data['suppliers'] = Supplier::all();
        $data['contract'] = BiomassaContract::where('id', $contractId)->first();
        return view('contracts.biomassa-contracts.sub-supplier.create',$data);
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

            BiomassaSubSupplier::create([
                'contract_id' => $contractId,
                'supplier_id' => $request->supplier_id,
            ]);

            DB::commit();
            return redirect(route('contracts.biomassa-contracts.sub-supplier.index',['contractId'=>$contractId]))->with('success', 'Sub Supplier kontrak baru berhasil di buat.');
            
        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Sub Supplier kontrak baru gagal di buat');
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
        $data['suppliers'] = Supplier::all();
        $data['contract'] = BiomassaContract::where('id', $contractId)->first();
        $data['sub'] = BiomassaSubSupplier::where('id', $id)->first();
        return view('contracts.biomassa-contracts.sub-supplier.edit',$data);
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

            BiomassaSubSupplier::where('id',$id)->update([
                'contract_id' => $contractId,
                'supplier_id' => $request->supplier_id,
            ]);

            DB::commit();
            return redirect(route('contracts.biomassa-contracts.sub-supplier.index',['contractId'=>$contractId]))->with('success', 'Sub Supplier kontrak baru berhasil di ubah.');
            
        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Sub Supplier kontrak baru gagal di ubah');
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
        BiomassaSubSupplier::where('id', $id)->delete();
        return redirect(route('contracts.biomassa-contracts.sub-supplier.index',['contractId'=>$contractId]))->with('success', 'Sub Supplier Kontrak Biomassa berhasil di hapus.');
    }
}
