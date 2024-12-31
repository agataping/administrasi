<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CSMothnlyProduction;


class CSMothnlyProductionController extends Controller
{
        //UNTUK MENAMPILAKN
        public function indexmproduction(Request $request)
        {
            $data =CSMothnlyProduction::all();
            $year = $request->input('year');
            $reports = CSMothnlyProduction::when($year, function ($query, $year) {
                return $query->whereYear('created_at', $year);
            })->get();
           $years = CSMothnlyProduction::selectRaw('YEAR(created_at) as year')
               ->distinct()
               ->orderBy('year', 'desc')
               ->pluck('year');
               // hitung total
               $totals = [
                   'bargings' => 0,
                   'dbcm_ob' => 0,
                   'mbcm_ob' => 0,
                   'ybcm_ob' => 0,
                   'dcoal_ton' => 0,
                   'mcoal_ton' => 0,
                   'ycoal_ton' => 0,
                   'dactual' => 0,
                   'mactual' => 0,
                   'yactual' => 0,
                   'dcoal' => 0,
                   'mcoal' => 0,
                   'ycoal' => 0
                ];
                
                foreach ($data as $d) {
                    foreach ($totals as $key => &$total) {
                        $value = str_replace('.', '', $d->$key ?? 0);  
                        $totalValue = floatval($value);  
                        
                        $totalValue = $totalValue / 10;  
                        
                        $totals[$key] += $totalValue;
                        
                        $d->{"formatted_$key"} = number_format($totalValue, 0, ',', '.');  
                    }
                }
                
                foreach ($totals as $key => &$total) {
                    $total = number_format($total, 0, ',', '.');
                }
                
                return view('csproduksi.index', compact('data', 'reports', 'years', 'year', 'totals'));
                
            }
            
            

        
        public function formMProduksi()
        {
            return view('csproduksi.formMProduksi');
        }


        
        
        public function createMproduksi(Request $request) {
            $request->validate([
                'date' => 'required',
                'dbcm_ob' => 'nullable|numeric',
                'mbcm_ob' => 'nullable|numeric',
                'ybcm_ob' => 'nullable|numeric',
                'dcoal_ton' => 'nullable|numeric',
                'mcoal_ton' => 'nullable|numeric',
                'ycoal_ton' => 'nullable|numeric',
                'dactual' => 'nullable|numeric',
                'mactual' => 'nullable|numeric',
                'yactual' => 'nullable|numeric',
                'dcoal' => 'nullable|numeric',
                'mcoal' => 'nullable|numeric',
                'ycoal' => 'nullable|numeric',
                'bargings' => 'nullable|numeric',
            ]);
            $validatedData['created_by'] = auth()->user()->username;
            CSMothnlyProduction::create($request->all());

            return redirect('/indexmproduction')->with('success', 'Data berhasil disimpan.');
          }
          public function formUpdateMProduksi($id)
          {
            $data = CSMothnlyProduction::FindOrFail($id);
            
              return view('csproduksi.updatedata',compact('data'));
          }

          public function updateMproduksi(Request $request,$id) {
            $validatedData=$request->validate([
                'date' => 'required',
                'dbcm_ob' => 'nullable|numeric',
                'mbcm_ob' => 'nullable|numeric',
                'ybcm_ob' => 'nullable|numeric',
                'dcoal_ton' => 'nullable|numeric',
                'mcoal_ton' => 'nullable|numeric',
                'ycoal_ton' => 'nullable|numeric',
                'dactual' => 'nullable|numeric',
                'mactual' => 'nullable|numeric',
                'yactual' => 'nullable|numeric',
                'dcoal' => 'nullable|numeric',
                'mcoal' => 'nullable|numeric',
                'ycoal' => 'nullable|numeric',
                'bargings' => 'nullable|numeric',
            ]);
            $validatedData['updated_by'] = auth()->user()->username;
            
            $CSMothnlyProduction = CSMothnlyProduction::findOrFail($id);
            $CSMothnlyProduction->update($validatedData);
            

            return redirect('/indexmproduction')->with('success', 'Data berhasil disimpan.');
          }
}
