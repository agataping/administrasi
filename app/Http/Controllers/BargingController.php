<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barging;
use App\Models\PicaBarging;
use App\Models\planBargings;
use App\Models\User;
use Carbon\Carbon;
use App\Models\HistoryLog;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BargingController extends Controller
{
    public function indexbarging(Request $request)
    {
        $user = Auth::user();  
        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');
        $companyId = $user->role !== 'admin' ? $user->id_company : $request->input('id_company');

        
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
        
        // Hitung nominal plan 
        $planNominal = null;
        if ($companyId) {
            $planNominal = DB::table('plan_bargings')
            ->whereIn('created_by', function ($query) use ($companyId) {
                $query->select('username')->from('users')->whereNotNull('id_company')->where('id_company', $companyId);
            })
            ->sum(DB::raw("CAST(REPLACE(REPLACE(nominal, '.', ''), ',', '.') AS DECIMAL(15,2))"));
           
            }
        // dd([
        //     'role' => Auth::user()->role,
        //     'companyId' => $companyId,
        // ]);
        
       
        
        $query = DB::table('bargings')
            ->join('users', 'bargings.created_by', '=', 'users.username')
            ->leftJoin('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->leftJoin(DB::raw('(SELECT pb1.* FROM plan_bargings pb1 
                WHERE pb1.id = (SELECT MIN(id) FROM plan_bargings 
                    WHERE kuota = pb1.kuota 
                    AND created_by = pb1.created_by) ) as plan_bargings'),
                function ($join) {
                    $join->on('bargings.kuota', '=', 'plan_bargings.kuota');
                    $join->on('users.username', '=', 'plan_bargings.created_by');
                })
            ->select('bargings.*', 'plan_bargings.nominal');
            if ($user->role !== 'admin') {
                $query->where('users.id_company', $user->id_company);
            } else {
                if ($companyId) {
                    $query->where('users.id_company', $companyId);
                } else {
                    $query->whereRaw('1 = 0');             
                }
            }
            
        // Filter berdasarkan tanggal jika ada input
        if ($startDate && $endDate) {
            $query->whereBetween('bargings.tanggal', [$startDate, $endDate]);
        }
    
        $data = $query->get();
    
        // Hitung total quantity
        $totalQuantity = 0;
        $count = 0;
        
        foreach ($data as $d) {
            $quantity = str_replace(['.', ','], ['', '.'], $d->quantity);
            $quantity = floatval($quantity);
            
            if (is_numeric($quantity)) {
                $totalQuantity += $quantity;
                $count++;
            }
        }
        
        $quantity = ($count > 0) ? $totalQuantity : 0;
        $deviasi = $planNominal - $quantity;
        $percen = ($planNominal != 0) ? ($quantity / $planNominal) * 100 : 0;
        // Format quantity
        $data = $data->map(function ($d) {
            $d->formatted_quantity = number_format(floatval(str_replace(['.', ','], ['', '.'], $d->quantity)), 0, ',', '.');
            return $d;
        });  
        
        
        return view('barging.index', compact('data', 'quantity', 'planNominal', 'deviasi', 'percen','perusahaans', 'companyId'));
    }
                


    public function indexmenu(Request $request)
    {
        $user = Auth::user();  

            $plan = planBargings::all(); 
            $startDate = $request->input('start_date'); 
            $endDate = $request->input('end_date');
            $companyId = $request->input('id_company');
            $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
            $kuota = $request->input('kuota'); 
            $planNominal = $plan->sum(function ($p) {
                return floatval(str_replace(['.', ','], ['', '.'], $p->nominal));
            });
            $query = DB::table('bargings')
            ->join('users', 'bargings.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->leftJoin('plan_bargings', function ($join) {
                $join->on('bargings.kuota', '=', 'plan_bargings.kuota')
                     ->whereRaw('plan_bargings.id = (SELECT MIN(id) FROM plan_bargings WHERE plan_bargings.kuota = bargings.kuota)');
            })
            ->select('bargings.*', 'plan_bargings.nominal');
            if ($user->role !== 'admin') {
                $query->where('users.id_company', $user->id_company);
            } else {
                if ($companyId) {
                    $query->where('users.id_company', $companyId);
                } else {
                    $query->whereRaw('1 = 0');             
                }
            }                    
            if ($startDate && $endDate) {
                $query->whereBetween('bargings.tanggal', [$startDate, $endDate]);
            }
        
            // Tambahkan filter kategori jika ada
            if ($kuota) {
                $query->where('bargings.kuota', $kuota);
            }
        
           $data = $query->get();
           $data->each(function ($item) {
               $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
            });
            // Perhitungan total
            $totalQuantity = 0;
            $count = 0;
            
            foreach ($data as $d) {
                $quantity = str_replace(['.', ','], ['', '.'], $d->quantity);
                $quantity = floatval($quantity);
                
                if (is_numeric($quantity)) {
                    $totalQuantity += $quantity;
                    $count++;
                }
            }
            
            $quantity = ($count > 0) ? $totalQuantity : 0;
            $deviasi = $planNominal - $quantity;
            $percen = ($planNominal != 0) ? ($quantity / $planNominal) * 100 : 0;
            
            $data = $data->map(function ($d) {
                $d->formatted_quantity = number_format(floatval(str_replace(['.', ','], ['', '.'], $d->quantity)), 0, ',', '.');
                return $d;
            });        
             
            return view('barging.indexmenu', compact('data','perusahaans', 'companyId', 'quantity', 'deviasi', 'percen'));
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
                'kuota' => 'required|string',
                'tanggal' => 'required|date',
                'file' => 'nullable|file',

            ]);
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filePath = $file->store('uploads', 'public');
                $validatedData['file'] = $filePath;
            }
    
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
            if ($request->input('action') == 'save') {
                return redirect('/indexmenu')->with('success', 'Data added successfully.');
            }
        
            return redirect()->back()->with('success', 'Data added successfully.');
    
            
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
            'quantity' => 'required|regex:/^[0-9.,]+$/',
            'tanggal' => 'required',
            'kuota' => 'required|string',
            'file' => 'nullable|file',


        ]);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            $validatedData['file'] = $filePath;
        }
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
        return redirect('/indexmenu')->with('success', 'data berhasil diperbarui.');

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
        return redirect('/indexmenu')->with('success', 'Data deleted successfully.');
    }



    //nominal
    public function indexPlan(Request $request)
    {
        $user = Auth::user();  

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date'); 
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
        $query = DB::table('plan_bargings')
        ->join('users', 'plan_bargings.created_by', '=', 'users.username')
        ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')        ->select('plan_bargings.*', 'users.id_company', 'perusahaans.nama as nama_perusahaan');
        
        if ($user->role !== 'admin') {
            $query->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $query->where('users.id_company', $companyId);
            } else {
                $query->whereRaw('1 = 0');             
            }
        }
        $data = $query->get();
        $data->each(function ($item) {
            $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
        });
        $planNominal = $data->sum(function ($p) {
            return floatval(str_replace(['.', ','], ['', '.'], $p->nominal));
        });
        
        
        return view('barging.indexplan',compact('data','startDate','endDate','planNominal','perusahaans', 'companyId'));
    }

    public function formplan()
    {
        return view('barging.planBargings');
    }

    public function createnominalplan(Request $request)
    {
        $validatedData = $request->validate([
            // 'nominal' => 'required',
            'nominal' => 'required|regex:/^[0-9.,]+$/',

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
      
        if ($request->input('action') == 'save') {
            return redirect('/indexPlan')->with('success', 'Data added successfully.');
        }
    
        return redirect()->back()->with('success', 'Data added successfully.');
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
        return redirect('/indexPlan')->with('success', 'Data deleted successfully.');


    }


    public function indexpicabarging(Request $request)
    {
        $user = Auth::user();  
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('id_company');
        
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
    
        $query = DB::table('pica_bargings')
            ->select('pica_bargings.*')
            ->join('users', 'pica_bargings.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id');
        
        if ($user->role !== 'admin') {
            $query->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $query->where('users.id_company', $companyId);
            } else {
                $query->whereRaw('1 = 0'); // Mencegah admin melihat semua data secara default
            }
        }
        
        if ($startDate && $endDate) {
            $query->whereBetween('pica_bargings.tanggal', [$startDate, $endDate]); 
        }
        
        $data = $query->get();
        return view('picabarging.index', compact('data', 'perusahaans', 'companyId'));
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
        if ($request->input('action') == 'save') {
            return redirect('/indexpicabarging')->with('success', 'Data added successfully.');
        }
    
        return redirect()->back()->with('success', 'Data added successfully.');
 
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
        return redirect('/indexpicabarging')->with('success', 'Data saved successfully.');
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
        return redirect('/indexpicabarging')->with('success', '');
    }
}
