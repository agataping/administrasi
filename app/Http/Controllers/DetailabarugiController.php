<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\categoryLabarugi;
use App\Models\JenisLabarugi;
use App\Models\detailabarugi;
use App\Models\subkategoriLabarugi;
use App\Models\PicalabaRugi;
class DetailabarugiController extends Controller
{
    //detail
    public function labarugi(Request $request)
    {
        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');    
        $data = detailabarugi::paginate(10);
        $query = DB::table('detailabarugis')
        ->join('sub_labarugis', 'detailabarugis.sub_id', '=', 'sub_labarugis.id')
        ->join('category_labarugis', 'sub_labarugis.kategori_id', '=', 'category_labarugis.id')
        ->join('jenis_labarugis', 'category_labarugis.jenis_id', '=', 'jenis_labarugis.id')
        ->select(
            'category_labarugis.namecategory as kategori_name',
            'jenis_labarugis.name as jenis_name',
            'jenis_labarugis.name',
            'sub_labarugis.id as sub_id',
            'detailabarugis.id as detail_id',

            'sub_labarugis.namesub as name_sub',
            'detailabarugis.nominalplan',
            'detailabarugis.nominalactual',
            'detailabarugis.tanggal',
            'detailabarugis.desc',
            'category_labarugis.id as category_id'
        );
        
        if ($startDate && $endDate) {
            $query->whereBetween('detailabarugis.tanggal', [$startDate, $endDate]);
        }
        // $query->orderBy('detailabarugis.tanggal', 'asc');
        $data = $query->orderBy('detailabarugis.tanggal', 'asc') 
        ->get()
        ->groupBy(['jenis_name', 'kategori_name']);
    
    $totalRevenuea = (clone $query)
        ->where('category_labarugis.namecategory', 'Revenue')
        ->get()
        ->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalactual ?? 0);
        });
    
    $totallkactual = (clone $query)
        ->where('jenis_labarugis.name', 'Laba Kotor')
        ->get()
        ->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalactual ?? 0);
        });
    
    $totallkplan = (clone $query)
        ->where('jenis_labarugis.name', 'Laba Kotor')
        ->get()
        ->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalplan ?? 0);
        });
    
        
    $totalRevenuep = (clone $query)
        ->where('category_labarugis.namecategory', 'Revenue')
        ->get()
        ->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalplan ?? 0);
        });
        //operasional
        $planoperasional = (clone $query)
        ->where('jenis_labarugis.name', 'Laba Operasional')
        ->get()
        ->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalplan ?? 0);
        });
        $actualoperasional = (clone $query)
        ->where('jenis_labarugis.name', 'Laba Operasional')
        ->get()
        ->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalactual ?? 0);
        });

        //lababersih
        $planlb = (clone $query)
        ->where('jenis_labarugis.name', 'Laba Bersih')
        ->get()
        ->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalplan ?? 0);
        });
        $actuallb = (clone $query)
        ->where('jenis_labarugis.name', 'Laba Bersih')
        ->get()
        ->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalactual ?? 0);
        });
        //laba rugi 
        $totalplanlr = $totalRevenuep-$totallkplan;
        $totalactuallr = $totalRevenuea-$totallkactual;
        $totalvertikal = $totalplanlr ? ($totalplanlr / $totalplanlr) * 100 : 0;
        //operasional
        $totalplanlp = $planoperasional-$totalplanlr;
        $totalactual = $actualoperasional-$totalactuallr;
        $verticallp = $totalRevenuep ? ($totalplanlp / $totalRevenuep) * 100 : 0;
        //lababersih
        $totalplanlb = $planlb-$planoperasional;
        $totalactuallb = $actualoperasional-$actuallb;
        $verticallb = $totalRevenuep ? ($totalplanlb / $totalRevenuep) * 100 : 0;
        
        
        if ($totalRevenuea === 0 || !$totalRevenuea) {
            $totalRevenuea = null;
        }
        if ($totalRevenuep === 0 || !$totalRevenuep) {
            $totalRevenuep = null;
        }
        
        $totals = $data->map(function ($categories, $jenisName) use (&$totalRevenuep, &$totalRevenuea) {
            $categoryTotalPlan = 0;
            $categoryTotalActual = 0;
            
            // Grup berdasarkan kategori (kategori_name)
            $subCategories = $categories->map(function ($kategori, $kategoriName) use (&$categoryTotalPlan, &$categoryTotalActual, $totalRevenuea, $totalRevenuep) {
                $subCategoryDetails = $kategori->groupBy('name_sub')->map(function ($items, $subCategory) use (&$categoryTotalPlan, &$categoryTotalActual, $totalRevenuea, $totalRevenuep) {
                    $totalPlan = $items->sum(function ($item) {
                        return (float)str_replace(',', '', $item->nominalplan ?? 0);
                    });
                    $totalActual = $items->sum(function ($item) {
                        return (float)str_replace(',', '', $item->nominalactual ?? 0);
                    });
                    
                    // Menampilkan hasil
                    $categoryTotalPlan += $totalPlan;
                    $categoryTotalActual += $totalActual;
        
                    $deviation = $totalPlan - $totalActual;
                    $percentage = $totalPlan != 0 ? ($totalActual / $totalPlan) * 100 : 0;
                    $vertikalanalisis = $totalRevenuep ? ($totalPlan / $totalRevenuep) * 100 : 0;
                    $vertikalanalisiss = $totalRevenuea ? ($totalPlan / $totalRevenuea) * 100 : 0;
                    
                    return [
                        'name_sub' => $subCategory,
                        'total_plan' => $totalPlan,
                        'total_actual' => $totalActual,
                        'vertikal' => $vertikalanalisis,
                        'deviation' => $deviation,
                        'percentage' => $percentage,
                        'vertikals' => $vertikalanalisiss,
                        'details' => $items,
                    ];
                });
        
                return [
                    'kategori_name' => $kategoriName,
                    'category_id' => $kategori->first()->category_id,  // Menambahkan category_id ke dalam hasil
                    'sub_categories' => $subCategoryDetails,
                    'total_plan' => $categoryTotalPlan,
                    'total_actual' => $categoryTotalActual,
                    'deviation' => $categoryTotalPlan - $categoryTotalActual,                 
                    'vertikal' => $totalRevenuep ? ($categoryTotalPlan / $totalRevenuep) * 100 : 0,
                    'vertikals' => $totalRevenuea ? ($categoryTotalPlan / $totalRevenuea) * 100 : 0,
                ];
            });
        
            return [
                'jenis_name' => $jenisName,
                'sub_categories' => $subCategories,
            ];
        });
        

        return view('labarugi.index', compact('totals','totalplanlr','totalvertikal','totalactuallr'
        ,'totalplanlp','verticallp','totalactual'));
    }
    
    public function formlabarugi()
    {
        $sub = subkategoriLabarugi::all();
        $sub = DB::table('sub_labarugis')
        ->join('category_labarugis', 'sub_labarugis.kategori_id', '=', 'category_labarugis.id')
        ->select('category_labarugis.namecategory','sub_labarugis.namesub','sub_labarugis.id')
        ->get();
        
        return view('labarugi.addData',compact ('sub'));
    }
    public function createlabarugi(Request $request)
    
    {
        $validatedData = $request->validate([
            'nominalplan' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'nominalactual' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'sub_id' => 'required|string',
            'desc' => 'required|string',
            'tanggal' => 'required|date',
        ]);
    
        // Format nominal untuk menghapus koma
        $validatedData['nominalplan'] = isset($validatedData['nominalplan']) 
            ? str_replace(',', '', $validatedData['nominalplan']) 
            : null;
        $validatedData['nominalactual'] = isset($validatedData['nominalactual']) 
            ? str_replace(',', '', $validatedData['nominalactual']) 
            : null;
    
        // Tentukan mana yang diset null
        if ($request->has('nominalplan') && !$request->has('nominalactual')) {
            $validatedData['nominalactual'] = null;
        } elseif ($request->has('nominalactual') && !$request->has('nominalplan')) {
            $validatedData['nominalplan'] = null;
        }
    
        // Tambahkan created_by
        $validatedData['created_by'] = auth()->user()->username;
    
        // Simpan data ke database
        detailabarugi::create($validatedData);

        return redirect('/labarugi')->with('success', 'Data berhasil disimpan.');
    }
    //category
    public function categorylabarugi()
    {
        $user = Auth::user();  
        $kat=JenisLabarugi::all();
        return view('labarugi.categoryform',compact('kat'));
    }
    public function createkatlabarugi (Request $request)
    {
        $validatedData = $request->validate([
            'namecategory' => 'required|string',
            'jenis_id' => 'required|string',
        ]);
        $validatedData['created_by'] = auth()->user()->username;
        categoryLabarugi::create($validatedData);
        return redirect('/labarugi')->with('success', 'Data berhasil disimpan.');
    }

    //sub
    public function sublr()
    {
        $user = Auth::user();  
        $kat = categoryLabarugi::all();

        return view('labarugi.subform',compact('kat'));
    }
    public function createsub (Request $request)
    {
        $validatedData = $request->validate([
            'namesub' => 'required|string',
            'kategori_id' => 'required|string',
        ]);
        $validatedData['created_by'] = auth()->user()->username;
        subkategoriLabarugi::create($validatedData);
        return redirect('/labarugi')->with('success', 'Data berhasil disimpan.');
    }
    
    //pica
    public function picalr(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $query = DB::table('picalaba_rugis') 
            ->select('*'); // Memilih semua kolom dari tabel
        
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]); // Tidak perlu menyebut nama tabel
        }
        
        $data = $query->get();
        
        return view ('picakeuangan.index', compact('data'));
    }
    

    
    public function formpicalr()
    {
        $user = Auth::user();  
        return view('picakeuangan.addData');
    }

    public function createpicalr(Request $request)
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
            'tanggal' => 'required|date',
        ]);
        $validatedData['created_by'] = auth()->user()->username;
        PicalabaRugi::create($validatedData);        
        return redirect('/picalr')->with('success', 'Data berhasil disimpan.');
    }
    
    public function formupdatepicalr($id){
        $data = PicalabaRugi::findOrFail($id);
        return view('picakeuangan.update', compact('data'));
    }
    
    public function updatepicalr(Request $request, $id)
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
            'tanggal' => 'required|date',
        ]);
        $validatedData['updated_by'] = auth()->user()->username;
        
        $PicaPeople = PicalabaRugi::findOrFail($id);
        $PicaPeople->update($validatedData);
        
        return redirect('/picalr')->with('success', 'Data berhasil disimpan.');
    }



    //update detail 
    public function formupdatelabarugi($id){
        $sub = DB::table('sub_labarugis')
        ->join('category_labarugis', 'sub_labarugis.kategori_id', '=', 'category_labarugis.id')
        ->select('category_labarugis.namecategory','sub_labarugis.namesub','sub_labarugis.id')
        ->get();
        $data = detailabarugi::findOrFail($id); 
        // dd($id);

    

        return view('labarugi.update.updatedetail', compact('data','sub'));
    }
    
    public function updatelabarugi(Request $request,$id)
    {
        $validatedData = $request->validate([
            'nominalplan' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'nominalactual' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'sub_id' => 'required|string',
            'desc' => 'required|string',
            'tanggal' => 'required|date',
        ]);
    
        // Format nominal untuk menghapus koma
        $validatedData['nominalplan'] = isset($validatedData['nominalplan']) 
            ? str_replace(',', '', $validatedData['nominalplan']) 
            : null;
        $validatedData['nominalactual'] = isset($validatedData['nominalactual']) 
            ? str_replace(',', '', $validatedData['nominalactual']) 
            : null;
    
        // Tentukan mana yang diset null
        if ($request->has('nominalplan') && !$request->has('nominalactual')) {
            $validatedData['nominalactual'] = null;
        } elseif ($request->has('nominalactual') && !$request->has('nominalplan')) {
            $validatedData['nominalplan'] = null;
        }
    
        // Tambahkan created_by
        $validatedData['updated_by'] = auth()->user()->username;
            
        $detailabarugi = detailabarugi::findOrFail($id);
        $detailabarugi->update($validatedData);


        return redirect('/labarugi')->with('success', 'Data berhasil disimpan.');
    }

    //updatecategory
    public function formupdatecategorylr($category_id)
    {
        $user = Auth::user();  
        $kat=JenisLabarugi::all();
        $data=categoryLabarugi::findOrFail($category_id);

        return view('labarugi.update.updatecategory',compact('kat','data'));
    }
    public function updatecategorylr (Request $request,$id)
    {
        $validatedData = $request->validate([
            'namecategory' => 'required|string',
            'jenis_id' => 'required|string',
        ]);
        $validatedData['updated_by'] = auth()->user()->username;
            
        $categoryLabarugi = categoryLabarugi::findOrFail($id);
        $categoryLabarugi->update($validatedData);

        return redirect('/labarugi')->with('success', 'Data berhasil disimpan.');
    }

    //sublabarugi
    public function formupdatesublr($id)
    {
        $user = Auth::user();  

        $kat = categoryLabarugi::all();
        $data=subkategoriLabarugi::findOrFail($id);

        return view('labarugi.update.updatesub',compact('kat','data'));
    }
    public function updatesublr (Request $request,$id)
    {
        $validatedData = $request->validate([
            'namesub' => 'required|string',
            'kategori_id' => 'required|string',
        ]);
        $validatedData['updated_by'] = auth()->user()->username;
            
        $subkategoriLabarugi = subkategoriLabarugi::findOrFail($id);
        $subkategoriLabarugi->update($validatedData);

        return redirect('/labarugi')->with('success', 'Data berhasil disimpan.');
    }


}
