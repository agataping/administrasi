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
use Carbon\Carbon;

class ControllerEwhFuel extends Controller
{
    public function indexewhfuel(Request $request)

    {
        $user = Auth::user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $queryEwh = DB::table('units')
            ->join('users', 'units.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->leftJoin('ewhs', 'units.id', '=', 'ewhs.unit_id')
            ->select(
                'units.unit as units',
                'ewhs.plan as plan_ewh',
                'ewhs.actual as actual_ewh'
            );
        if ($user->role !== 'admin') {
            $queryEwh->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $queryEwh->where('users.id_company', $companyId);
            } else {
                $queryEwh->whereRaw('users.id_company', $companyId);
            }
        }

        $queryFuel = DB::table('units')
            ->join('users', 'units.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')

            ->leftJoin('fuels', 'units.id', '=', 'fuels.unit_id')
            ->select(
                'units.unit as units',
                'fuels.plan as plan_fuel',
                'fuels.actual as actual_fuel'
            );
        if ($user->role !== 'admin') {
            $queryFuel->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $queryFuel->where('users.id_company', $companyId);
            } else {
                $queryFuel->whereRaw('users.id_company', $companyId);
            }
        }
if ($startDate && $endDate) {
    $startDateFormatted = Carbon::parse($startDate)->startOfDay();
    $endDateFormatted = Carbon::parse($endDate)->endOfDay();
            $queryEwh->whereBetween('ewhs.date', [$startDate, $endDate]);
            $queryFuel->whereBetween('fuels.date', [$startDate, $endDate]);
        }

        $dataPas = $queryEwh->orderBy('units.unit')->get()->groupBy('units');
        $dataUas = $queryFuel->orderBy('units.unit')->get()->groupBy('units');

        $totalsPas = $dataPas->map(function ($items, $unit) {
            $totalPasPlan = $items->sum(function ($item) {
                return (float)str_replace(',', '', $item->plan_ewh ?? 0);
            });

            $totalPasActual = $items->sum(function ($item) {
                return (float)str_replace(',', '', $item->actual_ewh ?? 0);
            });

            return [
                'units' => $unit,
                'total_pas_plan' => $totalPasPlan,
                'total_pas_actual' => $totalPasActual,
                'details' => $items,
            ];
        });

        $totalsUas = $dataUas->map(function ($items, $unit) {
            $totalUasPlan = $items->sum(function ($item) {
                return (float)str_replace(',', '', $item->plan_fuel ?? 0);
            });

            $totalUasActual = $items->sum(function ($item) {
                return (float)str_replace(',', '', $item->actual_fuel ?? 0);
            });

            return [
                'units' => $unit,
                'total_uas_plan' => $totalUasPlan,
                'total_uas_actual' => $totalUasActual,
                'details' => $items,
            ];
        });

        return view('ewh_fuels.index', compact(
            'dataPas',
            'dataUas',
            'totalsPas',
            'totalsUas',
            'startDate',
            'endDate',
            'perusahaans',
            'companyId'
        ));
    }
    public function indexewh(Request $request)
    {
        $user = Auth::user();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
        $queryewh = DB::table('ewhs')
            ->join('units', 'ewhs.unit_id', '=', 'units.id')
            ->join('users', 'ewhs.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select('ewhs.*', 'units.unit as units');
        if ($user->role !== 'admin') {
            $queryewh->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $queryewh->where('users.id_company', $companyId);
            } else {
                $queryewh->whereRaw('users.id_company', $companyId);
            }
        }
if ($startDate && $endDate) {
    $startDateFormatted = Carbon::parse($startDate)->startOfDay();
    $endDateFormatted = Carbon::parse($endDate)->endOfDay();
            $queryewh->whereBetween('ewhs.date', [$startDate, $endDate]);
        }

        $data = $queryewh->orderBy('units.unit')
            ->get()
            ->groupBy('units');
        $data->each(function ($items) {
            $items->each(function ($item) {
                $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
            });
        });

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
        return view('ewh_fuels.indexewh', compact('data', 'startDate', 'endDate', 'totals', 'perusahaans', 'companyId'));
    }


    public function indexfuel(Request $request)
    {
        $user = Auth::user();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $queryewh = DB::table('fuels')
            ->join('units', 'fuels.unit_id', '=', 'units.id')
            ->join('users', 'fuels.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select(
                'fuels.*',
                'units.unit as units'
            );
        if ($user->role !== 'admin') {
            $queryewh->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $queryewh->where('users.id_company', $companyId);
            } else {
                $queryewh->whereRaw('users.id_company', $companyId);
            }
        }
