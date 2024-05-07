<?php

namespace App\Http\Controllers\Settings\Variabels;

use App\Models\BbmPrice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BbmPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bbms = BbmPrice::query();

        $bbms->when($request->year, function ($query) use ($request) {
            $query->whereYear('start_date', $request->year);
        })->when($request->bbm_type, function ($query) use ($request) {
            $query->where('bbm_type', $request->bbm_type);
        });
      
        $data['bbms'] = $bbms->paginate(10)->appends(request()->query());
        return view('settings.variabels.bbm-prices.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.variabels.bbm-prices.create');
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
            'bbm_type' => 'required',
        ], [
            'start_date.required' => 'Tanggal Mulai wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'bbm_type.required' => 'Tipe BBM wajib diisi.',
        ]);

        BbmPrice::create([
            'start_date' => $request->start_date,
            'price' => $request->price,
            'bbm_type' => $request->bbm_type,
        ]);

        return redirect(route('settings.bbm-prices.index'))->with('success', 'Harga BBM baru berhasil dibuat.');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BbmPrice  $bbmPrice
     * @return \Illuminate\Http\Response
     */
    public function show(BbmPrice $bbmPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BbmPrice  $bbmPrice
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $data['bbm'] = BbmPrice::where('uuid', $uuid)->first();
        return view('settings.variabels.bbm-prices.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BbmPrice  $bbmPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $request->validate([
            'start_date' => 'required',
            'price' => 'required',
            'bbm_type' => 'required',
        ], [
            'start_date.required' => 'Tanggal Mulai wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'bbm_type.required' => 'Tipe BBM wajib diisi.',
        ]);

        BbmPrice::where('uuid',$uuid)->update([
            'start_date' => $request->start_date,
            'price' => $request->price,
            'bbm_type' => $request->bbm_type,
        ]);

        return redirect(route('settings.bbm-prices.index'))->with('success', 'Harga BBM baru berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BbmPrice  $bbmPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        
        BbmPrice::where('uuid',$uuid)->first()->delete();

        return redirect(route('settings.bbm-prices.index'))->with('success', 'Harga BBM baru berhasil di hapus.');
    }
}
