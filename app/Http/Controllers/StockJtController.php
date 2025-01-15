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
        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');  
        $query = DB::table('stock_jts');
        if ($startDate && $endDate) {
            $query->whereBetween('stock_jts.date', [$startDate, $endDate]);
        }
        
        $data = $query->get();
        
        $stokAwal = $data->whereNotNull('sotckawal')->first()->sotckawal ?? 0;

        $data->map(function ($stock) use ($stokAwal) {
            $stock->akumulasi_stock = $stokAwal + $stock->totalhauling;
            return $stock;
        });        
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
        'sotckawal' => 'nullable|numeric',
        'shifpertama' => 'nullable|numeric',
        'shifkedua' => 'nullable|numeric',
        'totalhauling' => 'nullable|numeric',
        'lokasi' =>'required' ,

    ]);

    // Ambil bulan dan tahun dari tanggal input
    $date = Carbon::parse($request->date);
    $month = $date->month;
    $year = $date->year;

    // Cek apakah stok awal sudah ada untuk bulan ini
    $existingStock = StockJt::whereYear('date', $year)
        ->whereMonth('date', $month)
        ->first();

    if ($existingStock) {
        // Jika stok awal sudah ada, update data shift dan hauling saja
        $existingStock->update([
            'shifpertama' => $request->shifpertama ?? $existingStock->shifpertama,
            'shifkedua' => $request->shifkedua ?? $existingStock->shifkedua,
            'totalhauling' => $request->totalhauling ?? $existingStock->totalhauling,
        ]);

        return redirect('/stockjt')->with('success', 'Data hauling berhasil diperbarui.');
    } else {
        // Jika stok awal belum ada, tambahkan data baru
        StockJt::create([
            'date' => $request->date,
            'sotckawal' => $request->sotckawal,
            'shifpertama' => $request->shifpertama,
            'shifkedua' => $request->shifkedua,
            'lokasi' => $request->lokasi,
            'totalhauling' => $request->totalhauling,
            'created_by' => auth()->user()->username,
        ]);
    }
        return redirect('/stockjt')->with('success', 'data berhasil disimpan.');
        
    }
    
    
    

    //Pica
    public function picastockjt(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $query = DB::table('picastockjts') 
            ->select('*'); // Memilih semua kolom dari tabel
        
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]); // Tidak perlu menyebut nama tabel
        }
        
        $data = $query->get();
        
        
        return view('picastokjt.index', compact('data'));
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
            'tanggal' => 'required|date',
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
            'tanggal' => 'required|date',
        ]);
        $validatedData['updated_by'] = auth()->user()->username;
        
        $PicaPeople = Picastockjt::findOrFail($id);
        $PicaPeople->update($validatedData);
        
        return redirect('/picastockjt')->with('success', 'data berhasil disimpan.');
    }

}
