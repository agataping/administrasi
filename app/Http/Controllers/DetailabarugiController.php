<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\categoryLabarugi;
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
    
        $query = DB::table('detailabarugis')
            ->join('sub_labarugis', 'detailabarugis.sub_id', '=', 'sub_labarugis.id')
            ->join('category_labarugis', 'sub_labarugis.kategori_id', '=', 'category_labarugis.id')
            ->select(
                'category_labarugis.namecategory as kategori_name',
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
    
        $data = $query->orderBy('category_labarugis.namecategory')
            ->get()
            ->groupBy('kategori_name');
    
        // Hitung total per sub-kategori dan kategori
        $totals = $data->map(function ($categories, $kategoriName) {
            $categoryTotalPlan = 0;
            $categoryTotalActual = 0;
    
            $subCategories = $categories->groupBy('name_sub')->map(function ($items, $subCategory) use (&$categoryTotalPlan, &$categoryTotalActual) {
                $totalPlan = $items->sum(function ($item) {
                    return (float)str_replace(',', '', $item->nominalplan ?? 0);
                });
                $totalActual = $items->sum(function ($item) {
                    return (float)str_replace(',', '', $item->nominalactual ?? 0);
                });
    
                // Tambahkan total ke kategori
                $categoryTotalPlan += $totalPlan;
                $categoryTotalActual += $totalActual;
    
                return [
                    'name_sub' => $subCategory,
                    'total_plan' => $totalPlan,
                    'total_actual' => $totalActual,
                    'details' => $items, // Data detail setiap sub-kategori
                ];
            });
    
            return [
                'kategori_name' => $kategoriName,
                'total_plan' => $categoryTotalPlan,
                'total_actual' => $categoryTotalActual,
                'sub_categories' => $subCategories,
            ];
        });
    
        return view('labarugi.index', ['totals' => $totals]);
    }
        public function formlabarugi()
    {
        $sub = subkategoriLabarugi::all();
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
        return view('labarugi.categoryform');
    }
    public function createkatlabarugi (Request $request)
    {
        $validatedData = $request->validate([
            'namecategory' => 'required|string',
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
