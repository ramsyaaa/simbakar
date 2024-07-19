<?php

namespace App\Http\Controllers\Coal;

use Illuminate\Http\Request;
use App\Models\FuelAdjusment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FuelAdjusmentOutcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $adjusments = FuelAdjusment::query();
        $adjusments->when($request->date, function ($query) use ($request) {
            $date = explode('-', $request->date);
            $query->whereYear('usage_date', $date[0]);
            $query->whereMonth('usage_date', $date[1]);
        })->when($request->day, function ($query) use ($request) {
            $query->where(DB::raw('DAY(usage_date)'), $request->day);
        })->when($request->fuel, function ($query) use ($request) {
            $query->where('type_fuel', $request->fuel);
        });
        $data['adjusments'] = $adjusments->where('type_adjusment','outcome')->latest()->paginate(10)->appends(request()->query());
        // dd($data);
        return view('coals.usages.adjusment-outcomes.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('coals.usages.adjusment-outcomes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $requestData = $request->all();
            FuelAdjusment::create($requestData);

            DB::commit();
            return redirect(route('coals.usages.adjusment-outcomes.index'))->with('success', 'BA Dibeli Perusahaan Lain berhasil di buat.');
            
        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','BA Dibeli Perusahaan Lain gagal di buat');
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
    public function edit($id)
    {
        $adjusment = FuelAdjusment::where('id', $id)->first();
        $data['adjusment'] = $adjusment;

        return view('coals.usages.adjusment-outcomes.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
  
        DB::beginTransaction();
        try {

            $requestData = $request->except(['_token','_method']);

            FuelAdjusment::where('id',$id)->update($requestData);

            DB::commit();
            return redirect(route('coals.usages.adjusment-outcomes.index'))->with('success', 'BA Dibeli Perusahaan Lain berhasil di ubah.');
            
        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','BA Dibeli Perusahaan Lain gagal di ubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        FuelAdjusment::where('id', $id)->delete();
        return redirect(route('coals.usages.adjusment-outcomes.index'))->with('success', 'BA Dibeli Perusahaan Lain berhasil di hapus.');
    }
}
