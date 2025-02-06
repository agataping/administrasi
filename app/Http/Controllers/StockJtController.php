<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Picastockjt;
use App\Models\StockJt;
use App\Models\HistoryLog;

class StockJtController extends Controller
{
    //detail
    public function stockjt(Request $request)
    {
        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');  
        $query = DB::table('stock_jts')
        ->select('stock_jts.*')

        ->where('stock_jts.created_by', auth()->user()->username); 

        if ($startDate && $endDate) {
            $query->whereBetween('stock_jts.date', [$startDate, $endDate]);
        }
        
       $data = $query->get();
       $data->each(function ($item) {
        $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
     });
     $totalHauling = (clone $query)->sum('totalhauling') ?? 0;

    // dd($totalHauling);        

        $stokAwal = $data->whereNotNull('sotckawal')->first()->sotckawal ?? 0;
        
        $akumulasi = $stokAwal;
        
        $data->map(function ($stock) use (&$akumulasi) {
            
            $akumulasi += $stock->totalhauling;
            $stock->akumulasi_stock = $akumulasi; 
            
            return $stock;
        });
        $grandTotal = $akumulasi;

        return view('stockjt.index', compact('data','totalHauling','grandTotal'));  
    }
    public function formstockjt(Request $request)
    {
        return view('stockjt.adddata');  
    }
    public function createstockjt(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'sotckawal' => 'nullable|numeric',
            'stockout' => 'nullable|numeric',
            'plan' => 'nullable|numeric',
            'shifpertama' => 'nullable|numeric',
            'shifkedua' => 'nullable|numeric',
            'totalhauling' => 'nullable|numeric',
            'lokasi' =>'required',
            'file' => 'nullable|file',

            
        ]);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public'); // Simpan ke storage/app/public/uploads
        } else {
            $filePath = null; // Jika tidak ada file, set null
        }
        
        $existingStock = StockJt::whereNotNull('sotckawal')->first();        

        
            $data=StockJt::create([
                'date' => $request->date,
                'sotckawal' => $request->sotckawal,
                'stockout' => $request->stockout,
                'plan' => $request->plan,
                'file' => $filePath,
                'shifpertama' => $request->shifpertama,
                'shifkedua' => $request->shifkedua,
                'lokasi' => $request->lokasi,
                'totalhauling' => $request->totalhauling,
                'created_by' => auth()->user()->username,
            ]);
            HistoryLog::create([
                'table_name' => '', 
                'record_id' => $data->id, 
                'action' => 'create',
                'old_data' => null, 
                'new_data' => json_encode($request), 
                'user_id' => auth()->id(), 
            ]);
        
        return redirect('/stockjt')->with('success', 'data berhasil disimpan.');
        
    }

        public function formupdatestockjt($id){
            $data = StockJt::findOrFail($id);
            return view('stockjt.update', compact('data'));    
        }

        public function updatestockjt(Request $request, $id) {
            $request->validate([
                'date' => 'required|date',
                'sotckawal' => 'nullable|numeric',
                'shifpertama' => 'nullable|numeric',
                'shifkedua' => 'nullable|numeric',
                'totalhauling' => 'nullable|numeric',
                'lokasi' => 'required',
                'stockout' => 'nullable|numeric',
                'plan' => 'nullable|numeric',
                'file' => 'nullable|file',
            ]);
            
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filePath = $file->store('uploads', 'public');
            } else {
                $filePath = null;
            }
        
            $validatedData = $request->only([
                'date', 'sotckawal', 'shifpertama', 'shifkedua', 'totalhauling', 
                'lokasi', 'stockout', 'plan'
            ]);
        
            if ($filePath) {
                $validatedData['file'] = $filePath;
            }
        
            $validatedData['updated_by'] = auth()->user()->username;
        
            $data = StockJt::findOrFail($id);
            $oldData = $data->toArray();
        
            $data->update($validatedData);
        
            HistoryLog::create([
                'table_name' => 'stock_jts',
                'record_id' => $id,
                'action' => 'update',
                'old_data' => json_encode($oldData),
                'new_data' => json_encode($validatedData),
                'user_id' => auth()->id(),
            ]);
        
            return redirect('/stockjt')->with('success', 'Data berhasil diupdate.');
        }
            
    public function deletestockjt ($id)
    {
        $data = StockJt::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'stock_jts', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/stockjt')->with('success', 'Data  berhasil Dihapus.');
    }
    


    //Pica
    public function picastockjt(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $query = DB::table('picastockjts') 
            ->select('*')
            ->where('picastockjts.created_by', auth()->user()->username); 

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]); 
        }
        
       $data = $query->get();
        
        
        return view('picastokjt.index', compact('data'));
    }
    
    public function formpicasjt()
    {
        $user = Auth::user();
        return view('picastokjt.addData');
    }
    
    public function createsjt(Request $request)
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
        $data=Picastockjt::create($validatedData);
        HistoryLog::create([
            'table_name' => '', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        
        return redirect('/picastockjt')->with('success', 'Data berhasil disimpan.');
    }
    
    public function formupdatesjt($id)
    {
        $data = Picastockjt::findOrFail($id);
        return view('picastokjt.update', compact('data'));
    }
    
    public function updatesjt(Request $request, $id)
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
        
        $data = Picastockjt::findOrFail($id);
        $oldData = $data->toArray();
        
        $data->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'picastockjts', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);        
        return redirect('/picastockjt')->with('success', 'data berhasil disimpan.');
    }

    public function deletepicastockjt ($id)
    {
        $data = Picastockjt::findOrFail($id);
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
        return redirect('/picastockjt')->with('success', 'Data  berhasil Dihapus.');
    }

}
