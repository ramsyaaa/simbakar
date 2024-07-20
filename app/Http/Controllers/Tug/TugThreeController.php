<?php

namespace App\Http\Controllers\Tug;

use App\Dock;
use App\Ship;
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
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use App\Models\HeadWarehouse;
use App\Models\UserInspection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TugThreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tugs = Tug::query();
        $tugs->where('tug',3)
        ->when($request->date, function ($query) use ($request) {
            $date = explode('-', $request->date);
            $query->whereYear('created_at', $date[0]);
            $query->whereMonth('created_at', $date[1]);
        })->when($request->fuel, function ($query) use ($request) {
            $query->where('type_fuel', $request->fuel);
        });
        $data['tugs'] = $tugs->latest()->paginate(10)->appends(request()->query());
        return view('inputs.tug-3.index',$data);

    }
    public function detail($id){

        $data['tug'] = Tug::where('id',$id)->first();
        return view('inputs.tug-3.index',$data);
    }
    public function destroy($id)
    {
        Tug::where('id', $id)->delete();
        return redirect(route('inputs.tug-3.index'))->with('success', 'Pembongkaran Batu Bara berhasil di hapus.');
    }
}
