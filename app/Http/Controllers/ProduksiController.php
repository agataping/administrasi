<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\ProduksiPa;
use App\Models\ProduksiUa;
use App\Models\Ewh;
use App\Models\Fuel;
use App\Models\PicaEwhFuel;
use App\Models\PicaPaUa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoryLog;

class ProduksiController extends Controller
{   //inde menu
    public function indexpaua(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Query untuk gabungkan data dari produksi_pas dan produksi_uas
        $query = DB::table('units')
            ->leftJoin('produksi_pas', 'units.id', '=', 'produksi_pas.unit_id')
            ->leftJoin('produksi_uas', 'units.id', '=', 'produksi_uas.unit_id')
            ->select(
                'units.unit as units',
                'produksi_pas.plan as pas_plan',
                'produksi_pas.actual as pas_actual',
                'produksi_uas.plan as uas_plan',
                'produksi_uas.actual as uas_actual'
            );
    
        if ($startDate && $endDate) {
            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('produksi_pas.tanggal', [$startDate, $endDate])
                    ->orWhereBetween('produksi_uas.date', [$startDate, $endDate]);
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
    
        return view('PA_UA.index', compact('data', 'totals', 'startDate', 'endDate'));
    }

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

        
    public function indexproduksiua(Request $request)
    {
        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');    

        $query = DB::table('produksi_uas')
        ->join('units', 'produksi_uas.unit_id', '=', 'units.id')
        ->select('produksi_uas.*',
        'units.unit as units')
        ->where('produksi_uas.created_by', auth()->user()->username); 

            if ($startDate && $endDate) {
                $query->whereBetween('produksi_uas.date', [$startDate, $endDate]);
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
                    return view('PA_UA.indexua', compact('data', 'startDate', 'endDate','totals'));
    }

    public function indexproduksipa(Request $request)
    {
        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');    

        $query = DB::table('produksi_pas')
        ->join('units', 'produksi_pas.unit_id', '=', 'units.id')
        ->select('produksi_pas.*',
        'units.unit as units')
        ->where('produksi_pas.created_by', auth()->user()->username); 

            if ($startDate && $endDate) {
                $query->whereBetween('produksi_pas.date', [$startDate, $endDate]);
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
            return view('PA_UA.indexpa', compact('data', 'startDate', 'endDate','totals'));
    }


    public function unit()
    {
        return view('PA_UA.addUnit');
    }
    
    public function formproduksipa()
    {
        $unit= Unit::all();
        return view('PA_UA.addproduksipa',compact('unit'));
        
    }

    public function formproduksiua()
    {
        $unit= Unit::all();
        return view('PA_UA.addproduksiua',compact('unit'));
        
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
    
    
    //create
    public function createproduksipa(Request $request) {
        $validatedData = $request->validate([
            'actual' => 'required',  
            'plan' => 'required',  
            'date' => 'required|date',  
            'desc' => 'required|string|max:255',  
            'unit_id' => 'required',  

        ]);
        $validatedData['created_by'] = auth()->user()->username;
        
        $data=ProduksiPa::create($validatedData);        
        HistoryLog::create([
            'table_name' => 'produksi_pas', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/indexproduksipa')->with('success', 'Data berhasil disimpan.');
    }

    public function createproduksiua(Request $request) {
        $validatedData = $request->validate([
            'actual' => 'required',  
            'plan' => 'required',  
            'date' => 'required|date',  
            'desc' => 'required|string|max:255',  
            'unit_id' => 'required',  

        ]);
        $validatedData['created_by'] = auth()->user()->username;
        
        $data=ProduksiUa::create($validatedData);        
        HistoryLog::create([
            'table_name' => 'produksi_uas', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/indexproduksiua')->with('success', 'Data berhasil disimpan.');
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


    
    
    public function createunit(Request $request)
    {
        $validatedData = $request->validate([
            'unit' => 'required|string|max:255',  
        ]);
        
        $validatedData['created_by'] = auth()->user()->username;
        Unit::create($validatedData);        
        
        return redirect('/indexpaua')->with('success', 'Data berhasil disimpan.');
    }
    
    
    //update
    public function formupdateproduksipa($id)
    {
        
        $unit= Unit::all();
        $data= ProduksiPa::findOrFail($id);
        return view('PA_UA.updatedatapa',compact('unit','data'));   
    }

    public function formupdateproduksiua($id)
    {
        
        $unit= Unit::all();
        $data= ProduksiUa::findOrFail($id);
        return view('PA_UA.updatedataua',compact('unit','data'));   
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

    
    public function updateproduksipa(Request $request, $id) {
        $validatedData = $request->validate([
            'plan' => 'nullable|numeric',
            'actual' => 'nullable|numeric',
            'date' => 'required',
            'desc' => 'required',
            'unit_id' => 'required',

        ]);
        $validatedData['updated_by'] = auth()->user()->username;
        $Produksi = ProduksiPa::findOrFail($id);
        $oldData = $Produksi->toArray();
        
        $Produksi->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'prpoduksi_pas', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);        
        return redirect('/indexpaua')->with('success', 'Data berhasil disimpan.');
    }

    public function updateproduksiua(Request $request, $id) {
        $validatedData = $request->validate([
            'plan' => 'nullable|numeric',
            'actual' => 'nullable|numeric',
            'date' => 'required',
            'desc' => 'required',
            'unit_id' => 'required',

        ]);
        $validatedData['updated_by'] = auth()->user()->username;
        $Produksi = ProduksiUa::findOrFail($id);
        $oldData = $Produksi->toArray();
        
        $Produksi->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'prpoduksi_uas', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);        
        return redirect('/indexproduksiua')->with('success', 'Data berhasil disimpan.');
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
    public function deleteproduksipa ($id)
    {
        $data = ProduksiPa::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'produksi_pas', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/indexpaua')->with('success', 'Data  berhasil Dihapus.');
    }
    public function deleteproduksiua ($id)
    {
        $data = ProduksiUa::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'produksi_uas', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/indexpaua')->with('success', 'Data  berhasil Dihapus.');
    }

    public function picapaua(Request $request)
    {
        $user = Auth::user();  
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $query = DB::table('pica_pa_uas') 
        ->select('*'); 
        
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]); // Tidak perlu menyebut nama tabel
        }
        
       $data = $query->get();
        
        
        return view('picapaua.index', compact('data'));
        
    }
    
    public function formpicapaua()
    {
        $user = Auth::user();  
        return view('picapaua.addData');
    }
    
    public function createpicapaua(Request $request)
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
        $data=PicaPaUa::create($validatedData);   
        HistoryLog::create([
            'table_name' => 'pica_pa_uas ', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);     
        return redirect('/picapaua')->with('success', 'Surat berhasil disimpan.');
    }
    
    public function formupdatepicapaua($id){
        $data = PicaPaUa::findOrFail($id);
        return view('picapaua.update', compact('data'));
    }
    
    public function updatepicapaua (Request $request, $id)
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
        
        $data =PicaPaUa::findOrFail($id);
        $oldData = $data->toArray();
        
        $data->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'pica_pa_uas ', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);        
        return redirect('/picapaua')->with('success', 'Surat berhasil disimpan.');
    }
    
    public function deletepicapaua ($id)
    {
        $data = PicaPaUa::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'pica_pa_uas ', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/')->with('success', 'Data  berhasil Dihapus.');
    }
    
}

        
        
        