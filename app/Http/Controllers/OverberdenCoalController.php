<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\OverbardenCoal;
use App\Models\PicaOverCoal;
use App\Models\kategoriOvercoal;
class OverberdenCoalController extends Controller
{

   //detail
   public function indexovercoal(Request $request)
   {
       $startDate = $request->input('start_date'); 
       $endDate = $request->input('end_date');    
       
       $query = DB::table('overberden_coal')
           ->join('kategori_overcoals', 'overberden_coal.kategori_id', '=', 'kategori_overcoals.id')
           ->select(
               'kategori_overcoals.name as kategori_name',
               'overberden_coal.nominalplan',
               'overberden_coal.nominalactual',
               'overberden_coal.tanggal',
               'overberden_coal.desc',
               'overberden_coal.id'
           );
       
       if ($startDate && $endDate) {
           $query->whereBetween('overberden_coal.tanggal', [$startDate, $endDate]);
       }
       
       $data = $query->orderBy('kategori_overcoals.name')
           ->get()
           ->groupBy('kategori_name');
       
       $totals = $data->map(function ($items, $category) {
           $totalPlan = $items->sum(function ($item) {
               return (float)str_replace(',', '', $item->nominalplan ?? 0);
           });
           $totalActual = $items->sum(function ($item) {
               return (float)str_replace(',', '', $item->nominalactual ?? 0);
           });
   
           // Hitung deviasi dan persen
           $deviation = $totalPlan - $totalActual;
           $percentage = $totalPlan != 0 ? ($totalActual / $totalPlan) * 100 : 0;
   
           return [
               'kategori_name' => $category,
               'total_plan' => $totalPlan,
               'total_actual' => $totalActual,
               'deviation' => $deviation,
               'percentage' => $percentage,
               'details' => $items,
           ];
       });
       
       return view('overbcoal.index', compact('totals', 'data', 'startDate', 'endDate'));
   }
   

    public function formovercoal(){
        $data = kategoriOvercoal::all();
        return view('overbcoal.addData',compact('data'));
    }
    public function formupdateovercoal($id){
        $kat = kategoriOvercoal::all();
        $data = OverbardenCoal::findOrFail($id);

        return view('overbcoal.updatedata',compact('data'));
    }
    public function createovercoal(Request $request)
    {
        $validatedData = $request->validate([
            'nominalplan' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'nominalactual' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'kategori_id' => 'required|string',
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
        OverbardenCoal::create($validatedData);
    
        // Redirect dengan pesan sukses
        return redirect('/indexovercoal')->with('success', 'Data berhasil disimpan.');
    }
        

    public function updateovercoal(Request $request, $id){
        
        $validatedData = $request->validate([
            'nominalplan' => 'required',
            'nominalactual' => 'required',
            'kategori_id' => 'required|string',
            'desc' => 'required|string',
            'tanggal' => 'required|string',
        ]);
        $validatedData['nominalplan'] = str_replace(',', '', $validatedData['nominalplan']);
        $validatedData['nominalactual'] = str_replace(',', '', $validatedData['nominalactual']);
        $validatedData['updated_by'] = auth()->user()->username;
            
        $OverbardenCoal = OverbardenCoal::findOrFail($id);
        $OverbardenCoal->update($validatedData);
    
    return redirect('/indexovercoal')->with('success', 'Data berhasil disimpan.');
    }


 
    

    //kategori
    public function formkategoriobc(){
        return view('overbcoal.formkategori');
    }
    public function createkatgeoriobc(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);
        $validatedData['created_by'] = auth()->user()->username;
        kategoriOvercoal::create($validatedData); 
        return redirect('/indexovercoal')->with('success', 'Data berhasil disimpan.');
        

    }

    //PICA
    public function picaobc(Request $request)
    {
        $user = Auth::user();  
        $data = PicaOverCoal::all();
        $year = $request->input('year');

        //filter tahun di laporan
        $reports = PicaOverCoal::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();
        
    $years = PicaOverCoal::selectRaw('YEAR(created_at) as year')
    ->distinct()
    ->orderBy('year', 'desc')
    ->pluck('year');
    
        return view('picaobc.index', compact('data','reports','years', 'year'));
    }

    
    public function formpicaobc()
    {
        $user = Auth::user();  
        return view('picaobc.addData');
    }

    public function createpicaobc(Request $request)
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
        PicaOverCoal::create($validatedData);        
        return redirect('/picaobc')->with('success', 'Data berhasil disimpan.');
    }
    
    public function formupdatepicaobc($id){
        $data = PicaOverCoal::findOrFail($id);
        return view('picaobc.update', compact('data'));
    }
    
    public function updatepicaobc(Request $request, $id)
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
        
        $PicaPeople = PicaOverCoal::findOrFail($id);
        $PicaPeople->update($validatedData);
        
        return redirect('/picaobc')->with('success', 'Data berhasil disimpan.');
    }
    
    
}

