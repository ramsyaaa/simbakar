<?php

namespace App\Http\Controllers\Contract\Adendum;

use App\Supplier;
use App\Models\Adendum;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Models\AdendumCoalContract;
use App\Http\Controllers\Controller;

class CoalAdendumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$contractId)
    {
        $adendums = Adendum::query();
        $adendums->with('contract')->where('contract_id',$contractId);
        $data['adendums'] = $adendums->paginate(10)->appends(request()->query());
        $data['contractId'] = $contractId;
        return view('contracts.adendum-coal-contracts.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createContract($contractId,$adendumId)
    {
        $data['suppliers'] = Supplier::all();
        $data['contract'] = CoalContract::where('id',$contractId)->first();
        $data['adendum'] = Adendum::where('id',$adendumId)->first();
        $data['coal'] = AdendumCoalContract::where('adendum_id',$adendumId)->first();
        return view('contracts.adendum-coal-contracts.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$contractId)
    {
        try {
    
            Adendum::create([
                'contract_id' => $contractId,
            ]);
    
            return redirect(route('contracts.adendum-coal-contracts.index',['contractId' => $contractId]))->with('success', 'Adendum Kontrak Batu Bara berhasil dibuat.');
            
        } catch (\ValidationException $th) {
            throw $th;
        }
       
    }

    public function storeContract(Request $request,$contractId,$adendumId)
    {
        try {
            
            $coal = AdendumCoalContract::where('adendum_id',$adendumId)->where('contract_id',$contractId)->first();
            if($coal){
                dd('1');
                $coal->contract_date = $request->contract_date;
                $coal->type_contract = $request->type_contract;
                $coal->kind_contract = $request->kind_contract;
                $coal->total_volume = $request->total_volume;
                $coal->price = $request->price;
                $coal->contract_start_date = $request->contract_start_date;
                $coal->contract_end_date = $request->contract_end_date;
                $coal->save();
            }else{
                
                AdendumCoalContract::create([
                    'adendum_id' => $adendumId,
                    'contract_id' => $contractId,
                    'supplier_id' => $request->supplier_id,
                    'contract_number' => $request->contract_number,
                    'contract_date' => $request->contract_date,
                    'type_contract' => $request->type_contract,
                    'kind_contract' => $request->kind_contract,
                    'total_volume' => $request->total_volume,
                    'price' => $request->price,
                    'contract_start_date' => $request->contract_start_date,
                    'contract_end_date' => $request->contract_end_date,
                ]);
        
            }
           
            return redirect(route('contracts.adendum-coal-contracts.index',['contractId' => $contractId]))->with('success', 'Adendum Kontrak Batu Bara berhasil dibuat.');
            
        } catch (\ValidationException $th) {
            throw $th;
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
    public function edit($uuid)
    {
        $data['coal'] = CoalContract::where('uuid', $uuid)->first();
        $data['suppliers'] = Supplier::all();
        return view('contracts.coal-contracts.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        CoalContract::where('uuid', $uuid)->update([
            'supplier_id' => $request->supplier_id,
            'contract_number' => $request->contract_number,
            'contract_date' => $request->contract_date,
            'type_contract' => $request->type_contract,
            'kind_contract' => $request->kind_contract,
            'total_volume' => $request->total_volume,
            'price' => $request->price,
            'contract_start_date' => $request->contract_start_date,
            'contract_end_date' => $request->contract_end_date,
        ]);
        return redirect(route('contracts.coal-contracts.index'))->with('success', 'Kontrak Batu Bara berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        CoalContract::where('uuid', $uuid)->delete();
        return redirect(route('contracts.coal-contracts.index'))->with('success', 'Kontrak Batu Bara berhasil di hapus.');
    }
}
