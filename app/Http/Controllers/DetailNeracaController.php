<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\DetailNeraca;
use App\Models\CategoryNeraca;
use App\Models\SubNeraca;
class DetailNeracaController extends Controller
{
    //detail
    public function indexfinancial(Request $request)
{
    $startDate = $request->input('start_date'); 
    $endDate = $request->input('end_date');    

    // Query data
    $query = DB::table('detail_neracas')
    ->join('sub_neracas', 'detail_neracas.sub_id', '=', 'sub_neracas.id')
    ->join('category_neracas', 'sub_neracas.kategori_id', '=', 'category_neracas.id')
    ->select(
        'category_neracas.namecategory as category',
        'sub_neracas.namesub as sub_category',
        'detail_neracas.nominal',
        'detail_neracas.name',
        'detail_neracas.tanggal',
        'detail_neracas.id'
    );
    
    if ($startDate && $endDate) {
        $query->whereBetween('detail_neracas.tanggal', [$startDate, $endDate]);
    }
    
    $data = $query->orderBy('category_neracas.namecategory')
    ->get()
    ->groupBy('category');
    
    $totalsAssets = $data->only(['CURRENT ASSETS', 'FIX ASSETS'])
    ->map(function ($categories) {
        return $categories->sum('nominal');
    })
    ->sum();
    $totalLiabilitas = $data->only(['EQUITY', 'LIABILITIES'])
    ->map(function ($categories) {
        return $categories->sum('nominal');
    })
    ->sum();
    //total control
    $control= $totalLiabilitas - $totalsAssets;
    // NILAI BENER JIKA 0
    if ($control !== 0) {
        $note = "Salah: $control";
    } else {
        $note = "Benar";
    }
    
    
    $groupedData = $data->map(function ($categories, $categoryName) {
        $totalJenis = 0;
        
        $categoriesGrouped = $categories->groupBy('sub_category')->map(function ($subItems, $subCategoryName) use (&$totalJenis) {
            $subTotal = $subItems->sum('nominal');
            $totalJenis += $subTotal;
            
            return [
                'sub_category' => $subCategoryName,
                'nominal' => $subTotal,
                'details' => $subItems,
            ];
        });
        
        return [
            'category_name' => $categoryName,
            'total' => $totalJenis,
            'sub_categories' => $categoriesGrouped,
        ];
    });
    
    // dd(compact('groupedData', 'totalLiabilitas'));
    
    return view('financial.index', compact('groupedData', 'totalsAssets','totalLiabilitas','control','note'));
}


    public function formfinanc(Request $reques){
        $sub = SubNeraca::all();
        $sub = DB::table('sub_neracas')
        ->join('category_neracas', 'sub_neracas.kategori_id', '=', 'category_neracas.id')
        ->select('category_neracas.namecategory','sub_neracas.namesub','sub_neracas.id')
        ->get();

        return view ('financial.addData',compact('sub'));
   
    }
    public function createfinanc(Request $request){
        $validatedData = $request->validate([
            'nominal' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'name' => 'required|string',
            'sub_id' => 'required|string',
            'tanggal' => 'required|date',
        ]);
    
        // Format nominal untuk menghapus koma
        $validatedData['nominal'] = isset($validatedData['nominal']) 
            ? str_replace(',', '', $validatedData['nominal']) 
            : null; 
        // Tambahkan created_by
        $validatedData['created_by'] = auth()->user()->username;
        // Simpan data ke database
        DetailNeraca::create($validatedData);
        return redirect('/indexfinancial')->with('success', 'Data berhasil disimpan.');
    }

    //categori
    public function categoryneraca()
    {
        $user = Auth::user();  
        return view('financial.categoryform');
    }
    public function createcategoryneraca (Request $request)
    {
        $validatedData = $request->validate([
            'namecategory' => 'required|string',
        ]);
        $validatedData['created_by'] = auth()->user()->username;
        CategoryNeraca::create($validatedData);
        return redirect('/indexfinancial')->with('success', 'Data berhasil disimpan.');
    }


    //sub
    public function subneraca()
    {
        $user = Auth::user();  
        $kat = CategoryNeraca::all();

        return view('financial.subform',compact('kat'));
    }
    public function createsubneraca (Request $request)
    {
        $validatedData = $request->validate([
            'namesub' => 'required|string',
            'kategori_id' => 'required|string',
        ]);
        $validatedData['created_by'] = auth()->user()->username;
        SubNeraca::create($validatedData);
        return redirect('/indexfinancial')->with('success', 'Data berhasil disimpan.');
    }


}
