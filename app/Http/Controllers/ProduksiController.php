<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Produksi;
use App\Models\PicaPaUa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProduksiController extends Controller
{
    public function indexpaua(Request $request)
    {
        $hauler = DB::table('produksis')
        ->join('units', 'produksis.unit_id', '=', 'units.id')
        ->where('units.unit', 'UNIT HAULER')
        ->select('produksis.*', 'units.unit', 'units.code_number')  
        ->get();
        
        $loader = DB::table('produksis')
        ->join('units', 'produksis.unit_id', '=', 'units.id')
        ->where('units.unit', 'UNIT LOADER')
        ->select('produksis.*', 'units.unit', 'units.code_number')  
        ->get();
        
        $support = DB::table('produksis')
        ->join('units', 'produksis.unit_id', '=', 'units.id')
        ->where('units.unit', 'UNIT SUPORT')
        ->select('produksis.*', 'units.unit', 'units.code_number')  
        ->get();



        //filter tahun
        
        $year = $request->input('year');
        $reports = Produksi::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();
       $years = Produksi::selectRaw('YEAR(created_at) as year')
           ->distinct()
           ->orderBy('year', 'desc')
           ->pluck('year');
        return view('PA_UA.index',compact('reports','years','year','hauler','loader','support'));
    }

    public function unit()
    {

        return view('PA_UA.addUnit');
    }

    public function produksi()
    {
        $unit= Unit::all();
        
        return view('PA_UA.addproduksi',compact('unit'));

    }


    //create
    public function createproduksi(Request $request) {
        $validatedData = $request->validate([
            'ob_bcm' => 'nullable|numeric',
            'ob_wh' => 'nullable|numeric',
            'ob_pty' => 'nullable|numeric',
            'ob_distance' => 'nullable|numeric',
            'coal_mt' => 'nullable|numeric',
            'coal_wh' => 'nullable|numeric',
            'coal_pty' => 'nullable|numeric',
            'coal_distance' => 'nullable|numeric',
            'general_hours' => 'nullable|numeric',
            'stby_hours' => 'nullable|numeric',
            'bd_hours' => 'nullable|numeric',
            'rental_hours' => 'nullable|numeric',
            'pa' => 'nullable|numeric',
            'mohh' => 'nullable|numeric',
            'ua' => 'nullable|numeric',
            'ltr_total' => 'nullable|numeric',
            'ltr_wh' => 'nullable|numeric',
            'ltr' => 'nullable|numeric',
            'ltr_coal' => 'nullable|numeric',
            'l_hm' => 'nullable|numeric',
            'l_bcm' => 'nullable|numeric',
            'l_mt' => 'nullable|numeric',
            'tot_pa' => 'nullable|string',
            'tot_ua' => 'nullable|string',
            'tot_ma' => 'nullable|string',
            'eu' => 'nullable|string',
            'pa_plan' => 'nullable|string',
            'ua_plan' => 'nullable|string',
            'unit_id' => 'required',
            't_hm' => 'nullable|string',
        ]);
        $validatedData['created_by'] = auth()->user()->username;

        Produksi::create($validatedData);        

        return redirect('/indexpaua')->with('success', 'Data berhasil disimpan.');
    }
    

    public function createunit(Request $request)
{
    $validatedData = $request->validate([
        'code_number' => 'required|unique:units,code_number',  
        'unit' => 'required|string|max:255',  
    ]);

    $validatedData['created_by'] = auth()->user()->username;
    Unit::create($validatedData);        

    return redirect('/indexpaua')->with('success', 'Data berhasil disimpan.');
}


    //update
    public function formupdateProduksi($id)
    {
        
        $unit= Unit::all();
        $data= Produksi::findOrFail($id);
        
        return view('PA_UA.updatedata',compact('unit','data'));
        
    }
    
    public function updateproduksi(Request $request, $id) {
        $validatedData = $request->validate([
            'ob_bcm' => 'nullable|numeric',
            'ob_wh' => 'nullable|numeric',
            'ob_pty' => 'nullable|numeric',
            'ob_distance' => 'nullable|numeric',
            'coal_mt' => 'nullable|numeric',
            'coal_wh' => 'nullable|numeric',
            'coal_pty' => 'nullable|numeric',
            'coal_distance' => 'nullable|numeric',
            'general_hours' => 'nullable|numeric',
            'stby_hours' => 'nullable|numeric',
            'bd_hours' => 'nullable|numeric',
            'rental_hours' => 'nullable|numeric',
            'pa' => 'nullable|numeric',
            'mohh' => 'nullable|numeric',
            'ua' => 'nullable|numeric',
            'ltr_total' => 'nullable|numeric',
            'ltr_wh' => 'nullable|numeric',
            'ltr' => 'nullable|numeric',
            'ltr_coal' => 'nullable|numeric',
            'l_hm' => 'nullable|numeric',
            'l_bcm' => 'nullable|numeric',
            'l_mt' => 'nullable|numeric',
            'tot_pa' => 'nullable|string',
            'tot_ua' => 'nullable|string',
            'tot_ma' => 'nullable|string',
            'eu' => 'nullable|string',
            'pa_plan' => 'nullable|string',
            'ua_plan' => 'nullable|string',
            'unit_id' => 'required',
            't_hm' => 'nullable|string',
        ]);
        $validatedData['updated_by'] = auth()->user()->username;
        $Produksi = Produksi::findOrFail($id);
        $Produksi->update($validatedData);
        
        return redirect('/indexpaua')->with('success', 'Data berhasil disimpan.');
    }

    public function picapaua(Request $request)
    {
        $user = Auth::user();  
        $data = PicaPaUa::all();
        $year = $request->input('year');

        //filter tahun di laporan
        $reports = PicaPaUa::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();
        
        $years = PicaPaUa::selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');
        
        return view('picapaua.index', compact('data','reports','years', 'year'));
        
    }

    
    public function formpicapaua()
    {
        $user = Auth::user();  
        return view('picapaua.addData');
    }

    public function createpicapaua(Request $request)
    {
                // dd($request->all());


                $validatedData = $request->validate([
                    'problem' => 'required|string',
                    'corectiveaction' => 'required|string',
                    'cause' => 'required|string',
                    'duedate' => 'required|string',
                    'pic' => 'required|string',
                    'status' => 'required|string',
                    'remerks' => 'required|string',
                ]);
                $validatedData['created_by'] = auth()->user()->username;
                PicaPaUa::create($validatedData);        
        return redirect('/picapaua')->with('success', 'Surat berhasil disimpan.');
    }

    public function formupdatepicapaua($id){
        $data = PicaPaUa::findOrFail($id);
        return view('picapaua.update', compact('data'));
    }

    public function updatepicapaua (Request $request, $id)
    {
                // dd($request->all());


                $validatedData = $request->validate([
                    'problem' => 'required|string',
                    'corectiveaction' => 'required|string',
                    'cause' => 'required|string',
                    'duedate' => 'required|string',
                    'pic' => 'required|string',
                    'status' => 'required|string',
                    'remerks' => 'required|string',
                ]);
                $validatedData['updated_by'] = auth()->user()->username;
        
                $PicaPeople =PicaPaUa::findOrFail($id);
                $PicaPeople->update($validatedData);
        
        return redirect('/picapaua')->with('success', 'Surat berhasil disimpan.');
    }

    
}

