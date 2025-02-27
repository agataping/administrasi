<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\OverbardenCoal;
use App\Models\PicaOverCoal;
use App\Models\kategoriOvercoal;
use Carbon\Carbon;
use App\Models\HistoryLog;
use Illuminate\Support\Facades\Route;
class OverberdenCoalController extends Controller
{
    //detail
    public function indexcoal(Request $request)
    {
        $user = Auth::user();  

        
        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');    
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
        $query = DB::table('overberden_coal')
        ->join('kategori_overcoals', 'overberden_coal.kategori_id', '=', 'kategori_overcoals.id')
        ->join('users', 'overberden_coal.created_by', '=', 'users.username')
        ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
        ->where('kategori_overcoals.name', 'Coal Getting')
        ->select('kategori_overcoals.name as kategori_name','overberden_coal.*');
        
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
            $query->whereBetween('overberden_coal.tanggal', [$startDate, $endDate]);
        }
        
        $data = $query->orderBy('kategori_overcoals.name')
        ->get()
        ->groupBy('kategori_name');

        $data->each(function ($items) {
            $items->each(function ($item) {
                $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
            });
        });
        $totals = $data->map(function ($items, $category) {
            $totalPlan = $items->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalplan ?? 0);
            });
            $totalActual = $items->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalactual ?? 0);
            });
            
            // Hitung deviasi dan persen
            $deviation = $totalPlan - $totalActual;
            $percentage = $totalPlan != 0 ? ($totalActual / $totalPlan) * 100 : 0;
            
            return [
                'kategori_name' => $category,
                'total_plan' => $totalPlan,
                'total_actual' => $totalActual,
                'deviation' => $deviation,
                'percentage' => $percentage,
                'details' => $items,
            ];
        });
        // dd($totals);

        return view('overbcoal.indexcoal', compact('totals','perusahaans', 'companyId'));
    }

    public function indexob(Request $request)
    {
        $user = Auth::user();  

        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');    
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
        $query = DB::table('overberden_coal')
        ->join('kategori_overcoals', 'overberden_coal.kategori_id', '=', 'kategori_overcoals.id')
        ->join('users', 'overberden_coal.created_by', '=', 'users.username')
        ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
        ->where('kategori_overcoals.name', 'Over Burden')
        ->select(
        'kategori_overcoals.name as kategori_name','overberden_coal.*');
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
            $query->whereBetween('overberden_coal.tanggal', [$startDate, $endDate]);
        }
        
        $data = $query->orderBy('kategori_overcoals.name')
        ->get()
        ->groupBy('kategori_name');
        $data->each(function ($items) {
            $items->each(function ($item) {
                $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
            });
        });
        $totals = $data->map(function ($items, $category)
        {
            $totalPlan = $items->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalplan ?? 0);
            });
            $totalActual = $items->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalactual ?? 0);
            });
            
            // Hitung deviasi dan persen
            $deviation = $totalPlan - $totalActual;
            
            $percentage = $totalPlan != 0 ? ($totalActual / $totalPlan) * 100 : 0;
            
            return [
                'kategori_name' => $category,
                'total_plan' => $totalPlan,
                'total_actual' => $totalActual,
                'deviation' => $deviation,
                'percentage' => $percentage,
                'details' => $items,
            ];
        });
        
        return view('overbcoal.indexob', compact('totals', 'data', 'startDate', 'endDate','perusahaans', 'companyId'));
    }
    
    public function indexovercoal(Request $request)
    {
        $user = Auth::user();  

        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');    
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $query = DB::table('overberden_coal')
        ->join('kategori_overcoals', 'overberden_coal.kategori_id', '=', 'kategori_overcoals.id')
        ->join('users', 'overberden_coal.created_by', '=', 'users.username')
        ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')

        ->select(
            'kategori_overcoals.name as kategori_name','overberden_coal.*'
        );
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
                $query->whereBetween('overberden_coal.tanggal', [$startDate, $endDate]);
            }
            
            
            // Ambil data dari query
           $data = $query->get();
            
            // Inisialisasi total nilai untuk Coal Getting
            $totalPlancoal = $data->where('kategori_name', 'Coal Getting')->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalplan ?? 0);
            });
            
            $totalActualcoal = $data->where('kategori_name', 'Coal Getting')->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalactual ?? 0);
            });
            // Hitung deviasi dan persen untuk Over Burden
            $deviationactual = $totalPlancoal - $totalActualcoal;
            $percentageactual = $totalPlancoal != 0 ? ($totalActualcoal / $totalPlancoal) * 100 : 0;
            
            
            
            // Inisialisasi total nilai untuk Over Burden
            $totalPlanob = $data->where('kategori_name', 'Over Burden')->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalplan ?? 0);
            });
            
            $totalActualob = $data->where('kategori_name', 'Over Burden')->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalactual ?? 0);
            });
            
            // Hitung deviasi dan persen untuk Over Burden
            $deviationob = $totalPlanob - $totalActualob;
            $percentageob = $totalPlanob != 0 ? ($totalActualob / $totalPlanob) * 100 : 0;
            
            // Hitung SR Plan dan SR Actual
            $srplan = $totalPlanob != 0 ? ($totalActualcoal / $totalPlanob) * 100 : 0;
            $sractual = $totalActualcoal != 0 ? ($totalActualob / $totalActualcoal) * 100 : 0;
            
            return view('overbcoal.index', compact(
                'totalPlancoal',
                'totalActualcoal',
                'totalPlanob',
                'totalActualob',
                'deviationob',
                'percentageob',
                'srplan',
                'sractual',
                'deviationactual',
                'percentageactual',
                 'data','perusahaans', 'companyId'

            ));
    }

    public function formovercoal()
    {
        $data = kategoriOvercoal::all();

        return view('overbcoal.addData',compact('data'));
    }
        
    public function formupdateovercoal($id)
    {
        $kat = kategoriOvercoal::all();
        $data = OverbardenCoal::findOrFail($id);
        $type = $data->kategori_id;
        // dd($type);
        return view('overbcoal.updatedata',compact('data','kat','type'));
    }

    public function createovercoal(Request $request)
    {
        $validatedData = $request->validate([
            'nominalplan' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'nominalactual' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'kategori_id' => 'required|string',
            'desc' => 'required|string',
            'tanggal' => 'required|date',
            'file' => 'nullable|file',

        ]);
        $type = $request->input('kategori_id', '2');
        // Format nominal untuk menghapus koma
        function convertToCorrectNumber($value) {
            if ($value === '' || $value === null) {
                return 0; 
            }
            $value = str_replace('.', '', $value);  
            $value = str_replace(',', '.', $value); 
            return floatval($value); 
        }
        
        // Tentukan mana yang diset null
        $validatedData['nominalplan'] = convertToCorrectNumber($validatedData['nominalplan']);
        $validatedData['nominalactual'] = convertToCorrectNumber($validatedData['nominalactual']);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            $validatedData['file'] = $filePath;
        }
        $validatedData['created_by'] = auth()->user()->username;
        $data=OverbardenCoal::create($validatedData);
        HistoryLog::create([
            'table_name' => 'overberden_coal', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        $type = $request->input('kategori_id', '2'); 
        $action = $request->input('action'); 
        
        if ($action == 'save') {
            if ($type == '2') {
                return redirect('/indexcoal')->with('success', 'Data added successfully.');
            } else {
                return redirect('/indexob')->with('success', 'Data added successfully.');
            }
        } elseif ($action == 'add') {
            return redirect()->back()->with('success', 'Data added successfully.');
        }
                
    }
    
    public function updateovercoal(Request $request, $id){
        // dd($request->all());
        $validatedData = $request->validate([
            'nominalplan' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'nominalactual' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'kategori_id' => 'required|string',
            'desc' => 'required|string',
            'tanggal' => 'required|date',
            'file' => 'nullable|file',

        ]);
        $type = $request->input('type', '2');
        
        // Format nominal untuk menghapus koma
        function convertToCorrectNumber($value) {
            if ($value === '' || $value === null) {
                return 0; 
            }
            $value = str_replace('.', '', $value);  
            $value = str_replace(',', '.', $value); 
            return floatval($value); 
        }
        // Tentukan mana yang diset null
        $validatedData['nominalplan'] = convertToCorrectNumber($validatedData['nominalplan']);
        $validatedData['nominalactual'] = convertToCorrectNumber($validatedData['nominalactual']);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            $validatedData['file'] = $filePath;
        }

        $validatedData['updated_by'] = auth()->user()->username;
        
        $OverbardenCoal = OverbardenCoal::findOrFail($id);
        $oldData = $OverbardenCoal->toArray();
        
        $OverbardenCoal->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'overberden_coal', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);  
        $type = $request->input('kategori_id', '2');
        if ($type === '2') {
            return redirect('/indexcoal')->with('success', 'Data berhasil diperbarui.');
        } else {
            return redirect('/indexob')->with('success', 'Data berhasil diperbarui.');
        }
        
    }

    public function deleteovercoal ($id)
    {
        $data = OverbardenCoal::findOrFail($id);
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
        return back()->with('success', 'Data berhasil dihapus.');
    }
    

    //kategori
    public function indexcategoryobcoal(Request $request)
    {
        $user = Auth::user(); 
        $companyId = $request->input('company_id'); 
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

    
        $query = DB::table('kategori_overcoals')
            ->select('kategori_overcoals.*')
            ->join('users', 'kategori_overcoals.created_by', '=', 'users.username')
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
    
        $data = $query->get(); 
    
        return view('overbcoal.indexcategoryobc', compact('data','companyId','perusahaans')); 
    }
    
    public function formkategoriobc()
    {
        return view('overbcoal.formkategori');
    }
    public function createkatgeoriobc(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);
        $validatedData['created_by'] = auth()->user()->username;
        
        $data=kategoriOvercoal::create($validatedData); 
        HistoryLog::create([
            'table_name' => 'kategori_overcoals', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexovercoal')->with('success', 'Data added successfully.');
        }
        return redirect()->back()->with('success', 'Data added successfully.');

    }

    public function formupdatecategoryobc($id){
        $user = Auth::user();  
        $data = kategoriOvercoal::findOrFail($id);
        return view('overbcoal.formupdatecategory',compact('data'));   
    }

    public function updatecategoryobc(Request $request,$id){
        $user = Auth::user();  
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);
        $validatedData['updated_by'] = auth()->user()->username;
        
        $data = kategoriOvercoal::findOrFail($id);
        $oldData = $data->toArray();
        
        $data->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'kategori_overcoals', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);        
        return view('overbcoal.indexcategoryobcoal',compact('data'));   
    }
        
    public function deletecategoryobc ($id)
    {
        $data = kategoriOvercoal::findOrFail($id);
        $oldData = $data->toArray();
        
        $data->delete();
        
        HistoryLog::create([
            'table_name' => 'kategori_overcoals', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect()->back()->with('success', 'Data deleted successfully.');    

    }
  
    
    
    //PICA
    public function picaobc(Request $request)
    {
        $user = Auth::user();  
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        
        $query = DB::table('pica_over_coal') 
        ->select('pica_over_coal.*')
        ->join('users', 'pica_over_coal.created_by', '=', 'users.username')
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
        
        return view('picaobc.index', compact('data','perusahaans', 'companyId'));
    }
    
    public function formpicaobc()
    {
        $user = Auth::user();  
        return view('picaobc.addData');
    }
    
    public function createpicaobc(Request $request)
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
        $data=PicaOverCoal::create($validatedData);       
        HistoryLog::create([
            'table_name' => 'pica_over_coal', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/picaobc')->with('success', 'Data added successfully.');
        }
    
        return redirect()->back()->with('success', 'Data added successfully.');
     }
    
    public function formupdatepicaobc($id){
        $data = PicaOverCoal::findOrFail($id);
        return view('picaobc.update', compact('data'));
    }
    
    public function updatepicaobc(Request $request, $id)
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
        
        $data = PicaOverCoal::findOrFail($id);
        $oldData = $data->toArray();
        
        $data->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'pica_over_coal', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);        
        return redirect('/picaobc')->with('success', 'Data berhasil disimpan.');
    }

    public function deletepicaobc ($id)
    {
        $data = PicaOverCoal::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'pica_over_coal', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/picaobc')->with('success', 'Data  berhasil Dihapus.');
    }
    
        
    
    
}

