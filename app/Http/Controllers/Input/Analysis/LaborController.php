<?php

namespace App\Http\Controllers\Input\Analysis;

use App\Http\Controllers\Controller;
use App\Labor;
use App\Ship;
use App\Supplier;
use Illuminate\Http\Request;

class LaborController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->month ?? date('Y-m');
        $date = explode('-', $bulan);

        $labors = Labor::query();
        $labors->when($request->month, function ($query) use ($date) {
            $query->whereYear('analysis_date', $date[0]);
            $query->whereMonth('analysis_date', $date[1]);
        });

        $labors->orderBy('analysis_date', 'desc');

        $data['labors'] = $labors->paginate(10)->appends(request()->query());
        return view('inputs.analysis.labor.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['suppliers'] = Supplier::get();
        $data['ships'] = Ship::get();
        return view('inputs.analysis.labor.create', $data);
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
            'supplier_uuid' => 'required',
            'ship_uuid' => 'required',
            'analysis_number' => 'required',
            'analysis_date' => 'required',
            'start_unloading' => 'required',
            'end_unloading' => 'required',
            'moisture_total' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'ash' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'fixed_carbon' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'calorivic_value' =>  [
                'required',
                'regex:/^\d{4}$/'
            ],
            'air_dried_moisture' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'volatile_matter' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'total_sulfur' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'carbon' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'nitrogen' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'hydrogen' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'oxygen' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'initial_deformation' =>  [
                'required',
                'regex:/^\d{4}$/'
            ],
            'hemispherical' =>  [
                'required',
                'regex:/^\d{4}$/'
            ],
            'softening' =>  [
                'required',
                'regex:/^\d{4}$/'
            ],
            'fluid' =>  [
                'required',
                'regex:/^\d{4}$/'
            ],
            'sio2' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'fe2o3' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'mgo' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'k2o' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'so3' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'mn3o4' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'al2o3' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'cao' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'na2o' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'tlo2' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'p2o5' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'butiran_70' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'butiran_50' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'butiran_32' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'butiran_32_50' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'butiran_238' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'hgi' => 'required|regex:/^\d{2}$/',
        ], [
            'supplier_uuid.required' => 'Pemasok wajib diisi',
            'ship_uuid.required' => 'Kapal wajib diisi',
            'analysis_number.required' => 'No Analisa wajib diisi',
            'analysis_date.required' => 'Tanggal analisa wajib diisi',
            'start_unloading.required' => 'Tanggal mulai bongkar wajib diisi',
            'end_unloading.required' => 'Tanggal selesai bongkar wajib diisi',
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
            'moisture_total.regex' => 'Total moisture maksimal 2 angka didepan koma',
            'ash.regex' => 'Ash maksimal 2 angka didepan koma',
            'fixed_carbon.regex' => 'Fixed carbon maksimal 2 angka didepan koma',
            'calorivic_value.regex' => 'Calorivic value harus 4 angka',
            'air_dried_moisture.regex' => 'Air dried moisture maksimal 2 angka didepan koma',
            'volatile_matter.regex' => 'Volatile matter maksimal 2 angka didepan koma',
            'total_sulfur.regex' => 'Total sulfur maksimal 2 angka didepan koma',
            'carbon.regex' => 'Carbon maksimal 2 angka didepan koma',
            'nitrogen.regex' => 'Nitrogen maksimal 2 angka didepan koma',
            'hydrogen.regex' => 'Hydrogen maksimal 2 angka didepan koma',
            'oxygen.regex' => 'Oxygen maksimal 2 angka didepan koma',
            'initial_deformation.regex' => 'Initial deformation harus 4 angka',
            'hemispherical.regex' => 'Hemispherical harus 4 angka',
            'softening.regex' => 'Softening harus 4 angka',
            'fluid.regex' => 'Fluid harus harus 4 angka',
            'sio2.regex' => 'SiO3 maksimal 2 angka didepan koma',
            'fe2o3.regex' => 'Fe2O3 maksimal 2 angka didepan koma',
            'mgo.regex' => 'MgO maksimal 2 angka didepan koma',
            'k2o.regex' => 'K2O maksimal 2 angka didepan koma',
            'so3.regex' => 'SO3 maksimal 2 angka didepan koma',
            'mn3o4.regex' => 'Mn3O4 maksimal 2 angka didepan koma',
            'al2o3.regex' => 'Al2O3 maksimal 2 angka didepan koma',
            'cao.regex' => 'CaO maksimal 2 angka didepan koma',
            'na2o.regex' => 'Na2O maksimal 2 angka didepan koma',
            'tlo2.regex' => 'TlO2 maksimal 2 angka didepan koma',
            'p2o5.regex' => 'P2O5 maksimal 2 angka didepan koma',
            'butiran_70.regex' => 'Butiran > 70 mm maksimal 2 angka didepan koma',
            'butiran_50.regex' => 'Butiran > 50 mm maksimal 2 angka didepan koma',
            'butiran_32.regex' => 'Butiran < 32 mm maksimal 2 angka didepan koma',
            'butiran_32_50.regex' => 'Butiran 32 - 50 mm maksimal 2 angka didepan koma',
            'butiran_238.regex' => 'Butiran < 2,38 mm maksimal 2 angka didepan koma',
            'hgi.regex' => 'HGI harus 2 angka',
        ]);

        Labor::create([
            'supplier_uuid' => $request->supplier_uuid,
            'ship_uuid' => $request->ship_uuid,
            'analysis_number' => $request->analysis_number,
            'analysis_date' => $request->analysis_date,
            'start_unloading' => $request->start_unloading,
            'end_unloading' => $request->end_unloading,
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

        return redirect(route('inputs.analysis.labors.index'))->with('success', 'Labor baru baru berhasil dibuat.');
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
        $data['labor'] = Labor::where('id', $id)->first();
        $data['suppliers'] = Supplier::get();
        $data['ships'] = Ship::get();
        return view('inputs.analysis.labor.edit',$data);
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
            'supplier_uuid' => 'required',
            'ship_uuid' => 'required',
            'analysis_number' => 'required',
            'analysis_date' => 'required',
            'start_unloading' => 'required',
            'end_unloading' => 'required',
            'moisture_total' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'ash' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'fixed_carbon' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'calorivic_value' =>  [
                'required',
                'regex:/^\d{4}$/'
            ],
            'air_dried_moisture' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'volatile_matter' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'total_sulfur' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'carbon' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'nitrogen' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'hydrogen' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'oxygen' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'initial_deformation' =>  [
                'required',
                'regex:/^\d{4}$/'
            ],
            'hemispherical' =>  [
                'required',
                'regex:/^\d{4}$/'
            ],
            'softening' =>  [
                'required',
                'regex:/^\d{4}$/'
            ],
            'fluid' =>  [
                'required',
                'regex:/^\d{4}$/'
            ],
            'sio2' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'fe2o3' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'mgo' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'k2o' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'so3' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'mn3o4' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'al2o3' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'cao' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'na2o' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'tlo2' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'p2o5' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'butiran_70' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'butiran_50' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'butiran_32' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'butiran_32_50' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'butiran_238' => 'required|regex:/^\d{1,2}(\.\d+)?$/',
            'hgi' => 'required|regex:/^\d{2}$/',
        ], [
            'supplier_uuid.required' => 'Pemasok wajib diisi',
            'ship_uuid.required' => 'Kapal wajib diisi',
            'analysis_number.required' => 'No Analisa wajib diisi',
            'analysis_date.required' => 'Tanggal analisa wajib diisi',
            'start_unloading.required' => 'Tanggal mulai bongkar wajib diisi',
            'end_unloading.required' => 'Tanggal selesai bongkar wajib diisi',
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
            'moisture_total.regex' => 'Total moisture maksimal 2 angka didepan koma',
            'ash.regex' => 'Ash maksimal 2 angka didepan koma',
            'fixed_carbon.regex' => 'Fixed carbon maksimal 2 angka didepan koma',
            'calorivic_value.regex' => 'Calorivic value harus 4 angka',
            'air_dried_moisture.regex' => 'Air dried moisture maksimal 2 angka didepan koma',
            'volatile_matter.regex' => 'Volatile matter maksimal 2 angka didepan koma',
            'total_sulfur.regex' => 'Total sulfur maksimal 2 angka didepan koma',
            'carbon.regex' => 'Carbon maksimal 2 angka didepan koma',
            'nitrogen.regex' => 'Nitrogen maksimal 2 angka didepan koma',
            'hydrogen.regex' => 'Hydrogen maksimal 2 angka didepan koma',
            'oxygen.regex' => 'Oxygen maksimal 2 angka didepan koma',
            'initial_deformation.regex' => 'Initial deformation harus 4 angka',
            'hemispherical.regex' => 'Hemispherical harus 4 angka',
            'softening.regex' => 'Softening harus 4 angka',
            'fluid.regex' => 'Fluid harus harus 4 angka',
            'sio2.regex' => 'SiO3 maksimal 2 angka didepan koma',
            'fe2o3.regex' => 'Fe2O3 maksimal 2 angka didepan koma',
            'mgo.regex' => 'MgO maksimal 2 angka didepan koma',
            'k2o.regex' => 'K2O maksimal 2 angka didepan koma',
            'so3.regex' => 'SO3 maksimal 2 angka didepan koma',
            'mn3o4.regex' => 'Mn3O4 maksimal 2 angka didepan koma',
            'al2o3.regex' => 'Al2O3 maksimal 2 angka didepan koma',
            'cao.regex' => 'CaO maksimal 2 angka didepan koma',
            'na2o.regex' => 'Na2O maksimal 2 angka didepan koma',
            'tlo2.regex' => 'TlO2 maksimal 2 angka didepan koma',
            'p2o5.regex' => 'P2O5 maksimal 2 angka didepan koma',
            'butiran_70.regex' => 'Butiran > 70 mm maksimal 2 angka didepan koma',
            'butiran_50.regex' => 'Butiran > 50 mm maksimal 2 angka didepan koma',
            'butiran_32.regex' => 'Butiran < 32 mm maksimal 2 angka didepan koma',
            'butiran_32_50.regex' => 'Butiran 32 - 50 mm maksimal 2 angka didepan koma',
            'butiran_238.regex' => 'Butiran < 2,38 mm maksimal 2 angka didepan koma',
            'hgi.regex' => 'HGI harus 2 angka',
        ]);

        Labor::where('id',$id)->update([
            'supplier_uuid' => $request->supplier_uuid,
            'ship_uuid' => $request->ship_uuid,
            'analysis_number' => $request->analysis_number,
            'analysis_date' => $request->analysis_date,
            'start_unloading' => $request->start_unloading,
            'end_unloading' => $request->end_unloading,
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

        return redirect(route('inputs.analysis.labors.index'))->with('success', 'Labor berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Labor::where('id',$id)->first()->delete();

        return redirect(route('inputs.analysis.labors.index'))->with('success', 'Labor berhasil dihapus.');
    }
}
