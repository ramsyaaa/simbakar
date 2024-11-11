<?php

namespace App\Http\Controllers\Input\Analysis;

use App\Http\Controllers\Controller;
use App\Models\CoalUnloading;
use App\Ship;
use App\Supplier;
use App\Surveyor;
use App\Unloading;
use Illuminate\Http\Request;

class UnloadingController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->month ?? date('Y-m');
        $date = explode('-', $bulan);
        
        $unloadings = Unloading::query();
        $year = isset($request->year) ? $request->year : \Carbon\Carbon::now()->year;

        $unloadings->where(function ($query) use ($date) {
            // Kondisi pertama: `analysis_date` null tapi `created_at` sesuai $year
            $query->whereNull('analysis_date')
                  ->whereYear('created_at', $date[0])
                  ->whereMonth('created_at', $date[1]);
        })
        ->orWhere(function ($query) use ($date) {
            // Kondisi kedua: `analysis_date` sesuai $year
            $query->whereYear('analysis_date', $date[0]);
            $query->whereMonth('analysis_date', $date[1]);
        });

        $unloadings = $unloadings->with(['coal_unloading']);

        $unloadings->orderBy('created_at', 'desc');

        $data['unloadings'] = $unloadings->paginate(10)->appends(request()->query());
        return view('inputs.analysis.unloading.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect(route('inputs.analysis.unloadings.index'));
        $data['suppliers'] = Supplier::get();
        $data['surveyors'] = Surveyor::get();
        $data['ships'] = Ship::get();
        return view('inputs.analysis.unloading.create', $data);
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
            'surveyor_uuid' => 'required',
            'analysis_number' => 'required',
            'analysis_date' => 'required',
            'moisture_total' => 'required',
            'ash' => 'required',
            'fixed_carbon' => 'required',
            'calorivic_value' => 'required',
            'air_dried_moisture' => 'required',
            'volatile_matter' => 'required',
            'total_sulfur' => 'required',
            'carbon' => 'required',
            'nitrogen' => 'required',
            'hydrogen' => 'required',
            'oxygen' => 'required',
            'initial_deformation' => 'required',
            'hemispherical' => 'required',
            'softening' => 'required',
            'fluid' => 'required',
            'sio2' => 'required',
            'fe2o3' => 'required',
            'mgo' => 'required',
            'k2o' => 'required',
            'so3' => 'required',
            'mn3o4' => 'required',
            'al2o3' => 'required',
            'cao' => 'required',
            'na2o' => 'required',
            'tlo2' => 'required',
            'p2o5' => 'required',
            'butiran_70' => 'required',
            'butiran_50' => 'required',
            'butiran_32' => 'required',
            'butiran_32_50' => 'required',
            'butiran_238' => 'required',
            'hgi' => 'required',
        ], [
            'surveyor_uuid.required' => 'Surveyor wajib diisi',
            'analysis_number.required' => 'No Analisa wajib diisi',
            'analysis_date.required' => 'Tanggal analisa wajib diisi',
            'moisture_total.required' => 'Total moisture wajib diisi',
            'ash.required' => 'Ash wajib diisi',
            'fixed_carbon.required' => 'Fixed carbon wajib diisi',
            'calorivic_value.required' => 'Calorivic value wajib diisi',
            'air_dried_moisture.required' => 'Air dried moisture wajib diisi',
            'volatile_matter.required' => 'Volatile matter wajib diisi',
            'total_sulfur.required' => 'Total sulfur wajib diisi',
            'carbon.required' => 'Carbon wajib diisi',
            'nitrogen.required' => 'Nitrogen wajib diisi',
            'hydrogen.required' => 'Hydrogen wajib diisi',
            'oxygen.required' => 'Oxygen wajib diisi',
            'initial_deformation.required' => 'Initial deformation wajib diisi',
            'hemispherical.required' => 'Hemispherical wajib diisi',
            'softening.required' => 'Softening wajib diisi',
            'fluid.required' => 'Fluid wajib diisi',
            'sio2.required' => 'SiO3 wajib diisi',
            'fe2o3.required' => 'Fe2O3 wajib diisi',
            'mgo.required' => 'MgO wajib diisi',
            'k2o.required' => 'K2O wajib diisi',
            'so3.required' => 'SO3 wajib diisi',
            'mn3o4.required' => 'Mn3O4 wajib diisi',
            'al2o3.required' => 'Al2O3 wajib diisi',
            'cao.required' => 'CaO wajib diisi',
            'na2o.required' => 'Na2O wajib diisi',
            'tlo2.required' => 'TlO2 wajib diisi',
            'p2o5.required' => 'P2O5 wajib diisi',
            'butiran_70.required' => 'Butiran > 70 mm wajib diisi',
            'butiran_50.required' => 'Butiran > 50 mm wajib diisi',
            'butiran_32.required' => 'Butiran < 32 mm wajib diisi',
            'butiran_32_50.required' => 'Butiran 32 - 50 mm wajib diisi',
            'butiran_238.required' => 'Butiran < 2,38 mm wajib diisi',
            'hgi.required' => 'HGI wajib diisi',
        ]);

        Unloading::create([
            "surveyor_uuid" => $request->surveyor_uuid,
            'analysis_number' => $request->analysis_number,
            'analysis_date' => $request->analysis_date,
            'moisture_total' => $request->moisture_total,
            'ash' => $request->ash,
            'fixed_carbon' => $request->fixed_carbon,
            'calorivic_value' => $request->calorivic_value,
            'air_dried_moisture' => $request->air_dried_moisture,
            'volatile_matter' => $request->volatile_matter,
            'total_sulfur' => $request->total_sulfur,
            'carbon' => $request->carbon,
            'nitrogen' => $request->nitrogen,
            'hydrogen' => $request->hydrogen,
            'oxygen' => $request->oxygen,
            'initial_deformation' => $request->initial_deformation,
            'hemispherical' => $request->hemispherical,
            'softening' => $request->softening,
            'fluid' => $request->fluid,
            'sio2' => $request->sio2,
            'fe2o3' => $request->fe2o3,
            'mgo' => $request->mgo,
            'k2o' => $request->k2o,
            'so3' => $request->so3,
            'mn3o4' => $request->mn3o4,
            'al2o3' => $request->al2o3,
            'cao' => $request->cao,
            'na2o' => $request->na2o,
            'tlo2' => $request->tlo2,
            'p2o5' => $request->p2o5,
            'butiran_70' => $request->butiran_70,
            'butiran_50' => $request->butiran_50,
            'butiran_32' => $request->butiran_32,
            'butiran_32_50' => $request->butiran_32_50,
            'butiran_238' => $request->butiran_238,
            'hgi' => $request->hgi,
        ]);

        return redirect(route('inputs.analysis.unloadings.index'))->with('success', 'Unloading baru baru berhasil dibuat.');
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
        $data['unloading'] = Unloading::where('id', $id)->with(['coal_unloading'])->first();
        $data['suppliers'] = Supplier::get();
        $data['surveyors'] = Surveyor::get();
        $data['ships'] = Ship::get();
        return view('inputs.analysis.unloading.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'surveyor_uuid' => 'required',
            'analysis_number' => 'required',
            'analysis_date' => 'required',
            'moisture_total' => 'required',
            'ash' => 'required',
            'fixed_carbon' => 'required',
            'calorivic_value' => 'required',
            'air_dried_moisture' => 'required',
            'volatile_matter' => 'required',
            'total_sulfur' => 'required',
            'carbon' => 'required',
            'nitrogen' => 'required',
            'hydrogen' => 'required',
            'oxygen' => 'required',
            'initial_deformation' => 'required',
            'hemispherical' => 'required',
            'softening' => 'required',
            'fluid' => 'required',
            'sio2' => 'required',
            'fe2o3' => 'required',
            'mgo' => 'required',
            'k2o' => 'required',
            'so3' => 'required',
            'mn3o4' => 'required',
            'al2o3' => 'required',
            'cao' => 'required',
            'na2o' => 'required',
            'tlo2' => 'required',
            'p2o5' => 'required',
            'butiran_70' => 'required',
            'butiran_50' => 'required',
            'butiran_32' => 'required',
            'butiran_32_50' => 'required',
            'butiran_238' => 'required',
            'hgi' => 'required',
        ], [
            'surveyor_uuid.required' => 'Surveyor wajib diisi',
            'analysis_number.required' => 'No Analisa wajib diisi',
            'analysis_date.required' => 'Tanggal analisa wajib diisi',
            'moisture_total.required' => 'Total moisture wajib diisi',
            'ash.required' => 'Ash wajib diisi',
            'fixed_carbon.required' => 'Fixed carbon wajib diisi',
            'calorivic_value.required' => 'Calorivic value wajib diisi',
            'air_dried_moisture.required' => 'Air dried moisture wajib diisi',
            'volatile_matter.required' => 'Volatile matter wajib diisi',
            'total_sulfur.required' => 'Total sulfur wajib diisi',
            'carbon.required' => 'Carbon wajib diisi',
            'nitrogen.required' => 'Nitrogen wajib diisi',
            'hydrogen.required' => 'Hydrogen wajib diisi',
            'oxygen.required' => 'Oxygen wajib diisi',
            'initial_deformation.required' => 'Initial deformation wajib diisi',
            'hemispherical.required' => 'Hemispherical wajib diisi',
            'softening.required' => 'Softening wajib diisi',
            'fluid.required' => 'Fluid wajib diisi',
            'sio2.required' => 'SiO3 wajib diisi',
            'fe2o3.required' => 'Fe2O3 wajib diisi',
            'mgo.required' => 'MgO wajib diisi',
            'k2o.required' => 'K2O wajib diisi',
            'so3.required' => 'SO3 wajib diisi',
            'mn3o4.required' => 'Mn3O4 wajib diisi',
            'al2o3.required' => 'Al2O3 wajib diisi',
            'cao.required' => 'CaO wajib diisi',
            'na2o.required' => 'Na2O wajib diisi',
            'tlo2.required' => 'TlO2 wajib diisi',
            'p2o5.required' => 'P2O5 wajib diisi',
            'butiran_70.required' => 'Butiran > 70 mm wajib diisi',
            'butiran_50.required' => 'Butiran > 50 mm wajib diisi',
            'butiran_32.required' => 'Butiran < 32 mm wajib diisi',
            'butiran_32_50.required' => 'Butiran 32 - 50 mm wajib diisi',
            'butiran_238.required' => 'Butiran < 2,38 mm wajib diisi',
            'hgi.required' => 'HGI wajib diisi',
        ]);

        $getData = Unloading::where('id',$id)->first();
        CoalUnloading::where([
            'id' => $getData->coal_unloading_id
        ])->update([
            'analysis_unloading_id' => $id,
        ]);

        Unloading::where('id',$id)->update([
            'surveyor_uuid' => $request->surveyor_uuid,
            'analysis_number' => $request->analysis_number,
            'analysis_date' => $request->analysis_date,
            'moisture_total' => $request->moisture_total,
            'ash' => $request->ash,
            'fixed_carbon' => $request->fixed_carbon,
            'calorivic_value' => $request->calorivic_value,
            'air_dried_moisture' => $request->air_dried_moisture,
            'volatile_matter' => $request->volatile_matter,
            'total_sulfur' => $request->total_sulfur,
            'carbon' => $request->carbon,
            'nitrogen' => $request->nitrogen,
            'hydrogen' => $request->hydrogen,
            'oxygen' => $request->oxygen,
            'initial_deformation' => $request->initial_deformation,
            'hemispherical' => $request->hemispherical,
            'softening' => $request->softening,
            'fluid' => $request->fluid,
            'sio2' => $request->sio2,
            'fe2o3' => $request->fe2o3,
            'mgo' => $request->mgo,
            'k2o' => $request->k2o,
            'so3' => $request->so3,
            'mn3o4' => $request->mn3o4,
            'al2o3' => $request->al2o3,
            'cao' => $request->cao,
            'na2o' => $request->na2o,
            'tlo2' => $request->tlo2,
            'p2o5' => $request->p2o5,
            'butiran_70' => $request->butiran_70,
            'butiran_50' => $request->butiran_50,
            'butiran_32' => $request->butiran_32,
            'butiran_32_50' => $request->butiran_32_50,
            'butiran_238' => $request->butiran_238,
            'hgi' => $request->hgi,
        ]);

        return redirect(route('inputs.analysis.unloadings.index'))->with('success', 'Unloading berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Unloading::where('id',$id)->first()->delete();

        return redirect(route('inputs.analysis.unloadings.index'))->with('success', 'Unloading berhasil dihapus.');
    }
}
