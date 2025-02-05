<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barging;
use App\Models\PicaBarging;
use App\Models\planBargings;
use Carbon\Carbon;
use App\Models\HistoryLog;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BargingController extends Controller
{
    public function indexbarging(Request $request)
    {
        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');  
        $plan = planBargings::all(); 
        $planNominal = $plan->sum('nominal');
        // dd($planNominal); 
        $query = DB::table('bargings')
            ->join('plan_bargings', 'bargings.kuota', '=', 'plan_bargings.kuota')
            ->select('bargings.*', 'plan_bargings.nominal')
            ->where('bargings.created_by', auth()->user()->username); 
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
            $kuota = $request->input('kuota'); 
            
            $query = DB::table('bargings')
                ->join('plan_bargings', 'bargings.kuota', '=', 'plan_bargings.kuota') 
                ->select('bargings.*', 'plan_bargings.nominal')
                ->where('bargings.created_by', auth()->user()->username); 

        
            // Tambahkan filter tanggal jika ada
            if ($startDate && $endDate) {
                $query->whereBetween('bargings.tanggal', [$startDate, $endDate]);
            }
        
            // Tambahkan filter kategori jika ada
            if ($kuota) {
                $query->where('bargings.kuota', $kuota);
            }
        
           $data = $query->get();
        
            // Perhitungan total
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
            $deviasi = $planNominal - $quantity;
            $percen = $quantity != 0 ? ($quantity / $planNominal) * 100 : 0;
        
            $data = $data->map(function ($d) {
                $d->formatted_quantity = number_format($d->quantity, 0, ',', '.');
                return $d;
            });
        
            return view('barging.indexmenu', compact('data', 'quantity', 'deviasi', 'percen'));
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
        
            $validatedData['created_by'] = auth()->user()->username;
        
            $data=Barging::create($validatedData);
            HistoryLog::create([
                'table_name' => 'bargings', 
                'record_id' => $data->id, 
                'action' => 'create',
                'old_data' => null, 
                'new_data' => json_encode($validatedData), 
                'user_id' => auth()->id(), 
            ]);
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


        ]);
        $validatedData['updated_by'] = auth()->user()->username;
            
        $Barging = Barging::findOrFail($id);
        $oldData = $Barging->toArray();
        
        $Barging->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'bargings', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/indexbarging')->with('success', 'data berhasil diperbarui.');

    }

    public function deletebarging ($id)
    {
        $data = Barging::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => '', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/indexmenu')->with('success', 'Data  berhasil Dihapus.');
    }



    //nominal
    public function indexPlan(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date'); 
        $query = DB::table('plan_bargings') 
        ->select('plan_bargings.*')
        ->where('plan_bargings.created_by', auth()->user()->username); 

        if ($startDate && $endDate) {
            $query->whereBetween('plan_bargings.tanggal', [$startDate, $endDate]);
        }
       $data = $query->get();
       $data->each(function ($item) {
           $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
        });
        
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
            'file' => 'nullable|file',
          ]);
          if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            $validatedData['file'] = $filePath;
        }
          $validatedData['created_by'] = auth()->user()->username;
        
          $data=planBargings::create($validatedData);
          HistoryLog::create([
            'table_name' => 'plan_bargings', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
      
          return redirect('/indexPlan')->with('success', 'data berhasil diperbarui.');

    }
    //update
    public function formupdateplan($id)
    {
        $data= planBargings::FindOrFail($id);
        return view('barging.updateplan',compact('data'));
    }

    public function updatedataplan(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nominal' => 'required',
            'tanggal' => 'required',
            'kuota' => 'required|string',
        ]);
    
        $planBargings = PlanBargings::findOrFail($id);
    
        // Simpan data lama sebelum update
        $oldData = $planBargings->toArray();
    
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($planBargings->file) {
                Storage::disk('public')->delete($planBargings->file);
            }
    
            // Simpan file baru
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            $validatedData['file'] = $filePath;
        }
    
        // Tambahkan informasi pengguna yang mengupdate
        $validatedData['updated_by'] = auth()->user()->username;
    
        // Update data di database
        $planBargings->update($validatedData);
    
        // Simpan perubahan ke tabel history_log
        HistoryLog::create([
            'table_name' => 'plan_bargings',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
    
        return redirect('/indexPlan')->with('success', 'Data berhasil diperbarui.');
    }
    
    public function deleteplanbarging ($id)
    {
        $data = PlanBargings::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => '', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/indexPlan')->with('success', 'Data  berhasil Dihapus.');


    }


    public function indexpicabarging (Request $request)
    {
        $user = Auth::user();  
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $query = DB::table('pica_bargings') 
            ->select('*')
            ->where('pica_bargings.created_by', auth()->user()->username); 

        
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]); 
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
        $data=PicaBarging::create($validatedData);  
        HistoryLog::create([
            'table_name' => 'pica_bargings', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);   
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
        
        $data =PicaBarging::findOrFail($id);
        $oldData = $data->toArray();
        
        $data->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'pica_bargings', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);        
        return redirect('/indexpicabarging')->with('success', 'data berhasil disimpan.');
    }

    public function deletepicabarging ($id)
    {
        $data = PicaBarging::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => '', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/indexpicabarging')->with('success', 'Data  berhasil Dihapus.');
    }
}
