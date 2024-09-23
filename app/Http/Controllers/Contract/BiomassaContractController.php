<?php

namespace App\Http\Controllers\Contract;

use App\Supplier;
use App\Models\BiomassaContract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BiomassaContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $biomassas = BiomassaContract::query();

        $biomassas->when($request->supplier_id, function ($query) use ($request) {
            $query->where('supplier_id', $request->supplier_id);
        });
        $data['suppliers'] = Supplier::all();
        $data['biomassas'] = $biomassas->latest()->paginate(10)->appends(request()->query());
        return view('contracts.biomassa-contracts.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['suppliers'] = Supplier::all();
        return view('contracts.biomassa-contracts.create',$data);
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
                'supplier_id' => 'required',
                'contract_number' => 'required',
                'contract_date' => 'required',
                'type_contract' => 'required',
                'kind_contract' => 'required',
                'total_volume' => 'required',
                'price' => 'required',
                'contract_start_date' => 'required',
                'contract_end_date' => 'required',
            ], [
                'supplier_id.required' => 'Supplier wajib diisi.',
                'contract_number.required' => 'Nomor Kontrak wajib diisi.',
                'contract_date.required' => 'Tanggal Kontrak wajib diisi.',
                'type_contract.required' => 'Tipe Kontrak wajib diisi.',
                'kind_contract.required' => 'Jenis Kontrak wajib diisi.',
                'total_volume.required' => 'Volume Total wajib diisi.',
                'price.required' => 'Harga wajib diisi.',
                'contract_start_date.required' => 'Tanggal Mulai Kontrak wajib diisi.',
                'contract_end_date.required' => 'Tanggal Selesai Kontrak wajib diisi.',
            ]);
    
            BiomassaContract::create([
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
    
            return redirect(route('contracts.biomassa-contracts.index'))->with('success', 'Kontrak Biomassa berhasil dibuat.');
            
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
        $data['coal'] = BiomassaContract::where('uuid', $uuid)->first();
        $data['suppliers'] = Supplier::all();
        return view('contracts.biomassa-contracts.edit',$data);
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
        BiomassaContract::where('uuid', $uuid)->update([
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
        return redirect(route('contracts.biomassa-contracts.index'))->with('success', 'Kontrak Biomassa berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        BiomassaContract::where('uuid', $uuid)->delete();
        return redirect(route('contracts.biomassa-contracts.index'))->with('success', 'Kontrak Biomassa berhasil di hapus.');
    }
}
