<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProduksiPa;
use App\Models\ProduksiUa;
use App\Models\Ewh;
use App\Models\Fuel;
use App\Models\Unit;
use App\Models\PicaEwhFuel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoryLog;
class ControllerEwhFuel extends Controller
{
    public function indexewhfuel(Request $request)

    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Query untuk gabungkan data dari produksi_pas dan produksi_uas
        $query = DB::table('units')
            ->leftJoin('ewhs', 'units.id', '=', 'ewhs.unit_id')
            ->leftJoin('fuels', 'units.id', '=', 'fuels.unit_id')
            ->select(
                'units.unit as units',
                'ewhs.plan as pas_plan',
                'ewhs.actual as pas_actual',
                'fuels.plan as uas_plan',
                'fuels.actual as uas_actual'
            );
    
        if ($startDate && $endDate) {
            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('ewhs.tanggal', [$startDate, $endDate])
                    ->orWhereBetween('fuels.date', [$startDate, $endDate]);
            });
        }
    
        $data = $query->orderBy('units.unit')->get()->groupBy('units');
    
        // Hitung total plan dan actual
        $totals = $data->map(function ($items, $unit) {
            $totalPasPlan = $items->sum(function ($item) {
                return (float)str_replace(',', '', $item->pas_plan ?? 0);
            });
    
            $totalPasActual = $items->sum(function ($item) {
                return (float)str_replace(',', '', $item->pas_actual ?? 0);
            });
    
            $totalUasPlan = $items->sum(function ($item) {
                return (float)str_replace(',', '', $item->uas_plan ?? 0);
            });
    
            $totalUasActual = $items->sum(function ($item) {
                return (float)str_replace(',', '', $item->uas_actual ?? 0);
            });
    
            return [
                'units' => $unit,
                'total_pas_plan' => $totalPasPlan,
                'total_pas_actual' => $totalPasActual,
                'total_uas_plan' => $totalUasPlan,
                'total_uas_actual' => $totalUasActual,
                'details' => $items,
            ];
        });
    
        return view('ewh_fuels.index', compact('data', 'totals', 'startDate', 'endDate'));
    }
    public function indexewh(Request $request)
    {
        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');    

        $query = DB::table('ewhs')
        ->join('units', 'ewhs.unit_id', '=', 'units.id')
        ->select('ewhs.*',
        'units.unit as units')
        ->where('ewhs.created_by', auth()->user()->username); 

            if ($startDate && $endDate) {
                $query->whereBetween('ewhs.date', [$startDate, $endDate]);
            }
            
            $data = $query->orderBy('units.unit')
            ->get()
            ->groupBy('units');            
            $totals = $data->map(function ($items, $category) {
                // Hitung total_plan dan total_actual
                $totalPlan = $items->sum(function ($item) {
                    return (float)str_replace(',', '', $item->plan ?? 0);
                });
                $totalActual = $items->sum(function ($item) {
                    return (float)str_replace(',', '', $item->actual ?? 0);
                });
            
                return [
                    'units' => $category, // Nama grup dari groupBy
                    'total_plan' => $totalPlan,
                    'total_actual' => $totalActual,
                    'details' => $items,
                ];
            });
            // dd($totals);
                    return view('ewh_fuels.indexewh', compact('data', 'startDate', 'endDate','totals'));
    }


    public function indexfuel(Request $request)
    {
        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');    

        $query = DB::table('fuels')
        ->join('units', 'fuels.unit_id', '=', 'units.id')
        ->select('fuels.*',
        'units.unit as units')
        ->where('fuels.created_by', auth()->user()->username); 

            if ($startDate && $endDate) {
                $query->whereBetween('fuels.date', [$startDate, $endDate]);
            }
            
            $data = $query->orderBy('units.unit')
            ->get()
            ->groupBy('units');            
            $totals = $data->map(function ($items, $category) {
                // Hitung total_plan dan total_actual
                $totalPlan = $items->sum(function ($item) {
                    return (float)str_replace(',', '', $item->plan ?? 0);
                });
                $totalActual = $items->sum(function ($item) {
                    return (float)str_replace(',', '', $item->actual ?? 0);
                });
            
                return [
                    'units' => $category, // Nama grup dari groupBy
                    'total_plan' => $totalPlan,
                    'total_actual' => $totalActual,
                    'details' => $items,
                ];
            });
            // dd($totals);
                    return view('ewh_fuels.indexfuel', compact('data', 'startDate', 'endDate','totals'));
    }

    public function formewh()
    {
        $unit= Unit::all();
        return view('ewh_fuels.addewh',compact('unit'));
        
    }
    public function formfuel()
    {
        $unit= Unit::all();
        return view('ewh_fuels.addfuel',compact('unit'));
        
    }

    public function formproduksiua()
    {
        $unit= Unit::all();
        return view('PA_UA.addproduksiua',compact('unit'));
        
    }

    public function createewh(Request $request) {
        $validatedData = $request->validate([
            'actual' => 'required',  
            'plan' => 'required',  
            'date' => 'required|date',  
            'desc' => 'required|string|max:255',  
            'unit_id' => 'required',  

        ]);
        $validatedData['created_by'] = auth()->user()->username;
        
        $data=Ewh::create($validatedData);        
        HistoryLog::create([
            'table_name' => 'ewhs', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/indexewh')->with('success', 'Data berhasil disimpan.');
    }


    
    public function createfuel(Request $request) {
        $validatedData = $request->validate([
            'actual' => 'required',  
            'plan' => 'required',  
            'date' => 'required|date',  
            'desc' => 'required|string|max:255',  
            'unit_id' => 'required',  

        ]);
        $validatedData['created_by'] = auth()->user()->username;
        
        $data=Fuel::create($validatedData);        
        HistoryLog::create([
            'table_name' => 'fuels', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        return redirect('indexfuel')->with('success', 'Data berhasil disimpan.');
    }

    public function formupdateewh($id)
    {
        
        $unit= Unit::all();
        $data= Ewh::findOrFail($id);
        return view('ewh_fuels.updatedataewh',compact('unit','data'));   
    }
    public function formupdatefuels($id)
    {
        
        $unit= Unit::all();
        $data= Fuels::findOrFail($id);
        return view('ewh_fuels.updatedatafuel',compact('unit','data'));   
    }
    public function updateewh(Request $request, $id) {
        $validatedData = $request->validate([
            'plan' => 'nullable|numeric',
            'actual' => 'nullable|numeric',
            'date' => 'required',
            'desc' => 'required',
            'unit_id' => 'required',

        ]);
        $validatedData['updated_by'] = auth()->user()->username;
        $Produksi = Ewh::findOrFail($id);
        $oldData = $Produksi->toArray();
        
        $Produksi->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'ewhs', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);        
        return redirect('/indeewh')->with('success', 'Data berhasil disimpan.');
    }

    public function updatefuel(Request $request, $id) {
        $validatedData = $request->validate([
            'plan' => 'nullable|numeric',
            'actual' => 'nullable|numeric',
            'date' => 'required',
            'desc' => 'required',
            'unit_id' => 'required',

        ]);
        $validatedData['updated_by'] = auth()->user()->username;
        $Produksi = Fuel::findOrFail($id);
        $oldData = $Produksi->toArray();
        
        $Produksi->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'fuels', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);        
        return redirect('/indexfuel')->with('success', 'Data berhasil disimpan.');
    }

    
    public function deletefuel ($id)
    {
        $data = Fuel::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'fuels', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/indexpaua')->with('success', 'Data  berhasil Dihapus.');
    }

    public function deleteewh ($id)
    {
        $data = Ewh::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'ewhs', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/indexpaua')->with('success', 'Data  berhasil Dihapus.');
    }

    public function picaewhfuel(Request $request)
    {
        $user = Auth::user();  
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $query = DB::table('pica_ewh_fuels') 
        ->select('*'); 
        
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]); // Tidak perlu menyebut nama tabel
        }
        
       $data = $query->get();
        
        
        return view('picaewhfuel.index', compact('data'));
        
    }
    
    public function formpicaewhfuel()
    {
        $user = Auth::user();  
        return view('picaewhfuel.addData');
    }
    
    public function createpicaewhfuel(Request $request)
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
        $data=PicaEwhFuel::create($validatedData);   
        HistoryLog::create([
            'table_name' => 'pica_ewh_fuels ', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);     
        return redirect('/picaewhfuel')->with('success', 'Surat berhasil disimpan.');
    }
    
    public function formupdatepicaewhfuel($id){
        $data = PicaEwhFuel::findOrFail($id);
        return view('picaewhfuel.update', compact('data'));
    }
    
    public function updatepicaewhfuel (Request $request, $id)
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
        
        $data =PicaEwhFuel::findOrFail($id);
        $oldData = $data->toArray();
        
        $data->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'pica_ewh_fuels ', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);        
        return redirect('/picaewhfuel')->with('success', 'Surat berhasil disimpan.');
    }
    
    public function deletepicaewhfuel ($id)
    {
        $data = PicaEwhFuel::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'pica_ewh_fuels ', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/picaewhfuel')->with('success', 'Data  berhasil Dihapus.');
    }

}
