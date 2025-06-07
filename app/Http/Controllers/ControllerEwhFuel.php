<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CodeUnit;
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
        $tahun = Carbon::now()->year;
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;

        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
        $queryewh = DB::table('fuels')
            ->join('code_unit', 'fuels.unit_id', '=', 'code_unit.id')
            ->join('users', 'fuels.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select('fuels.*', 'code_unit.code as code');
        if ($user->role !== 'admin') {
            $queryewh->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $queryewh->where('users.id_company', $companyId);
            } else {
                $queryewh->whereRaw('users.id_company', $companyId);
            }
        }
        if (!$startDate || !$endDate) {
            $startDate = Carbon::createFromDate($tahun, 1, 1)->startOfDay();
            $endDate = Carbon::createFromDate($tahun, 12, 31)->endOfDay();
        } else {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
        }
        $queryewh->whereBetween('fuels.date', [$startDate, $endDate]);


        $data = $queryewh->orderBy('code_unit.code')
            ->get()
            ->groupBy('code');
        $data->each(function ($items) {
            $items->each(function ($item) {
                $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
            });
        });
        $count = $queryewh->count();

        // Hitung totals per kategori
        $totals = $data->map(function ($items, $category) {
            $totalPlan = $items->sum(function ($item) {
                return (float) str_replace(',', '', $item->plan ?? 0);
            });
            $totalActual = $items->sum(function ($item) {
                return (float) str_replace(',', '', $item->actual ?? 0);
            });

            $jumlahDataPlanValid = $items->filter(function ($item) {
                return is_numeric(str_replace(',', '', $item->plan));
            })->count();

            $jumlahDataActualValid = $items->filter(function ($item) {
                return is_numeric(str_replace(',', '', $item->actual));
            })->count();

            $averagePlanfuels = $jumlahDataPlanValid > 0 ? $totalPlan / $jumlahDataPlanValid : 0;
            $averageActualfuels = $jumlahDataActualValid > 0 ? $totalActual / $jumlahDataActualValid : 0;
            $Ach = ($totalPlan != 0) ? floor(($totalActual / $totalPlan) * 10000) / 100 : 0;
            // dd($Ach);

            return [
                'totalAch' => $Ach,
                'units' => $category,
                'total_plan' => $totalPlan,
                'total_actual' => $totalActual,
                'details' => $items,
                'jumlah_data_plan_valid' => $jumlahDataPlanValid,
                'jumlah_data_actual_valid' => $jumlahDataActualValid,
                'average_plan' => $averagePlanfuels,
                'average_actual' => $averageActualfuels,
            ];
        });

        // Hitung total data valid plan dan actual dari semua data (flat)
        $allItems = $data->flatten();

        $totalDataPlanValid = $allItems->filter(function ($item) {
            return is_numeric(str_replace(',', '', $item->plan));
        })->count();

        $totalDataActualValid = $allItems->filter(function ($item) {
            return is_numeric(str_replace(',', '', $item->actual));
        })->count();
        $totalDataActualValid = $allItems->filter(function ($item) {
            return is_numeric(str_replace(',', '', $item->actual));
        })->count();

        $totalPlanGlobalfuels = $allItems->sum(function ($item) {
            return (float) str_replace(',', '', $item->plan ?? 0);
        });

        $totalActualGlobalfuels = $allItems->sum(function ($item) {
            return (float) str_replace(',', '', $item->actual ?? 0);
        });
        $totalAchGlobal = $allItems->sum(function ($item) {
            return (float) str_replace(',', '', $item->actual ?? 0);
        });
        $totalachGlobalFuel = ($totalPlanGlobalfuels != 0) ? floor(($totalActualGlobalfuels / $totalPlanGlobalfuels) * 10000) / 100 : 0;

        $averageachGlobalFuel = $count > 0 ? $totalachGlobalFuel / $count : 0;

        $averagePlanGlobalfuels = $totalDataPlanValid > 0 ? $totalPlanGlobalfuels / $totalDataPlanValid : 0;
        $averageActualGlobalfuels = $totalDataActualValid > 0 ? $totalActualGlobalfuels / $totalDataActualValid : 0;

        $queryewh = DB::table('ewhs')
            ->join('code_unit', 'ewhs.unit_id', '=', 'code_unit.id')
            ->join('users', 'ewhs.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select('ewhs.*', 'code_unit.code as code');
        if ($user->role !== 'admin') {
            $queryewh->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $queryewh->where('users.id_company', $companyId);
            } else {
                $queryewh->whereRaw('users.id_company', $companyId);
            }
        }
        if (!$startDate || !$endDate) {
            $startDate = Carbon::createFromDate($tahun, 1, 1)->startOfDay();
            $endDate = Carbon::createFromDate($tahun, 12, 31)->endOfDay();
        } else {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
        }
        $queryewh->whereBetween('ewhs.date', [$startDate, $endDate]);


        $data = $queryewh->orderBy('code_unit.code')
            ->get()
            ->groupBy('code');
        $data->each(function ($items) {
            $items->each(function ($item) {
                $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
            });
        });

        // Hitung totals per kategori
        $totals = $data->map(function ($items, $category) {
            $totalPlan = $items->sum(function ($item) {
                return (float) str_replace(',', '', $item->plan ?? 0);
            });
            $totalActual = $items->sum(function ($item) {
                return (float) str_replace(',', '', $item->actual ?? 0);
            });

            $jumlahDataPlanValid = $items->filter(function ($item) {
                return is_numeric(str_replace(',', '', $item->plan));
            })->count();

            $jumlahDataActualValid = $items->filter(function ($item) {
                return is_numeric(str_replace(',', '', $item->actual));
            })->count();

            $averagePlan = $jumlahDataPlanValid > 0 ? $totalPlan / $jumlahDataPlanValid : 0;
            $averageActual = $jumlahDataActualValid > 0 ? $totalActual / $jumlahDataActualValid : 0;

            return [
                'units' => $category,
                'total_plan' => $totalPlan,
                'total_actual' => $totalActual,
                'details' => $items,
                'jumlah_data_plan_valid' => $jumlahDataPlanValid,
                'jumlah_data_actual_valid' => $jumlahDataActualValid,
                'average_plan' => $averagePlan,
                'average_actual' => $averageActual,
            ];
        });

        // Hitung total data valid plan dan actual dari semua data (flat)
        $allItems = $data->flatten();

        $totalDataPlanValid = $allItems->filter(function ($item) {
            return is_numeric(str_replace(',', '', $item->plan));
        })->count();

        $totalDataActualValid = $allItems->filter(function ($item) {
            return is_numeric(str_replace(',', '', $item->actual));
        })->count();

        $totalPlanGlobal = $allItems->sum(function ($item) {
            return (float) str_replace(',', '', $item->plan ?? 0);
        });

        $totalActualGlobal = $allItems->sum(function ($item) {
            return (float) str_replace(',', '', $item->actual ?? 0);
        });

        $averagePlanGlobal = $totalDataPlanValid > 0 ? $totalPlanGlobal / $totalDataPlanValid : 0;
        $averageActualGlobal = $totalDataActualValid > 0 ? $totalActualGlobal / $totalDataActualValid : 0;


        return view('ewh_fuels.index', compact(
            // 'dataPas',
            // 'dataUas',
            // 'totalsPas',
            // 'totalsUas',
            'startDate',
            'endDate',
            'perusahaans',
            'companyId',
            'averageActualGlobal',
            'averagePlanGlobal',
            'averagePlanGlobalfuels',
            'averageActualGlobalfuels'
            
        ));
    }
    public function indexewh(Request $request)
    {
        $user = Auth::user();

        $tahun = Carbon::now()->year;
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
        $queryewh = DB::table('ewhs')
            ->join('code_unit', 'ewhs.unit_id', '=', 'code_unit.id')
            ->join('users', 'ewhs.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select('ewhs.*', 'code_unit.code as code');
        if ($user->role !== 'admin') {
            $queryewh->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $queryewh->where('users.id_company', $companyId);
            } else {
                $queryewh->whereRaw('users.id_company', $companyId);
            }
        }
        if (!$startDate || !$endDate) {
            $startDate = Carbon::createFromDate($tahun, 1, 1)->startOfDay();
            $endDate = Carbon::createFromDate($tahun, 12, 31)->endOfDay();
        } else {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
        }
        $queryewh->whereBetween('ewhs.date', [$startDate, $endDate]);


        $data = $queryewh->orderBy('code_unit.code')
            ->get()
            ->groupBy('code');
        $data->each(function ($items) {
            $items->each(function ($item) {
                $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
            });
        });
        $count = $queryewh->count();

        // Hitung totals per kategori
        $totals = $data->map(function ($items, $category) {
            $totalPlan = $items->sum(function ($item) {
                return (float) str_replace(',', '', $item->plan ?? 0);
            });
            $totalActual = $items->sum(function ($item) {
                return (float) str_replace(',', '', $item->actual ?? 0);
            });

            $jumlahDataPlanValid = $items->filter(function ($item) {
                return is_numeric(str_replace(',', '', $item->plan));
            })->count();

            $jumlahDataActualValid = $items->filter(function ($item) {
                return is_numeric(str_replace(',', '', $item->actual));
            })->count();

            $averagePlan = $jumlahDataPlanValid > 0 ? $totalPlan / $jumlahDataPlanValid : 0;
            $averageActual = $jumlahDataActualValid > 0 ? $totalActual / $jumlahDataActualValid : 0;
            $Ach = ($totalPlan != 0) ? floor(($totalActual / $totalPlan) * 10000) / 100 : 0;
            // dd($Ach);

            return [
                'totalAch' => $Ach,
                'units' => $category,
                'total_plan' => $totalPlan,
                'total_actual' => $totalActual,
                'details' => $items,
                'jumlah_data_plan_valid' => $jumlahDataPlanValid,
                'jumlah_data_actual_valid' => $jumlahDataActualValid,
                'average_plan' => $averagePlan,
                'average_actual' => $averageActual,
            ];
        });

        // Hitung total data valid plan dan actual dari semua data (flat)
        $allItems = $data->flatten();

        $totalDataPlanValid = $allItems->filter(function ($item) {
            return is_numeric(str_replace(',', '', $item->plan));
        })->count();

        $totalDataActualValid = $allItems->filter(function ($item) {
            return is_numeric(str_replace(',', '', $item->actual));
        })->count();
        $totalDataActualValid = $allItems->filter(function ($item) {
            return is_numeric(str_replace(',', '', $item->actual));
        })->count();

        $totalPlanGlobal = $allItems->sum(function ($item) {
            return (float) str_replace(',', '', $item->plan ?? 0);
        });

        $totalActualGlobal = $allItems->sum(function ($item) {
            return (float) str_replace(',', '', $item->actual ?? 0);
        });
        $totalAchGlobal = $allItems->sum(function ($item) {
            return (float) str_replace(',', '', $item->actual ?? 0);
        });
        $totalachGlobal = ($totalPlanGlobal != 0) ? floor(($totalActualGlobal / $totalPlanGlobal) * 10000) / 100 : 0;

        $averageachGlobal = $count > 0 ? $totalachGlobal / $count : 0;

        $averagePlanGlobal = $totalDataPlanValid > 0 ? $totalPlanGlobal / $totalDataPlanValid : 0;
        $averageActualGlobal = $totalDataActualValid > 0 ? $totalActualGlobal / $totalDataActualValid : 0;
        // return response()->json([
        //     'totals_per_unit' => $totals,
        //     'total_data_plan_valid' => $totalDataPlanValid,
        //     'total_data_actual_valid' => $totalDataActualValid,
        //     'average_plan_global' => $averagePlanGlobal,
        //     'average_actual_global' => $averageActualGlobal,
        // ]);


        return view('ewh_fuels.indexewh', compact('averageachGlobal', 'data', 'startDate', 'endDate', 'totals', 'perusahaans', 'companyId', 'averageActualGlobal', 'averagePlanGlobal'));
    }


    public function indexfuel(Request $request)
    {
        $user = Auth::user();

        $tahun = Carbon::now()->year;
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
        $queryewh = DB::table('fuels')
            ->join('code_unit', 'fuels.unit_id', '=', 'code_unit.id')
            ->join('users', 'fuels.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select('fuels.*', 'code_unit.code as code');
        if ($user->role !== 'admin') {
            $queryewh->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $queryewh->where('users.id_company', $companyId);
            } else {
                $queryewh->whereRaw('users.id_company', $companyId);
            }
        }
        if (!$startDate || !$endDate) {
            $startDate = Carbon::createFromDate($tahun, 1, 1)->startOfDay();
            $endDate = Carbon::createFromDate($tahun, 12, 31)->endOfDay();
        } else {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
        }
        $queryewh->whereBetween('fuels.date', [$startDate, $endDate]);


        $data = $queryewh->orderBy('code_unit.code')
            ->get()
            ->groupBy('code');
        $data->each(function ($items) {
            $items->each(function ($item) {
                $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
            });
        });
        $count = $queryewh->count();

        // Hitung totals per kategori
        $totals = $data->map(function ($items, $category) {
            $totalPlan = $items->sum(function ($item) {
                return (float) str_replace(',', '', $item->plan ?? 0);
            });
            $totalActual = $items->sum(function ($item) {
                return (float) str_replace(',', '', $item->actual ?? 0);
            });

            $jumlahDataPlanValid = $items->filter(function ($item) {
                return is_numeric(str_replace(',', '', $item->plan));
            })->count();

            $jumlahDataActualValid = $items->filter(function ($item) {
                return is_numeric(str_replace(',', '', $item->actual));
            })->count();

            $averagePlan = $jumlahDataPlanValid > 0 ? $totalPlan / $jumlahDataPlanValid : 0;
            $averageActual = $jumlahDataActualValid > 0 ? $totalActual / $jumlahDataActualValid : 0;
            $Ach = ($totalPlan != 0) ? floor(($totalActual / $totalPlan) * 10000) / 100 : 0;
            // dd($Ach);

            return [
                'totalAch' => $Ach,
                'units' => $category,
                'total_plan' => $totalPlan,
                'total_actual' => $totalActual,
                'details' => $items,
                'jumlah_data_plan_valid' => $jumlahDataPlanValid,
                'jumlah_data_actual_valid' => $jumlahDataActualValid,
                'average_plan' => $averagePlan,
                'average_actual' => $averageActual,
            ];
        });

        // Hitung total data valid plan dan actual dari semua data (flat)
        $allItems = $data->flatten();

        $totalDataPlanValid = $allItems->filter(function ($item) {
            return is_numeric(str_replace(',', '', $item->plan));
        })->count();

        $totalDataActualValid = $allItems->filter(function ($item) {
            return is_numeric(str_replace(',', '', $item->actual));
        })->count();
        $totalDataActualValid = $allItems->filter(function ($item) {
            return is_numeric(str_replace(',', '', $item->actual));
        })->count();

        $totalPlanGlobalfuels = $allItems->sum(function ($item) {
            return (float) str_replace(',', '', $item->plan ?? 0);
        });

        $totalActualGlobalfuels = $allItems->sum(function ($item) {
            return (float) str_replace(',', '', $item->actual ?? 0);
        });
        $totalAchGlobal = $allItems->sum(function ($item) {
            return (float) str_replace(',', '', $item->actual ?? 0);
        });
        $totalachGlobalFuel = ($totalPlanGlobalfuels != 0) ? floor(($totalActualGlobalfuels / $totalPlanGlobalfuels) * 10000) / 100 : 0;

        $averageachGlobalFuel = $count > 0 ? $totalachGlobalFuel / $count : 0;
        $averagePlanGlobalfuels = $totalDataPlanValid > 0 ? $totalPlanGlobalfuels / $totalDataPlanValid : 0;
        $averageActualGlobalfuels = $totalDataActualValid > 0 ? $totalActualGlobalfuels / $totalDataActualValid : 0;


        return view('ewh_fuels.indexfuel', compact('averagePlanGlobalfuels','averageActualGlobalfuels','data', 'startDate', 'endDate', 'totals', 'perusahaans', 'companyId','totalachGlobalFuel','averageachGlobalFuel'));
    }

    public function formewh()
    {
        $unit = CodeUnit::all();
        return view('ewh_fuels.addewh', compact('unit'));
    }
    public function formfuel()
    {
        $unit = CodeUnit::all();
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
        $unit = CodeUnit::all();
        $data = Ewh::findOrFail($id);
        return view('ewh_fuels.updatedataewh', compact('unit', 'data'));
    }
    public function formupdatefuel($id)
    {

        $unit = CodeUnit::all();
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
        $tahun = Carbon::now()->year;
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;
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


        if (!$startDate || !$endDate) {
            $startDate = Carbon::createFromDate($tahun, 1, 1)->startOfDay();
            $endDate = Carbon::createFromDate($tahun, 12, 31)->endOfDay();
        } else {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
        }
        $queryewh->whereBetween('pica_ewh_fuels.tanggal', [$startDate, $endDate]); // Tidak perlu menyebut nama tabel


        $data = $queryewh->get();


        return view('picaewhfuel.index', compact('startDate', 'endDate', 'data', 'perusahaans', 'companyId'));
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

    public function indexcodeunit(Request $request)
    {
        $user = Auth::user();
        $companyId = $request->input('company_id');

        $query = DB::table('code_unit')
            ->select('code_unit.*')
            ->join('users', 'code_unit.created_by', '=', 'users.username')
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
        return view('ewh_fuels.unit.index', compact('data'));
    }

    public function codeunit()
    {
        return view('ewh_fuels.unit.add');
    }

    public function createcodeunit(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:255',
        ]);

        $validatedData['created_by'] = auth()->user()->username;
        $data = CodeUnit::create($validatedData);
        HistoryLog::create([
            'table_name' => 'mining_readinesses',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        $redirectTo = $request->input('redirect_to');

        // redirect berdasarkan halaman sebelumnya
        if (!$redirectTo) {
            if (url()->previous() == route('indexewh')) {
                $redirectTo = route('indexewh');
            } elseif (url()->previous() == route('indexfuel')) {
                $redirectTo = route('indexfuel');
            } 
        }

        if ($request->input('action') == 'save') {
            return redirect($redirectTo)->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }
    public function formupdatecodeunit($id)
    {
        $data = CodeUnit::findOrFail($id);
        return view('ewh_fuels.unit.update', compact('data'));
    }

    public function updetedcodeunit(Request $request, $id)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:255',

        ]);
        $validatedData['updated_by'] = auth()->user()->username;
        $unit = CodeUnit::findOrFail($id);
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

        // redirect berdasarkan halaman sebelumnya
        if (!$redirectTo) {
            if (url()->previous() == route('indexewh')) {
                $redirectTo = route('indexewh');
            } elseif (url()->previous() == route('indexfuel')) {
                $redirectTo = route('indexfuel');
            } 
        }

        if ($request->input('action') == 'save') {
            return redirect($redirectTo)->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    
    }

    public function deletedcodeunit($id)
    {
        $data = CodeUnit::findOrFail($id);
        $oldData = $data->toArray();

        // Hapus data dari tabel 
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'code_unit',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect()->back()->with('success', 'Data deleted successfully.');
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
