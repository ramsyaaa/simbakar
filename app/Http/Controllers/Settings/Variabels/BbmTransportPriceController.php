<?php

namespace App\Http\Controllers\Settings\Variabels;

use Illuminate\Http\Request;
use App\Models\BbmTransportPrice;
use App\Http\Controllers\Controller;

class BbmTransportPriceController extends Controller
{
    public function index(Request $request)
    {
        $bbms = BbmTransportPrice::query();

        $bbms->when($request->year, function ($query) use ($request) {
            $query->whereYear('start_date', $request->year);
        });
      
        $data['bbms'] = $bbms->paginate(10)->appends(request()->query());
        return view('settings.variabels.bbm-transport-prices.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.variabels.bbm-transport-prices.create');
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

        BbmTransportPrice::create([
            'start_date' => $request->start_date,
            'price' => $request->price
        ]);

        return redirect(route('settings.bbm-transport-prices.index'))->with('success', 'Harga Angkut BBM baru berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BbmTransportPrice  $BbmTransportPrice
     * @return \Illuminate\Http\Response
     */
    public function show(BbmTransportPrice $BbmTransportPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BbmTransportPrice  $BbmTransportPrice
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $data['bbm'] = BbmTransportPrice::where('uuid', $uuid)->first();
        return view('settings.variabels.bbm-transport-prices.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BbmTransportPrice  $BbmTransportPrice
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

        BbmTransportPrice::where('uuid',$uuid)->update([
            'start_date' => $request->start_date,
            'price' => $request->price
        ]);

        return redirect(route('settings.bbm-transport-prices.index'))->with('success', 'Harga Angkut BBM baru berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BbmTransportPrice  $BbmTransportPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        BbmTransportPrice::where('uuid',$uuid)->first()->delete();

        return redirect(route('settings.bbm-transport-prices.index'))->with('success', 'Harga Angkut BBM baru berhasil di hapus.');
    }
}
