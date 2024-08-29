<?php

namespace App\Http\Controllers\Input\AnalysisBbm;

use App\AnalyticAfter;
use App\BbmReceipt;
use App\Http\Controllers\Controller;
use App\Labor;
use App\Ship;
use App\Supplier;
use Illuminate\Http\Request;

class AfterController extends Controller
{
    public function index(Request $request)
    {
        $afters = AnalyticAfter::query();

        $afters->when($request->year, function ($query) use ($request) {
            $query->whereYear('analysis_date', $request->year);
        });

        $data['analytics'] = $afters->paginate(10)->appends(request()->query());
        return view('inputs.analysis-bbm.after.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['bbm_receipt'] = BbmReceipt::where([['analytic_after_id', '=', null]])->get();
        return view('inputs.analysis-bbm.after.create', $data);
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

        $analytic = AnalyticAfter::create([
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
            'analytic_after_id' => $analytic->id,
        ]);

        return redirect(route('inputs.analysis-bbm.afters.index'))->with('success', 'Analisa baru baru berhasil dibuat.');
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
        $data['analytic'] = AnalyticAfter::where('id', $id)->first();
        return view('inputs.analysis-bbm.after.edit',$data);
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

        AnalyticAfter::where('id',$id)->update([
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

        return redirect(route('inputs.analysis-bbm.afters.index'))->with('success', 'Analisa berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AnalyticAfter::where('id',$id)->first()->delete();

        return redirect(route('inputs.analysis-bbm.afters.index'))->with('success', 'Analisa berhasil dihapus.');
    }
}
