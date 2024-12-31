<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Neraca;
use App\Models\KategoryNeraca;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class NeracaController extends Controller
{
    //neraca kategori dan neraca form dan index
    public function indexneraca(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $neracas = Neraca::whereYear('created_at', $tahun)->with('Datakategori')->get();
        return view('neraca.index',compact('neracas','tahun'));
    }

    public function kategorineraca()
    {
        $kategori= KategoryNeraca::all();

        return view('neraca.formKategori',compact('kategori'));
    }

    public function neraca()
    {
        $kat= KategoryNeraca::all();
        
        return view('neraca.formNeraca', compact('kat'));

    }


    //create
    public function createneraca(Request $request) {
        $validatedData = $request->validate([
            'Neraca.*.description' => 'required|string|max:255',
            'Neraca.*.nominal' => 'required|numeric',
            'Neraca.*.category_id' => 'required|exists:Kategory_neracas,id',
        ]);
    
        foreach ($request->input('Neraca') as $subcategoryData) {
            Neraca::create($subcategoryData);
        }
    
        return redirect('/indexneraca')->with('success', 'Data berhasil disimpan.');
    }
    

    public function createkategorineraca(Request $request)
    {
        $kategori = new KategoryNeraca();
        $kategori->name = $request->name;
        $kategori->parent_id = $request->parent_id;
        $kategori->level = 
        
        $kategori->save();
        return redirect('/indexneraca')->with('success', 'Data berhasil disimpan.');
    }
}
