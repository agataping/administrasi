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
use Termwind\Components\Dd;

class DetailNeracaController extends Controller
{
    //detail
    public function indexfinancial(Request $request)
    {
        $user = Auth::user();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
        // Query data
        $query = DB::table('detail_neracas')
            ->join('sub_neracas', 'detail_neracas.sub_id', '=', 'sub_neracas.id')
            ->join('category_neracas', 'sub_neracas.kategori_id', '=', 'category_neracas.id')
            ->join('users', 'detail_neracas.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select(
                'category_neracas.namecategory as category',
                'sub_neracas.namesub as sub_category',
                'detail_neracas.*',
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

        if ($startDate && $endDate) {
            $query->whereBetween('detail_neracas.tanggal', [$startDate, $endDate]);
        }
        $data = $query->orderBy('category_neracas.created_at', 'asc')
            ->get()

            ->groupBy('category');


        // $totalsAssets = $data->only(['CURRENT ASSETS', 'FIX ASSETS'])
        // ->map(function ($categories) {
        //     return $categories->sum('nominal');
        // })
        // ->sum();
        // $totalLiabilitas = $data->only(['EQUITY', 'LIABILITIES'])
        // ->map(function ($categories) {
        //     return $categories->sum('nominal');
        // })
        // ->sum();
        // //total control
        // $control= $totalLiabilitas - $totalsAssets;
        // // NILAI BENER JIKA 0
        // if ($control !== 0) {
        //     $note = "Salah: $control";
        // } else {
        //     $note = "Benar";
        // }
        $fixassettotal = (clone $query)
            ->where('category_neracas.namecategory', 'FIX ASSETS')
            ->get()
            ->reduce(function ($carry, $item) {
                return [
                    'credit'      => $carry['credit'] + (float)str_replace(',', '', $item->credit ?? 0),
                    'debit'       => $carry['debit'] + (float)str_replace(',', '', $item->debit ?? 0),
                    'credit_actual'  => $carry['credit_actual'] + (float)str_replace(',', '', $item->credit_actual ?? 0),
                    'debit_actual'   => $carry['debit_actual'] + (float)str_replace(',', '', $item->debit_actual ?? 0),
                ];
            }, ['credit' => 0, 'debit' => 0, 'credit_actual' => 0, 'debit_actual' => 0]);
        $currenasset = (clone $query)
            ->where('category_neracas.namecategory', 'CURRENT ASSETS')
            ->get()
            ->reduce(function ($carry, $item) {
                return [
                    'credit'         => $carry['credit'] + (float)str_replace(',', '', $item->credit ?? 0),
                    'debit'          => $carry['debit'] + (float)str_replace(',', '', $item->debit ?? 0),
                    'credit_actual'  => $carry['credit_actual'] + (float)str_replace(',', '', $item->credit_actual ?? 0),
                    'debit_actual'   => $carry['debit_actual'] + (float)str_replace(',', '', $item->debit_actual ?? 0), // Perbaikan disini!
                ];
            }, ['credit' => 0, 'debit' => 0, 'credit_actual' => 0, 'debit_actual' => 0]);
        // FIX ASSET hasil
        $totalcreditfixassetplan = $fixassettotal['credit'];
        $totaldebitfixassetplan = $fixassettotal['debit'];
        $totalcreditfixassetactual = $fixassettotal['credit_actual'];
        $totaldebitfixassetactual = $fixassettotal['debit_actual'];
        $totalplanfixasset = $totaldebitfixassetplan - $totalcreditfixassetplan; //plan (debit-credit)
        $totalactualfixasset = $totaldebitfixassetactual - $totalcreditfixassetactual; //actuall (debit-credit)

        // current asset hasil
        $creditcurrentassetplan = $currenasset['credit'];
        $debitcurrentassetplan = $currenasset['debit'];
        $creditcurrentassetactual = $currenasset['credit_actual'];
        $debitcurrentassetactual = $currenasset['debit_actual'];
        $totalplancurrentasset = $debitcurrentassetplan - $creditcurrentassetplan; //plan
        $totalactualcurrentasset = $debitcurrentassetactual - $creditcurrentassetactual; //actual
        //total LIABILITIES EQUITY 
        $totalplanasset = ($totalplancurrentasset < 0)
            ? $totalplanfixasset + $totalplancurrentasset
            : $totalplanfixasset - $totalplancurrentasset; //plan
        $totalactualasset = ($totalactualcurrentasset < 0)//actual
            ? $totalactualfixasset + $totalactualcurrentasset
            : $totalactualfixasset - $totalactualcurrentasset;

            // dd($fixassettotal,$currenasset, $totalplanasset, $totalactualasset,$totalactualcurrentasset,$totalactualfixasset);

        $liabilitestotal = (clone $query)
            ->where('category_neracas.namecategory', 'LIABILITIES')
            ->get()
            ->reduce(function ($carry, $item) {
                return [
                    'credit'      => $carry['credit'] + (float)str_replace(',', '', $item->credit ?? 0),
                    'debit'       => $carry['debit'] + (float)str_replace(',', '', $item->debit ?? 0),
                    'credit_actual'  => $carry['credit_actual'] + (float)str_replace(',', '', $item->credit_actual ?? 0),
                    'debit_actual'   => $carry['debit_actual'] + (float)str_replace(',', '', $item->debit_actual ?? 0),
                ];
            }, ['credit' => 0, 'debit' => 0, 'credit_actual' => 0, 'debit_actual' => 0]);
        $equatytotal = (clone $query)
            ->where('category_neracas.namecategory', 'EQUITY')
            ->get()
            ->reduce(function ($carry, $item) {
                return [
                    'credit'         => $carry['credit'] + (float)str_replace(',', '', $item->credit ?? 0),
                    'debit'          => $carry['debit'] + (float)str_replace(',', '', $item->debit ?? 0),
                    'credit_actual'  => $carry['credit_actual'] + (float)str_replace(',', '', $item->credit_actual ?? 0),
                    'debit_actual'   => $carry['debit_actual'] + (float)str_replace(',', '', $item->debit_actual ?? 0), // Perbaikan disini!
                ];
            }, ['credit' => 0, 'debit' => 0, 'credit_actual' => 0, 'debit_actual' => 0]);
        // LIABILITIES hasil
        $totalCreditliabilites = $liabilitestotal['credit'];
        $totalDebitliabilites = $liabilitestotal['debit'];
        $totalCreditactualliabilites = $liabilitestotal['credit_actual'];
        $totalDebitactualliabilites = $liabilitestotal['debit_actual'];
        $totalplanliabili = $totalCreditliabilites - $totalDebitliabilites; //plan
        $toalactualliabliti = $totalCreditactualliabilites - $totalDebitactualliabilites; //actuall

        // equaty hasil
        $totalCreditequaty = $equatytotal['credit'];
        $totalDebitequaty = $equatytotal['debit'];
        $totalCreditactualequaty = $equatytotal['credit_actual'];
        $totalDebitactualequaty = $equatytotal['debit_actual'];
        $totalplanequaty = $totalCreditequaty - $totalDebitequaty; //plan
        $totalactualequaty = $totalCreditactualequaty - $totalDebitactualequaty; //actual
        //total LIABILITIES EQUITY 
        $modalhutangplan = ($totalplanequaty < 0)
            ? $totalplanliabili + $totalplanequaty
            : $totalplanliabili - $totalplanequaty;
        $modalhutangactual = ($totalactualequaty < 0)
            ? $toalactualliabliti + $totalactualequaty
            : $toalactualliabliti - $totalactualequaty;

        // dd($totalCreditliabilites,$totalDebitliabilites, $totalplanliabili, $totalplanequaty, $totalCreditequaty, $totalDebitequaty,$modalhutangplan);

        $groupedData = $data->map(function ($categories, $categoryName) {
            $totalJenis = ['debit' => 0, 'credit' => 0];

            $categoriesGrouped = $categories->groupBy('sub_category')->map(function ($subItems, $subCategoryName) use (&$totalJenis) {
                // Konversi nilai ke float untuk perhitungan yang benar
                $subTotalDebit = $subItems->sum(fn($item) => (float) str_replace(',', '', $item->debit));
                $subTotalCredit = $subItems->sum(fn($item) => (float) str_replace(',', '', $item->credit));
                $subTotalDebitactual = $subItems->sum(fn($item) => (float) str_replace(',', '', $item->debit_actual));
                $subTotalCreditactual = $subItems->sum(fn($item) => (float) str_replace(',', '', $item->credit_actual));

                // Menambahkan ke total keseluruhan
                $totalJenis['debit'] += $subTotalDebit;
                $totalJenis['credit'] += $subTotalCredit;

                // Hitung Subtotal Plan dan Actual
                $subTotalplanasset = $subTotalDebit - $subTotalCredit;
                $subTotalSaldoActualasset = $subTotalDebitactual - $subTotalCreditactual;
                $subTotalplanmodalhutang = $subTotalCredit - $subTotalDebit;
                $subTotalSaldoActualmodalhutang = $subTotalCreditactual - $subTotalDebitactual;

                return [
                    'sub_category' => $subCategoryName,
                    'sub_id' => $subItems->first()->sub_id ?? null,
                    'sub_total_debit' => $subTotalDebit,
                    'sub_total_credit' => $subTotalCredit,
                    'sub_total_debitactual' => $subTotalDebitactual,
                    'sub_total_creditactual' => $subTotalCreditactual,
                    'subTotalplanasset' => $subTotalplanasset,
                    'subTotalSaldoActualasset' => $subTotalSaldoActualasset,
                    'subTotalplanmodalhutang' => $subTotalplanmodalhutang,
                    'subTotalSaldoActualmodalhutang' => $subTotalSaldoActualmodalhutang,

                    'details' => $subItems->map(function ($item) {
                        return [
                            'id' => $item->detail_id,
                            'name' => $item->name,
                            'tanggal' => $item->tanggal,
                            'debit' => (float) str_replace(',', '', $item->debit),
                            'credit' => (float) str_replace(',', '', $item->credit),
                            'debit_actual' => (float) str_replace(',', '', $item->debit_actual),
                            'credit_actual' => (float) str_replace(',', '', $item->credit_actual),
                            'fileplan' => $item->fileplan ?? null,
                            'fileactual' => $item->fileactual ?? null,
                        ];
                    }),
                ];
            });

            // Hitung total plan dan actual setelah perulangan selesai
            $subTotalplanasset = $totalJenis['debit'] - $totalJenis['credit'];
            $subTotalSaldoActualasset = array_sum(array_column($categoriesGrouped->toArray(), 'subTotalSaldoActualasset'));
            $subTotalplanmodalhutang = $totalJenis['credit'] - $totalJenis['debit'];
            $subTotalSaldoActualmodalhutang = array_sum(array_column($categoriesGrouped->toArray(), 'subTotalSaldoActualmodalhutang'));
            // dd($totalSaldoActualModalHutang) ;
            return [
                'category_name' => $categoryName,
                'total' => $totalJenis,
                'sub_categories' => $categoriesGrouped,
                'category_id' => $categories->first()->category_id,
                'subTotalplanasset' => in_array($categoryName, ['CURRENT ASSETS', 'FIX ASSETS']) ? $subTotalplanasset : null,
                'subTotalSaldoActualasset' => in_array($categoryName, ['CURRENT ASSETS', 'FIX ASSETS']) ? $subTotalSaldoActualasset : null,

                'subTotalplanmodalhutang' => in_array($categoryName, ['LIABILITIES', 'EQUITY']) ? $subTotalplanmodalhutang : null,
                'subTotalSaldoActualmodalhutang' => in_array($categoryName, ['LIABILITIES', 'EQUITY']) ? $subTotalSaldoActualmodalhutang : null,
            ];
        });
        // dd($groupedData);

        return view('financial.index', compact('groupedData', 'perusahaans', 'companyId', 'modalhutangactual', 'modalhutangplan','totalplanasset','totalactualasset'));
    }
    public function formfinanc(Request $request)
    {
        $sub = SubNeraca::all();
        $sub = DB::table('sub_neracas')
            ->join('category_neracas', 'sub_neracas.kategori_id', '=', 'category_neracas.id')
            ->select('category_neracas.namecategory', 'sub_neracas.namesub', 'sub_neracas.id')
            ->get();

        return view('financial.addData', compact('sub'));
    }

    public function createfinanc(Request $request)
    {
        $validatedData = $request->validate([
            'debit' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'credit' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'debit_actual' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'credit_actual' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
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

        function convertToCorrectNumber($value)
        {
            if ($value === '' || $value === null) {
                return 0; // Jika kosong, set ke 0
            }
            $value = str_replace('.', '', $value);  // Hapus titik pemisah ribuan
            $value = str_replace(',', '.', $value); // Ubah koma desimal ke titik (format internasional)
            return floatval($value); // Pastikan menjadi angka
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
            'debit' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'credit' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'debit_actual' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'credit_actual' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'fileactual' => 'nullable|file',
            'fileplan' => 'nullable|file',

            'name' => 'required|string',
            'sub_id' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        // Format nominal untuk menghapus koma
        function convertToCorrectNumber($value)
        {
            if ($value === '' || $value === null) {
                return 0;
            }
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
            return floatval($value);
        }
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
        return redirect('/indexfinancial')->with('success', 'Data berhasil disimpan.');
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

        $kat = $query->get();

        return view('financial.indexcategory', compact('kat', 'companyId', 'perusahaans'));
    }
    public function categoryneraca()
    {
        $user = Auth::user();
        return view('financial.categoryform');
    }

    public function createcategoryneraca(Request $request)
    {
        $validatedData = $request->validate([
            'namecategory' => 'required|string',
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
        $data = categoryneraca::FindOrFail($id);
        return view('financial.update.updatecategory', compact('data'));
    }

    public function updatecatneraca(Request $request, $id)
    {
        $validatedData = $request->validate([
            'namecategory' => 'required|string',
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
        return redirect('/indexfinancial')->with('success', 'Data berhasil disimpan.');
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
            ->select('sub_neracas.*')
            ->join('users', 'sub_neracas.created_by', '=', 'users.username')
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

        $kat = $query->get();

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

        return redirect('/indexfinancial')->with('success', 'Data berhasil disimpan.');
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
