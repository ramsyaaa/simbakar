<?php

namespace App\Http\Controllers\Contract\Adendum;

use App\Supplier;
use App\Models\Adendum;
use App\Models\UnitPenalty;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Models\PenaltyClause;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AdendumPenaltyClause;

class AdendumPenaltyClauseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$adendumId)
    {
        $penalties = AdendumPenaltyClause::query();

        $data['adendum'] = Adendum::where('id', $adendumId)->first();
        $data['contract'] = CoalContract::where('id', $data['adendum']->id)->first();

        $data['penalties'] = $penalties->where('contract_id',$adendumId)->latest()->paginate(10)->appends(request()->query());
        // dd($data);
        return view('contracts.adendum-coal-contracts.penalty-clause.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($adendumId)
    {
        $data['adendum'] = Adendum::where('id', $adendumId)->first();
        $data['contract'] = CoalContract::where('id', $data['adendum']->id)->first();
        
        $data['units'] = UnitPenalty::all();
        return view('contracts.adendum-coal-contracts.penalty-clause.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$adendumId)
    {
        DB::beginTransaction();
        try {
            $adendum = Adendum::where('id', $adendumId)->first();
            AdendumPenaltyClause::create($request->all());

            DB::commit();
            return redirect(route('contracts.adendum-coal-contracts.penalty-clause.index',['adendumId'=>$adendum->id]))->with('success', 'Klausul denda penolakan kontrak baru berhasil di buat.');
            
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
    public function edit($adendumId,$id)
    {
        $data['adendum'] = Adendum::where('id', $adendumId)->first();
        $data['contract'] = CoalContract::where('id', $data['adendum']->id)->first();

        $data['penalty'] = AdendumPenaltyClause::where('id', $id)->first();
        $data['units'] = UnitPenalty::all();
        return view('contracts.adendum-coal-contracts.penalty-clause.edit',$data);
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

            $adendum = Adendum::where('id', $adendumId)->first();
            AdendumPenaltyClause::where('id',$id)->update($request->except(['_token','_method']));

            DB::commit();
            return redirect(route('contracts.adendum-coal-contracts.penalty-clause.index',['adendumId'=>$adendum->id]))->with('success', 'Spesifikasi kontrak baru berhasil di ubah.');
            
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
        AdendumPenaltyClause::where('id', $id)->delete();
        return redirect(route('contracts.adendum-coal-contracts.penalty-clause.index',['adendumId'=>$adendumId]))->with('success', 'Klausul Penyesuaian Kontrak Batu Bara berhasil di hapus.');
    }
}
