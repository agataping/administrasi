<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\DetailNeraca;
use App\Models\CategoryNeraca;
use App\Models\SubNeraca;
use App\Models\HistoryLog;
use App\Models\JenisNeraca;
use Termwind\Components\Dd;
use Carbon\Carbon;

class DetailNeracaController extends Controller
{
    //detail
    public function indexfinancial(Request $request)
    {
        $user = Auth::user();

        $tahun = Carbon::now()->year;
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
        // Query data
        $query = DB::table('detail_neracas')
            ->join('sub_neracas', 'detail_neracas.sub_id', '=', 'sub_neracas.id')
            ->join('category_neracas', 'sub_neracas.kategori_id', '=', 'category_neracas.id')
            ->join('users', 'detail_neracas.created_by', '=', 'users.username')
            ->join('jenis_neracas', 'category_neracas.jenis_id', '=', 'jenis_neracas.id')

            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select(
                'category_neracas.namecategory as category',
                'category_neracas.*',

                'sub_neracas.namesub as sub_category',
                'detail_neracas.*',
                'jenis_neracas.name as jenis_name',
                'sub_neracas.id as sub_id',
                'category_neracas.id as category_id',
                'detail_neracas.id as detail_id'
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
        if (!$startDate || !$endDate) {
            $startDate = Carbon::createFromDate($tahun, 1, 1)->startOfDay();
            $endDate = Carbon::createFromDate($tahun, 12, 31)->endOfDay();
        } else {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
        }
        $query->whereBetween('detail_neracas.tanggal', [$startDate, $endDate]);


        $data = $query
            ->orderBy('jenis_neracas.id', 'asc')
            ->orderBy('sub_neracas.created_at', 'asc')
            ->orderBy('detail_neracas.created_at', 'asc')
            ->get()
            ->groupBy(['jenis_name', 'category', 'sub_category']);
        // dd($query->orderBy('jenis_neracas.created_at', 'asc')->get());


        $totalPerJenis = [];
        $totalPlan = [
            'current_asset' => 0,
            'fix_asset' => 0,
            'liabilities' => 0,
            'equity' => 0,
        ];
        $totalActual = [
            'current_asset' => 0,
            'fix_asset' => 0,
            'liabilities' => 0,
            'equity' => 0,
        ];


        $categoryTotals = []; // Untuk total kategori
        $subCategoryTotals = []; // Untuk total subkategori

        foreach ($data as $jenis_name => $categories) {
            $jenisClean = strtolower(trim($jenis_name));

            foreach ($categories as $category_name => $subcategories) {
                $categoryTotals[$category_name] = [
                    'debit' => 0,
                    'credit' => 0,
                    'debit_actual' => 0,
                    'credit_actual' => 0,
                ];


                foreach ($subcategories as $subcategory_name => $details) {

                    $subCategoryTotals[$subcategory_name] = [
                        'debit' => collect($details)->sum(fn($item) => (float) str_replace(',', '', $item->debit)),
                        'credit' => collect($details)->sum(fn($item) => (float) str_replace(',', '', $item->credit)),
                        'debit_actual' => collect($details)->sum(fn($item) => (float) str_replace(',', '', $item->debit_actual)),
                        'credit_actual' => collect($details)->sum(fn($item) => (float) str_replace(',', '', $item->credit_actual)),
                    ];

                    // Tambahkan total subkategori ke total kategori
                    $categoryTotals[$category_name]['debit'] += $subCategoryTotals[$subcategory_name]['debit'];
                    $categoryTotals[$category_name]['credit'] += $subCategoryTotals[$subcategory_name]['credit'];
                    $categoryTotals[$category_name]['debit_actual'] += $subCategoryTotals[$subcategory_name]['debit_actual'];
                    $categoryTotals[$category_name]['credit_actual'] += $subCategoryTotals[$subcategory_name]['credit_actual'];
                }
            }
            // dd($subCategoryTotals);

            // Hitung total berdasarkan kategori yang ada di jenis ini
            $totalDebit = collect($categoryTotals)->sum('debit');
            $totalCredit = collect($categoryTotals)->sum('credit');
            $totalDebitActual = collect($categoryTotals)->sum('debit_actual');
            $totalCreditActual = collect($categoryTotals)->sum('credit_actual');


            //total jenis asset
            $fixAssetTotals = (clone $query)
                ->where('jenis_neracas.name', 'fix assets')
                ->get()
                ->reduce(function ($totals, $item) {
                    $totals['debit'] += (float)str_replace(',', '', $item->debit ?? 0);
                    $totals['credit'] += (float)str_replace(',', '', $item->credit ?? 0);
                    $totals['debit_actual'] += (float)str_replace(',', '', $item->debit_actual ?? 0);
                    $totals['credit_actual'] += (float)str_replace(',', '', $item->credit_actual ?? 0);
                    return $totals;
                }, ['debit' => 0, 'credit' => 0, 'debit_actual' => 0, 'credit_actual' => 0]);

            $totalplanfixasset = $fixAssetTotals['debit'] - $fixAssetTotals['credit'];
            $totalactualfixtasset = $fixAssetTotals['debit_actual'] - $fixAssetTotals['credit_actual'];

            $currenassettotal = (clone $query)
                ->where('jenis_neracas.name', 'CURRENT ASSETS')
                ->get()
                ->reduce(function ($totals, $item) {
                    $totals['debit'] += (float)str_replace(',', '', $item->debit ?? 0);
                    $totals['credit'] += (float)str_replace(',', '', $item->credit ?? 0);
                    $totals['debit_actual'] += (float)str_replace(',', '', $item->debit_actual ?? 0);
                    $totals['credit_actual'] += (float)str_replace(',', '', $item->credit_actual ?? 0);
                    return $totals;
                }, ['debit' => 0, 'credit' => 0, 'debit_actual' => 0, 'credit_actual' => 0]);

            $totalplancurrentasset = $currenassettotal['debit'] - $currenassettotal['credit'];
            $totalactualcurrentasset = $currenassettotal['debit_actual'] - $currenassettotal['credit_actual'];

            $totalplanasset = $totalplanfixasset + $totalplancurrentasset; //plan asset
            $totalactualasset = $totalactualfixtasset + $totalactualcurrentasset; //actual asset

            //modal hutang
            $liabilititotal = (clone $query)
                ->where('jenis_neracas.name', 'LIABILITIES')
                ->get()
                ->reduce(function ($totals, $item) {
                    $totals['debit'] += (float)str_replace(',', '', $item->debit ?? 0);
                    $totals['credit'] += (float)str_replace(',', '', $item->credit ?? 0);
                    $totals['debit_actual'] += (float)str_replace(',', '', $item->debit_actual ?? 0);
                    $totals['credit_actual'] += (float)str_replace(',', '', $item->credit_actual ?? 0);
                    return $totals;
                }, ['debit' => 0, 'credit' => 0, 'debit_actual' => 0, 'credit_actual' => 0]);
            // dd($liabilititotal);
            $totalplanliabiliti = $liabilititotal['credit'] - $liabilititotal['debit'];
            // $totalactualliabiliti = $liabilititotal['debit_actual']  - $liabilititotal ['credit_actual'];
            $totalactualliabiliti = abs($liabilititotal['credit_actual'] - $liabilititotal['debit_actual']);

            $equitytotal = (clone $query)
                ->where('jenis_neracas.name', 'EQUITY')
                ->get()
                ->reduce(function ($totals, $item) {
                    $totals['debit'] += (float)str_replace(',', '', $item->debit ?? 0);
                    $totals['credit'] += (float)str_replace(',', '', $item->credit ?? 0);
                    $totals['debit_actual'] += (float)str_replace(',', '', $item->debit_actual ?? 0);
                    $totals['credit_actual'] += (float)str_replace(',', '', $item->credit_actual ?? 0);
                    return $totals;
                }, ['debit' => 0, 'credit' => 0, 'debit_actual' => 0, 'credit_actual' => 0]);

            $totalplanequity = abs($equitytotal['credit'] - $equitytotal['debit']);
            $totalactualequity = abs($equitytotal['credit_actual'] - $equitytotal['debit_actual']);
            $totalplanmodalhutang = abs($totalplanliabiliti + $totalplanequity); //plan
            $totalactualmodalhutang = abs($totalactualliabiliti + $totalactualequity); //actual
            // dd($totalplanmodalhutang,  $totalactualmodalhutang,$totalplanliabiliti , $totalplanequity);
            // Control Validasi Neraca
            $controlplan = round($totalplanmodalhutang - $totalplanasset);
            $controlactual = round($totalactualmodalhutang - $totalactualasset);

            $noteplan = $controlplan == 0 ? "Valid" : "Invalid: $controlplan";
            $noteactual = $controlactual == 0 ? "Valid" : "Invalid: $controlactual";
            // dd($controlactual, $noteactual, $totalactualmodalhutang, $totalactualliabiliti, $totalplanliabiliti);
        }
        return view('financial.index', compact(
            'totalplanfixasset',
            'totalactualfixtasset',
            'totalplancurrentasset',
            'totalactualcurrentasset',
            'totalplanasset',
            'totalactualasset',
            'totalplanliabiliti',
            'totalactualliabiliti',
            'totalplanequity',
            'totalactualequity',
            'totalplanmodalhutang',
            'totalactualmodalhutang',
            'noteplan',
            'noteactual',
            'categoryTotals',
            'subCategoryTotals',
            'data',
            'perusahaans',
            'startDate',
            'endDate',
            'companyId'
        ));
    }
    public function formfinanc(Request $request)
    {
        // $sub = SubNeraca::all();
        $sub = DB::table('sub_neracas')
            ->join('category_neracas', 'sub_neracas.kategori_id', '=', 'category_neracas.id')
            ->select('category_neracas.namecategory', 'sub_neracas.namesub', 'sub_neracas.id')
            ->get();

        return view('financial.addData', compact('sub'));
    }

    public function createfinanc(Request $request)
    {
        $validatedData = $request->validate([
            'debit' => 'nullable|regex:/^-?\d+(,\d+)?(\.\d{1,2})?$/',
            'credit' => 'nullable|regex:/^-?\d+(,\d+)?(\.\d{1,2})?$/',
            'debit_actual' => 'nullable|regex:/^-?\d+(,\d+)?(\.\d{1,2})?$/',
            'credit_actual' => 'nullable|regex:/^-?\d+(,\d+)?(\.\d{1,2})?$/',
            'fileactual' => 'nullable|file',
            'fileplan' => 'nullable|file',
            'name' => 'required|string',
            'sub_id' => 'required|string',
            'tanggal' => 'required|date',
        ]);
        if ($request->hasFile('fileactual')) {
            $fileActual = $request->file('fileactual');
            $fileActualPath = $fileActual->store('uploads', 'public');
            $validatedData['fileactual'] = $fileActualPath;
        }

        if ($request->hasFile('fileplan')) {
            $filePlan = $request->file('fileplan');
            $filePlanPath = $filePlan->store('uploads', 'public');
            $validatedData['fileplan'] = $filePlanPath;
        }




        $validatedData['debit'] = convertToCorrectNumber($validatedData['debit']);
        $validatedData['credit'] = convertToCorrectNumber($validatedData['credit']);
        $validatedData['debit_actual'] = convertToCorrectNumber($validatedData['debit_actual']);
        $validatedData['credit_actual'] = convertToCorrectNumber($validatedData['credit_actual']);
        // Tambahkan created_by
        $validatedData['created_by'] = auth()->user()->username;
        // Simpan data ke database
        $data = DetailNeraca::create($validatedData);
        HistoryLog::create([
            'table_name' => 'detail_neracas',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexfinancial')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function formupdatefinancial($id)
    {
        // $sub = DB::table('sub_neracas')
        //     ->join('category_neracas', 'sub_neracas.kategori_id', '=', 'category_neracas.id')
        //     ->select('category_neracas.namecategory', 'sub_neracas.namesub', 'sub_neracas.id')
        //     ->get();
        $sub = DB::table('sub_neracas')
            ->join('category_neracas', 'sub_neracas.kategori_id', '=', 'category_neracas.id')
            ->select('category_neracas.namecategory', 'sub_neracas.namesub', 'sub_neracas.id')
            ->get();

        $data = DetailNeraca::FindOrFail($id);
        return view('financial.update.updatedetail', compact('data', 'sub'));
    }

    public function updatedetailfinan(Request $request, $id)
    {
        $validatedData = $request->validate([
            'debit' => 'nullable|regex:/^-?\d+(,\d+)?(\.\d{1,2})?$/',
            'credit' => 'nullable|regex:/^-?\d+(,\d+)?(\.\d{1,2})?$/',
            'debit_actual' => 'nullable|regex:/^-?\d+(,\d+)?(\.\d{1,2})?$/',
            'credit_actual' => 'nullable|regex:/^-?\d+(,\d+)?(\.\d{1,2})?$/',
            'fileactual' => 'nullable|file',
            'fileplan' => 'nullable|file',

            'name' => 'required|string',
            'sub_id' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        // Format nominal untuk menghapus koma
        if ($request->hasFile('fileactual')) {
            $fileActual = $request->file('fileactual');
            $fileActualPath = $fileActual->store('uploads', 'public');
            $validatedData['fileactual'] = $fileActualPath;
        }

        if ($request->hasFile('fileplan')) {
            $filePlan = $request->file('fileplan');
            $filePlanPath = $filePlan->store('uploads', 'public');
            $validatedData['fileplan'] = $filePlanPath;
        }


        $validatedData['debit'] = convertToCorrectNumber($validatedData['debit']);
        $validatedData['credit'] = convertToCorrectNumber($validatedData['credit']);
        $validatedData['debit_actual'] = convertToCorrectNumber($validatedData['debit_actual']);
        $validatedData['credit_actual'] = convertToCorrectNumber($validatedData['credit_actual']);

        $validatedData['updated_by'] = auth()->user()->username;
        $data = DetailNeraca::findOrFail($id);
        $oldData = $data->toArray();

        $data->update($validatedData);


        HistoryLog::create([
            'table_name' => 'detailsneracas',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
        ]);
        return redirect('/indexfinancial')->with('success', 'Data saved successfully.');
    }

    //categori
    public function indexcategoryneraca(Request $request)
    {
        $user = Auth::user();
        $companyId = $request->input('company_id');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();


        $query = DB::table('category_neracas')
            ->select('category_neracas.*')
            ->join('users', 'category_neracas.created_by', '=', 'users.username')
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

        $kat = $query
        ->orderBy('category_neracas.id', 'asc')

        ->get();

        return view('financial.indexcategory', compact('kat', 'companyId', 'perusahaans'));
    }
    public function categoryneraca()
    {
        $user = Auth::user();
        $kat = JenisNeraca::all();
        return view('financial.categoryform', compact('kat'));
    }

    public function createcategoryneraca(Request $request)
    {
        $validatedData = $request->validate([
            'namecategory' => 'required|string',
            'jenis_id' => 'required|string',
        ]);
        $validatedData['created_by'] = auth()->user()->username;
        $data = CategoryNeraca::create($validatedData);
        HistoryLog::create([
            'table_name' => 'category_neracas',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexfinancial')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function formupdatecatneraca($id)
    {
        $kat = JenisNeraca::all();
        $data = categoryneraca::FindOrFail($id);
        return view('financial.update.updatecategory', compact('data', 'kat'));
    }

    public function updatecatneraca(Request $request, $id)
    {
        $validatedData = $request->validate([
            'namecategory' => 'required|string',
            'jenis_id' => 'required|string',

        ]);
        $validatedData['updated_by'] = auth()->user()->username;
        $data = CategoryNeraca::findOrFail($id);
        $oldData = $data->toArray();

        $data->update($validatedData);

        HistoryLog::create([
            'table_name' => 'category_neracas',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
        ]);
        return redirect('/indexfinancial')->with('success', 'Data saved successfully.');
    }
    public function deltecategoryneraca($id)
    {
        $data = CategoryNeraca::findOrFail($id);
        $oldData = $data->toArray();

        // Hapus data dari tabel 
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'category_neracas',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect()->back()->with('success', 'Data deleted successfully.');
    }

    //sub
    public function indexsubneraca(Request $request)
    {
        $user = Auth::user();
        $companyId = $request->input('company_id');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();


        $query = DB::table('sub_neracas')
            ->join('category_neracas', 'sub_neracas.kategori_id', '=', 'category_neracas.id')
            ->join('users', 'sub_neracas.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select('sub_neracas.*', 'category_neracas.namecategory as nama_kategori');

        if ($user->role !== 'admin') {
            $query->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $query->where('users.id_company', $companyId);
            } else {
                $query->whereRaw('users.id_company', $companyId);
            }
        }

        $kat = $query
        ->orderBy('sub_neracas.id', 'asc')
        ->get();

        return view('financial.indexsub', compact('kat', 'companyId', 'perusahaans'));
    }
    public function subneraca()
    {
        $user = Auth::user();
        $kat = CategoryNeraca::all();
        return view('financial.subform', compact('kat'));
    }

    public function createsubneraca(Request $request)
    {
        $validatedData = $request->validate([
            'namesub' => 'required|string',
            'kategori_id' => 'required|string',
        ]);
        $validatedData['created_by'] = auth()->user()->username;
        $data = SubNeraca::create($validatedData);
        HistoryLog::create([
            'table_name' => 'sub_neracas',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexfinancial')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function formupdatesubneraca($id)
    {
        $kat = CategoryNeraca::all();
        $data = SubNeraca::FindorFail($id);

        return view('financial.update.updatesub', compact('data', 'kat'));
    }

    public function updatesubneraca(Request $request, $id)
    {
        $validatedData = $request->validate([
            'namesub' => 'required|string',
            'kategori_id' => 'required|string',
        ]);
        $validatedData['updated_by'] = auth()->user()->username;
        $data = SubNeraca::findOrFail($id);
        $oldData = $data->toArray();

        $data->update($validatedData);

        HistoryLog::create([
            'table_name' => 'sub_neracas',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
        ]);

        return redirect('/indexfinancial')->with('success', 'Data saved successfully.');
    }

    public function deletefinancial($id)
    {
        $data = DetailNeraca::findOrFail($id);
        $oldData = $data->toArray();

        // Hapus data dari tabel 
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'detailneracas',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect('/indexfinancial')->with('success', 'Data deleted successfully.');
    }

    public function deletesubfinan($id)
    {
        $data = SubNeraca::findOrFail($id);
        $oldData = $data->toArray();

        // Hapus data dari tabel 
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'sub_neracas',
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
