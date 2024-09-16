<?php

namespace App\Http\Controllers\Contract\Adendum;

use App\Supplier;
use App\Models\Adendum;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Models\DeliveryClause;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AdendumDeliveryClause;

class AdendumDeliveryClauseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$adendumId)
    {
        $deliveries = AdendumDeliveryClause::query();

        $data['adendum'] = Adendum::where('id', $adendumId)->first();
        $data['contract'] = CoalContract::where('id', $data['adendum']->id)->first();

        $data['deliveries'] = $deliveries->where('adendum_id',$adendumId)->latest()->paginate(10)->appends(request()->query());
        // dd($data);
        return view('contracts.adendum-coal-contracts.delivery-clause.index',$data);

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

        return view('contracts.adendum-coal-contracts.delivery-clause.create',$data);
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
            $date = explode('-',$request->delivery_date);
            $adendum = Adendum::where('id', $adendumId)->first();

            AdendumDeliveryClause::create([
                'adendum_id' => $adendum->id,
                'contract_id' => $adendum->contract_id,
                'month' => $date[1],
                'year' => $date[0],
                'load' => $request->load,
                'rakor' => $request->rakor,
            ]);

            DB::commit();
            return redirect(route('contracts.adendum-coal-contracts.delivery-clause.index',['adendumId'=>$adendumId]))->with('success', 'Klausul pengirim kontrak baru berhasil di buat.');
            
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
    public function edit($adendumId,$id)
    {
        $data['adendum'] = Adendum::where('id', $adendumId)->first();
        $data['contract'] = CoalContract::where('id', $data['adendum']->id)->first();

        $data['delivery'] = AdendumDeliveryClause::where('id', $id)->first();
        return view('contracts.adendum-coal-contracts.delivery-clause.edit',$data);
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
        // dd($request);
        DB::beginTransaction();
        try {

            $date = explode('-',$request->delivery_date);

            AdendumDeliveryClause::where('id',$id)->update([
                'month' => $date[1],
                'year' => $date[0],
                'load' => $request->load,
                'rakor' => $request->rakor,
            ]);

            DB::commit();
            return redirect(route('contracts.adendum-coal-contracts.delivery-clause.index',['adendumId'=>$adendumId]))->with('success', 'Spesifikasi kontrak baru berhasil di ubah.');
            
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
        AdendumDeliveryClause::where('id', $id)->delete();
        return redirect(route('contracts.adendum-coal-contracts.delivery-clause.index',['adendumId'=>$adendumId]))->with('success', 'Klausul Pengiriman Kontrak Batu Bara berhasil di hapus.');
    }
}
