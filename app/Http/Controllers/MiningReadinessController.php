<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\KategoriMiniR;
use App\Models\MiningReadiness;
use App\Models\PicaMining;
use App\Models\HistoryLog;

class MiningReadinessController extends Controller
{
    public function indexmining(Request $request)
    {
        //filter data perbaikan pakai tanggal
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        //ngambil data
        $query = DB::table('mining_readinesses')
        ->join('kategori_mini_r_s', 'mining_readinesses.KatgoriDescription', '=', 'kategori_mini_r_s.kategori')
        ->join('users', 'mining_readinesses.created_by', '=', 'users.username')
        ->select(
            'kategori_mini_r_s.kategori',
            'mining_readinesses.Description',
            'mining_readinesses.NomerLegalitas',
            'mining_readinesses.tanggal',
            'mining_readinesses.status',
            'mining_readinesses.berlaku',
            'mining_readinesses.nomor',
            'mining_readinesses.id',
            'mining_readinesses.Achievement',
            'mining_readinesses.filling',
            'mining_readinesses.created_by',
            'mining_readinesses.KatgoriDescription'
        )
        ->where('mining_readinesses.created_by', auth()->user()->username); 
        if ($startDate && $endDate) {
            $query->whereBetween('mining_readinesses.tanggal', [$startDate, $endDate]); // Tidak perlu menyebut nama tabel
        }
       $data = $query->get();
        
        //hitung achievement, konversi data, kelompok+hitung data by"kategori"
        $data->transform(function ($item) 
        {
            $achievement = str_replace('%', '', $item->Achievement);
            $item->average_achievement = $achievement ? (float)$achievement : 0;
            return $item;
        });
        $groupedData = $data->groupBy('kategori')->map(function ($items) {
            $total = $items->sum(function ($item) {
                return (float)str_replace('%', '', $item->Achievement); 
            });
            $count = $items->count();
            $average = $count > 0 ? $total / $count : 0;
            return $items->map(function ($item) use ($average) {
                $item->average_achievement = $average;
                return $item;
            });
        });
        $totalAllCategories = $groupedData->map(function ($items) {
            $totalAchievement = $items->sum(function ($item) {
                return (float)str_replace('%', '', $item->Achievement);
            });
            $count = $items->count();
            return $count > 0 ? $totalAchievement / $count : 0;
        })->sum(); 
        //hitung tot. aspect 
        $totalCategories = $groupedData->count(); 
        $totalAspect = $totalCategories > 0 ? round($totalAllCategories / $totalCategories, 2) : 0;
        
        //cek hitungan sesuai gak + cocokin hitungan di excel 
        // dd([
            //     'totalAllCategories' => $totalAllCategories,
            //     'totalCategories' => $totalCategories,
            //     'totalAspect' => $totalAspect,
            // ]);
            //  total "Legal Aspect"
            $groupedData = $groupedData->map(function ($items, $key) use ($totalAspect) {
                if ($key === 'Legal Aspect') {
                    return $items->map(function ($item) use ($totalAspect) {
                        $item->average_achievement = $totalAspect;
                        return $item;
                    });
                }
                return $items;
            });
            return view('Mining.index', compact('groupedData', 'totalAspect'));
    }
        
    public function FormKategori()
    {
        return view('Mining.formKategori');
    }
    
        
    public function createKatgori(Request $request)
    {
        $validatedData = $request->validate([
            'kategori' => 'required|array',
            'kategori.*' => 'required|string',
        ]);
        $createdBy = auth()->user()->username;
        
        foreach ($validatedData['kategori'] as $nama) {
            $data=KategoriMiniR::create(['kategori' => $nama]);
        }
        HistoryLog::create([
            'table_name' => 'kategori_mini_r_s', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/indexmining')->with('success', 'Data berhasil disimpan.');
    }
    
    public function FormMining()
    {
        $kategori = KategoriMiniR::all();
        return view('Mining.formMining', compact('kategori'));
    }
    
    public function CreateMining(Request $request)
    {
        $validatedData = $request->validate([
            'Description' => 'required',
            'NomerLegalitas' => 'nullable',
            'status' => 'nullable',
            'Achievement' => 'required',
            'tanggal' => 'nullable',
            'berlaku' => 'nullable',
            'nomor' => 'required',
            'filling' => 'nullable',
            'KatgoriDescription' => 'required',
        ]);
        
        $validatedData['created_by'] = auth()->user()->username;
        $data=MiningReadiness::create($validatedData);
        HistoryLog::create([
            'table_name' => 'mining_readinesses', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/indexmining')->with('success', 'Data berhasil disimpan.');
    }
    
    public function FormMiningUpdate($id) 
    {
        $kategori = KategoriMiniR::all();
        $mining = MiningReadiness::findOrFail($id);    
        return view('Mining.updateMining', compact('mining', 'kategori'));
    }
    
    public function UpdateMining(Request $request, $id)
    {
        $validatedData = $request->validate([
            'Description' => 'required',
            'NomerLegalitas' => 'nullable',
            'status' => 'nullable',
            'Achievement' => 'required',
            'tanggal' => 'nullable',
            'berlaku' => 'nullable',
            'nomor' => 'required',
            'filling' => 'nullable',
            'KatgoriDescription' => 'required',
        ]);
        
        $validatedData['updated_by'] = auth()->user()->username;
        
        $mining = MiningReadiness::findOrFail($id);
        $oldData = $mining->toArray();
        
        $mining->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'mining_readinesses  ', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);        
        return redirect('/indexmining')->with('success', 'Data berhasil diperbarui.');
    }

    public function deleteminig ($id)
    {
        $data = MiningReadiness::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'mining_readinesses  ', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/indexmining')->with('success', 'Data  berhasil Dihapus.');
    }
        
    public function picamining(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $query = DB::table('pica_minings') 
        ->select('*')
        ->where('pica_minings.created_by', auth()->user()->username); 
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]); 
        }
       $data = $query->get();
        
        return view('picamining.index', compact('data'));
    }
    
    public function formpicamining()
    {
        $user = Auth::user();
        return view('picamining.addData');
    }
    
    public function createpicamining(Request $request)
    {
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
        $data=PicaMining::create($validatedData);
        HistoryLog::create([
            'table_name' => 'pica_minings  ', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        
        return redirect('/picamining')->with('success', 'Data berhasil disimpan.');
    }
    
    public function formupdatepicamining($id)
    {
        $data = PicaMining::findOrFail($id);
        return view('picamining.update', compact('data'));
    }
    
    public function updatepicamining(Request $request, $id)
    {
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
        
        $PicaPeople = PicaMining::findOrFail($id);
        $oldData = $PicaPeople->toArray();
        
        $PicaPeople->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'pica_minings  ', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);        
        return redirect('/picamining')->with('success', 'data berhasil disimpan.');
    }
    
    public function deletepicamining ($id)
    {
        $data = PicaMining::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'pica_minings', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/')->with('success', 'Data  berhasil Dihapus.');
    }
        
        


}
