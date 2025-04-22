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
use Carbon\Carbon;

class ProduksiController extends Controller
{   //index menu
    public function indexpaua(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        // Query produksi_pas
        $queryPas = DB::table('units')
            ->join('users', 'units.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')


            ->leftJoin('produksi_pas', 'units.id', '=', 'produksi_pas.unit_id')
            ->select(
                'units.unit as units',
                'produksi_pas.plan as pas_plan',
                'produksi_pas.actual as pas_actual'
            );
        if ($user->role !== 'admin') {
            $queryPas->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $queryPas->where('users.id_company', $companyId);
            } else {
                $queryPas->whereRaw('users.id_company', $companyId);
            }
        }

        // Query produksi_uas
        $queryUas = DB::table('units')
            ->join('users', 'units.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')

            ->leftJoin('produksi_uas', 'units.id', '=', 'produksi_uas.unit_id')
            ->select(
                'units.unit as units',
                'produksi_uas.plan as uas_plan',
                'produksi_uas.actual as uas_actual'
            );
        if ($user->role !== 'admin') {
            $queryUas->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $queryUas->where('users.id_company', $companyId);
            } else {
                $queryUas->whereRaw('users.id_company', $companyId);
            }
        }
        // Tambahkan filter tanggal jika tersedia
        if ($startDate && $endDate) {
            $startDateFormatted = Carbon::parse($startDate)->startOfDay();
            $endDateFormatted = Carbon::parse($endDate)->endOfDay();
            $queryPas->whereBetween('produksi_pas.date', [$startDate, $endDate]);
            $queryUas->whereBetween('produksi_uas.date', [$startDate, $endDate]);
        }

        // Ambil data produksi_pas dan produksi_uas terpisah
        $dataPas = $queryPas->orderBy('units.unit')->get()->groupBy('units');
        $dataUas = $queryUas->orderBy('units.unit')->get()->groupBy('units');

        // Hitung total untuk produksi_pas
        $totalsPas = $dataPas->map(function ($items, $unit) {
            $totalPasPlan = $items->sum(function ($item) {
                return (float)str_replace(',', '', $item->pas_plan ?? 0);
            });

            $totalPasActual = $items->sum(function ($item) {
                return (float)str_replace(',', '', $item->pas_actual ?? 0);
            });

            return [
                'units' => $unit,
                'total_pas_plan' => $totalPasPlan,
                'total_pas_actual' => $totalPasActual,
                'details' => $items,
            ];
        });

        // Hitung total untuk produksi_uas
        $totalsUas = $dataUas->map(function ($items, $unit) {
            $totalUasPlan = $items->sum(function ($item) {
                return (float)str_replace(',', '', $item->uas_plan ?? 0);
            });

            $totalUasActual = $items->sum(function ($item) {
                return (float)str_replace(',', '', $item->uas_actual ?? 0);
            });

            return [
                'units' => $unit,
                'total_uas_plan' => $totalUasPlan,
                'total_uas_actual' => $totalUasActual,
                'details' => $items,
            ];
        });

        return view('PA_UA.index', compact('dataPas', 'dataUas', 'totalsPas', 'totalsUas', 'startDate', 'endDate', 'perusahaans', 'companyId'));
    }

    public function indexproduksiua(Request $request)
    {
        $user = Auth::user();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
        $query = DB::table('produksi_uas')
            ->join('units', 'produksi_uas.unit_id', '=', 'units.id')
            ->join('users', 'produksi_uas.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select(
                'produksi_uas.*',
                'units.unit as units'
            );
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
            $startDateFormatted = Carbon::parse($startDate)->startOfDay();
            $endDateFormatted = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('produksi_uas.date', [$startDate, $endDate]);
        }

        $data = $query->orderBy('units.unit')
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
        return view('PA_UA.indexua', compact('data', 'startDate', 'endDate', 'totals', 'perusahaans', 'companyId'));
    }

    public function indexproduksipa(Request $request)
    {
        $user = Auth::user();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $query = DB::table('produksi_pas')
            ->join('units', 'produksi_pas.unit_id', '=', 'units.id')
            ->join('users', 'produksi_pas.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select(
                'produksi_pas.*',
                'produksi_pas.id as id_pa',
                'units.*',
                'units.unit as units'
            );
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
            $startDateFormatted = Carbon::parse($startDate)->startOfDay();
            $endDateFormatted = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('produksi_pas.date', [$startDate, $endDate]);
        }

        $data = $query->orderBy('units.unit')
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
        return view('PA_UA.indexpa', compact('data', 'startDate', 'endDate', 'totals', 'perusahaans', 'companyId'));
    }


    public function unit()
    {
        return view('PA_UA.addUnit');
    }

    public function formproduksipa()
    {
        $unit = Unit::all();
        return view('PA_UA.addproduksipa', compact('unit'));
    }

    public function formproduksiua()
    {
        $unit = Unit::all();
        return view('PA_UA.addproduksiua', compact('unit'));
    }

    //unit
    public function indexunit(Request $request)
    {
        $user = Auth::user();
        $companyId = $request->input('company_id');

        $query = DB::table('units')
            ->select('units.*')
            ->join('users', 'units.created_by', '=', 'users.username')
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

        $data = $query->get();

        return view('PA_UA.indexunit', compact('data'));
    }

    //create
    public function createproduksipa(Request $request)
    {
        $validatedData = $request->validate([
            'actual' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'plan' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
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

        $data = ProduksiPa::create($validatedData);
        HistoryLog::create([
            'table_name' => 'produksi_pas',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexproduksipa')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function createproduksiua(Request $request)
    {
        $validatedData = $request->validate([
            'actual' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'plan' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
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

        $data = ProduksiUa::create($validatedData);
        HistoryLog::create([
            'table_name' => 'produksi_uas',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexproduksiua')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }



    public function createunit(Request $request)
    {
        $validatedData = $request->validate([
            'unit' => 'required|string|max:255',
        ]);

        $validatedData['created_by'] = auth()->user()->username;
        Unit::create($validatedData);

        $redirectTo = $request->input('redirect_to');

        // redirect berdasarkan halaman sebelumnya
        if (!$redirectTo) {
            if (url()->previous() == route('indexproduksipa')) {
                $redirectTo = route('indexproduksipa');
            } elseif (url()->previous() == route('indexproduksiua')) {
                $redirectTo = route('indexproduksiua');
            } elseif (url()->previous() == route('indexewh')) {
                $redirectTo = route('indexewh');
            } elseif (url()->previous() == route('indexfuel')) {
                $redirectTo = route('indexfuel');
            } else {
                $redirectTo = route('indexproduksipa'); // Default redirect
            }
        }

        if ($request->input('action') == 'save') {
            return redirect($redirectTo)->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    //update
    public function formupdateproduksipa($id_pa)
    {

        $unit = Unit::all();
        $data = ProduksiPa::findOrFail($id_pa);
        return view('PA_UA.updatedatapa', compact('unit', 'data'));
    }

    public function formupdateproduksiua($id)
    {

        $unit = Unit::all();
        $data = ProduksiUa::findOrFail($id);
        return view('PA_UA.updatedataua', compact('unit', 'data'));
    }

    public function formupadteunit($id)
    {
        $data = Unit::findOrFail($id);
        return view('PA_UA.updateunit', compact('data'));
    }

    public function updateunit(Request $request, $id)
    {
        $validatedData = $request->validate([
            'unit' => 'required|string|max:255',

        ]);
        $validatedData['updated_by'] = auth()->user()->username;
        $unit = Unit::findOrFail($id);
        $oldData = $unit->toArray();

        $unit->update($validatedData);

        HistoryLog::create([
            'table_name' => 'units',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        $redirectTo = $request->input('redirect_to');
        if (!$redirectTo) {
            if (url()->previous() == route('indexproduksipa')) {
                $redirectTo = route('indexproduksipa');
            } elseif (url()->previous() == route('indexproduksiua')) {
                $redirectTo = route('indexproduksiua');
            } elseif (url()->previous() == route('indexewh')) {
                $redirectTo = route('indexewh');
            } elseif (url()->previous() == route('indexfuel')) {
                $redirectTo = route('indexfuel');
            } else {
                $redirectTo = route('indexproduksipa'); // Default redirect
            }
        }

        if ($request->input('action') == 'save') {
            return redirect($redirectTo)->with('success', 'Data saved successfully.');
        }
    }


    public function updateproduksipa(Request $request, $id_pa)
    {
        $validatedData = $request->validate([
            'actual' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'plan' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
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
        $Produksi = ProduksiPa::findOrFail($id_pa);
        $oldData = $Produksi->toArray();

        $Produksi->update($validatedData);

        HistoryLog::create([
            'table_name' => 'prpoduksi_pas',
            'record_id' => $id_pa,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        return redirect('/indexproduksipa')->with('success', 'Data saved successfully.');
    }

    public function updateproduksiua(Request $request, $id)
    {
        $validatedData = $request->validate([
            'actual' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'plan' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
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
        return redirect('/indexproduksiua')->with('success', 'Data saved successfully.');
    }

    public function deleteproduksipa($id_pa)
    {
        $data = ProduksiPa::findOrFail($id_pa);
        $oldData = $data->toArray();

        // Hapus data dari tabel 
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'produksi_pas',
            'record_id' => $id_pa,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect()->back()->with('success', 'Data deleted successfully.');
    }
    public function deleteproduksiua($id)
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
        return redirect()->back()->with('success', 'Data deleted successfully.');
    }
    public function deleteunit($id)
    {
        $data = Unit::findOrFail($id);
        $oldData = $data->toArray();

        // Hapus data dari tabel 
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'units',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect()->back()->with('success', 'Data deleted successfully.');
    }


    public function picapaua(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $query = DB::table('pica_pa_uas')
            ->select('pica_pa_uas.*')
            ->join('users', 'pica_pa_uas.created_by', '=', 'users.username')
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
            $startDateFormatted = Carbon::parse($startDate)->startOfDay();
            $endDateFormatted = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('tanggal', [$startDate, $endDate]); // Tidak perlu menyebut nama tabel
        }

        $data = $query->get();


        return view('picapaua.index', compact('data', 'perusahaans', 'companyId'));
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
        $data = PicaPaUa::create($validatedData);
        HistoryLog::create([
            'table_name' => 'pica_pa_uas ',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/picapaua')->with('success', 'Data added successfully.');
        }
        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function formupdatepicapaua($id)
    {
        $data = PicaPaUa::findOrFail($id);
        return view('picapaua.update', compact('data'));
    }

    public function updatepicapaua(Request $request, $id)
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

        $data = PicaPaUa::findOrFail($id);
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
        return redirect('/picapaua')->with('success', 'Data saved successfully.');
    }

    public function deletepicapaua($id)
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
        return redirect('/picapaua')->with('success', 'Data deleted successfully.');
    }
}



if (!function_exists('convertToCorrectNumber')) {
    function convertToCorrectNumber($value)
    {
        if ($value === '' || $value === null) return 0;
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);
        return floatval($value);
    }
}
