<?php

namespace App\Http\Controllers\Contract;

use App\Supplier;
use App\Models\TransferBbm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransferBbmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $bbms = TransferBbm::query();

        // $date = explode('-',$request->date);
        // $bbms->when($request->date, function ($query) use ($date) {
        //     $query->where('alocation_month', $date[1]);
        //     $query->where('alocation_year', $date[0]);
        // });
        // $data['bbms'] = $bbms->paginate(10)->appends(request()->query());

        return view('contracts.transfer-bbms.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['suppliers'] = Supplier::all();
        return view('contracts.transfer-bbms.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'supplier_uuid' => 'required',
                'contract_number' => 'required',
                'contract_date' => 'required',
                'type_contract' => 'required',
                'kind_contract' => 'required',
                'total_volume' => 'required',
                'price' => 'required',
                'contract_start_date' => 'required',
                'contract_end_date' => 'required',
            ], [
                'supplier_uuid.required' => 'Supplier wajib diisi.',
                'contract_number.required' => 'Nomor Kontrak wajib diisi.',
                'contract_date.required' => 'Tanggal Kontrak wajib diisi.',
                'type_contract.required' => 'Tipe Kontrak wajib diisi.',
                'kind_contract.required' => 'Jenis Kontrak wajib diisi.',
                'total_volume.required' => 'Volume Total wajib diisi.',
                'price.required' => 'Harga wajib diisi.',
                'contract_start_date.required' => 'Tanggal Mulai Kontrak wajib diisi.',
                'contract_end_date.required' => 'Tanggal Selesai Kontrak wajib diisi.',
            ]);
    
            TransferBbm::create([
                'supplier_uuid' => $request->supplier_uuid,
                'contract_number' => $request->contract_number,
                'contract_date' => $request->contract_date,
                'type_contract' => $request->type_contract,
                'kind_contract' => $request->kind_contract,
                'total_volume' => $request->total_volume,
                'price' => $request->price,
                'contract_start_date' => $request->contract_start_date,
                'contract_end_date' => $request->contract_end_date,
            ]);
    
            return redirect(route('contracts.transfer-bbms.index'))->with('success', 'Kontrak Batu Bara berhasil dibuat.');
            
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
        $data['coal'] = TransferBbm::where('uuid', $uuid)->first();
        $data['suppliers'] = Supplier::all();
        return view('contracts.transfer-bbms.edit',$data);
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
        TransferBbm::where('uuid', $uuid)->update([
            'supplier_uuid' => $request->supplier_uuid,
            'contract_number' => $request->contract_number,
            'contract_date' => $request->contract_date,
            'type_contract' => $request->type_contract,
            'kind_contract' => $request->kind_contract,
            'total_volume' => $request->total_volume,
            'price' => $request->price,
            'contract_start_date' => $request->contract_start_date,
            'contract_end_date' => $request->contract_end_date,
        ]);
        return redirect(route('contracts.transfer-bbms.index'))->with('success', 'Kontrak Batu Bara berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        TransferBbm::where('uuid', $uuid)->delete();
        return redirect(route('contracts.transfer-bbms.index'))->with('success', 'Kontrak Batu Bara berhasil di hapus.');
    }
}
