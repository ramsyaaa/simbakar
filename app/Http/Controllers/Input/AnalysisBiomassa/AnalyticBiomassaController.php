<?php

namespace App\Http\Controllers\Input\AnalysisBiomassa;

use App\Ship;
use App\Labor;
use App\Supplier;
use App\BbmReceipt;
use Illuminate\Http\Request;
use App\Models\AnalyticBiomassa;
use App\Models\BiomassaContract;
use App\Models\BiomassaSubSupplier;
use App\Http\Controllers\Controller;

class AnalyticBiomassaController extends Controller
{
    public function index(Request $request)
    {
        $afters = AnalyticBiomassa::query();

        $afters->when($request->year, function ($query) use ($request) {
            $query->whereYear('analysis_date', $request->year);
        });

        $data['analytics'] = $afters->paginate(10)->appends(request()->query());
        return view('inputs.analysis-biomassa.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['contracts'] = BiomassaContract::all();
        return view('inputs.analysis-biomassa.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $checkAnalytic = AnalyticBiomassa::where('analysis_number',$request->analysis_number)->first();
        if($checkAnalytic){
            return redirect(route('inputs.analysis-biomassa.index'))->with('danger', 'Nomor analisa sudah pernah di input pada tanggal '.$checkAnalytic->analysis_date); 
        }
        AnalyticBiomassa::create($request->all());


        return redirect(route('inputs.analysis-biomassa.index'))->with('success', 'Analisa baru baru berhasil dibuat.');
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
        $analytic = AnalyticBiomassa::where('id', $id)->first();
        
        $data['contracts'] = BiomassaContract::all();
        $data['suppliers'] = BiomassaSubSupplier::where('contract_id', $analytic->contract_id)
        ->join('suppliers', 'suppliers.id','biomassa_sub_suppliers.supplier_id')
        ->get();
        $data['analytic'] = $analytic;
        return view('inputs.analysis-biomassa.edit',$data);
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

        AnalyticBiomassa::where('id',$id)->update($request->except(['_token','_method']));

        return redirect(route('inputs.analysis-biomassa.index'))->with('success', 'Analisa berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AnalyticBiomassa::where('id',$id)->first()->delete();

        return redirect(route('inputs.analysis-biomassa.index'))->with('success', 'Analisa berhasil dihapus.');
    }
}
