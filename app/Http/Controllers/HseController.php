<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\kategoriHse;
use App\Models\Hse;
use App\Models\PicaHse;
use App\Models\HistoryLog;

class HseController extends Controller
{
    public function indexhse(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $query = DB::table('hses')
        ->join('kategori_hses', 'hses.kategori_id', '=', 'kategori_hses.id')
        ->join('users', 'hses.created_by', '=', 'users.username')
        ->select(
            'hses.id',
            'hses.nameindikator',
            'hses.target',
            'hses.nilai',
            'hses.indikator',
            'hses.keterangan',
            'kategori_hses.name as kategori_name',
            'users.username as created_by'
        )
        ->where('pica_bargings.created_by', auth()->user()->username); 

        if ($startDate && $endDate) {
            $query->whereBetween('hses.date', [$startDate, $endDate]); 
        }
        $data = $query->orderBy('kategori_hses.name') 
        ->get()
        ->groupBy('kategori_name'); 

        return view('hse.index',compact('data'));
    }

    public function formkategorihse()
    {
        return view('hse.formkategori');
        
    }
    public function formhse()
    {
        $data = kategoriHse :: all();
        return view('hse.addData',compact('data'));
    }
    
    public function createhse(Request $request)
    {
        $validatedData = $request->validate([
            'nameindikator' => 'required',
            'date' => 'required',
            'indikator' => 'nullable',
            'target' => 'nullable',
            'nilai' => 'required',
            'keterangan' => 'nullable',
            'kategori_id' => 'required',
            
        ]);
        
        $validatedData['created_by'] = auth()->user()->username;
        $data=Hse::create($validatedData);
        HistoryLog::create([
            'table_name' => 'hses', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        
        return redirect('/indexhse')->with('success', 'data berhasil disimpan.');
    }
    
    public function createkategorihse(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        $createdBy = auth()->user()->username;
        kategoriHse::create($validatedData);  
        return redirect('/indexhse')->with('success', 'Data berhasil disimpan.');
    }
    
    public function updatehse(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nameindikator' => 'required',
            'indikator' => 'nullable',
            'target' => 'nullable',
            'nilai' => 'required',
            'date' => 'required',
            
            'keterangan' => 'nullable',
            'kategori_id' => 'required',
        ]);
        
        $validatedData['updated_by'] = auth()->user()->username;
        
        $hse = Hse::findOrFail($id);
        $oldData = $hse->toArray();
        
        $hse->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'hses', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);        
        return redirect('/indexhse')->with('success', 'Data berhasil diperbarui.');
    }
    
    public function formupdatehse($id)
    {
        $kategori = kategoriHse::all();
        $hse = hse::findOrFail($id);
        
        return view('hse.update',compact('hse','kategori'));
    }
    
    public function deletehse ($id)
    {
        $data = Hse::findOrFail($id);
        $oldData = $data->toArray();
        
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'indexhse', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/indexhse')->with('success', 'Data  berhasil Dihapus.');
    }
    
    
    public function picahse(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $query = DB::table('pica_hses') 
        ->select('*')
        ->where('pica_bargings.created_by', auth()->user()->username); 
        
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]); 
        }
        
        $data = $query->get();
        
        return view('picahse.index', compact('data'));
        
    }
    
    
    public function formpicahse()
    {
        $user = Auth::user();  
        return view('picahse.addData');
    }
    
    public function createpicahse(Request $request)
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
        $data=PicaHse::create($validatedData);  
        HistoryLog::create([
            'table_name' => 'pica_hses', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);      
        return redirect('/picahse')->with('success', 'Surat berhasil disimpan.');
    }
    
    public function formupdatepicahse($id){
        $data = PicaHse::findOrFail($id);
        return view('picahse.update', compact('data'));
    }
    
    public function updatepicahse(Request $request, $id)
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
        
        $data =PicaHse::findOrFail($id);
        $oldData = $data->toArray();
        
        $data->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'pica_hses', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);        
        return redirect('/picahse')->with('success', 'Surat berhasil disimpan.');
    }

    public function deletepicahse ($id)
    {
        $data = Picahse::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'pica_hses', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/picahse')->with('success', 'Data  berhasil Dihapus.');
    }
    
    


}
