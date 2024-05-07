<?php

namespace App\Http\Controllers\Settings\Variabels;

use Illuminate\Http\Request;
use App\Models\ShipUnloaderPrice;
use App\Http\Controllers\Controller;

class ShipUnloadPriceController extends Controller
{
    public function index(Request $request)
    {
        $ships = ShipUnloaderPrice::query();

        $ships->when($request->year, function ($query) use ($request) {
            $query->whereYear('start_date', $request->year);
        });
      
        $data['ships'] = $ships->paginate(10)->appends(request()->query());
        return view('settings.variabels.ship-unload-prices.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.variabels.ship-unload-prices.create');
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

        ShipUnloaderPrice::create([
            'start_date' => $request->start_date,
            'price' => $request->price
        ]);

        return redirect(route('settings.ship-unload-prices.index'))->with('success', 'Tarif Ship Unloader baru berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShipUnloaderPrice  $ShipUnloaderPrice
     * @return \Illuminate\Http\Response
     */
    public function show(ShipUnloaderPrice $ShipUnloaderPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShipUnloaderPrice  $ShipUnloaderPrice
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $data['ship'] = ShipUnloaderPrice::where('uuid', $uuid)->first();
        return view('settings.variabels.ship-unload-prices.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShipUnloaderPrice  $ShipUnloaderPrice
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

        ShipUnloaderPrice::where('uuid',$uuid)->update([
            'start_date' => $request->start_date,
            'price' => $request->price
        ]);

        return redirect(route('settings.ship-unload-prices.index'))->with('success', 'Tarif Ship Unloader baru berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShipUnloaderPrice  $ShipUnloaderPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        ShipUnloaderPrice::where('uuid',$uuid)->first()->delete();

        return redirect(route('settings.ship-unload-prices.index'))->with('success', 'Tarif Ship Unloader baru berhasil di hapus.');
    }
}
