<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HargaPokoPenjualan;

class HPPController extends Controller
{
    public function indexhpp(Request $request)
    {
        $year = $request->input('year');
        $reports = HargaPokoPenjualan::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();
       $years = HargaPokoPenjualan::selectRaw('YEAR(created_at) as year')
           ->distinct()
           ->orderBy('year', 'desc')
           ->pluck('year');
        // $categories = HargaPokoPenjualan::all();
        $categories = DB::table('harga_poko_penjualans')
        ->where('harga_poko_penjualans.subcategory', 'over burden')
        ->select(
            'harga_poko_penjualans.realisasi', 
            'harga_poko_penjualans.category', 
            'harga_poko_penjualans.subcategory', 
            'harga_poko_penjualans.item', 
            'harga_poko_penjualans.rencana', 
            'harga_poko_penjualans.created_by', )
            ->get();
        return view('hpp.index',compact('categories','year','years','reports'));
    }

    //UNTUK MENAMPILAKN FORM dan ADD DATA NAMA hpp
    public function hpp()
    {
        $categories = HargaPokoPenjualan::all();
        return view('hpp.formHpp',compact('categories'));
    }
    
    public function addHpp(Request $request)
    {
        $request->validate([
            'items.*.subcategory' => 'nullable',
            'items.*.planSub' => 'nullable',
            'items.*.realisasiSub' => 'nullable',
            'items' => 'nullable|array',
            'items.*.item' => 'nullable',
            'items.*.rencana' => 'nullable',
            'items.*.realisasi' => 'nullable',
        ]);
        foreach ($request->items as $itemData) {
        HargaPokoPenjualan::create([
            'category' => 'Contraktor Cost',
            'subcategory' => $itemData['subcategory'],
            'rencana' =>  $itemData['rencana'] ?? 0,
            'planSub' =>  $itemData['plansub'] ?? 0,
            'realisasiSub' =>  $itemData['realisasiSub'] ?? 0,
            'item' =>  $itemData['item'],
            'realisasi' => $itemData['realisasi'] ?? 0,
            'created_by' => auth()->user()->username

        ]);
    }
        return redirect('/indexhpp')->with('success', 'Surat berhasil disimpan.');
    }
    // $categories = HargaPokoPenjualan::with('children')->whereNull('parent_id')->get();
    // return view('kategori.index', compact('categories'));


}


