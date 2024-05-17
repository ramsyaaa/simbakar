<?php

namespace App\Http\Controllers\Settings\Variabels;

use Illuminate\Http\Request;
use App\Models\ElectricPrice;
use App\Http\Controllers\Controller;

class ElectricPriceController extends Controller
{
    public function index(Request $request)
    {
        $electrics = ElectricPrice::query();

        $electrics->when($request->year, function ($query) use ($request) {
            $query->whereYear('start_date', $request->year);
        });
      
        $data['electrics'] = $electrics->paginate(10)->appends(request()->query());
        return view('settings.variabels.electric-prices.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.variabels.electric-prices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'price' => 'required',
        ], [
            'start_date.required' => 'Tanggal Mulai wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
        ]);

        ElectricPrice::create([
            'start_date' => $request->start_date,
            'price' => $request->price
        ]);

        return redirect(route('settings.electric-prices.index'))->with('success', 'Tarif Listrik baru berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ElectricPrice  $ElectricPrice
     * @return \Illuminate\Http\Response
     */
    public function show(ElectricPrice $ElectricPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ElectricPrice  $ElectricPrice
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $data['electric'] = ElectricPrice::where('uuid', $uuid)->first();
        return view('settings.variabels.electric-prices.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ElectricPrice  $ElectricPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $request->validate([
            'start_date' => 'required',
            'price' => 'required',
        ], [
            'start_date.required' => 'Tanggal Mulai wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
        ]);

        ElectricPrice::where('uuid',$uuid)->update([
            'start_date' => $request->start_date,
            'price' => $request->price
        ]);

        return redirect(route('settings.electric-prices.index'))->with('success', 'Tarif Listrik baru berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ElectricPrice  $ElectricPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        ElectricPrice::where('uuid',$uuid)->first()->delete();

        return redirect(route('settings.electric-prices.index'))->with('success', 'Tarif Listrik baru berhasil di hapus.');
    }
}
