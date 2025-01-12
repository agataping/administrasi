<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barging;
use App\Models\PicaBarging;
use App\Models\planBargings;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BargingController extends Controller
{
    public function indexbarging(Request $request)
    {
        $plan = planBargings::all(); 
        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');  
    
        $query = DB::table('bargings')
            ->join('plan_bargings', 'bargings.plan_id', '=', 'plan_bargings.id') 
            ->select('bargings.*', 'plan_bargings.nominal'); 
    
        if ($startDate && $endDate) {
            $query->whereBetween('bargings.tanggal', [$startDate, $endDate]);
        }
    
        $data = $query->get();
    
        $totalQuantity = 0;
        $count = 0;
    
        foreach ($data as $d) {
            $quantity = floatval(str_replace(',', '', $d->quantity));
            
            if (is_numeric($quantity)) {
                $totalQuantity += $quantity;  
                $count++;
            }
        }
    
        $quantity = ($count > 0) ? $totalQuantity : 0;
        $planNominal = $plan->isEmpty() ? 0 : $plan->first()->nominal;
        $deviasi=  $planNominal-$quantity;
        $percen = $quantity != 0 ? ($quantity / $planNominal) * 100 : 0;

        $data = $data->map(function ($d) {
            $d->formatted_quantity = number_format($d->quantity, 0, ',', '.');
            return $d;
        });
    
        return view('barging.index', compact('data', 'quantity', 'plan','deviasi','percen'));
    }
    

    //create data

    public function formbarging()
    {
        $plan = planBargings::first();
        return view('barging.addData',compact('plan'));
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
            'tanggal' => 'required',
            'plan_id' => 'required|exists:plan_bargings,id',

        ]);

        $validatedData['created_by'] = auth()->user()->username;
        Barging::create($validatedData);

        return redirect('/indexbarging')->with('success', 'data berhasil disimpan.');

    }

    //update data
    public function updatebarging($id)
    {
        $data =Barging::FindOrFail($id);
        $plan = planBargings::first();

        return view('barging.updatedata',compact('data','plan'));
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
            'tanggal' => 'required',
            'plan_id' => 'required|exists:plan_bargings,id',


        ]);
        $validatedData['updated_by'] = auth()->user()->username;
            
        $Barging = Barging::findOrFail($id);
        $Barging->update($validatedData);

        return redirect('/indexbarging')->with('success', 'data berhasil diperbarui.');

    }

    //nominal
    public function indexPlan()
    {
        // Ambil nilai Plan dari database (atau default jika tidak ada)
        $nominal = DB::table('plan_bargings')->whereNotNull('nominal')->value('nominal') ?? 100;
        return view('barging.planBargings', compact('nominal'));
    }

    public function updatePlan(Request $request)
    {
        // Validasi input
        $request->validate([
            'nominal' => 'required|numeric|min:1'
        ]);

        // Update atau simpan nilai Plan di database
        DB::table('plan_bargings')->updateOrInsert(
            ['nominal' => $request->nominal]
        );

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
        return redirect('/indexpicabarging')->with('success', 'Surat berhasil disimpan.');
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
