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

            'sub_labarugis.namesub as name_sub',
            'detailabarugis.nominalplan',
            'detailabarugis.nominalactual',
            'detailabarugis.tanggal',
            'detailabarugis.desc',
            'detailabarugis.id'
        );
    
    if ($startDate && $endDate) {
        $query->whereBetween('detailabarugis.tanggal', [$startDate, $endDate]);
    }
    //untuk total laba rugi
    $data = $query->orderBy('jenis_labarugis.name') 
        ->orderBy('category_labarugis.namecategory') 
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
                // dd($totalPlan);
    
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
                    'percentage' => $totalPlan != 0 ? ($totalActual / $totalPlan) * 100 : 0,
                    'vertikals' => $vertikalanalisiss,
                    'details' => $items,
                ];
            });
    
            return [
                'kategori_name' => $kategoriName,
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
        $user = Auth::user();  
        $data = PicalabaRugi::all();
        $year = $request->input('year');

        //filter tahun di laporan
        $reports = PicalabaRugi::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();
        
        $years = PicalabaRugi::selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');
        
        return view ('picakeuangan.index', compact('data','reports','years', 'year'));
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
        ]);
        $validatedData['updated_by'] = auth()->user()->username;
        
        $PicaPeople = PicalabaRugi::findOrFail($id);
        $PicaPeople->update($validatedData);
        
        return redirect('/picalr')->with('success', 'Data berhasil disimpan.');
    }


}
