<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\categoryLabarugi;
use App\Models\jenisLabarugi;
use App\Models\detailabarugi;
use App\Models\subkategoriLabarugi;
use App\Models\PicalabaRugi;
use App\Models\HistoryLog;
use Carbon\Carbon;

class DetailabarugiController extends Controller
{
    //detail
    public function labarugi(Request $request)
    {
        $user = Auth::user();

        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;
        $companyId = $request->input('id_company');
        $tahun = Carbon::now()->year;

        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $data = detailabarugi::paginate(10);
        $query = DB::table('detailabarugis')
            ->join('sub_labarugis', 'detailabarugis.sub_id', '=', 'sub_labarugis.id')
            ->join('category_labarugis', 'sub_labarugis.kategori_id', '=', 'category_labarugis.id')
            ->join('jenis_labarugis', 'category_labarugis.jenis_id', '=', 'jenis_labarugis.id')
            ->join('users', 'detailabarugis.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')

            ->select(
                'category_labarugis.namecategory as kategori_name',
                'category_labarugis.id as category_id',
                'category_labarugis.ordernumber',
                'jenis_labarugis.name as jenis_name',
                'jenis_labarugis.name',
                'sub_labarugis.id as sub_id',
                'sub_labarugis.namesub as name_sub',
                'detailabarugis.id as detail_id',
                'detailabarugis.*'

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

        $tahun = Carbon::now()->year;
        if (!$startDate || !$endDate) {
            $startDate = Carbon::createFromDate($tahun, 1, 1)->startOfDay();
            $endDate = Carbon::createFromDate($tahun, 12, 31)->endOfDay();
        } else {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
        }

        $query->whereBetween('detailabarugis.tanggal', [$startDate, $endDate]);

        // $query->orderBy('detailabarugis.tanggal', 'asc');
        $data = $query
            ->orderBy('jenis_labarugis.id', 'asc')
            ->orderBy('category_labarugis.ordernumber', 'asc')
            ->orderBy('sub_labarugis.ordernumber', 'asc')
            ->orderBy('detailabarugis.ordernumber', 'asc')
            ->get()

            ->groupBy(['jenis_name', 'kategori_name']);
        // dd($query->orderBy('jenis_neracas.created_at', 'asc')->get());

        $data->each(function ($items) {
            $items->each(function ($subItems) {
                $subItems->each(function ($item) {
                    $item->file_extension = isset($item->file) && $item->file !== null
                        ? pathinfo($item->file, PATHINFO_EXTENSION)
                        : null;
                });
            });
        });

        // dd($data);        

        $totalRevenuea = (clone $query)
            ->where('category_labarugis.namecategory', 'Revenue')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalactual ?? 0);
            });

        $totallkactual = (clone $query)
            ->join('category_labarugis AS cat1', 'sub_labarugis.kategori_id', '=', 'cat1.id')
            ->join('jenis_labarugis AS jenis1', 'cat1.jenis_id', '=', 'jenis1.id')

            ->where('jenis1.name', 'Gross Profit')
            ->where('cat1.namecategory', '!=', 'Revenue')
            ->get()
            ->sum(function ($item) {
                return (float) str_replace(',', '', $item->nominalactual ?? 0);
            });

        $totallkplan = (clone $query)
            ->join('category_labarugis AS cat1', 'sub_labarugis.kategori_id', '=', 'cat1.id')
            ->join('jenis_labarugis AS jenis1', 'cat1.jenis_id', '=', 'jenis1.id')
            ->where('jenis1.name', 'Gross Profit')
            ->where('cat1.namecategory', '!=', 'Revenue')
            ->get()
            ->sum(function ($item) {
                return (float) str_replace(',', '', $item->nominalplan ?? 0);
            });




        $totalRevenuep = (clone $query)
            ->where('category_labarugis.namecategory', 'Revenue')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalplan ?? 0);
            });
        //operasional
        $planoperasional = (clone $query)
            ->where('jenis_labarugis.name', 'Operating Profit')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalplan ?? 0);
            });
        $actualoperasional = (clone $query)
            ->where('jenis_labarugis.name', 'Operating Profit')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalactual ?? 0);
            });
        // dd($actualoperasional);

        //lababersih
        $planlb = (clone $query)
            ->where('jenis_labarugis.name', 'Net Profit')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalplan ?? 0);
            });
        // dd($planlb );

        $actuallb = (clone $query)
            ->where('jenis_labarugis.name', 'Net Profit')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalactual ?? 0);
            });
        // dd($actuallb );

        $totalnetprofitplan = (clone $query)
            ->where('jenis_labarugis.name', 'Net Profit')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalplan ?? 0);
            });
        $totalactualnetprofit = (clone $query)
            ->where('jenis_labarugis.name', 'Net Profit')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalactual ?? 0);
            });


        // $totalactualnetprofit = (clone $query)
        //     ->where('jenis_labarugis.name', 'Net Profit')
        //     ->orderBy('id')
        //     ->get()
        //     ->filter(function ($item) {
        //         return floatval(str_replace(',', '', $item->nominalactual)) != 0;
        //     })
        //     ->values() 
        //     ->reduce(function ($carry, $item) {
        //         $nominal = floatval(str_replace(',', '', $item->nominalactual));

        //         if (is_null($carry)) {
        //             return $nominal;
        //         }

        //         return $carry - $nominal;
        //     });



        // dd($totalnetprofitplan, $totalactualnetprofit);


        //laba rugi 
        $totalplanlr = $totalRevenuep - $totallkplan;
        $totalactuallr = $totalRevenuea - $totallkactual;
        $totalvertikal = ($totalRevenuep && $totalRevenuep != 0) ? round(($totalplanlr / $totalRevenuep) * 100, 2) : 0;
        $totalvertikals = ($totalRevenuea) ? round(($totalactuallr / $totalRevenuea) * 100, 2) : 0;
        $deviasilr = $totalplanlr - $totalactuallr;
        $persenlr = ($totalplanlr) ? round(($totalactuallr / $totalplanlr) * 100, 2) : 0;
        //operasional
        $totalplanlp = $totalplanlr - $planoperasional;
        $totalactualOp = $totalactuallr - $actualoperasional;
        $verticallp = ($totalRevenuep) ? round(($totalplanlp / $totalRevenuep) * 100, 2) : 0;
        $verticalsp = ($totalRevenuea) ? round(($totalactualOp / $totalRevenuea) * 100, 2) : 0;
        $deviasiop = $totalplanlp - $totalactualOp;
        $persenop = ($totalplanlp) ? round(($totalactualOp / $totalplanlp) * 100, 2) : 0;
        $vertikalplanop = ($totalRevenuep && $totalRevenuep != 0) ? round(($planoperasional / $totalRevenuep) * 100, 2) : 0;
        $vertikalactualop = ($totalRevenuea && $totalRevenuea != 0) ? round(($actualoperasional / $totalRevenuea) * 100, 2) : 0;
        // dd($vertikalactualop, $verticalsp,$actualoperasional,$totalRevenuep);
        $deviasitotalgeneral = $planoperasional - $actualoperasional;
        $persengeneralop = ($planoperasional) ? round(($actualoperasional / $planoperasional) * 100, 2) : 0;

        //lababersih
        // $totalplanlb = $totalplanlp - $planlb;
        $totalplanlb = floatval($totalplanlp ?? 0) - floatval($planlb ?? 0);
        // dd($totalplanlb,$totalplanlp,$planlb );

        $totalactuallb = $totalactuallr + -$actuallb - $actualoperasional;
        // dd($totalactualOp,$actualoperasional);
        $verticallb = ($totalRevenuep) ? round(($totalplanlb / $totalRevenuep) * 100, 2) : 0;
        $verticalslb = ($totalRevenuea) ? round(($totalactuallb / $totalRevenuea) * 100, 2) : 0;
        $deviasilb = $totalplanlb - $totalactuallb;
        $persenlb = ($totalplanlb) ? round(($totalactuallb / $totalplanlb) * 100, 2) : 0;
        $vertikalplanetprofit = ($totalRevenuep) ? round(($totalnetprofitplan / $totalRevenuep) * 100, 2) : 0;
        $vertalactualnetprofit = ($totalRevenuea) ? round(($totalactualnetprofit / $totalRevenuea) * 100, 2) : 0;
        // dd($vertalactualnetprofit,$totalactualnetprofit,$vertikalplanetprofit, $totalactuallb, $verticallb, $verticalslb, $persenlb);

        if ($totalRevenuea === 0 || !$totalRevenuea) {
            $totalRevenuea = null;
        }
        if ($totalRevenuep === 0 || !$totalRevenuep) {
            $totalRevenuep = null;
        }

        $totals = $data->map(function ($categories, $jenisName) use (&$totalRevenuep, &$totalRevenuea) {
            $categoryTotalPlan = 0;
            $categoryTotalActual = 0;
            // Grup berdasarkan kategori (kategori_name)
            $subCategories = $categories->map(function ($kategori, $kategoriName) use ($totalRevenuea, $totalRevenuep) {

                $subCategoryDetails = $kategori->groupBy('name_sub')->map(function ($items, $subCategory) use ($totalRevenuea, $totalRevenuep, &$categoryTotalPlan, &$categoryTotalActual) {
                    $totalPlan = $items->sum(function ($item) {
                        return (float)str_replace(',', '', $item->nominalplan ?? 0);
                    });
                    $totalActual = $items->sum(function ($item) {
                        return (float)str_replace(',', '', $item->nominalactual ?? 0);
                    });


                    // Menampilkan hasil
                    $categoryTotalPlan += $totalPlan;
                    $categoryTotalActual += $totalActual;

                    $deviation = $totalPlan - $totalActual;
                    $percentage = ($totalPlan != 0) ? round(($totalActual / $totalPlan) * 100, 2) : 0;
                    $vertikalanalisis = $totalRevenuep ? round(($totalPlan / $totalRevenuep) * 100, 2) : 0;
                    $vertikalanalisiss = $totalRevenuea ? round(($totalPlan / $totalRevenuea) * 100, 2) : 0;
                    // dd($categoryTotalPlan, $totalActual, $deviation,$totalPlan,$categoryTotalActual);

                    return [
                        'name_sub' => $subCategory,
                        'total_plan' => $totalPlan,
                        'total_actual' => $totalActual,
                        'vertikal' => $vertikalanalisis,
                        'deviation' => $deviation,
                        'percen' => $percentage,
                        'vertikals' => $vertikalanalisiss,
                        'details' => $items,


                    ];
                });

                return [
                    'kategori_name' => $kategoriName,
                    // 'total_plan' => $totalPlan,
                    // 'total_actual' => $totalActual,

                    'category_id' => $kategori->first()->category_id,  // Menambahkan category_id ke dalam hasil
                    'sub_categories' => $subCategoryDetails,
                    'total_plan' => $categoryTotalPlan,
                    'total_actual' => $categoryTotalActual,
                    'deviation' => $categoryTotalPlan - $categoryTotalActual,
                    'vertikal' => ($totalRevenuep) ? round(($categoryTotalPlan / $totalRevenuep) * 100, 2) : 0,
                    'vertikals' => ($totalRevenuea) ? round(($categoryTotalActual / $totalRevenuea) * 100, 2) : 0,
                    // 'percentage' => $percentage,
                    'percen' => ($categoryTotalPlan > 0) ? round((($categoryTotalPlan - $categoryTotalActual) / $categoryTotalPlan) * 100, 2) : 0,

                ];
            });

            return [
                'jenis_name' => $jenisName,
                'sub_categories' => $subCategories,
            ];
        });


        return view('labarugi.index', compact(
            'startDate',
            'endDate',
            'totalactualnetprofit',
            'vertikalplanetprofit',
            'vertalactualnetprofit',
            'totalnetprofitplan',
            'totals',
            'totalplanlr',
            'totalvertikal',
            'totalactuallr',
            'totalplanlp',
            'verticallp',
            'totalactualOp',
            'verticalsp',
            'persenlb',
            'deviasilb',
            'verticalslb',
            'deviasiop',
            'persenop',
            'deviasilr',
            'persenlr',
            'totalvertikals',
            'persenlb',
            'deviasilb',
            'verticalslb',
            'verticallb',
            'totalplanlb',
            'totalactuallb',
            'planoperasional',
            'actualoperasional',
            'perusahaans',
            'companyId',
            'vertikalplanop',
            'vertikalactualop',
            'deviasitotalgeneral',
            'persengeneralop',
        ));
    }

    public function formlabarugi()
    {
        $sub = subkategoriLabarugi::all();
        $sub = DB::table('sub_labarugis')
            ->join('category_labarugis', 'sub_labarugis.kategori_id', '=', 'category_labarugis.id')
            ->select('category_labarugis.namecategory', 'sub_labarugis.namesub', 'sub_labarugis.id')
            ->get();

        return view('labarugi.addData', compact('sub'));
    }

    //create laab rugi atau detail laba rugi
    public function createlabarugi(Request $request)

    {
        $validatedData = $request->validate([
            'nominalactual' => 'nullable|regex:/^-?[0-9.,]+$/',
            'nominalplan' => 'nullable|regex:/^-?[0-9.,]+$/',
            'sub_id' => 'required|string',
            'desc' => 'required|string',
            'tanggal' => 'required|date',
            'file' => 'nullable|file',
            'ordernumber' => 'nullable|numeric',


        ]);

        // Format nominal untuk menghapus koma
        $validatedData['nominalplan'] = isset($validatedData['nominalplan'])
            ? floatval(str_replace(',', '.', preg_replace('/[^\d.-]/', '', $validatedData['nominalplan'])))
            : null;

        $validatedData['nominalactual'] = isset($validatedData['nominalactual'])
            ? floatval(str_replace(',', '.', preg_replace('/[^\d.-]/', '', $validatedData['nominalactual'])))
            : null;



        //file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            $validatedData['file'] = $filePath;
        }

        // Tentukan mana yang diset null




        // Tambahkan created_by
        $validatedData['created_by'] = auth()->user()->username;

        // Simpan data ke database
        $data = detailabarugi::create($validatedData);
        HistoryLog::create([
            'table_name' => 'detailabarugis',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/labarugi')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }
    //category
    public function indexdesclr(Request $request)
    {
        $user = Auth::user();
        $companyId = $request->input('company_id');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();


        $query = DB::table('category_labarugis')
            ->select('category_labarugis.*', 'category_labarugis.id as category_id',)
            ->join('users', 'category_labarugis.created_by', '=', 'users.username')
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
            ->orderBy('category_labarugis.ordernumber ', 'asc')
            ->get();

        return view('labarugi.indexcategory', compact('kat', 'companyId', 'perusahaans'));
    }

    public function categorylabarugi()
    {
        $user = Auth::user();
        $kat = jenisLabarugi::all();
        return view('labarugi.categoryform', compact('kat'));
    }
    public function createkatlabarugi(Request $request)
    {
        $validatedData = $request->validate([
            'namecategory' => 'required|string',
            'jenis_id' => 'required|string',
            'ordernumber' => 'nullable|numeric',
        ]);
        $validatedData['created_by'] = auth()->user()->username;
        $data = categoryLabarugi::create($validatedData);
        HistoryLog::create([
            'table_name' => 'category_labarugis',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/labarugi')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }
    public function deletecategorylr($id)
    {
        $data = categoryLabarugi::findOrFail($id);
        $oldData = $data->toArray();

        // Hapus data dari tabel 
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'category_labarugis',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect()->back()->with('success', 'Data deleted successfully.');
    }

    //sub
    public function indexsublr(Request $request)
    {
        $user = Auth::user();
        $companyId = $request->input('company_id');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();


        $query = DB::table('sub_labarugis')
            ->select('sub_labarugis.*')
            ->join('users', 'sub_labarugis.created_by', '=', 'users.username')
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
            ->orderBy('sub_labarugis.id', 'asc')
            ->get();
        return view('labarugi.indexsub', compact('kat', 'companyId', 'perusahaans'));
    }
    public function sublr()
    {
        $user = Auth::user();
        $kat = categoryLabarugi::all();

        return view('labarugi.subform', compact('kat'));
    }
    public function createsub(Request $request)
    {
        $validatedData = $request->validate([
            'namesub' => 'required|string',
            'kategori_id' => 'required|string',
            'ordernumber' => 'nullable|numeric',

        ]);
        $validatedData['created_by'] = auth()->user()->username;
        $data = subkategoriLabarugi::create($validatedData);
        HistoryLog::create([
            'table_name' => 'sub_labarugis',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/labarugi')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }


    //pica
    public function picalr(Request $request)
    {
        $user = Auth::user();
        $tahun = Carbon::now()->year;
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $query = DB::table('picalaba_rugis')
            ->select('picalaba_rugis.*')
            ->join('users', 'picalaba_rugis.created_by', '=', 'users.username')
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
        if (!$startDate || !$endDate) {
            $startDate = Carbon::createFromDate($tahun, 1, 1)->startOfDay();
            $endDate = Carbon::createFromDate($tahun, 12, 31)->endOfDay();
        } else {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
        }
        $query->whereBetween('tanggal', [$startDate, $endDate]);


        $data = $query->get();

        return view('picakeuangan.index', compact('startDate', 'endDate', 'data', 'perusahaans', 'companyId'));
    }

    public function formpicalr()
    {
        $user = Auth::user();
        return view('picakeuangan.addData');
    }

    public function createpicalr(Request $request)
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
        $data = PicalabaRugi::create($validatedData);
        HistoryLog::create([
            'table_name' => 'picalaba_rugis',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/picalr')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function formupdatepicalr($id)
    {
        $data = PicalabaRugi::findOrFail($id);
        return view('picakeuangan.update', compact('data'));
    }

    public function updatepicalr(Request $request, $id)
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

        $data = PicalabaRugi::findOrFail($id);
        $oldData = $data->toArray();

        $data->update($validatedData);

        HistoryLog::create([
            'table_name' => 'picalaba_rugis',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        return redirect('/picalr')->with('success', 'Data saved successfully.');
    }
    //update PICA 
    public function formupdatelabarugi($id)
    {
        $sub = DB::table('sub_labarugis')
            ->join('category_labarugis', 'sub_labarugis.kategori_id', '=', 'category_labarugis.id')
            ->select('category_labarugis.namecategory', 'sub_labarugis.namesub', 'sub_labarugis.id')
            ->get();
        $data = detailabarugi::findOrFail($id);
        // dd($id);
        return view('labarugi.update.updatedetail', compact('data', 'sub'));
    }

    public function updatelabarugi(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nominalactual' => 'nullable|regex:/^-?[0-9.,]+$/',
            'nominalplan' => 'nullable|regex:/^-?[0-9.,]+$/',
            'sub_id' => 'required|string',
            'desc' => 'required|string',
            'tanggal' => 'required|date',
            'file' => 'nullable|file',
            'ordernumber' => 'nullable|numeric',


        ]);

        // Format nominal untuk menghapus koma
        $validatedData['nominalplan'] = isset($validatedData['nominalplan'])
            ? floatval(str_replace(',', '.', preg_replace('/[^\d.-]/', '', $validatedData['nominalplan'])))
            : null;

        $validatedData['nominalactual'] = isset($validatedData['nominalactual'])
            ? floatval(str_replace(',', '.', preg_replace('/[^\d.-]/', '', $validatedData['nominalactual'])))
            : null;
        //file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            $validatedData['file'] = $filePath;
        }
        // Tentukan mana yang diset null
        if ($request->has('nominalplan') && !$request->has('nominalactual')) {
            $validatedData['nominalactual'] = null;
        } elseif ($request->has('nominalactual') && !$request->has('nominalplan')) {
            $validatedData['nominalplan'] = null;
        }

        // Tambahkan created_by
        $validatedData['updated_by'] = auth()->user()->username;

        $detailabarugi = detailabarugi::findOrFail($id);
        $oldData = $detailabarugi->toArray();

        $detailabarugi->update($validatedData);

        HistoryLog::create([
            'table_name' => 'detaillabarugis',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);

        return redirect('/labarugi')->with('success', 'Data saved successfully.');
    }

    //updatecategory
    public function formupdatecategorylr($category_id)
    {
        $user = Auth::user();
        $kat = jenisLabarugi::all();
        $data = categoryLabarugi::findOrFail($category_id);

        return view('labarugi.update.updatecategory', compact('kat', 'data'));
    }
    public function updatecategorylr(Request $request, $id)
    {
        $validatedData = $request->validate([
            'namecategory' => 'required|string',
            'jenis_id' => 'required|string',
            'ordernumber' => 'nullable|numeric    ',

        ]);
        $validatedData['updated_by'] = auth()->user()->username;

        $categoryLabarugi = categoryLabarugi::findOrFail($id);
        $oldData = $categoryLabarugi->toArray();

        $categoryLabarugi->update($validatedData);

        HistoryLog::create([
            'table_name' => 'category_labarugis',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        return redirect('/labarugi')->with('success', 'Data saved successfully.');
    }

    //sublabarugi
    public function formupdatesublr($id)
    {
        $user = Auth::user();

        $kat = categoryLabarugi::all();
        $data = subkategoriLabarugi::findOrFail($id);

        return view('labarugi.update.updatesub', compact('kat', 'data'));
    }
    public function updatesublr(Request $request, $id)
    {
        $validatedData = $request->validate([
            'namesub' => 'required|string',
            'kategori_id' => 'required|string',
            'ordernumber' => 'nullable|numeric',

        ]);
        $validatedData['updated_by'] = auth()->user()->username;

        $subkategoriLabarugi = subkategoriLabarugi::findOrFail($id);
        $oldData = $subkategoriLabarugi->toArray();

        $subkategoriLabarugi->update($validatedData);

        HistoryLog::create([
            'table_name' => 'sub_labarugis',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        return redirect('/labarugi')->with('success', 'Data saved successfully.');
    }

    //delete
    public function deletedetaillr($id)
    {
        $data = detailabarugi::findOrFail($id);
        $oldData = $data->toArray();

        // Hapus data dari tabel 
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'detaillabarugis',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect('/labarugi')->with('success', 'Data deleted successfully.');
    }

    public function deletepicalr($id)
    {
        $data = Picalabarugi::findOrFail($id);
        $oldData = $data->toArray();

        // Hapus data dari tabel 
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'picalaba_rugis',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect('/picalr')->with('success', 'Data deleted successfully.');
    }

    public function deletesublr($id)
    {
        $data = subkategoriLabarugi::findOrFail($id);
        $oldData = $data->toArray();

        // Hapus data dari tabel 
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'sub_labarugis',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect()->back()->with('success', 'Data deleted successfully.');
    }
}
