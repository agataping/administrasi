<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class persentaseCompany
{
    public function DataReport(Request $request, $companyid)
    {


        $user = Auth::user();
        $companyName = DB::table('users')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select('perusahaans.nama as company_name')
            ->where('users.id', $user->id)
            ->first();

        if (!$companyName) {
            // return response()->json(['message' => 'Perusahaan tidak ditemukan'], 404);
        }

        //neraca
        // $tahun = $request->input('tahun', session('tahun'));
        // $tahun = $request->input('tahun', date('Y'));
        $tahun = $request->input('tahun', date('Y'));
        // $companyid = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
        if ($tahun) {
            session(['tahun' => $tahun]);
        }
        session(['tahun' => $tahun]);


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
            )
            ->where('users.id_company', $companyid);
        if ($tahun) {
            $query->whereBetween('detail_neracas.tanggal', ["$tahun-01-01", "$tahun-12-31"]);
        }

        $data = $query->orderBy('jenis_neracas.created_at', 'asc')
            ->get()
            ->groupBy(['jenis_name', 'category', 'sub_category']);


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
        // dd( $totalplanasset);
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

        $totalplanliabiliti = $liabilititotal['credit'] - $liabilititotal['debit'];
        // $totalactualliabiliti =  $liabilititotal['debit_actual']-$liabilititotal['credit_actual'] ;
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
        $totalactualmodalhutang = $totalactualliabiliti + $totalactualequity; //actual
        $planlavarge = $totalplanequity ? round(($totalplanliabiliti / $totalplanequity) * 100, 2) : 0;
        $actuallavarge = $totalactualequity ? round(($totalactualliabiliti / $totalactualequity) * 100, 2) : 0;

        // dd($totalactualliabiliti,  $totalactualequity);


        $query = DB::table('detailabarugis')
            ->join('sub_labarugis', 'detailabarugis.sub_id', '=', 'sub_labarugis.id')
            ->join('category_labarugis', 'sub_labarugis.kategori_id', '=', 'category_labarugis.id')
            ->join('jenis_labarugis', 'category_labarugis.jenis_id', '=', 'jenis_labarugis.id')
            ->leftJoin('users', 'detailabarugis.created_by', '=', 'users.username')
            ->select(
                'category_labarugis.namecategory as kategori_name',
                'jenis_labarugis.name as jenis_name',
                'category_labarugis.id as category_id',
                'detailabarugis.nominalplan',
                'detailabarugis.nominalactual'
            )

            ->where('users.id_company', $companyid);
        if (!empty($tahun)) {
            $query->whereBetween('detailabarugis.tanggal', ["$tahun-01-01", "$tahun-12-31"]);
        }
        $data = $query->get()->groupBy(['jenis_name', 'kategori_name']);
        // Menghitung Total Revenue untuk actual dan plan
        $totalRevenuea = (clone $query)
            ->where('category_labarugis.namecategory', 'Revenue')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalactual ?? 0);
            });

        $totalRevenuep = (clone $query)
            ->where('category_labarugis.namecategory', 'Revenue')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalplan ?? 0);
            });
        //cogs
        $totalactualcogas = (clone $query)
            ->where('category_labarugis.namecategory', 'Cost of Goods Sold')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalactual ?? 0);
            });
        $totalplancogas = (clone $query)
            ->where('category_labarugis.namecategory', 'LIKE', '%Cost of Goods Sold%')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalplan ?? 0);
            });
        $actualcogs = $totalRevenuea ? round(($totalactualcogas / $totalRevenuea) * 100, 2) : 0;
        $plancogs = $totalRevenuep ? round(($totalplancogas / $totalRevenuep) * 100, 2) : 0;
        // dd($query->where('category_labarugis.namecategory', 'Cost of Goods Sold')->get());

        // dd($plancogs,$totalplancogas,$totalRevenuep);
        //cost of employe
        $totactualsalary = (clone $query)
            ->whereIn('category_labarugis.namecategory', ['Salary', 'Biaya Gaji'])
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', trim($item->nominalactual ?? 0));
            });

        $totplansalary = (clone $query)
            ->whereIn('category_labarugis.namecategory', ['Salary', 'Biaya Gaji'])
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', trim($item->nominalplan ?? 0));
            });

        $actualcoe = $totalRevenuea ? round(($totactualsalary / $totalRevenuea) * 100, 2) : 0;
        $plancoe = $totalRevenuep ? round(($totplansalary / $totalRevenuep) * 100, 2) : 0;

        //csr
        // $totactualscsr = (clone $query)
        //     // ->where(function ($q) {
        //     //     $q->where('category_labarugis.namecategory', 'like', '%CSR%')
        //     //         ->orWhere('category_labarugis.namecategory', 'like', '%PPM%')
        //     //         ->orWhere('category_labarugis.namecategory', 'like', '%Sosial%');
        //     // })
        //     ->whereRaw("category_labarugis.namecategory COLLATE utf8mb4_general_ci LIKE ?", ['%CSR%'])

        //     ->get()
        //     ->sum(function ($item) {
        //         return (float)str_replace(',', '', $item->nominalactual ?? 0);
        //     });
        $totactualscsr = (clone $query)
            ->where(function ($q) {
                $q->where('category_labarugis.namecategory', 'like', '%CSR%')
                    ->orWhere('category_labarugis.namecategory', 'like', '%PPM%')
                    ->orWhere('category_labarugis.namecategory', 'like', '%Sosial%')
                    ->orWhere('sub_labarugis.namesub', 'like', '%CSR%')
                    ->orWhere('sub_labarugis.namesub', 'like', '%PPM%')
                    ->orWhere('sub_labarugis.namesub', 'like', '%Sosial%');
            })
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalactual ?? 0);
            });
        $totplanscsr = (clone $query)
            ->where(function ($q) {
                $q->where('category_labarugis.namecategory', 'like', '%CSR%')
                    ->orWhere('category_labarugis.namecategory', 'like', '%PPM%')
                    ->orWhere('category_labarugis.namecategory', 'like', '%Sosial%')
                    ->orWhere('sub_labarugis.namesub', 'like', '%CSR%')
                    ->orWhere('sub_labarugis.namesub', 'like', '%PPM%')
                    ->orWhere('sub_labarugis.namesub', 'like', '%Sosial%');
            })
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalplan ?? 0);
            });

        // dd($totplanscsr, $totactualscsr);

        $actualcsr = $totalRevenuea ? round(($totactualscsr / $totalRevenuea) * 100, 2) : 0;
        $plancsr = $totalRevenuep ? round(($totplanscsr / $totalRevenuep) * 100, 2) : 0;
        // dd($plancsr);
        // Menghitung Profit Margin (Laba Kotor)
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
        // Menghitung Operating Profit (Laba Operasional)
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
        // Menghitung Net Profit (Laba Bersih)
        $planlb = (clone $query)
            ->where('jenis_labarugis.name', 'Net Profit')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalplan ?? 0);
            });

        $actuallb = (clone $query)
            ->where('jenis_labarugis.name', 'Net Profit')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalactual ?? 0);
            });

        $totalplanlr = $totalRevenuep - $totallkplan;
        $totalactuallr = $totalRevenuea - $totallkactual;
        $totalvertikal = ($totalplanlr && $totalRevenuep > 0) ? round(($totalplanlr / $totalRevenuep) * 100, 2) : 0;
        $totalvertikals = ($totalRevenuea > 0) ? round(($totalactuallr / $totalRevenuea) * 100, 2) : 0;
        $deviasilr = $totalplanlr - $totalactuallr;
        $persenlr = $totalplanlr ? round(($totalactuallr / $totalplanlr) * 100, 2) : 0;
        // dd($actualoppersen);
        //operating profit
        $totalplanlp = $totalplanlr - $planoperasional;
        $totalactualOp = $totalactuallr - $actualoperasional;
        $verticallp = $totalRevenuep ? round(($totalplanlp / $totalRevenuep) * 100, 2) : 0;
        $verticalop = $totalRevenuea ? round(($totalactualOp / $totalRevenuea) * 100, 2) : 0;
        // $vertikalactualop = ($totalRevenuea && $totalRevenuea != 0) ? round(($actualoperasional / $totalRevenuea) * 100, 2) : 0;
        // dd($totalplanlp);
        // dd($totalRevenuea,$totalactualOp,$verticalop);
        $deviasiop = $totalplanlp - $totalactualOp;
        $persenop = $totalplanlp ? round(($totalactualOp / $totalplanlp) * 100, 2) : 0;
        //operasional
        $planoppersen = $totalRevenuep ? round(($planoperasional / $totalRevenuep) * 100, 2) : 0;
        $actualoppersen = $totalRevenuep ? round(($actualoperasional / $totalRevenuea) * 100, 2) : 0;
        // dd($actualoppersen);

        //lababersih
        $totalplanlb = floatval($totalplanlp ?? 0) - floatval($planlb ?? 0);
        $totalactuallb = $totalactuallr +  -$actuallb - $actualoperasional;
        $verticallb = ($totalRevenuep) ? round(($totalplanlb / $totalRevenuep) * 100, 2) : 0;

        $verticallb = $totalRevenuep ? round(($totalplanlb / $totalRevenuep) * 100, 2) : 0; //plan
        $verticalslb = $totalRevenuea ? round(($totalactuallb / $totalRevenuea) * 100, 2) : 0; //actual
        $deviasilb = $totalplanlb - $totalactuallb;
        $persenlb = $totalplanlb ? round(($totalactuallb / $totalplanlb) * 100, 2) : 0;
        $vertikalplanetprofit = ($totalRevenuep) ? round(($totalnetprofitplan / $totalRevenuep) * 100, 2) : 0;
        $vertalactualnetprofit = ($totalRevenuea) ? round(($totalactualnetprofit / $totalRevenuea) * 100, 2) : 0;

        // Mengatur nilai null jika total revenue adalah 0 atau null
        if ($totalRevenuea === 0 || !$totalRevenuea) {
            $totalRevenuea = null;
        }
        if ($totalRevenuep === 0 || !$totalRevenuep) {
            $totalRevenuep = null;
        }
        //kpi jtn & pengukuran 
        //total ongkosplan dan ongkos actual financial
        $ongkosactual = $totalRevenuea + $totalactualcogas + $totalactuallr + $totactualsalary
            + $totactualscsr + $actualoperasional + $totalactualOp + $totalactualnetprofit + $totalactualasset + $totalactualequity;
        // dd([
        //     'totalRevenuea' => $totalRevenuea,
        //     'totalactualcogas' => $totalactualcogas,
        //     'totallkactual' => $totalactuallr,
        //     'totactualsalary' => $totactualsalary,
        //     'totactualscsr' => $totactualscsr,
        //     'actualoperasional' => $actualoperasional,
        //     'totalactualOp' => $totalactualOp,
        //     'actuallb' => $totalactualnetprofit,
        //     'totalactualasset' => $totalactualasset,
        //     'totalactualmodalhutang' => $totalactualmodalhutang,$totalactualliabiliti,$totalactualequity,
        //     'ongkosactual (total semua)' => $ongkosactual,
        // ]);

        // (total seluruh plan) yang belum - Return On Assets - Return On Equity 
        $ongkosplan = $totalRevenuep + $totalplancogas + $totalplanlr +
            $totplansalary + $totplanscsr + $planoperasional + $totalplanlp + $totalnetprofitplan + $totalplanasset + $totalplanequity;  // (total seluruh plan) yang belum - Return On Assets - Return On Equity */
        // dd([
        //     'totalRevenuep' => $totalRevenuep,
        //     'totalplancogas' => $totalplancogas,
        //     'totallkplan' => $totalplanlr,
        //     'totplansalary' => $totplansalary,
        //     'totplanscsr' => $totplanscsr,
        //     'planoperasional' => $planoperasional,
        //     'totalplanlp' => $totalplanlp,
        //     'planlb' => $totalnetprofitplan,
        //     'roa' => $totalplanasset,
        //     'totalplanmodalhutang' => $totalplanmodalhutang,
        //     'ongkosplan (total semua)' => $ongkosplan,
        // ]);

        // Perhitungan persen revenue dan weight (plan)

        $planreturnonasset = ($totalplanasset != 0) ? round(($totalplanlb / $totalplanasset) * 100, 2) : 0;/* asset*/
        $persenassetplan = ($ongkosplan != 0) ? round(($totalplanasset / $ongkosplan) * 100, 2) : 0;/* asset*/
        $weightasset = round(($persenassetplan / 35.00) * 100, 2);
        // dd( $weightasset,$totalplanasset,$ongkosplan,$persenassetplan);


        $persenreturnonequity = ($totalplanequity  != 0) ? round(($totalplanlb / $totalplanequity) * 100, 2) : 0;/* libili equaity*/
        $persenmodalhutangplan = ($ongkosplan != 0) ? round(($totalplanequity / $ongkosplan) * 100, 2) : 0;/* asset*/
        $weightmodalhutang = round(($persenmodalhutangplan / 35.00) * 100, 2);
        // dd( $weightmodalhutang,$persenmodalhutangplan,$ongkosplan,$totalplanmodalhutang);

        $persenrevenue = ($ongkosplan != 0) ? round(($totalRevenuep / $ongkosplan) * 100, 2) : 0;/* revenue*/
        $weightrevenue = round(($persenrevenue / 35.00) * 100, 2);
        $persencogs = ($ongkosplan != 0) ? round(($totalplancogas / $ongkosplan) * 100, 2) : 0;/* cogs*/
        $weightcogs = round(($persencogs / 35.00) * 100, 2);
        $persenprofitmargin = ($ongkosplan != 0) ? round(($totalplanlr / $ongkosplan) * 100, 2) : 0;/* profit margin*/
        $weightprofitmargin = round(($persenprofitmargin / 35.00) * 100, 2);
        // dd( $weightprofitmargin,$persenprofitmargin,$ongkosplan,$totalplanlr);

        $persencostemploye = ($ongkosplan != 0) ? round(($totplansalary / $ongkosplan) * 100, 2) : 0;/* saleri cost employe*/
        $weightcostemploye = round(($persencostemploye / 35.00) * 100, 2);
        $persencsr = ($ongkosplan != 0) ? round(($totplanscsr / $ongkosplan) * 100, 2) : 0;/* csr*/
        $weightcsr = round(($persencsr / 35.00) * 100, 2);
        // dd($totplanscsr,$ongkosplan,$persencsr);
        // dd($ongkosplan);

        $persenopratingcost = ($ongkosplan != 0) ? round(($planoperasional / $ongkosplan) * 100, 2) : 0;/*operasional cost*/
        $weightopratingcost = round(($persenopratingcost / 35.00) * 100, 2);
        $persenoperatingprofitmargin = ($ongkosplan != 0) ? round(($totalplanlp / $ongkosplan) * 100, 2) : 0;/* opersional profit mg*/
        $weightopratingmg = round(($persenoperatingprofitmargin / 35.00) * 100, 2);
        $persennetprofitmargin = ($ongkosplan != 0) ? round(($totalnetprofitplan / $ongkosplan) * 100, 2) : 0;/*net profit*/
        $weightnetprofitmargin = round(($persennetprofitmargin / 35.00) * 100, 2);
        $totalpercenfinancial = $persenassetplan + $persenmodalhutangplan + $persenrevenue + $persencogs + $persenprofitmargin + $persencostemploye + $persencsr + $persenopratingcost + $persenoperatingprofitmargin + $persennetprofitmargin;

        // Perhitungan persen actual dan index result (index * weight)
        $actualreturnonasset = ($ongkosactual != 0) ? round(($totalactualasset / $ongkosactual) * 100, 2) : 0;/* asset*/
        $persenactualasset = ($totalactualasset != 0) ? round(($totalactuallb / $totalactualasset) * 100, 2) : 0;/* asset*/
        $indexactualasset = ($actualreturnonasset != 0) ? round(($persenassetplan / $actualreturnonasset) * 100, 2) : 0;
        // dd( $actualreturnonasset,$indexactualasset,$ongkosactual,$totalactualasset);

        $resultasset = round($indexactualasset * ($weightasset / 100), 2);
        $actualreturnonequaity = ($ongkosactual != 0) ? round(($totalactualequity / $ongkosactual) * 100, 2) : 0;/* liabiliti equity*/
        $persenactualmodalhutang = ($totalactualequity != 0) ? round(($totalactuallb / $totalactualequity) * 100, 2) : 0;/* liabiliti equity*/

        $indexmodalhutangactual = ($actualreturnonequaity != 0) ? round(($persenmodalhutangplan / $actualreturnonequaity) * 100, 2) : 0;
        // $indexmodalhutangactual = ($persenmodalhutangplan != 0) ? round(($actualreturnonequaity / $persenmodalhutangplan) * 100, 2) : 0;
        // dd( $indexmodalhutangactual,$persenmodalhutangplan,$actualreturnonequaity,$persenmodalhutangplan);

        // dd($indexmodalhutangactual,$actualreturnonequaity,$persenmodalhutangplan);
        $resultequity = round($indexmodalhutangactual * ($weightmodalhutang / 100), 2);
        $persenactualrevenue = ($ongkosactual != 0) ? round(($totalRevenuea / $ongkosactual) * 100, 2) : 0; /* revenue*/
        $indexrevenue = ($persenrevenue != 0) ? round(($persenactualrevenue / $persenrevenue) * 100, 2) : 0;
        // dd($indexrevenue,$persenactualrevenue,$persenrevenue,$totalRevenuep,$ongkosplan);
        $resultrevenue = round($indexrevenue *  ($weightrevenue / 100), 2);
        $persenactualcogs = ($ongkosactual != 0) ? round(($totalactualcogas / $ongkosactual) * 100, 2) : 0;/* cogs*/
        $indexcogs = ($persencogs != 0) ? round(($persenactualcogs / $persencogs) * 100, 2) : 0;
        $resultcogs = round($indexcogs * ($weightcogs / 100), 2);
        $persenactualprofitmg = ($ongkosactual != 0) ? round(($totalactuallr / $ongkosactual) * 100, 2) : 0;/* profit margin*/
        $indexprofitmg = ($persenprofitmargin != 0) ? round(($persenactualprofitmg / $persenprofitmargin) * 100, 2) : 0;
        // dd($totalactuallr,$indexprofitmg,$persenprofitmargin,$persenactualprofitmg,$totalRevenuep,$ongkosplan);

        $resultoperatingpm = round($indexprofitmg * ($weightprofitmargin / 100), 2);
        $pserenactualcostemploye = ($ongkosactual != 0) ? round(($totactualsalary / $ongkosactual) * 100, 2) : 0;/* saleri cost employe*/
        $indexcostemlpoye = ($persencostemploye != 0) ? round(($pserenactualcostemploye / $persencostemploye) * 100, 2) : 0;
        $resultemploye = round($indexcostemlpoye * ($weightcostemploye / 100), 2);
        $persenactualcsr = ($ongkosactual != 0) ? round(($totactualscsr / $ongkosactual) * 100, 2) : 0;/* csr*/
        $indexcsr = ($persencsr != 0) ? round(($persenactualcsr / $persencsr) * 100, 2) : 0;
        $resultcsr = round($indexcsr *  ($weightcsr / 100), 2);
        // dd($indexcsr,$persencsr,$persenactualcsr);
        $persenactualoperatincost = ($ongkosactual != 0) ? round(($actualoperasional / $ongkosactual) * 100, 2) : 0;/*operasional cost*/
        $indexoperatingcost = ($persenopratingcost != 0) ? round(($persenactualoperatincost / $persenopratingcost) * 100, 2) : 0;
        $ressultoperasionalcost = round($indexoperatingcost * ($weightopratingcost / 100), 2);
        $persenactualoperasionalpmg = ($ongkosactual != 0) ? round(($totalactualOp / $ongkosactual) * 100, 2) : 0;/* opersional profit mg*/
        $indexoperasionalpmg = ($persenoperatingprofitmargin != 0) ? round(($persenactualoperasionalpmg / $persenoperatingprofitmargin) * 100, 2) : 0;
        $resultgrosspm = round($indexoperasionalpmg * ($weightopratingmg / 100), 2);
        $persenactualnetprofitmg = ($ongkosactual != 0) ? round(($actuallb / $ongkosactual) * 100, 2) : 0;/*net profit*/
        $indexnetprofitmg = ($persennetprofitmargin != 0) ? round(($persenactualnetprofitmg / $persennetprofitmargin) * 100, 2) : 0;
        $resultnetpm = round($indexnetprofitmg * ($weightnetprofitmargin / 100), 2);
        //financial perspectif 
        $totalindexfinancial = $resultrevenue + $resultcogs + $resultemploye + $resultcsr + $resultgrosspm + $ressultoperasionalcost + $resultoperatingpm + $resultnetpm + $resultasset + $resultequity;
        $totalresultfinancial = round(($totalindexfinancial / 35.00) * 100, 2);
        // dd($totalresultfinancial,$totalindexfinancial, $resultrevenue , $resultcogs , $resultemploye , $resultcsr , $resultgrosspm , $ressultoperasionalcost , $resultoperatingpm , $resultnetpm , $resultasset , $resultequity,);
        $totalopersenactualfinancial = $persenactualasset + $actualreturnonequaity + $persenactualrevenue + $persenactualcogs + $persenactualprofitmg + $pserenactualcostemploye + $persenactualcsr + $persenactualoperatincost + $persenactualoperasionalpmg + $persenactualnetprofitmg;

        // Memetakan data untuk menampilkan laporan KPI
        $totals = $data->map(function ($categories, $jenisName) use ($totalRevenuep, $totalRevenuea) {
            return [
                'jenis_name' => $jenisName,
                'categories' => $categories->map(function ($kategori) use ($totalRevenuep, $totalRevenuea) {
                    $totalPlan = $kategori->sum(fn($item) => (float) str_replace(',', '', $item->nominalplan ?? 0));
                    $totalActual = $kategori->sum(fn($item) => (float) str_replace(',', '', $item->nominalactual ?? 0));

                    // Calculate deviation and percentage here
                    $deviation = $totalPlan - $totalActual;
                    $percentage = $totalPlan != 0 ? round(($totalActual / $totalPlan) * 100, 2) : 0;
                    $vertikalanalisis = $totalRevenuep ? round(($totalPlan / $totalRevenuep) * 100, 2) : 0;
                    $vertikalanalisiss = $totalRevenuea ? round(($totalPlan / $totalRevenuea) * 100, 2) : 0;
                    return [
                        'kategori_name' => $kategori->first()->kategori_name,
                        'category_id' => $kategori->first()->category_id,
                        'total_plan' => $totalPlan,
                        'total_actual' => $totalActual,
                        'deviation' => $deviation,
                        'percentage' => $percentage,
                        'vertikalanalisis' => $vertikalanalisis,
                        'vertikalanalisiss' => $vertikalanalisiss,
                        'totalRevenuea' => $totalRevenuea,
                        'totalRevenuep' => $totalRevenuep,



                    ];
                })
            ];
        });


        //Cs barging
        $query = DB::table('plan_bargings')
            ->join('users', 'plan_bargings.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')->select('plan_bargings.*', 'users.id_company', 'perusahaans.nama as nama_perusahaan')

            ->where('users.id_company', $companyid);
        if (!empty($tahun)) {
            $query->whereBetween('plan_bargings.tanggal', ["$tahun-01-01", "$tahun-12-31"]);
        }

        $data = $query->get();
        $data->each(function ($item) {
            $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
        });
        $totalplanbarging = $data->sum(function ($p) {
            return floatval(str_replace(['.', ','], ['', '.'], $p->nominal));
        });
        //plan ekspor
        $totalplanekspor = (clone $query)
            ->where('plan_bargings.kuota', 'Ekspor')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace('.', '', $item->nominal ?? 0);
            });
        $totalplandomestik = (clone $query)
            ->where('plan_bargings.kuota', 'Domestik')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace('.', '', $item->nominal ?? 0);
            });

        //barging
        $query = DB::table('bargings')
            ->join('users', 'bargings.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select('bargings.*', 'users.id_company', 'perusahaans.nama as nama_perusahaan')

            ->where('users.id_company', $companyid);
        if (!empty($tahun)) {
            $query->whereBetween('bargings.tanggal', ["$tahun-01-01", "$tahun-12-31"]);
        }
        $data = $query->get();
        $totalactualbarging = $data->sum(function ($p) {
            return floatval(str_replace(['.', ','], ['', '.'], $p->quantity));
        });
        //actual ekspor
        $totalactualekspor = (clone $query)
            ->where('bargings.kuota', 'Ekspor')

            ->get()
            ->sum(function ($item) {
                return (float)str_replace('.', '', $item->quantity ?? 0);
            });
        // dd($totalactualekspor);

        $indexekspor = ($totalplanekspor != 0) ? round(($totalactualekspor / $totalplanekspor) * 100, 2) : 0;
        $resultekspor = round(($indexekspor * 0.05), 2);
        $totalactualdomestik = (clone $query)
            ->where('bargings.kuota', 'Domestik')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace('.', '', $item->quantity ?? 0);
            });
        $indexdomestik = ($totalplandomestik != 0) ? round(($totalactualdomestik / $totalplandomestik) * 100, 2) : 0;
        $resultdomestik = round(($indexdomestik * 0.05), 2);
        // dd($resultdomestik);
        // dd($resulutdomestik,$resultekspor,$indexdomestik,$totalactualdomestik);

        //belum clear
        $totalresultcp = round($resultdomestik + $resultekspor);
        // $totalresultcp = round(3.00 + 0.56 + $resultdomestik + $resultekspor);
        $totalresultcostumer = round(($totalresultcp / 0.15), 2);

        // dd($totalresultcostumer);



        //internal proses ob coal
        $query = DB::table('overberden_coal')
            ->join('kategori_overcoals', 'overberden_coal.kategori_id', '=', 'kategori_overcoals.id')
            ->join('users', 'overberden_coal.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')

            ->select(
                'kategori_overcoals.name as kategori_name',
                'overberden_coal.*'
            )
            ->where('users.id_company', $companyid);
        if (!empty($tahun)) {
            $query->whereBetween('overberden_coal.tanggal', ["$tahun-01-01", "$tahun-12-31"]);
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
        $indexcoalgetting = ($totalPlancoal != 0) ? round($totalActualcoal / $totalPlancoal, 2) : 0;
        $resultcoal = round(($indexcoalgetting * 0.02), 2); //result coal
        $resultcoalmt = round(($indexcoalgetting * 0.03), 2); //result coal mt

        // Inisialisasi total nilai untuk Over Burden
        $totalPlanob = $data->where('kategori_name', 'Over Burden')->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalplan ?? 0);
        });
        $totalActualob = $data->where('kategori_name', 'Over Burden')->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalactual ?? 0);
        });
        $indexoverburder = $totalPlanob != 0 ? round(($totalActualob / $totalPlanob) * 100, 2) : 0;
        $resultob = round(($indexoverburder * 0.02), 2); //result ob
        $resultobbcm = round(($indexoverburder * 0.03), 2); //result ob bcm
        // dd($resultob);


        //PA 
        $query = DB::table('units')
            ->join('produksi_pas', 'units.id', '=', 'produksi_pas.unit_id')
            ->leftJoin('users', 'units.created_by', '=', 'users.username')
            ->select(
                'units.unit as units',
                'produksi_pas.plan as pas_plan',
                'produksi_pas.actual as pas_actual',
            )
            ->where('users.id_company', $companyid);
        if (!empty($tahun)) {
            $query->whereBetween('produksi_pas.date', ["$tahun-01-01", "$tahun-12-31"]);
        }

        $data = $query->get();
        // $totalactualunithauler=
        $totalactualunithauler = (clone $query)
            ->where('units.unit', 'UNIT HAULER')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->pas_actual ?? 0);
            });
        $totalplanunithauler = (clone $query)
            ->where('units.unit', 'UNIT HAULER')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->pas_plan ?? 0);
            });
        // dd($totalactualunithauler);
        $resultpa = round(($indexoverburder * 0.06), 2); //result PA


        // Group the data by 'units'
        $groupedData = $data->groupBy('units');

        $unitpa = $groupedData->map(function ($items, $unit) {
            // Sum the 'pas_plan' and 'pas_actual' for each group
            $totalPasPlan = $items->sum(function ($item) {
                return (float)str_replace(',', '', $item->pas_plan ?? 0);
            });

            $totalPasActual = $items->sum(function ($item) {
                return (float)str_replace(',', '', $item->pas_actual ?? 0);
            });

            $indexpa = $totalPasPlan != 0 ? round(($totalPasActual / $totalPasPlan) * 100, 2) : 0;
            // dd($totalPasPlan, $totalPasActual, $indexpa);

            return [
                'units' => $unit,
                'total_pas_plan' => $totalPasPlan,
                'total_pas_actual' => $totalPasActual,
                'indexpa' => $indexpa,
                'details' => $items,
            ];
        });
        // Hitung rata-rata total plan dan actual (Physical Availability)
        $averagePasPlan = $unitpa->avg('total_pas_plan');
        $averagePasActual = $unitpa->avg('total_pas_actual');
        // dd($averagePasPlan);
        //ua
        $query = DB::table('produksi_uas')
            ->join('units', 'produksi_uas.unit_id', '=', 'units.id')
            ->join('users', 'produksi_uas.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select(
                'produksi_uas.*',
                'units.unit as units'
            )
            ->where('users.id_company', $companyid);
        if (!empty($tahun)) {
            $query->whereBetween('produksi_uas.date', ["$tahun-01-01", "$tahun-12-31"]);
        }
        $data = $query->get();
        $totalactualuaunithauler = (clone $query)
            ->where('units.unit', 'UNIT HAULER')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->actual ?? 0);
            });
        $totalplanuaunithauler = (clone $query)
            ->where('units.unit', 'UNIT HAULER')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->plan ?? 0);
            });

        $resultua = round(($indexoverburder * 0.04), 2); //result PA
        // dd($totalactualuaunithauler);


        // $data = $query->orderBy('units.unit')
        //     ->get()
        //     ->groupBy('units');

        // Pembebasan Lahan
        $query = DB::table('pembebasan_lahans')
            ->leftJoin('users', 'pembebasan_lahans.created_by', '=', 'users.username')

            ->select('*')
            ->where('users.id_company', $companyid);
        if (!empty($tahun)) {
            $query->whereBetween('pembebasan_lahans.tanggal', ["$tahun-01-01", "$tahun-12-31"]);
        }

        $dataPembebasan = $query->get();

        $averageAchievement = $dataPembebasan->average(function ($item) {
            return (float)str_replace('%', '', $item->Achievement);
        });

        // Mining Readiness
        $query = DB::table('mining_readinesses')
            ->join('kategori_mini_r_s', 'mining_readinesses.KatgoriDescription', '=', 'kategori_mini_r_s.kategori')
            ->join('users', 'mining_readinesses.created_by', '=', 'users.username')
            ->select('kategori_mini_r_s.kategori', 'mining_readinesses.*')
            ->where('users.id_company', $companyid);

        if (!empty($tahun)) {
            $query->whereBetween('mining_readinesses.tanggal', ["$tahun-01-01", "$tahun-12-31"]);
        }

        $dataMining = $query->get();

        $dataMining->transform(function ($item) {
            $achievement = str_replace('%', '', $item->Achievement);
            $item->average_achievement = $achievement ? (float)$achievement : 0;
            return $item;
        });

        $groupedData = $dataMining->groupBy('kategori')->map(function ($items) {
            $total = $items->sum(function ($item) {
                return (float)str_replace('%', '', $item->Achievement);
            });
            $count = $items->count();
            $average = $count > 0 ? $total / $count : 0;
            return $items->map(function ($item) use ($average) {
                $item->average_achievement = $average;
                return $item;
            });
        });

        $totalAllCategories = $groupedData->map(function ($items) {
            $totalAchievement = $items->sum(function ($item) {
                return (float)str_replace('%', '', $item->Achievement);
            });
            $count = $items->count();
            return $count > 0 ? $totalAchievement / $count : 0;
        })->sum();

        $totalCategories = $groupedData->count();
        $totalAspect = $totalCategories > 0 ? round($totalAllCategories / $totalCategories, 2) : 0;

        $finalAverage = ($totalAspect + $averageAchievement) / 2;
        $indexmining = $finalAverage != 0 ? round(($finalAverage * 100) / 100, 2) : 0;
        $resultmining = round(($indexmining * 0.03), 2); //result mining


        //people readiness
        $totalQuality = 0;
        $totalQuantity = 0;
        $count = 0;

        $query = DB::table('people_readinesses')
            ->select('people_readinesses.*')
            ->join('users', 'people_readinesses.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->where('users.id_company', $companyid);
        if (!empty($tahun)) {
            $query->whereBetween('people_readinesses.tanggal', ["$tahun-01-01", "$tahun-12-31"]);
        }
        $people = $query->get();
        // dd($query->toSql(), $query->getBindings());

        $totalQuality = 0;
        $totalQuantity = 0;
        $count = 0;

        foreach ($people as $d) {
            $qualityPlan = floatval(str_replace('%', '', trim($d->Quality_plan)));
            $quantityPlan = floatval(str_replace('%', '', trim($d->Quantity_plan)));

            if (is_numeric($qualityPlan) && is_numeric($quantityPlan)) {
                $totalQuality += $qualityPlan;
                $totalQuantity += $quantityPlan;
                $count++;
            }
            // echo "Quality Plan: $d->Quality_plan → Converted: $qualityPlan\n";
            // echo "Quantity Plan: $d->Quantity_plan → Converted: $quantityPlan\n";
        }
        // dd("Total Quality:", $totalQuality, "Total Quantity:", $totalQuantity, "Count:", $count);

        if ($count > 0) {
            $averageQuality = $totalQuality / $count;
            $averageQuantity = $totalQuantity / $count;
        } else {
            $averageQuality = 0;
            $averageQuantity = 0;
        }

        if ($averageQuantity > 0) {
            $totalpr = (($averageQuality + $averageQuantity) / 2);
        } else {
            $totalpr = 0;
        }

        $indexpeople = $totalpr != 0 ? round(($totalpr * 100) / 100, 2) : 0;
        $resultpeople = round($indexpeople * (10 / 100), 2);




        //infrastruktur
        $query = DB::table('infrastructure_readinesses')
            ->select('infrastructure_readinesses.*')
            ->join('users', 'infrastructure_readinesses.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->where('users.id_company', $companyid);
        if (!empty($tahun)) {
            $query->whereBetween('infrastructure_readinesses.tanggal', ["$tahun-01-01", "$tahun-12-31"]);
        }
        $datainfra = $query->get();


        $averagePerformance = $datainfra->pluck('total') // Ambil hanya data yang sudah terfilter
            ->map(function ($item) {
                return (float) str_replace('%', '', $item); // Ubah ke angka float
            })
            ->avg();

        $indexinfra = $averagePerformance != 0 ? round(($averagePerformance * 100) / 100, 2) : 0;
        $resultinfrastruktur = round($indexinfra * (10 / 100), 2);
        //l&g
        $totalindexlearning = $resultpeople + $resultinfrastruktur;
        $resultlearning = round($totalindexlearning * 0.10, 2);

        // dd($averagePerformance,$indexinfra);

        //stock jetty
        // $startDate = $request->input('start_date');
        // $endDate = $request->input('end_date');

        $query = DB::table('bargings')
            ->select('bargings.*')
            ->join('users', 'bargings.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->where('users.id_company', $companyid);

        // Filter berdasarkan tanggal jika ada input
        if (!empty($tahun)) {
            $query->whereBetween('bargings.tanggal', ["$tahun-01-01", "$tahun-12-31"]);
        }


        $data = $query->get();
        $totalQuantity = 0;
        $count = 0;

        foreach ($data as $d) {
            $quantity = str_replace(['.', ','], ['', '.'], $d->quantity);
            $quantity = floatval($quantity);

            if (is_numeric($quantity)) {
                $totalQuantity += $quantity;
                $count++;
            }
        }
        $data = $data->map(function ($d) {
            $d->formatted_quantity = number_format(floatval(str_replace(['.', ','], ['', '.'], $d->quantity)), 0, ',', '.');
            return $d;
        });
        // dd($totalQuantity);



        // 1. Query utama: hanya untuk data dalam tahun filter
        $query = DB::table('stock_jts')
            ->select('stock_jts.*')
            ->join('users', 'stock_jts.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->where('users.id_company', $companyid);


        if (!empty($tahun)) {
            $query->whereBetween('stock_jts.date', ["$tahun-01-01", "$tahun-12-31"]);
        }

        $data = $query->get();

        // 2. Ambil sotckawal dari tahun-tahun sebelumnya (TANPA filter tahun)
        $sotckAwalQuery = DB::table('stock_jts')
            ->select('sotckawal', 'date')
            ->join('users', 'stock_jts.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->whereNotNull('stock_jts.sotckawal')
            ->whereDate('stock_jts.date', '<', "$tahun-01-01")// sebelum tahun yang difilter
            ->where('users.id_company', $companyid);


        // Ambil stok awal paling terakhir sebelum tahun tersebut
        $stokAwal = $sotckAwalQuery
            ->orderByDesc('date')
            ->pluck('sotckawal')
            ->map(function ($val) {
                return floatval(str_replace(',', '.', str_replace('.', '', $val)));
            })
            ->first() ?? 0;

        // Tambahkan stok awal ke data tahun itu
        $planNominal = $data->sum(function ($p) {
            return floatval(str_replace(['.', ','], ['', '.'], $p->plan));
        });

        $data->transform(function ($item) {
            $item->sotckawal = floatval(str_replace(',', '.', str_replace('.', '', $item->sotckawal)));
            return $item;
        });

        $totalHauling = $data->sum('totalhauling') ?? 0;

        // Proses total stockout dan stock akhir
        $prevStockAkhir = $stokAwal;
        $totalStockOut = 0;
        $totalStockAkhir = 0;

        $data = $data->sortBy('date')->values(); // urutkan dulu biar akurat

        $data->each(function ($stock) use (&$prevStockAkhir, &$totalStockOut, &$totalStockAkhir) {
            $stock->sotckawal = $stock->sotckawal > 0 ? $stock->sotckawal : $prevStockAkhir;

            $stock->stock_akhir = ($stock->sotckawal + $stock->totalhauling) - $stock->stockout;

            $totalStockOut += $stock->stockout;
            $prevStockAkhir = $stock->stock_akhir;
            $totalStockAkhir = $stock->stock_akhir; // disimpan yang terakhir
        });
        $grandTotal = optional($data->last())->akumulasi_stock ?? 0;

        $grandTotalstockakhir = optional($data->last())->stock_akhir ?? 0;
        // dd($grandTotalstockakhir);

        //ewh
        $queryewh = DB::table('ewhs')
            ->join('units', 'ewhs.unit_id', '=', 'units.id')
            ->join('users', 'ewhs.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select('ewhs.*', 'units.unit as units')
            ->where('users.id_company', $companyid);
        if (!empty($tahun)) {
            $query->whereBetween('ewhs.date', ["$tahun-01-01", "$tahun-12-31"]);
        }

        $data = $queryewh
            ->get();
        $totalplanewh = $data->sum(function ($p) {
            return (float) str_replace(',', '', $p->plan ?? 0);
        });
        $totalactualewh = $data->sum(function ($p) {
            return (float) str_replace(',', '', $p->actual ?? 0);
        });
        $resultewh = round(($indexoverburder * 0.04), 2); //result ewh

        //fuel
        $queryfuels = DB::table('fuels')
            ->join('units', 'fuels.unit_id', '=', 'units.id')
            ->join('users', 'fuels.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select(
                'fuels.*',
                'units.unit as units'
            )
            ->where('users.id_company', $companyid);
        if (!empty($tahun)) {
            $query->whereBetween('fuels.date', ["$tahun-01-01", "$tahun-12-31"]);
        }
        $data = $queryfuels->get();
        $totalplanfuel = $data->sum(function ($p) {
            return (float) str_replace(',', '', $p->plan ?? 0);
        });
        $totalactualfuel = $data->sum(function ($p) {
            return (float) str_replace(',', '', $p->actual ?? 0);
        });
        $resultfuel = round(($indexoverburder * 0.03), 2); //result fuel
        $resultIPP = $resultcoal + $resultob + $resultewh + $resultua + $resultpa + $resultfuel + $resultcoalmt + $resultobbcm + $resultmining;
        $totalresultIPP = round(($resultIPP / 30.00) * 100, 2);
        $totalresultcompany = round(($totalresultfinancial + $totalresultcostumer + $totalresultIPP + $resultlearning) / 4, 2);
        // dd($totalresultcompany);
        $totalresult = $totalindexfinancial + $totalresultcp + $resultIPP + $totalindexlearning;
        // dd($totalresultcompany);

        return compact(
            //total 
            'totalresult',
            'resultIPP',
            'totalresultcompany',
            'totalresultIPP',
            //fuels
            'totalplanfuel',
            'totalactualfuel',
            //ewh
            'totalplanewh',
            'totalactualewh',
            //barging
            'totalresultcostumer',
            'totalactualbarging',
            'totalplanbarging',
            'totalplandomestik',
            'totalplanekspor',
            'totalactualekspor',
            'totalactualdomestik',
            'indexekspor',
            'indexdomestik',
            //lavarge
            'planlavarge',
            'actuallavarge',
            //net profit
            'vertalactualnetprofit',
            'vertikalplanetprofit',
            //l&g
            'resultlearning',
            'totals',
            //neraca
            'planreturnonasset',
            'actualreturnonasset',
            'indexactualasset',
            'weightasset',
            'persenactualasset', //assets
            'actualreturnonequaity',
            'indexmodalhutangactual',
            'weightmodalhutang',
            'persenreturnonequity',
            'persenactualmodalhutang', //modal hutang
            //nama perusahaan

            'companyName',
            'user',
            'perusahaans',
            'companyid',
            //stock jetty
            'grandTotal',
            'grandTotalstockakhir',
            // 'indexstockjetty',
            //cs perspect
            //financial weight & index 
            'verticallb',
            'verticalop',
            'verticalslb',
            'weightrevenue',
            'weightcogs',
            'weightprofitmargin',
            'weightcostemploye',
            'weightcsr',
            'weightopratingcost',
            'weightopratingmg',
            'weightnetprofitmargin',
            //index
            'indexrevenue',
            'indexcogs',
            'indexprofitmg',
            'indexcostemlpoye',
            'indexcsr',
            'indexoperatingcost',
            'indexoperasionalpmg',
            'indexnetprofitmg',
            //laba rugi 
            'totalRevenuea',
            'totalRevenuep', //revenue 
            'totalvertikal',
            'totalvertikals',
            'persenlb', //laba rugi
            'verticallp',
            'persenop', //Operating Profit Margin
            'verticalslb',
            'deviasilb',
            'persenlr', //net profit
            'data',
            'planoppersen',
            'actualoppersen', //Operasional Cost 
            //cogs
            'actualcogs',
            'plancogs',
            'totalactualcogas',
            'totalplancogas',
            //cos of employe
            'actualcoe',
            'plancoe',
            //salary atau csr
            'actualcsr',
            'totplanscsr',
            'plancsr',

            //over burden dan coal
            'totalPlancoal',
            'totalActualcoal',
            'totalPlanob',
            'totalActualob',
            'indexoverburder',
            'indexcoalgetting',
            //ua
            'totalactualuaunithauler',
            //pa
            'averagePasActual',
            'averagePasPlan',
            'unitpa',
            'totalactualunithauler',
            // pembebasan lahan dan mining
            'finalAverage',
            'indexmining',
            //peolple
            'indexpeople',
            'totalpr',
            //infrastruktur
            'averagePerformance',
            'indexinfra',
            //plan
            'totalpercenfinancial',
            'totalplanlr',
            'totalplancogas',
            'ongkosplan',
            'totplansalary',
            'totplanscsr',
            'planoperasional',
            'totalplanlp',
            'totalnetprofitplan',
            'totalplanasset',
            'totalplanequity',
            'persenassetplan',
            'weightasset',
            'persenmodalhutangplan',
            'weightmodalhutang',
            'persenrevenue',
            'weightrevenue',
            'persencogs',
            'weightcogs',
            'persenprofitmargin',
            'weightprofitmargin',
            'persencostemploye',
            'weightcostemploye',
            'persencsr',
            'weightcsr',
            'persenopratingcost',
            'weightopratingcost',
            'persenoperatingprofitmargin',
            'weightopratingmg',
            'persennetprofitmargin',
            'weightnetprofitmargin',
            'totalpercenfinancial',
            //actual
            'totalRevenuea',
            'totalactualcogas',
            'totalactuallr',
            'totactualsalary',
            'totactualscsr',
            'actualoperasional',
            'totalactualOp',
            'totalactualnetprofit',
            'totalactualasset',
            'totalactualequity',
            'ongkosactual',
            'persenactualasset',
            'actualreturnonequaity',
            'persenactualrevenue',
            'persenactualcogs',
            'persenactualprofitmg',
            'pserenactualcostemploye',
            'persenactualcsr',
            'persenactualoperatincost',
            'persenactualoperasionalpmg',
            'persenactualnetprofitmg',
            'totalopersenactualfinancial',
            //result
            'actualreturnonasset',
            'resultrevenue',
            'resultcogs',
            'resultgrosspm',
            'resultemploye',
            'resultcsr',
            'ressultoperasionalcost',
            'resultoperatingpm',
            'resultnetpm',
            'resultasset',
            'resultequity',
            'totalindexlearning',
            'resultpeople',
            'resultlearning',
            'resultinfrastruktur',
            'resultmining',

            'resultdomestik',
            'resultekspor',
            'resultob',
            'resultobbcm',
            'resultcoal',
            'resultcoalmt',
            'resultfuel',
            'resultewh',
            'resultpa',
            'resultua',
            'totalresultfinancial',
            'totalresultcompany',
            'totalresultcostumer',
            'totalresultcp',
            'totalindexfinancial',





        );
    }

    // <!-- @if(auth()->user()->role === 'admin')    
    // <form method="GET" action="{{ route('reportkpi') }}" id="filterForm">
    //     <label for="id_company">Select Company:
    //         <br>
    //         <small><em>To view company KPI, please select a company from the list.</em></small>
    //     </label>
    //     <select name="id_company" id="id_company" onchange="updateCompanyName(); document.getElementById('filterForm').submit();">
    //         <option value="">-- Select Company --</option>
    //         @foreach ($perusahaans as $company)
    //         <option value="{{ $company->id }}" data-nama="{{ $company->nama }}" {{ request('id_company') == $company->id ? 'selected' : '' }}>
    //             {{ $company->nama }}
    //         </option>
    //         @endforeach
    //     </select>
    // </form>
    // @endif -->
    // <!-- <form method="GET" action="{{ route('reportkpi') }}">
    //     <label for="tahun">Pilih Tahun:</label>
    //     <select name="tahun" id="tahun" onchange="this.form.submit()">
    //         @for ($i = date('Y'); $i >= 2019; $i--)
    //         <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
    //             {{ $i }}
    //         </option>
    //         @endfor
    //     </select>
    // </form>
    //  -->

}
