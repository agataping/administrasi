<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InfrastructureReadiness;
use App\Models\Picainfrastruktur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\HistoryLog;

class InfrastructureReadinessController extends Controller
{
    //InfrastructureReadiness
    public function indexInfrastructureReadiness(Request $request)
    {
        $user = Auth::user();  
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $query = DB::table('infrastructure_readinesses')
        ->select('infrastructure_readinesses.*')
        ->join('users', 'infrastructure_readinesses.created_by', '=', 'users.username')
        ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id');
        if ($user->role !== 'admin') {
            $query->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $query->where('users.id_company', $companyId);
            } else {
                $query->whereRaw('users.id_company', $companyId);             
            }
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]); 
        }
        $data = $query->get();

        $averagePerformance = DB::table('infrastructure_readinesses')
        ->selectRaw('REPLACE(total, "%", "") as total_numeric')
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        })
        ->get()
        ->map(function ($item) {
            return (float) $item->total_numeric;
        })
        ->avg();
        return view('InfrastructureReadines.index', compact('data', 'averagePerformance','perusahaans', 'companyId'));
    }

    public function fromadd()
    {
        return view('InfrastructureReadines.addData');
    }

    public function createInfrastructureReadiness(Request $request)
    {
        $validatedData = $request->validate([ 
            'ProjectName' => 'required',
            'Preparation' => 'nullable',
            'Construction' => 'nullable',
            'Commissiong' => 'nullable',
            'KelayakanBangunan' => 'required',
            'Kelengakapan' => 'required',
            'Kebersihan' => 'required',
            'total' => 'required',
            'note' => 'nullable|string',
            'tanggal' => 'required|date',
            
        ]);
        
        $validatedData['created_by'] = auth()->user()->username;
        $infrastruktur= InfrastructureReadiness::create($validatedData); 
        HistoryLog::create([
            'table_name' => 'infrastructure_readinesses', 
            'record_id' => $infrastruktur->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexInfrastructureReadiness')->with('success', 'Data added successfully.');
        }
    
        return redirect()->back()->with('success', 'Data added successfully.');
        
    }
    
    public function formupdateInfrastructureReadiness($id){
        $data = InfrastructureReadiness::findOrFail($id);
        return view('InfrastructureReadines.updatedata', compact('data'));
    }
    
    //update
    public function updateInfrastructureReadiness(Request $request, $id)
    {
        $validatedData = $request->validate([
            'ProjectName' => 'required',
            'Preparation' => 'nullable',
            'Construction' => 'nullable',
            'Commissiong' => 'nullable',
            'KelayakanBangunan' => 'required',
            'Kelengakapan' => 'required',
            'Kebersihan' => 'required',
            'total' => 'required',
            'note' => 'nullable|string',
            'tanggal' => 'required|date',
            
        ]);
        
        $validatedData['updated_by'] = auth()->user()->username;
        
        $InfrastructureReadiness = InfrastructureReadiness::findOrFail($id);
        $oldData = $InfrastructureReadiness->toArray();
        
        $InfrastructureReadiness->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'people_readiness', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);      
        return redirect('/indexInfrastructureReadiness')->with('success', 'Data berhasil diperbarui.');
    }
    
    public function deleteinfrastruktur ($id)
    {
        $data = InfrastructureReadiness::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'infrastructure_readinesses', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/indexInfrastructureReadiness')->with('success', 'Data  berhasil Dihapus.');
    }
    
    public function picainfrastruktur(Request $request)
    {
        $user = Auth::user();  
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $query = DB::table('picainfrastrukturs') 
        ->select('picainfrastrukturs.*')
        ->join('users', 'picainfrastrukturs.created_by', '=', 'users.username')
        ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id');
    
        if ($user->role !== 'admin') {
                $query->where('users.id_company', $companyId);
            } else {
                if ($companyId) {
                    $query->where('users.id_company', $companyId);
                } else {
                    $query->whereRaw('users.id_company', $companyId);             
                }
            }
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]); 
        }
        $data = $query->get();        
        return view('picainfra.index', compact('data','perusahaans', 'companyId'));
    }
    
    
    public function formpicainfra()
    {
        $user = Auth::user();  
        return view('picainfra.addData');
    }
    
    public function createpicainfra(Request $request)
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
        $data=Picainfrastruktur::create($validatedData); 
        HistoryLog::create([
            'table_name' => 'picainfrastrukturs  ', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);       
        if ($request->input('action') == 'save') {
            return redirect('/picainfrastruktur')->with('success', 'Data added successfully.');
        }
    
        return redirect()->back()->with('success', 'Data added successfully.');
    }
    
    public function formupdatepicainfra($id){
        $data = Picainfrastruktur::findOrFail($id);
        return view('picainfra.update', compact('data'));
    }
    
    public function updatepicainfra(Request $request, $id)
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
        $PicaPeople = Picainfrastruktur::findOrFail($id);
        $oldData = $PicaPeople->toArray();
        
        $PicaPeople->update($validatedData);
        HistoryLog::create([
            'table_name' => 'people_readiness', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/picainfrastruktur')->with('success', 'Surat berhasil disimpan.');
    }
    
    
    public function deletepicainfrastruktur ($id)
    {
        $data = Picainfrastruktur::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'picainfrastrukturs  ', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/picainfrastruktur')->with('success', 'Data  berhasil Dihapus.');
    }
}
