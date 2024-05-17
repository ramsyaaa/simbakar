<?php

namespace App\Http\Controllers\Contract;

use App\Ship;
use Illuminate\Http\Request;
use App\Models\BbmBookContract;
use App\Http\Controllers\Controller;

class BbmBookContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bbms = BbmBookContract::query();
        $date = explode('-',$request->date);
        $bbms->when($request->date, function ($query) use ($date) {
            $query->where('alocation_month', $date[1]);
            $query->where('alocation_year', $date[0]);
        });
        $data['bbms'] = $bbms->paginate(10)->appends(request()->query());
        return view('contracts.bbm-book-contracts.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['ships'] = Ship::all();
        return view('contracts.bbm-book-contracts.create',$data);
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
                'order_number' => 'required',
                'order_date' => 'required',
                'alocation_date' => 'required',
                'total' => 'required',
                'fleet_type' => 'required',
                'ship_uuid' => 'nullable',
            ], [
                'order_number.required' => 'Nomor Pemesanan wajib diisi.',
                'order_date.required' => 'Tanggal Pemesanan wajib diisi.',
                'alocation_date.required' => 'Tanggal Alokasi wajib diisi.',
                'total.required' => 'Jumlah wajib diisi.',
                'fleet_type.required' => 'Armada wajib diisi.'
            ]);

            $date = explode('-',$request->alocation_date);

            BbmBookContract::create([
                'order_number' => $request->order_number,
                'order_date' => $request->order_date,
                'alocation_month' => $date[1],
                'alocation_year' => $date[0],
                'alocation_date' => $request->alocation_date,
                'total' => $request->total,
                'fleet_type' => $request->fleet_type,
                'ship_uuid' => $request->ship_uuid ?? null
            ]);
            return redirect(route('contracts.bbm-book-contracts.index'))->with('success', 'Kontrak Pemesanan BBM berhasil dibuat.');
            
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
        $data['bbm'] = BbmBookContract::where('uuid', $uuid)->first();
        $data['ships'] = Ship::all();
        return view('contracts.bbm-book-contracts.edit',$data);
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
        $request->validate([
            'order_number' => 'required',
            'order_date' => 'required',
            'alocation_date' => 'required',
            'total' => 'required',
            'fleet_type' => 'required',
            'ship_uuid' => 'nullable',
        ], [
            'order_number.required' => 'Nomor Pemesanan wajib diisi.',
            'order_date.required' => 'Tanggal Pemesanan wajib diisi.',
            'alocation_date.required' => 'Tanggal Alokasi wajib diisi.',
            'total.required' => 'Jumlah wajib diisi.',
            'fleet_type.required' => 'Armada wajib diisi.'
        ]);

        $date = explode('-',$request->alocation_date);
        
        BbmBookContract::where('uuid',$uuid)->update([
            'order_number' => $request->order_number,
            'order_date' => $request->order_date,
            'alocation_month' => $date[1],
            'alocation_year' => $date[0],
            'alocation_date' => $request->alocation_date,
            'total' => $request->total,
            'fleet_type' => $request->fleet_type,
            'ship_uuid' => $request->ship_uuid ?? null
        ]);
        return redirect(route('contracts.bbm-book-contracts.index'))->with('success', 'Kontrak Pemesanan BBM berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        BbmBookContract::where('uuid', $uuid)->delete();
        return redirect(route('contracts.bbm-book-contracts.index'))->with('success', 'Kontrak Pemesanan BBM berhasil di hapus.');
    }
}
