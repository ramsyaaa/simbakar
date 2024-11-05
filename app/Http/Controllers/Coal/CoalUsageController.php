<?php

namespace App\Http\Controllers\Coal;

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
use PhpParser\Node\Expr\AssignOp\Coalesce;

class CoalUsageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['units'] = Unit::all();
        if ($request->has('date')){

            $usages = CoalUsage::query();
            $usages->when($request->date, function ($query) use ($request) {
                $date = explode('-', $request->date);
                $query->whereYear('usage_date', $date[0]);
                $query->whereMonth('usage_date', $date[1]);
            })
            ->when($request->unit_id, function($query) use ($request){
                $query->where('unit_id',$request->unit_id);
            })
            ->when($request->day, function ($query) use ($request) {
                $query->where(DB::raw('DAY(usage_date)'), $request->day);
            });
            $data['usages'] = $usages->orderBy('unit_id','asc')->latest()->paginate(7)->appends(request()->query());
        }
        return view('coals.usages.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['units'] = Unit::all();
        return view('coals.usages.create',$data);
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

            $request->validate([

                'tug_9_number' => 'required|unique:coal_usages,tug_9_number',
                'usage_date' => 'required',
                'amount_use' => 'required',
                'unit_id' => 'required',
            ], [
                'tug_9_number.required' => 'No TUG 9 wajib diisi',
                'tug_9_number.unique' => 'No TUG 9 sudah digunakan',
                'usage_date.required' => 'Tanggal pakai wajib diisi',
                'amount_use.required' => 'Jumlah pakai wajib diisi',
                'unit_id.required' => 'Unit pakai wajib diisi',
            ]);
            $requestData = $request->all();
            
            $usage = CoalUsage::create($requestData);

            Tug::create([
                'tug' => 9,
                'tug_number' => $requestData['tug_9_number'],
                'type_tug' => 'coal-usage',
                'usage_amount' => $requestData['amount_use'],
                'unit' => 'Kg',
                'type_fuel' => 'Batu Bara',
                'coal_usage_id' => $usage->id,
            ]);
            $date = Carbon::parse($request->usage_date);
            $month = $date->format('Y-m');
            $day = $date->format('d');
            //test usage
            DB::commit();
            return redirect(route('coals.usages.index',['date' => $month,'day'=>$day]))->with('success', 'Pemakaian Batu Bara berhasil di buat.');

        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Pemakaian Batu Bara gagal di buat');
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
        $usage = CoalUsage::where('id', $id)->first();
        $data['units'] = Unit::all();
        $data['usage'] = $usage;

        return view('coals.usages.edit',$data);
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
            $coal_usage = CoalUsage::where([
                'id' => $id,
            ])->first();

            if($coal_usage == null){
                return;
            }

            $request->validate([
                'tug_9_number' => ['required', $coal_usage->tug_9_number != $request->tug_9_number ? 'unique:tugs,tug_number' : ''],
            ], [
                'tug_9_number.required' => 'No TUG9 wajib diisi',
                'tug_9_number.unique' => 'No TUG9 sudah digunakan',
            ]);

            $requestData = $request->except(['_token','_method']);

            CoalUsage::where('id',$id)->update($requestData);

            Tug::where('type_tug','coal-usage')->where('coal_usage_id',$id)->update([
                'tug_number' => $requestData['tug_9_number'],
                'usage_amount' => $requestData['amount_use'],
            ]);
            $coal = CoalUsage::where('id',$id)->first();

            $date = Carbon::parse($coal->usage_date);
            $month = $date->format('Y-m');
            $day = $date->format('d');

            DB::commit();
            return redirect(route('coals.usages.index',['date' => $month,'day'=>$day]))->with('success', 'Pemakaian Batu Bara berhasil di ubah.');

        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Pemakaian Batu Bara gagal di ubah');
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
        $coal = CoalUsage::where('id', $id)->first();
        $date = Carbon::parse($coal->usage_date);
        $month = $date->format('Y-m');
        $day = $date->format('d');
        $coal->delete();

        return redirect(route('coals.usages.index',['date' => $month,'day'=>$day]))->with('success', 'Pemakaian Batu Bara berhasil di hapus.');
    }
}
