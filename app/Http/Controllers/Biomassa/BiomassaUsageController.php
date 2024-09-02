<?php

namespace App\Http\Controllers\Biomassa;

use App\BiomassaUsage;
use App\Dock;
use App\Ship;
use App\Unit;
use App\Labor;
use App\Harbor;
use App\Loading;
use App\Supplier;
use App\Surveyor;
use App\ShipAgent;
use App\Unloading;
use Carbon\Carbon;
use App\Models\Tug;
use App\Transporter;
use App\LoadingCompany;
use App\Models\CoalUsage;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use App\Models\HeadWarehouse;
use App\Models\UserInspection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BiomassaUsageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $usages = BiomassaUsage::query();
        $usages->when($request->date, function ($query) use ($request) {
            $date = explode('-', $request->date);
            $query->whereYear('usage_date', $date[0]);
            $query->whereMonth('usage_date', $date[1]);
        })->when($request->day, function ($query) use ($request) {
            $query->where(DB::raw('DAY(usage_date)'), $request->day);
        });
        $data['usages'] = $usages->latest()->paginate(10)->appends(request()->query());
        return view('biomassa.usages.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['units'] = Unit::all();
        return view('biomassa.usages.create',$data);
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

            $usage = BiomassaUsage::create($requestData);

            Tug::create([
                'tug' => 9,
                'tug_number' => $requestData['tug_9_number'],
                'type_tug' => 'biomassa-usage',
                'usage_amount' => $requestData['amount_use'],
                'unit' => 'Kg',
                'type_fuel' => 'Biomassa',
                'biomassa_usage_id' => $usage->id,
            ]);

            DB::commit();
            return redirect(route('biomassa.usages.index'))->with('success', 'Pemakaian Biomassa berhasil di buat.');

        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Pemakaian Biomassa gagal di buat');
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
        $usage = BiomassaUsage::where('id', $id)->first();
        $data['units'] = Unit::all();
        $data['usage'] = $usage;

        return view('biomassa.usages.edit',$data);
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

            BiomassaUsage::where('id',$id)->update($requestData);

            Tug::where('type_tug','biomassa-usage')->where('biomassa_usage_id',$id)->update([
                'tug_number' => $requestData['tug_9_number'],
                'usage_amount' => $requestData['amount_use'],
            ]);

            DB::commit();
            return redirect(route('biomassa.usages.index'))->with('success', 'Pemakaian Biomassa berhasil di ubah.');

        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Pemakaian Biomassa gagal di ubah');
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
        BiomassaUsage::where('id', $id)->delete();
        return redirect(route('biomassa.usages.index'))->with('success', 'Pemakaian Biomassa berhasil di hapus.');
    }
}
