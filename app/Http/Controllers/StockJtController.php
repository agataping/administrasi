<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Picastockjt;
use App\Models\StockJt;
class StockJtController extends Controller
{
    //detail
    public function stockjt(Request $request)
    {
        $data = StockJt::all();
        return view('stockjt.index', compact('data'));  
    }
    public function formstockjt(Request $request)
    {
        return view('stockjt.addData');  
    }
    public function createstockjt(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'sotckawal' => 'required|numeric|min:0',
            'shifpertama' => 'nullable|numeric|min:0',
            'shifkedua' => 'nullable|numeric|min:0',
            'totalhauling' => 'nullable|numeric|min:0',
        ]);

        // Ambil bulan dan tahun dari tanggal
    $date = Carbon::parse($request->date);
    $month = $date->month;
    $year = $date->year;

    // Cek apakah stok awal sudah diinput untuk bulan ini
    $exists = StockJt::whereYear('date', $year)
        ->whereMonth('date', $month)
        ->exists();


        if ($exists) {
            // Menampilkan pesan dengan session flash dan redirect
            return redirect()->back()->with('error', 'Stok awal untuk bulan ini sudah diinput!');
        }
        $stock = StockJt::create([
            'date' => $request->date
,
            'sotckawal' => $request->sotckawal,
            'shifpertama' => $request->shifpertama,
            'shifkedua' => $request->shifkedua,
            'totalhauling' => $request->totalhauling,
            'created_by' => auth()->user()->username,
            
        ]);


        return redirect('/stockjt')->with('success', 'data berhasil disimpan.');

    }

    

    //Pica
    public function picastockjt(Request $request)
    {
        $user = Auth::user();
        $data = Picastockjt::all();
        $year = $request->input('year');
        
        $reports = Picastockjt::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();
        
        $years = Picastockjt::selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');
        
        return view('picastokjt.index', compact('data', 'reports', 'years', 'year',));
    }
    
    public function formpicasjt()
    {
        $user = Auth::user();
        return view('picastokjt.addData');
    }
    
    public function createsjt(Request $request)
    {
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
        Picastockjt::create($validatedData);
        
        return redirect('/picastockjt')->with('success', 'Data berhasil disimpan.');
    }
    
    public function formupdatesjt($id)
    {
        $data = Picastockjt::findOrFail($id);
        return view('picastokjt.update', compact('data'));
    }
    
    public function updatesjt(Request $request, $id)
    {
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
        
        $PicaPeople = Picastockjt::findOrFail($id);
        $PicaPeople->update($validatedData);
        
        return redirect('/picastockjt')->with('success', 'data berhasil disimpan.');
    }

}
