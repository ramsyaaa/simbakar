<?php

namespace App\Http\Controllers\Contract;

use App\Supplier;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PenaltyClause;

class PenaltyClauseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$contractId)
    {
        $penalties = PenaltyClause::query();

        $data['contract'] = CoalContract::where('id', $contractId)->first();
        $data['penalties'] = $penalties->where('contract_id',$contractId)->latest()->paginate(10)->appends(request()->query());
        // dd($data);
        return view('contracts.coal-contracts.penalty-clause.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($contractId)
    {
        $data['contract'] = CoalContract::where('id', $contractId)->first();
        return view('contracts.coal-contracts.penalty-clause.create',$data);
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

            PenaltyClause::create($request->all());

            DB::commit();
            return redirect(route('contracts.coal-contracts.penalty-clause.index',['contractId'=>$contractId]))->with('success', 'Klausul denda penolakan kontrak baru berhasil di buat.');
            
        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Klausul denda penolakan kontrak baru gagal di buat');
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
        $data['contract'] = CoalContract::where('id', $contractId)->first();
        $data['penalty'] = PenaltyClause::where('id', $id)->first();
        return view('contracts.coal-contracts.penalty-clause.edit',$data);
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
            PenaltyClause::where('id',$id)->update($request->except(['_token','_method']));

            DB::commit();
            return redirect(route('contracts.coal-contracts.penalty-clause.index',['contractId'=>$contractId]))->with('success', 'Spesifikasi kontrak baru berhasil di ubah.');
            
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
        PenaltyClause::where('id', $id)->delete();
        return redirect(route('contracts.coal-contracts.penalty-clause.index',['contractId'=>$contractId]))->with('success', 'Klausul Penyesuaian Kontrak Batu Bara berhasil di hapus.');
    }
}
