<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barging;
use App\Models\PicaBarging;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BargingController extends Controller
{
    public function indexbarging(Request $request)
    {
        $data =Barging::all();

        $year = $request->input('year');
        $reports = Barging::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();
       $years = Barging::selectRaw('YEAR(created_at) as year')
           ->distinct()
           ->orderBy('year', 'desc')
           ->pluck('year');

           //hitung tot. quality MT
           $totalQuantity = 0;
           $count = 0;
           
           foreach ($data as $d) {
               $quantity = floatval(str_replace(',', '', $d->quantity));
               
               if (is_numeric($quantity)) {
                   $totalQuantity += $quantity;  
                   $count++;
                }
            }
            
            if ($count > 0) {
                $quantity = $totalQuantity;
            } else {
                $quantity = 0;  
            }
            
            $data= $data->map(function ($d) {
                $d->formatted_quantity = number_format($d->quantity, 0, ',', '.');
                return $d;
            });
            
            
        return view('barging.index',compact('data','reports','years','year','quantity'));
    }

    //create data

    public function formbarging()
    {
        return view('barging.addData');
    }
    public function createbarging(Request $request)
    {
        $validatedData = $request->validate([
            'laycan' => 'required',
            'namebarge' => 'required',
            'surveyor' => 'required',
            'portloading' => 'required',
            'portdishcharging' => 'required',
            'notifyaddres' => 'required',
            'initialsurvei' => 'required',
            'finalsurvey' => 'required',
            'quantity' => 'required',


        ]);

        $validatedData['created_by'] = auth()->user()->username;
        Barging::create($validatedData);

        return redirect('/indexbarging')->with('success', 'data berhasil disimpan.');

    }

    //update data
    public function updatebarging($id)
    {
        $data =Barging::FindOrFail($id);

        return view('barging.updatedata',compact('data'));
    }

    public function updatedatabarging(Request $request, $id)
    {
        $validatedData = $request->validate([
            'laycan' => 'required',
            'namebarge' => 'required',
            'surveyor' => 'required',
            'portloading' => 'required',
            'portdishcharging' => 'required',
            'notifyaddres' => 'required',
            'initialsurvei' => 'required',
            'finalsurvey' => 'required',
            'quantity' => 'required',


        ]);
        $validatedData['updated_by'] = auth()->user()->username;
            
        $Barging = Barging::findOrFail($id);
        $Barging->update($validatedData);

        return redirect('/indexbarging')->with('success', 'data berhasil diperbarui.');

    }
    
    public function indexpicabarging (Request $request)
    {
        $user = Auth::user();  
        $data = PicaBarging::all();
        $year = $request->input('year');

        //filter tahun di laporan
        $reports = PicaBarging::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();
        
        $years = PicaBarging::selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');
        
        return view('picabarging.index', compact('data','reports','years', 'year'));
        
    }

    
    public function formpicabarging()
    {
        $user = Auth::user();  
        return view('picabarging.addData');
    }

    public function createpicabarging(Request $request)
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
                PicaBarging::create($validatedData);        
        return redirect('/picamining')->with('success', 'Surat berhasil disimpan.');
    }

    public function updatepicabarging($id){
        $data = PicaBarging::findOrFail($id);
        return view('picabarging.update', compact('data'));
    }

    public function updatedatapicabarging(Request $request, $id)
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
        
                $PicaPeople =PicaBarging::findOrFail($id);
                $PicaPeople->update($validatedData);
        
        return redirect('/indexpicabarging')->with('success', 'data berhasil disimpan.');
    }
}
