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
    public function dashboardstockjt(Request $request){
        $user = Auth::user();  
        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date'); 
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get(); 
        $query = DB::table('stock_jts')
        ->select('stock_jts.*')
        ->join('users', 'stock_jts.created_by', '=', 'users.username')
        ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id');
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
            $query->whereBetween('stock_jts.date', [$startDate, $endDate]);
        }
        
       $data = $query->get();
       $planNominal = $data->sum(function ($p) {
        return floatval(str_replace(['.', ','], ['', '.'], $p->plan));
        });
       $data->transform(function ($item) {
        $item->sotckawal = floatval(str_replace(',', '.', str_replace('.', '', $item->sotckawal)));
        return $item;
        });
        
        $data->each(function ($item) {
            $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
        });
        //  dd($data);
        $totalHauling = (clone $query)->sum('totalhauling') ?? 0;
        $stokAwal = floatval($data->whereNotNull('sotckawal')->first()->sotckawal ?? 0);
        
        $akumulasi = $stokAwal;

        $data->map(function ($stock, $index) use (&$akumulasi, &$stock_akhir) {
            $stock->sotckawal = floatval($stock->sotckawal ?? 0);
            $stock->totalhauling = floatval($stock->totalhauling ?? 0);
            $stock->stockout = floatval($stock->stockout ?? 0);
            if ($index === 0) {
                $akumulasi = $stock->sotckawal; 
            }
            $akumulasi += $stock->totalhauling;
            $stock->akumulasi_stock = $akumulasi;    
            $akumulasi -= $stock->stockout;
            $stock->stock_akhir = $akumulasi;
            $stock_akhir = $stock->stock_akhir;
            return $stock;
        });
    
        $deviasi = $planNominal - $stock_akhir;
        $percen = ($planNominal != 0) ? ($stock_akhir / $planNominal) * 100 : 0;
        $grandTotal = optional($data->last())->stock_akhir ?? 0;
        return view('stockjt.indexmenu', compact('data','totalHauling','grandTotal','perusahaans', 'companyId','planNominal','deviasi','percen'));  
    }


    public function stockjt(Request $request)
    {

        $user = Auth::user();  
        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date'); 
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get(); 
        $query = DB::table('stock_jts')
        ->select('stock_jts.*')
        ->join('users', 'stock_jts.created_by', '=', 'users.username')
        ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id');
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
            $query->whereBetween('stock_jts.date', [$startDate, $endDate]);
        }
        
       $data = $query->get();
       $planNominal = $data->sum(function ($p) {
        return floatval(str_replace(['.', ','], ['', '.'], $p->plan));
        });
       $data->transform(function ($item) {
        $item->sotckawal = floatval(str_replace(',', '.', str_replace('.', '', $item->sotckawal)));
        return $item;
    });
    
       $data->each(function ($item) {
        $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
     });
    //  dd($data);
     $totalHauling = (clone $query)->sum('totalhauling') ?? 0;
     $stokAwal = floatval($data->whereNotNull('sotckawal')->first()->sotckawal ?? 0);
     
     $akumulasi = $stokAwal;

    $data->map(function ($stock, $index) use (&$akumulasi, &$stock_akhir) {
        $stock->sotckawal = floatval($stock->sotckawal ?? 0);
        $stock->totalhauling = floatval($stock->totalhauling ?? 0);
        $stock->stockout = floatval($stock->stockout ?? 0);
        if ($index === 0) {
            $akumulasi = $stock->sotckawal; 
        }
        $akumulasi += $stock->totalhauling;
        $stock->akumulasi_stock = $akumulasi;    
        $akumulasi -= $stock->stockout;
        $stock->stock_akhir = $akumulasi;
        $stock_akhir = $stock->stock_akhir;
        return $stock;
    });
    
    
    $grandTotal = optional($data->last())->akumulasi_stock ?? 0;
    $grandTotalstockakhir = optional($data->last())->stock_akhir ?? 0;

        return view('stockjt.index', compact('data','totalHauling','grandTotal','perusahaans', 'companyId','planNominal','grandTotalstockakhir'));  
    }



    public function formstockjt(Request $request)
    {
        return view('stockjt.adddata');  
    }
    public function createstockjt(Request $request)
    {
        $validatedData=$request->validate([
            'date' => 'required|date',
            'sotckawal' => 'nullable|regex:/^[\d]+([,.]\d+)?$/',
            'stockout' => 'nullable|regex:/^[\d]+([,.]\d+)?$/',
            'plan' => 'nullable|regex:/^[\d]+([,.]\d+)?$/',
            'shifpertama' => 'nullable|numeric',
            'shifkedua' => 'nullable|numeric',
            'totalhauling' => 'nullable|numeric',
            'lokasi' =>'required',
            'file' => 'nullable|file',

            
        ]);
        // Format nominal untuk menghapus koma
        function convertToCorrectNumber($value) {
            if ($value === '' || $value === null) {
                return 0; 
            }
    
            $value = str_replace(',', '.', $value);
    
            return floatval(preg_replace('/[^\d.]/', '', $value)); 
        }
    
    
        // Tentukan mana yang diset null
        $validatedData['plan'] = convertToCorrectNumber($validatedData['plan']);
        $validatedData['sotckawal'] = convertToCorrectNumber($validatedData['sotckawal']);
        $validatedData['stockout'] = convertToCorrectNumber($validatedData['stockout']);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public'); 
        } else {
            $filePath = null; 
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
            if ($request->input('action') == 'save') {
                return redirect('/stockjt')->with('success', 'Data added successfully.');
            }
        
            return redirect()->back()->with('success', 'Data added successfully.');
        
    }

        public function formupdatestockjt($id){
            $data = StockJt::findOrFail($id);
            return view('stockjt.update', compact('data'));    
        }

        public function updatestockjt(Request $request, $id) {
            // Validasi input
            $validatedData=$request->validate([
                'date' => 'required|date',
                'sotckawal' => 'nullable|regex:/^[\d]+([,.]\d+)?$/',
                'stockout' => 'nullable|regex:/^[\d]+([,.]\d+)?$/',
                'plan' => 'nullable|regex:/^[\d]+([,.]\d+)?$/',
                'shifkedua' => 'nullable|numeric',
                'totalhauling' => 'nullable|numeric',
                'lokasi' => 'required|string',
                'file' => 'nullable|file',
            ]);
        
            function convertToCorrectNumber($value) {
                if (empty($value)) {
                    return 0;
                }
        
                $value = str_replace('.', '', $value);
                $value = str_replace(',', '.', $value);
        
                return floatval($value);
            }
        
            $validatedData = $request->all();
        
            $validatedData['stockawal'] = convertToCorrectNumber($validatedData['stockawal'] ?? 0);
            $validatedData['plan'] = convertToCorrectNumber($validatedData['plan'] ?? 0);
            $validatedData['stockout'] = convertToCorrectNumber($validatedData['stockout'] ?? 0);
        
            $data = StockJt::findOrFail($id);
            $oldData = $data->toArray();
        
            if ($request->hasFile('file')) {
                if ($data->file) {
                    Storage::disk('public')->delete($data->file);
                }
        
                $file = $request->file('file');
                $filePath = $file->store('uploads', 'public');
                $validatedData['file'] = $filePath;
            }
        
            // Simpan user yang mengupdate
            $validatedData['updated_by'] = auth()->user()->username;
        
            // Update data
            $data->update($validatedData);
        
            // Simpan log perubahan
            HistoryLog::create([
                'table_name' => 'stock_jts',
                'record_id' => $id,
                'action' => 'update',
                'old_data' => json_encode($oldData),
                'new_data' => json_encode($validatedData),
                'user_id' => auth()->id(),
            ]);
        
            return redirect('/stockjt')->with('success', 'Data updated successfully.');
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
        return redirect('/stockjt')->with('success', 'Data deleted successfully.');
    }
    


    //Pica
    public function picastockjt(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $query = DB::table('picastockjts') 
            ->select('picastockjts.*')
            ->join('users', 'picastockjts.created_by', '=', 'users.username')
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
            $query->whereBetween('tanggal', [$startDate, $endDate]); 
        }
        
       $data = $query->get();
        
        
        return view('picastokjt.index', compact('data','perusahaans', 'companyId'));
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
        if ($request->input('action') == 'save') {
            return redirect('/picastockjt')->with('success', 'Data added successfully.');
        }
    
        return redirect()->back()->with('success', 'Data added successfully.');
    

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
        return redirect('/picastockjt')->with('success', 'data saved successfully.');
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
        return redirect('/picastockjt')->with('success', 'Data deleted successfully.');
    }

}