if ($startDate && $endDate) {
    $startDateFormatted = Carbon::parse($startDate)->startOfDay();
    $endDateFormatted = Carbon::parse($endDate)->endOfDay();
            $queryewh->whereBetween('fuels.date', [$startDate, $endDate]);
        }

        $data = $queryewh->orderBy('units.unit')
            ->get()
            ->groupBy('units');
        $data->each(function ($items) {
            $items->each(function ($item) {
                $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
            });
        });

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
        return view('ewh_fuels.indexfuel', compact('data', 'startDate', 'endDate', 'totals', 'perusahaans', 'companyId'));
    }

    public function formewh()
    {
        $unit = Unit::all();
        return view('ewh_fuels.addewh', compact('unit'));
    }
    public function formfuel()
    {
        $unit = Unit::all();
        return view('ewh_fuels.addfuel', compact('unit'));
    }



    public function createewh(Request $request)
    {
        $validatedData = $request->validate([
            'actual' => 'nullable|regex:/^-?\d+(,\d+)?(\.\d{1,2})?$/',
            'plan' => 'nullable|regex:/^-?\d+(,\d+)?(\.\d{1,2})?$/',
            'date' => 'required|date',
            'desc' => 'required|string|max:255',
            'unit_id' => 'required',
            'file' => 'nullable|file',


        ]);

        // Tentukan mana yang diset null
        $validatedData['plan'] = convertToCorrectNumber($validatedData['plan']);
        $validatedData['actual'] = convertToCorrectNumber($validatedData['actual']);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            $validatedData['file'] = $filePath;
        }

        $validatedData['created_by'] = auth()->user()->username;

        $data = Ewh::create($validatedData);
        HistoryLog::create([
            'table_name' => 'ewhs',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexewh')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }



    public function createfuel(Request $request)
    {
        $validatedData = $request->validate([
            'actual' => 'nullable|regex:/^-?\d+(,\d+)?(\.\d{1,2})?$/',
            'plan' => 'nullable|regex:/^-?\d+(,\d+)?(\.\d{1,2})?$/',
            'date' => 'required|date',
            'desc' => 'required|string|max:255',
            'unit_id' => 'required',
            'file' => 'nullable|file',


        ]);

        // Tentukan mana yang diset null
        $validatedData['plan'] = convertToCorrectNumber($validatedData['plan']);
        $validatedData['actual'] = convertToCorrectNumber($validatedData['actual']);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            $validatedData['file'] = $filePath;
        }

        $validatedData['created_by'] = auth()->user()->username;

        $data = Fuel::create($validatedData);
        HistoryLog::create([
            'table_name' => 'fuels',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexfuel')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function formupdateewh($id)
    {

        $unit = Unit::all();
        $data = Ewh::findOrFail($id);
        return view('ewh_fuels.updatedataewh', compact('unit', 'data'));
    }
    public function formupdatefuels($id)
    {

        $unit = Unit::all();
        $data = Fuel::findOrFail($id);
        return view('ewh_fuels.updatedatafuel', compact('unit', 'data'));
    }
    public function updateewh(Request $request, $id)
    {
        $validatedData = $request->validate([
            'actual' => 'nullable|regex:/^-?\d+(,\d+)?(\.\d{1,2})?$/',
            'plan' => 'nullable|regex:/^-?\d+(,\d+)?(\.\d{1,2})?$/',
            'date' => 'required',
            'desc' => 'required',
            'unit_id' => 'required',
            'file' => 'nullable|file',


        ]);

        // Tentukan mana yang diset null
        $validatedData['plan'] = convertToCorrectNumber($validatedData['plan']);
        $validatedData['actual'] = convertToCorrectNumber($validatedData['actual']);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            $validatedData['file'] = $filePath;
        }

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
        return redirect('/indexewh')->with('success', 'Data saved successfully..');
    }

    public function updatefuel(Request $request, $id)
    {
        $validatedData = $request->validate([
            'actual' => 'nullable|regex:/^-?\d+(,\d+)?(\.\d{1,2})?$/',
            'plan' => 'nullable|regex:/^-?\d+(,\d+)?(\.\d{1,2})?$/',
            'date' => 'required',
            'desc' => 'required',
            'unit_id' => 'required',
            'file' => 'nullable|file',


        ]);

        // Tentukan mana yang diset null
        $validatedData['plan'] = convertToCorrectNumber($validatedData['plan']);
        $validatedData['actual'] = convertToCorrectNumber($validatedData['actual']);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            $validatedData['file'] = $filePath;
        }

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
        return redirect('/indexfuel')->with('success', 'Data saved successfully..');
    }


    public function deletefuel($id)
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
        return redirect()->back()->with('success', 'Data deleted successfully.');
    }

    public function deleteewh($id)
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
        return redirect()->back()->with('success', 'Data deleted successfully.');
    }

    public function picaewhfuel(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $queryewh = DB::table('pica_ewh_fuels')
            ->select('pica_ewh_fuels.*')
            ->join('users', 'pica_ewh_fuels.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id');

        if ($user->role !== 'admin') {
            $queryewh->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $queryewh->where('users.id_company', $companyId);
            } else {
                $queryewh->whereRaw('users.id_company', $companyId);
            }
        }


if ($startDate && $endDate) {
    $startDateFormatted = Carbon::parse($startDate)->startOfDay();
    $endDateFormatted = Carbon::parse($endDate)->endOfDay();
            $queryewh->whereBetween('tanggal', [$startDate, $endDate]); // Tidak perlu menyebut nama tabel
        }

        $data = $queryewh->get();


        return view('picaewhfuel.index', compact('data', 'perusahaans', 'companyId'));
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
        $data = PicaEwhFuel::create($validatedData);
        HistoryLog::create([
            'table_name' => 'pica_ewh_fuels ',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/picaewhfuel')->with('success', 'Data added successfully.');
        }
        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function formupdatepicaewhfuel($id)
    {
        $data = PicaEwhFuel::findOrFail($id);
        return view('picaewhfuel.update', compact('data'));
    }

    public function updatepicaewhfuel(Request $request, $id)
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

        $data = PicaEwhFuel::findOrFail($id);
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
        return redirect('/picaewhfuel')->with('success', 'Data saved successfully.');
    }

    public function deletepicaewhfuel($id)
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
        return redirect('/picaewhfuel')->with('success', 'Data deleted successfully.');
    }
}
if (!function_exists('convertToCorrectNumber')) {
    function convertToCorrectNumber($value) {
        if ($value === '' || $value === null) return 0;
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);
        return floatval($value);
    }
}