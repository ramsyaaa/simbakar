<?php

namespace App\Http\Controllers\Input\AnalysisBbm;

use App\AnalyticBefore;
use App\BbmReceipt;
use App\Ship;
use App\before;
use App\Loading;
use App\Surveyor;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BeforeController extends Controller
{
    public function index(Request $request)
    {
        $befores = AnalyticBefore::query();
        $year = isset($request->year) ? $request->year : \Carbon\Carbon::now()->year;

        $befores->when($year, function ($query) use ($year) {
            $query->whereYear('analysis_date', $year);
        });

        $befores->orderBy('created_at', 'desc');

        $data['analytics'] = $befores->paginate(10)->appends(request()->query());
        return view('inputs.analysis-bbm.before.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['bbm_receipt'] = BbmReceipt::where([['analytic_before_id', '=', null]])->get();
        return view('inputs.analysis-bbm.before.create', $data);
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
            'faktur_number' =>'required',
            'analysis_number' => 'required',
            'analysis_date' => 'required',
            'density' => 'required',
            'spesific_gravity' => 'required',
            'kinematic_viscosity' => 'required',
            'sulfur_content' => 'required',
            'flash_point' => 'required',
            'pour_point' => 'required',
            'carbon_residu' => 'required',
            'water_content' => 'required',
            'fame_content' => 'required',
            'ash_content' => 'required',
            'sediment_content' => 'required',
            'calorific_value' => 'required',
            'sodium' => 'required',
            'potassium' => 'required',
            'vanadium' => 'required',
        ], [
            'faktur_number.required' => 'Nomor faktur wajib dipilih.',
            'analysis_number.required' => 'Nomor analisis wajib diisi.',
            'analysis_date.required' => 'Tanggal analisis wajib diisi.',
            'density.required' => 'Density at 15 C wajib diisi.',
            'spesific_gravity.required' => 'Specific Gravity at 60/60 F wajib diisi.',
            'kinematic_viscosity.required' => 'Kinematic Viscosity at 40 wajib diisi.',
            'sulfur_content.required' => 'Sulfur Content wajib diisi.',
            'flash_point.required' => 'Flash Point PMcc wajib diisi.',
            'pour_point.required' => 'Pour Point wajib diisi.',
            'carbon_residu.required' => 'Carbon residue wajib diisi.',
            'water_content.required' => 'Water content wajib diisi.',
            'fame_content.required' => 'FAME content wajib diisi.',
            'ash_content.required' => 'Ash content wajib diisi.',
            'sediment_content.required' => 'Sediment content wajib diisi.',
            'calorific_value.required' => 'Clorific value gross wajib diisi.',
            'sodium.required' => 'Sodium (Na) wajib diisi.',
            'potassium.required' => 'Potassium (K) wajib diisi.',
            'vanadium.required' => 'Vanadium (V) wajib diisi.',
        ]);

        $analytic = AnalyticBefore::create([
            'analysis_number' => $request->analysis_number,
            'analysis_date' => $request->analysis_date,
            'density' => $request->density,
            'spesific_gravity' => $request->spesific_gravity,
            'kinematic_viscosity' => $request->kinematic_viscosity,
            'sulfur_content' => $request->sulfur_content,
            'flash_point' => $request->flash_point,
            'pour_point' => $request->pour_point,
            'carbon_residu' => $request->carbon_residu,
            'water_content' => $request->water_content,
            'fame_content' => $request->fame_content,
            'ash_content' => $request->ash_content,
            'sediment_content' => $request->sediment_content,
            'calorific_value' => $request->calorific_value,
            'sodium' => $request->sodium,
            'potassium' => $request->potassium,
            'vanadium' => $request->vanadium,
        ]);

        BbmReceipt::where([
            'id' => $request->faktur_number,
        ])->update([
            'analytic_before_id' => $analytic->id,
        ]);

        return redirect(route('inputs.analysis-bbm.befores.index'))->with('success', 'Analisa baru baru berhasil dibuat.');
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
        $data['analytic'] = AnalyticBefore::where('id', $id)->first();
        return view('inputs.analysis-bbm.before.edit',$data);
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
            'analysis_number' => 'required',
            'analysis_date' => 'required',
            'density' => 'required',
            'spesific_gravity' => 'required',
            'kinematic_viscosity' => 'required',
            'sulfur_content' => 'required',
            'flash_point' => 'required',
            'pour_point' => 'required',
            'carbon_residu' => 'required',
            'water_content' => 'required',
            'fame_content' => 'required',
            'ash_content' => 'required',
            'sediment_content' => 'required',
            'calorific_value' => 'required',
            'sodium' => 'required',
            'potassium' => 'required',
            'vanadium' => 'required',
        ], [
            'analysis_number.required' => 'Nomor analisis wajib diisi.',
            'analysis_date.required' => 'Tanggal analisis wajib diisi.',
            'density.required' => 'Density at 15 C wajib diisi.',
            'spesific_gravity.required' => 'Specific Gravity at 60/60 F wajib diisi.',
            'kinematic_viscosity.required' => 'Kinematic Viscosity at 40 wajib diisi.',
            'sulfur_content.required' => 'Sulfur Content wajib diisi.',
            'flash_point.required' => 'Flash Point PMcc wajib diisi.',
            'pour_point.required' => 'Pour Point wajib diisi.',
            'carbon_residu.required' => 'Carbon residue wajib diisi.',
            'water_content.required' => 'Water content wajib diisi.',
            'fame_content.required' => 'FAME content wajib diisi.',
            'ash_content.required' => 'Ash content wajib diisi.',
            'sediment_content.required' => 'Sediment content wajib diisi.',
            'calorific_value.required' => 'Clorific value gross wajib diisi.',
            'sodium.required' => 'Sodium (Na) wajib diisi.',
            'potassium.required' => 'Potassium (K) wajib diisi.',
            'vanadium.required' => 'Vanadium (V) wajib diisi.',
        ]);

        AnalyticBefore::where('id',$id)->update([
            'analysis_number' => $request->analysis_number,
            'analysis_date' => $request->analysis_date,
            'density' => $request->density,
            'spesific_gravity' => $request->spesific_gravity,
            'kinematic_viscosity' => $request->kinematic_viscosity,
            'sulfur_content' => $request->sulfur_content,
            'flash_point' => $request->flash_point,
            'pour_point' => $request->pour_point,
            'carbon_residu' => $request->carbon_residu,
            'water_content' => $request->water_content,
            'fame_content' => $request->fame_content,
            'ash_content' => $request->ash_content,
            'sediment_content' => $request->sediment_content,
            'calorific_value' => $request->calorific_value,
            'sodium' => $request->sodium,
            'potassium' => $request->potassium,
            'vanadium' => $request->vanadium,
        ]);

        return redirect(route('inputs.analysis-bbm.befores.index'))->with('success', 'Analisa berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AnalyticBefore::where('id',$id)->first()->delete();

        return redirect(route('inputs.analysis-bbm.befores.index'))->with('success', 'Analisa berhasil dihapus.');
    }
}
