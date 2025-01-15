<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barging;
use App\Models\PicaBarging;
use App\Models\planBargings;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BargingController extends Controller
{
    public function indexbarging(Request $request)
    {
        $plan = planBargings::all(); 
        $planNominal = $plan->isEmpty() ? 0 : $plan->first()->nominal; 
        // dd($planNominal); 
        $query = DB::table('bargings')
            ->join('plan_bargings', 'bargings.plan_id', '=', 'plan_bargings.id')
            ->select('bargings.*', 'plan_bargings.nominal')
            ->whereBetween('bargings.tanggal', [
                Carbon::now()->startOfMonth()->toDateString(),
                Carbon::now()->endOfMonth()->toDateString()
            ]);
        
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
        
        $deviasi =  $planNominal - $quantity;  
        $percen = $quantity != 0 ? ($quantity / $planNominal) * 100 : 0;  
        $data = $data->map(function ($d) {
            $d->formatted_quantity = number_format($d->quantity, 0, ',', '.');
            return $d;
        });
        
        return view('barging.index', compact('data', 'quantity', 'planNominal', 'deviasi', 'percen','planNominal'));
        }


        public function indexmenu(Request $request)
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
                    
        
            
            return view('barging.indexmenu', compact('data', 'quantity',
             'deviasi', 'percen'));
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
                'quantity' => 'required|numeric',
                'kuota' => 'required|string',
                'tanggal' => 'required|date',
            ]);
        
            // Cari plan_id berdasarkan bulan dari tanggal
            $bulan = date('Y-m', strtotime($validatedData['tanggal']));
            $plan = planBargings::where('tanggal', 'like', "$bulan%")->first();
        
            if (!$plan) {
                return redirect()->back()->with('errors', 'Plan ID tidak ditemukan untuk bulan ini.');
            }
        
            // Tambahkan plan_id dan created_by
            $validatedData['plan_id'] = $plan->id;
            $validatedData['created_by'] = auth()->user()->username;
        
            Barging::create($validatedData);
        
            return redirect('/indexbarging')->with('success', 'Data berhasil ditambahkan.');
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
            'kuota' => 'required|string',
            'plan_id' => 'required|exists:plan_bargings,id',


        ]);
        $validatedData['updated_by'] = auth()->user()->username;
            
        $Barging = Barging::findOrFail($id);
        $Barging->update($validatedData);

        return redirect('/indexbarging')->with('success', 'data berhasil diperbarui.');

    }

    //nominal
    public function indexPlan(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date'); 
        $query = DB::table('plan_bargings') 
        ->select(
            'plan_bargings.nominal',
            'plan_bargings.tanggal',
            'plan_bargings.kuota',
            'plan_bargings.id'
        );
    if ($startDate && $endDate) {
        $query->whereBetween('plan_bargings.tanggal', [$startDate, $endDate]);
    }



        $data = $query->get();


        return view('barging.indexplan',compact('data','startDate','endDate'));
    }
    public function formplan()
    {
        return view('barging.planBargings');
    }

    public function updatePlan(Request $request)
    {
        $validatedData = $request->validate([
            'nominal' => 'required',
            'tanggal' => 'required',
            'kuota' => 'required|string',

          ]);
          $validatedData['created_by'] = auth()->user()->username;
        
          planBargings::create($validatedData);
      
          return redirect('/indexbarging')->with('success', 'data berhasil diperbarui.');

    }
    //update
    public function formupdateplan($id)
    {
        $data= planBargings::FindOrFail($id);
        return view('barging.updateplan',compact('data'));
    }

    public function updatedataplan(Request $request,$id)
    {
        $validatedData = $request->validate([
            'nominal' => 'required',
            'tanggal' => 'required',
            'kuota' => 'required|string',

          ]);
          $validatedData['updated_by'] = auth()->user()->username;
            
          $planBargings = planBargings::findOrFail($id);
          $planBargings->update($validatedData);
  
  
      
          return redirect('/indexPlan')->with('success', 'data berhasil diperbarui.');

    }


    public function indexpicabarging (Request $request)
    {
        $user = Auth::user();  
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $query = DB::table('pica_bargings') 
            ->select('*'); // Memilih semua kolom dari tabel
        
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]); // Tidak perlu menyebut nama tabel
        }
        
        $data = $query->get();
        return view('picabarging.index', compact('data'));
        
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
            'tanggal' => 'required|date',
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
                    'tanggal' => 'required|date',

                ]);
                $validatedData['updated_by'] = auth()->user()->username;
        
                $PicaPeople =PicaBarging::findOrFail($id);
                $PicaPeople->update($validatedData);
        
        return redirect('/indexpicabarging')->with('success', 'data berhasil disimpan.');
    }
}
