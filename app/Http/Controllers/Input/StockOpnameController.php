<?php

namespace App\Http\Controllers\Input;

use App\Models\StockOpname;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockOpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stocks = StockOpname::query();

        $stocks->when($request->year, function ($query) use ($request) {
            $query->whereYear('measurement_date', $request->year);
        });
      
        $data['stocks'] = $stocks->paginate(10)->appends(request()->query());
        return view('inputs.stock-opnames.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inputs.stock-opnames.create');
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
            'measurement_date' => 'required',
            'stock_opname' => 'required',
            'loose_density' => 'required',
            'compact_density' => 'required',
        ], [
            'measurement_date.required' => 'Tanggal Pengukuran Mulai wajib diisi.',
            'stock_opname.required' => 'Stock Opname wajib diisi.',
            'loose_density.required' => 'Loose Density wajib diisi.',
            'compact_density.required' => 'Compact Density wajib diisi.',
        ]);

        StockOpname::create([
            'measurement_date' => $request->measurement_date,
            'stock_opname' => $request->stock_opname,
            'loose_density' => $request->loose_density,
            'compact_density' => $request->compact_density,
        ]);

        return redirect(route('inputs.stock-opnames.index'))->with('success', 'Stock Opname baru berhasil dibuat.');
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
        $data['stock'] = StockOpname::where('uuid', $uuid)->first();
        return view('inputs.stock-opnames.edit',$data);
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
            'measurement_date' => 'required',
            'stock_opname' => 'required',
            'loose_density' => 'required',
            'compact_density' => 'required',
        ], [
            'measurement_date.required' => 'Tanggal Pengukuran Mulai wajib diisi.',
            'stock_opname.required' => 'Stock Opname wajib diisi.',
            'loose_density.required' => 'Loose Density wajib diisi.',
            'compact_density.required' => 'Compact Density wajib diisi.',
        ]);

        StockOpname::where('uuid',$uuid)->update([
            'measurement_date' => $request->measurement_date,
            'stock_opname' => $request->stock_opname,
            'loose_density' => $request->loose_density,
            'compact_density' => $request->compact_density,
        ]);

        return redirect(route('inputs.stock-opnames.index'))->with('success', 'Stock Opname baru berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        StockOpname::where('uuid',$uuid)->first()->delete();

        return redirect(route('inputs.stock-opnames.index'))->with('success', 'Stock Opname baru berhasil dihapus.');
    }
}
