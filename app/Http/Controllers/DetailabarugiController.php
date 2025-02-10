<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\categoryLabarugi;
use App\Models\jenisLabarugi;
use App\Models\detailabarugi;
use App\Models\subkategoriLabarugi;
use App\Models\PicalabaRugi;
use App\Models\HistoryLog;

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
            'category_labarugis.id as category_id',
            'jenis_labarugis.name as jenis_name',
            'jenis_labarugis.name',
            'sub_labarugis.id as sub_id',
            'sub_labarugis.namesub as name_sub',
            'detailabarugis.id as detail_id',
            'detailabarugis.*'

        )
        ->where('detailabarugis.created_by', auth()->user()->username); 

        
        if ($startDate && $endDate) {
            $query->whereBetween('detailabarugis.tanggal', [$startDate, $endDate]);
        }
        // $query->orderBy('detailabarugis.tanggal', 'asc');
        $data = $query->orderBy('category_labarugis.created_at', 'asc') 
        ->get()
        ->groupBy(['jenis_name', 'kategori_name']);
        $data->each(function ($items) {
            $items->each(function ($subItems) {
                $subItems->each(function ($item) {
                    $item->file_extension = isset($item->file) && $item->file !== null 
                        ? pathinfo($item->file, PATHINFO_EXTENSION) 
                        : null;
                });
            });
        });
        
        // dd($data);        
        
        $totalRevenuea = (clone $query) 
        ->where('category_labarugis.namecategory', 'Revenue')
        ->get()
        ->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalactual ?? 0);
        });
        
        $totallkactual = (clone $query)
        ->join('category_labarugis AS cat1', 'sub_labarugis.kategori_id', '=', 'cat1.id') 
        ->join('jenis_labarugis AS jenis1', 'cat1.jenis_id', '=', 'jenis1.id') 
        
        ->where('jenis1.name', 'Gross Profit') 
        ->where('cat1.namecategory', '!=', 'Revenue') 
        ->get()
        ->sum(function ($item) {
            return (float) str_replace(',', '', $item->nominalactual ?? 0);
        });

        $totallkplan = (clone $query)
        ->join('category_labarugis AS cat1', 'sub_labarugis.kategori_id', '=', 'cat1.id') 
        ->join('jenis_labarugis AS jenis1', 'cat1.jenis_id', '=', 'jenis1.id') 
        ->where('jenis1.name', 'Gross Profit') 
        ->where('cat1.namecategory', '!=', 'Revenue') 
        ->get()
        ->sum(function ($item) {
            return (float) str_replace(',', '', $item->nominalplan ?? 0);
        });
        
    
    
        
        $totalRevenuep = (clone $query)
        ->where('category_labarugis.namecategory', 'Revenue')
        ->get()
        ->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalplan ?? 0);
        });
        //operasional
        $planoperasional = (clone $query)
        ->where('jenis_labarugis.name', 'Operating Profit')
        ->get()
        ->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalplan ?? 0);
        });
        $actualoperasional = (clone $query)
        ->where('jenis_labarugis.name', 'Operating Profit')
        ->get()
        ->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalactual ?? 0);
        });

        //lababersih
        $planlb = (clone $query)
        ->where('jenis_labarugis.name', 'Net Profit')
        ->get()
        ->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalplan ?? 0);
        });
        $actuallb = (clone $query)
        ->where('jenis_labarugis.name', 'Net Profit')
        ->get()
        ->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalactual ?? 0);
        });
                // dd($actuallb );

        //laba rugi 
        $totalplanlr = $totalRevenuep-$totallkplan;
        $totalactuallr = $totalRevenuea-$totallkactual;
        $totalvertikal = ($totalRevenuep && $totalRevenuep != 0) ? ($totalplanlr / $totalRevenuep) * 100 : 0;
        $totalvertikals = $totalRevenuea ? ($totalactuallr / $totalRevenuea) * 100 : 0;
        $deviasilr = $totalplanlr-$totalactuallr;
        $persenlr = $totalplanlr ? ($totalactuallr / $totalplanlr) * 100 : 0;
        //operasional
        $totalplanlp = $totalplanlr-$planoperasional;
        $totalactualOp = $actualoperasional-$totalactuallr;
        $verticallp = $totalRevenuep ? ($totalplanlp / $totalRevenuep) * 100 : 0;
        $verticalsp = $totalRevenuea ? ($totalactualOp / $totalRevenuea) * 100 : 0;
        $deviasiop = $totalplanlp-$totalactualOp;
        $persenop = $totalplanlp ? ($totalactualOp / $totalplanlp) * 100 : 0;
        //lababersih
        $totalplanlb = $totalplanlp-$planlb;
        $totalactuallb = $actualoperasional-$actuallb;
        // dd($totalactuallb );
        $verticallb = $totalRevenuep ? ($totalplanlb / $totalRevenuep) * 100 : 0;
        $verticalslb = $totalRevenuea ? ($totalactuallb / $totalRevenuea) * 100 : 0;
        $deviasilb = $totalplanlb-$totalactuallb;
        $persenlb = $totalplanlb ? ($totalactuallb / $totalplanlb) * 100 : 0;
   
        // dd($totalplanlb, $totalactuallb, $verticallb, $verticalslb, $persenlb);

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
            $subCategories = $categories->map(function ($kategori, $kategoriName) use ($totalRevenuea, $totalRevenuep) {
            
                $subCategoryDetails = $kategori->groupBy('name_sub')->map(function ($items, $subCategory) use ($totalRevenuea, $totalRevenuep, &$categoryTotalPlan, &$categoryTotalActual) {
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
        ,'totalplanlp','verticallp','totalactualOp','verticalsp','persenlb',
        'deviasilb','verticalslb', 'deviasiop','persenop', 'deviasilr','persenlr','totalvertikals',
        'persenlb','deviasilb','verticalslb','verticallb','totalplanlb','totalactuallb'
            ));
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

    //create laab rugi atau detail laba rugi
    public function createlabarugi(Request $request)
    
    {
        $validatedData = $request->validate([
            'nominalactual' => 'nullable|regex:/^[0-9.,]+$/',
            'nominalplan' => 'nullable|regex:/^[0-9.,]+$/',
            'sub_id' => 'required|string',
            'desc' => 'required|string',
            'tanggal' => 'required|date',
            'file' => 'nullable|file',

        ]);
    
        // Format nominal untuk menghapus koma
        $validatedData['nominalplan'] = isset($validatedData['nominalplan']) 
        ? str_replace(',', '.', str_replace('.', '', $validatedData['nominalplan'])) 
        : null;
    
    $validatedData['nominalactual'] = isset($validatedData['nominalactual']) 
        ? str_replace(',', '.', str_replace('.', '', $validatedData['nominalactual'])) 
        : null;
        
        //file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            $validatedData['file'] = $filePath;
        }
        
        // Tentukan mana yang diset null
        if ($request->has('nominalplan') && !$request->has('nominalactual')) {
            $validatedData['nominalactual'] = null;
        } elseif ($request->has('nominalactual') && !$request->has('nominalplan')) {
            $validatedData['nominalplan'] = null;
        }
    

        // Tambahkan created_by
        $validatedData['created_by'] = auth()->user()->username;
    
        // Simpan data ke database
        $data=detailabarugi::create($validatedData);
        HistoryLog::create([
            'table_name' => 'detailabarugis', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/labarugi')->with('success', 'Data added successfully.');
        }
    
        return redirect()->back()->with('success', 'Data added successfully.');
    }
    //category
    public function categorylabarugi()
    {
        $user = Auth::user();  
        $kat=jenisLabarugi::all();
        return view('labarugi.categoryform',compact('kat'));
    }
    public function createkatlabarugi (Request $request)
    {
        $validatedData = $request->validate([
            'namecategory' => 'required|string',
            'jenis_id' => 'required|string',
        ]);
        $validatedData['created_by'] = auth()->user()->username;
        $data=categoryLabarugi::create($validatedData);
        HistoryLog::create([
            'table_name' => 'category_labarugis', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/labarugi')->with('success', 'Data added successfully.');
        }
    
        return redirect()->back()->with('success', 'Data added successfully.');
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
        $data=subkategoriLabarugi::create($validatedData);
        HistoryLog::create([
            'table_name' => 'sub_labarugis', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/labarugi')->with('success', 'Data added successfully.');
        }
    
        return redirect()->back()->with('success', 'Data added successfully.');

    }
    
    //pica
    public function picalr(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $query = DB::table('picalaba_rugis') 
            ->select('*')
            ->where('picalaba_rugis.created_by', auth()->user()->username); 

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]); 
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
        $data=PicalabaRugi::create($validatedData);  
        HistoryLog::create([
            'table_name' => 'picalaba_rugis', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);  
        if ($request->input('action') == 'save') {
            return redirect('/picalr')->with('success', 'Data added successfully.');
        }
    
        return redirect()->back()->with('success', 'Data added successfully.');    
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
        
        $data = PicalabaRugi::findOrFail($id);
        $oldData = $data->toArray();
        
        $data->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'picalaba_rugis', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);        
        return redirect('/picalr')->with('success', 'Data saved successfully.');
    }
    //update PICA 
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
            'file' => 'nullable|file',

        ]);
    
        // Format nominal untuk menghapus koma
        $validatedData['nominalplan'] = isset($validatedData['nominalplan']) 
            ? str_replace(',', '', $validatedData['nominalplan']) 
            : null;
        $validatedData['nominalactual'] = isset($validatedData['nominalactual']) 
            ? str_replace(',', '', $validatedData['nominalactual']) 
            : null;
    
        //file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            $validatedData['file'] = $filePath;
        }
        // Tentukan mana yang diset null
        if ($request->has('nominalplan') && !$request->has('nominalactual')) {
            $validatedData['nominalactual'] = null;
        } elseif ($request->has('nominalactual') && !$request->has('nominalplan')) {
            $validatedData['nominalplan'] = null;
        }
    
        // Tambahkan created_by
        $validatedData['updated_by'] = auth()->user()->username;
            
        $detailabarugi = detailabarugi::findOrFail($id);
        $oldData = $detailabarugi->toArray();
        
        $detailabarugi->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'detaillabarugis', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);

        return redirect('/labarugi')->with('success', 'Data saved successfully.');
    }

    //updatecategory
    public function formupdatecategorylr($category_id)
    {
        $user = Auth::user();  
        $kat=jenisLabarugi::all();
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
        $oldData = $categoryLabarugi->toArray();
        
        $categoryLabarugi->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'category_labarugis', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/labarugi')->with('success', 'Data saved successfully.');
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
        $oldData = $subkategoriLabarugi->toArray();
        
        $subkategoriLabarugi->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'sub_labarugis', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/labarugi')->with('success', 'Data saved successfully.');
    }

    //delete
    public function deletedetaillr ($id)
    {
        $data = detailabarugi::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'detaillabarugis', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/labarugi')->with('success', 'Data deleted successfully.');
    }

    public function deletepicalr ($id)
    {
        $data = Picalabarugi::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'picalaba_rugis', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/picalr')->with('success', 'Data deleted successfully.');
    }

    public function deletesublr ($id)
    {
        $data = categoryLabarugi::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'category_labarugis', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect()->back()->with('success', 'Data deleted successfully.');    

    }


}
