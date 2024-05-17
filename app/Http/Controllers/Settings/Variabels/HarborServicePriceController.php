<?php

namespace App\Http\Controllers\Settings\Variabels;

use Illuminate\Http\Request;
use App\Models\HarborServicePrice;
use App\Http\Controllers\Controller;

class HarborServicePriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $harbors = HarborServicePrice::query();

        $harbors->when($request->year, function ($query) use ($request) {
            $query->whereYear('start_date', $request->year);
        });
      
        $data['harbors'] = $harbors->paginate(10)->appends(request()->query());
        return view('settings.variabels.harbor-service-prices.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.variabels.harbor-service-prices.create');
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

        HarborServicePrice::create([
            'start_date' => $request->start_date,
            'price' => $request->price
        ]);

        return redirect(route('settings.harbor-service-prices.index'))->with('success', 'Harga Jasa Dermaga baru berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HarborServicePrice  $harborServicePrice
     * @return \Illuminate\Http\Response
     */
    public function show(HarborServicePrice $harborServicePrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HarborServicePrice  $harborServicePrice
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $data['harbor'] = HarborServicePrice::where('uuid', $uuid)->first();
        return view('settings.variabels.harbor-service-prices.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HarborServicePrice  $harborServicePrice
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

        HarborServicePrice::where('uuid',$uuid)->update([
            'start_date' => $request->start_date,
            'price' => $request->price
        ]);

        return redirect(route('settings.harbor-service-prices.index'))->with('success', 'Harga Jasa Dermaga baru berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HarborServicePrice  $harborServicePrice
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        HarborServicePrice::where('uuid',$uuid)->first()->delete();

        return redirect(route('settings.harbor-service-prices.index'))->with('success', 'Harga Jasa Dermaga baru berhasil di hapus.');
    }
}
