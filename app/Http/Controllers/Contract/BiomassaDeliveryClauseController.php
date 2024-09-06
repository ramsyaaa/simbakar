<?php

namespace App\Http\Controllers\Contract;

use App\Supplier;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DeliveryClause;

class BiomassaDeliveryClauseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$contractId)
    {
        $deliveries = DeliveryClause::query();

        $data['contract'] = CoalContract::where('id', $contractId)->first();
        $data['deliveries'] = $deliveries->where('contract_id',$contractId)->latest()->paginate(10)->appends(request()->query());
        // dd($data);
        return view('contracts.coal-contracts.delivery-clause.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($contractId)
    {
        $data['contract'] = CoalContract::where('id', $contractId)->first();
        return view('contracts.coal-contracts.delivery-clause.create',$data);
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
            $date = explode('-',$request->delivery_date);

            DeliveryClause::create([
                'contract_id' => $contractId,
                'month' => $date[1],
                'year' => $date[0],
                'load' => $request->load,
                'rakor' => $request->rakor,
            ]);

            DB::commit();
            return redirect(route('contracts.coal-contracts.delivery-clause.index',['contractId'=>$contractId]))->with('success', 'Klausul pengirim kontrak baru berhasil di buat.');
            
        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Klausul pengiriman kontrak baru gagal di buat');
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
        $data['delivery'] = DeliveryClause::where('id', $id)->first();
        return view('contracts.coal-contracts.delivery-clause.edit',$data);
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

            $date = explode('-',$request->delivery_date);
            DeliveryClause::where('id',$id)->update([
                'contract_id' => $contractId,
                'month' => $date[1],
                'year' => $date[0],
                'load' => $request->load,
                'rakor' => $request->rakor,
            ]);

            DB::commit();
            return redirect(route('contracts.coal-contracts.delivery-clause.index',['contractId'=>$contractId]))->with('success', 'Spesifikasi kontrak baru berhasil di ubah.');
            
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
        DeliveryClause::where('id', $id)->delete();
        return redirect(route('contracts.coal-contracts.delivery-clause.index',['contractId'=>$contractId]))->with('success', 'Klausul Pengiriman Kontrak Batu Bara berhasil di hapus.');
    }
}
