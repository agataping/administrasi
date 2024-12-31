<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HargaPokoPenjualan;

class HPPController extends Controller
{
    public function indexhpp()
    {
              // Ambil semua kategori utama beserta subkategori
              $categories = HargaPokoPenjualan::with('children')->whereNull('parent_id')->get();

              // Data dummy untuk rencana dan realisasi
              $data = [
                  'HPP' => [
                      'rencana' => 175322324342,
                      'realisasi' => 9959600907,
                  ],
              ];
        return view('hpp.index',compact('data','categories'));
    }

    //UNTUK MENAMPILAKN FORM dan ADD DATA NAMA hpp
    public function hpp()
    {
        $categories = HargaPokoPenjualan::whereNull('parent_id')->get();
        return view('hpp.formHpp',compact('categories'));
    }
    
    public function addHpp(Request $request)
    {
        $request->validate([
            'uraian' => 'required|string',
            'tahun' => 'required|string',
            'parent_id' => 'nullable|exists:harga_poko_penjualans,id',
            'realisasi' => 'nullable|numeric',
            'rencana' => 'nullable|numeric'
        ]);
    
        $parent = HargaPokoPenjualan::find($request->parent_id);

        $level = $parent ? $parent->level + 1 : 0; // Set level berdasarkan parent
    
        HargaPokoPenjualan::create([
            'uraian' => $request->uraian,
            'parent_id' => $request->parent_id,
            'realisasi' => $request->realisasi,
            'rencana' => $request->rencana,
            'tahun' => $request->tahun,
            'level' => $level
        ]);
      
        return redirect('/indexhpp')->with('success', 'Surat berhasil disimpan.');
    }
    // $categories = HargaPokoPenjualan::with('children')->whereNull('parent_id')->get();
    // return view('kategori.index', compact('categories'));


}


