<?php

namespace App\Http\Controllers\Settings\Variabels;

use App\Models\PriceAreaTax;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PriceAreaTaxController extends Controller
{
    public function index(Request $request)
    {
        $taxes = PriceAreaTax::query();

        $taxes->when($request->year, function ($query) use ($request) {
            $query->whereYear('start_date', $request->year);
        });
      
        $data['taxes'] = $taxes->paginate(10)->appends(request()->query());
        return view('settings.variabels.price-area-taxes.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.variabels.price-area-taxes.create');
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
            'percentage' => 'required',
        ], [
            'start_date.required' => 'Tanggal Mulai wajib diisi.',
            'percentage.required' => 'Persentase wajib diisi.',
        ]);

        try {
            
            PriceAreaTax::create([
                'start_date' => $request->start_date,
                'percentage' => $request->percentage
            ]);

            return redirect(route('settings.price-area-taxes.index'))->with('success', 'Besar Pajak Daerah baru berhasil dibuat.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger','Mohon periksa data nya lagi !');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PriceAreaTax  $PriceAreaTax
     * @return \Illuminate\Http\Response
     */
    public function show(PriceAreaTax $PriceAreaTax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PriceAreaTax  $PriceAreaTax
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $data['tax'] = PriceAreaTax::where('uuid', $uuid)->first();
        return view('settings.variabels.price-area-taxes.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PriceAreaTax  $PriceAreaTax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $request->validate([
            'start_date' => 'required',
            'percentage' => 'required',
        ], [
            'start_date.required' => 'Tanggal Mulai wajib diisi.',
            'percentage.required' => 'Persentase wajib diisi.',
        ]);

        try {

            PriceAreaTax::where('uuid',$uuid)->update([
                'start_date' => $request->start_date,
                'percentage' => $request->percentage
            ]);
    
            return redirect(route('settings.price-area-taxes.index'))->with('success', 'Besar Pajak Daerah baru berhasil di ubah.');

        } catch (\Throwable $th) {
            return redirect()->back()->with('danger','Mohon periksa data nya lagi !');
        }
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PriceAreaTax  $PriceAreaTax
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        PriceAreaTax::where('uuid',$uuid)->first()->delete();

        return redirect(route('settings.price-area-taxes.index'))->with('success', 'Besar Pajak Daerah baru berhasil di hapus.');
    }
}
