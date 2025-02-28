<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\DB;
use App\Models\planBargings;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function reportkpi(Request $request) {
        $user = Auth::user();
            $companyName = DB::table('users')
                ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
                ->select('perusahaans.nama as company_name')
                ->where('users.id', $user->id)
                ->first();
            
            if (!$companyName) {
                // return response()->json(['message' => 'Perusahaan tidak ditemukan'], 404);
            }
        
        
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
     
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
            ->where('category_labarugis.namecategory', 'Cost of Goods Sold')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalplan ?? 0);
        });
        $actualcogs = $totalRevenuea ? ($totalactualcogas /$totalRevenuea ) * 100 : 0;
        $plancogs = $totalRevenuep ? ($totalplancogas / $totalRevenuep) * 100 : 0;
        //cos of employe
        $totactualsalary = (clone $query)
            ->where('category_labarugis.namecategory', 'Salary')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalactual ?? 0);
        });

        $totplansalary = (clone $query)
            ->where('category_labarugis.namecategory', 'Salary')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalplan ?? 0);
        });
        $actualcoe = $totalRevenuea ? ($totactualsalary /$totalRevenuea ) * 100 : 0;
        $plancoe = $totalRevenuep ? ($totplansalary / $totalRevenuep) * 100 : 0;

        //csr
        $totactualscsr = (clone $query)
            ->where('category_labarugis.namecategory', 'Social & CSR')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalactual ?? 0);
        });
        $totplanscsr = (clone $query)
            ->where('category_labarugis.namecategory', 'Social & CSR')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalplan ?? 0);
        });
        $actualcsr = $totalRevenuea ? ($totactualscsr /$totalRevenuea ) * 100 : 0;
        $plancsr = $totalRevenuep ? ($totplanscsr / $totalRevenuep) * 100 : 0;    
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
    
            $totalplanlr = $totalRevenuep-$totallkplan;
            $totalactuallr = $totalRevenuea-$totallkactual;
            $totalvertikal = $totalplanlr ? ($totalplanlr / $totalRevenuep) * 100 : 0;
            $totalvertikals = $totalRevenuea ? ($totalactuallr / $totalRevenuea) * 100 : 0;
            $deviasilr = $totalplanlr-$totalactuallr;
            // dd($totalactuallr);
            $persenlr = $totalplanlr ? ($totalactuallr / $totalplanlr) * 100 : 0;
            // dd($actualoppersen);
            //operating profit
            $totalplanlp = $totalplanlr-$planoperasional;
            $totalactualOp = $actualoperasional-$totalactuallr;
            $verticallp = $totalRevenuep ? ($totalplanlp / $totalRevenuep) * 100 : 0;
            $verticalop = $totalRevenuea ? ($totalactualOp / $totalRevenuea) * 100 : 0;
            $deviasiop = $totalplanlp-$totalactualOp;
            $persenop = $totalplanlp ? ($totalactualOp / $totalplanlp) * 100 : 0;
            //operasional
            $planoppersen = $totalRevenuep ? ($planoperasional / $totalRevenuep) * 100 : 0;
            $actualoppersen = $totalRevenuep ? ($totalactualOp / $totalRevenuea) * 100 : 0;
            //lababersih
            $totalplanlb = $planlb-$planoperasional;
            $totalactuallb = $actualoperasional-$actuallb;
            $verticallb = $totalRevenuep ? ($totalplanlb / $totalRevenuep) * 100 : 0;//plan
            $verticalslb = $totalRevenuea ? ($totalactuallb / $totalRevenuea) * 100 : 0;//actual
            $deviasilb = $totalplanlb-$totalactuallb;
            $persenlb = $totalplanlb ? ($totalactuallb / $totalplanlb) * 100 : 0;
            // Mengatur nilai null jika total revenue adalah 0 atau null
        if ($totalRevenuea === 0 || !$totalRevenuea) {
            $totalRevenuea = null;
        }
        if ($totalRevenuep === 0 || !$totalRevenuep) {
            $totalRevenuep = null;
        }
    //kpi jtn & pengukuran 
    //total ongkosplan dan ongkos actual financial
    $ongkosactual= $totalRevenuea + $totalactualcogas + $totallkactual + $totactualsalary + $totactualscsr + $actualoperasional + $totalactualOp + $actuallb; // (total seluruh plan) yang belum - Return On Assets - Return On Equity 
    $ongkosplan= $totalRevenuep + $totalplancogas + $totallkplan + $totplansalary + $totplanscsr + $planoperasional + $totalplanlp + $planlb; // (total seluruh plan) yang belum - Return On Assets - Return On Equity 
    //persen plan financial
    
    // Perhitungan persen revenue dan weight
    $persenrevenue = ($ongkosplan != 0) ? ($totalRevenuep / $ongkosplan) * 100 : 0;/* revenue*/ $weightrevenue = round(($persenrevenue / 35.00) * 100, 2);
    $persencogs = ($ongkosplan != 0) ? ($totalplancogas / $ongkosplan) * 100 : 0;/* cogs*/$weightcogs = round(($persencogs / 35.00) * 100, 2);
    $persenprofitmargin = ($ongkosplan != 0) ? ($totallkplan / $ongkosplan) * 100 : 0;/* profit margin*/$weightprofitmargin = round(($persenprofitmargin / 35.00) * 100, 2);
    $persencostemploye = ($ongkosplan != 0) ? ($totplansalary / $ongkosplan) * 100 : 0;/* saleri cost employe*/$weightcostemploye = round(($persencostemploye / 35.00) * 100, 2);
    $persencsr = ($ongkosplan != 0) ? ($totplanscsr / $ongkosplan) * 100 : 0;/* csr*/$weightcsr = round(($persencsr / 35.00) * 100, 2);
    $persenopratingcost = ($ongkosplan != 0) ? ($totplanscsr / $ongkosplan) * 100 : 0;/*operasional cost*/$weightopratingcost = round(($persenopratingcost / 35.00) * 100, 2);
    $persenoperatingprofitmargin = ($ongkosplan != 0) ? ($totalplanlp / $ongkosplan) * 100 : 0;/* opersional profit mg*/$weightopratingmg = round(($persenoperatingprofitmargin / 35.00) * 100, 2);
    $persennetprofitmargin = ($ongkosplan != 0) ? ($planlb / $ongkosplan) * 100 : 0;/*net profit*/$weightnetprofitmargin = round(($persennetprofitmargin / 35.00) * 100, 2);
    // Perhitungan persen actual dan index
    $persenactualrevenue = ($ongkosactual != 0) ? ($totalRevenuea / $ongkosactual) * 100 : 0; /* revenue*/ $indexrevenue = ($persenrevenue != 0) ? round(($persenactualrevenue / $persenrevenue) * 100, 2) : 0;
    $persenactualcogs = ($ongkosactual != 0) ? ($totalactualcogas / $ongkosactual) * 100 : 0;/* cogs*/$indexcogs = ($persencogs != 0) ? round(($persenactualcogs / $persencogs) * 100, 2) : 0;
    $persenactualprofitmg = ($ongkosactual != 0) ? ($totallkactual / $ongkosactual) * 100 : 0;/* profit margin*/$indexprofitmg = ($persenprofitmargin != 0) ? round(($persenactualprofitmg / $persenprofitmargin) * 100, 2) : 0; 
    $pserenactualcostemploye = ($ongkosactual != 0) ? ($totactualsalary / $ongkosactual) * 100 : 0;/* saleri cost employe*/$indexcostemlpoye = ($persencostemploye != 0) ? round(($pserenactualcostemploye / $persencostemploye) * 100, 2) : 0;
    $persenactualcsr = ($ongkosactual != 0) ? ($totactualscsr / $ongkosactual) * 100 : 0;/* csr*/$indexcsr = ($persencsr != 0) ? round(($persenactualcsr / $persencsr) * 100, 2) : 0;
    $persenactualoperatincost = ($ongkosactual != 0) ? ($actualoperasional / $ongkosactual) * 100 : 0;/*operasional cost*/$indexoperatingcost = ($persenopratingcost != 0) ? round(($persenactualoperatincost / $persenopratingcost) * 100, 2) : 0;
    $persenactualoperasionalpmg = ($ongkosactual != 0) ? ($totalactualOp / $ongkosactual) * 100 : 0;/* opersional profit mg*/$indexoperasionalpmg = ($persenoperatingprofitmargin != 0) ? round(($persenactualoperasionalpmg / $persenoperatingprofitmargin) * 100, 2) : 0;
    $persenactualnetprofitmg = ($ongkosactual != 0) ? ($actuallb / $ongkosactual) * 100 : 0;/*net profit*/$indexnetprofitmg = ($persennetprofitmargin != 0) ? round(($persenactualnetprofitmg / $persennetprofitmargin) * 100, 2) : 0;
    
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
        $query = DB::table('bargings')
        ->join('users', 'bargings.created_by', '=', 'users.username') 
        ->leftJoin('plan_bargings', function ($join) {
            $join->on('bargings.kuota', '=', 'plan_bargings.kuota')
                 ->groupBy('bargings.kuota'); 
        });        
        // ->select('bargings.*', 'plan_bargings.nominal', 'bargings.kuota')
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
        // dd($data);
        $categories = ['Ekspor', 'Domestik'];
        $results = [];
        
        $totalPlanAll = $data->sum('nominal'); 
        // dd($totalPlanAll);
        $totalActualAll = $data->sum(function ($d) {
            return floatval(str_replace(',', '', $d->quantity));
        });
        $index= $totalPlanAll? ($totalActualAll/$totalPlanAll)* 100 : 0;
        $index = round($index, 2);
        
        $results['total'] = [
            'Plan' => number_format($totalPlanAll, 2, ',', '.'),
            'Actual' => number_format($totalActualAll, 2, ',', '.'),
            'Index' => $index
            
        ];
        
        foreach ($categories as $category) {
            $filteredData = collect($data)->where('kuota', $category);
            // dd($filteredData);

            
            $totalPlan = $filteredData->sum('nominal'); 
            $totalActual = $filteredData->sum(function ($d) {
                return floatval(str_replace(',', '', $d->quantity));
            });
            $index= $totalPlan? ($totalActual/$totalPlan)* 100 : 0;
            $index = round($index, 2);
            $results[$category] = [
                'Plan' => number_format($totalPlan, 2, ',', '.'),
                'Actual' => number_format($totalActual, 2, ',', '.'),
                'Index' => $index
                
            ];
        } 
        
        //internal proses ob coal
        $query = DB::table('overberden_coal')
        ->join('kategori_overcoals', 'overberden_coal.kategori_id', '=', 'kategori_overcoals.id')
        ->leftJoin('users', 'overberden_coal.created_by', '=', 'users.username') 

        ->select( 'kategori_overcoals.name as kategori_name','overberden_coal.*');
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
        $totalPlancoal = $data->where('kategori_name', 'Coal Getting')->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalplan ?? 0);
        }); 
        $totalActualcoal = $data->where('kategori_name', 'Coal Getting')->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalactual ?? 0);
        });  
        $indexcoalgetting = ($totalActualcoal != 0) ? ($totalPlancoal / $totalActualcoal) * 100 : 0;
        // Inisialisasi total nilai untuk Over Burden
        $totalPlanob = $data->where('kategori_name', 'Over Burden')->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalplan ?? 0);
        });
        // dd($totalPlanob);
        $totalActualob = $data->where('kategori_name', 'Over Burden')->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalactual ?? 0);
        });
        $indexoverburder = $totalActualob != 0 ? round(($totalPlanob / $totalActualob) * 100,2) : 0;

        //PA 
        $query = DB::table('units')
        ->join('produksi_pas', 'units.id', '=', 'produksi_pas.unit_id')
        ->leftJoin('users', 'units.created_by', '=', 'users.username') 
        ->select(
            'units.unit as units',
            'produksi_pas.plan as pas_plan',
            'produksi_pas.actual as pas_actual',
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
    $data = $query->get();
    
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
    
        $indexpa = $totalPasPlan != 0 ? round(($totalPasActual / $totalPasPlan) * 100,2) : 0;
        // dd($totalPasPlan, $totalPasActual, $indexpa);
        return [
            'units' => $unit,
            'total_pas_plan' => $totalPasPlan,
            'total_pas_actual' => $totalPasActual,
            'indexpa' => $indexpa,
            'details' => $items,
        ];
    });

    // Pembebasan Lahan
    $query = DB::table('pembebasan_lahans')
    ->leftJoin('users', 'pembebasan_lahans.created_by', '=', 'users.username') 

    ->select('*');
    if ($user->role !== 'admin') {
        $query->where('users.id_company', $companyId);
    } else {
        if ($companyId) {
            $query->where('users.id_company', $companyId);
        } else {
            $query->whereRaw('users.id_company', $companyId);             
        }
    }

            
    $dataPembebasan = $query->get();
    
    $averageAchievement = $dataPembebasan->average(function ($item) {
        return (float)str_replace('%', '', $item->Achievement);
    });
    
    // Mining Readiness
    $query = DB::table('mining_readinesses')
    ->join('kategori_mini_r_s', 'mining_readinesses.KatgoriDescription', '=', 'kategori_mini_r_s.kategori')
    ->join('users', 'mining_readinesses.created_by', '=', 'users.username')
    ->select('kategori_mini_r_s.kategori', 'mining_readinesses.*');
    if ($user->role !== 'admin') {
        $query->where('users.id_company', $companyId);
    } else {
        if ($companyId) {
            $query->where('users.id_company', $companyId);
        } else {
            $query->whereRaw('users.id_company', $companyId);             
        }
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
    $indexmining = $finalAverage != 0 ? round(($finalAverage * 100) / 100,2) : 0;


    //people readiness
    $totalQuality = 0;
    $totalQuantity = 0;
    $count = 0; 
    $query = DB::table('people_readinesses') 
    ->join('users', 'people_readinesses.created_by', '=', 'users.username') 

    ->select('people_readinesses.*');
    if ($user->role !== 'admin') {
        $query->where('users.id_company', $companyId);
    } else {
        if ($companyId) {
            $query->where('users.id_company', $companyId);
        } else {
            $query->whereRaw('users.id_company', $companyId);             
        }
    }  
    $people = $query->get();
    
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
    }
    
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
    $indexpeople = $totalpr != 0 ? round(($totalpr * 100) / 100,2) : 0;


    //infrastruktur
    $query = DB::table('infrastructure_readinesses')
    ->select('infrastructure_readinesses.*')
    ->join('users', 'infrastructure_readinesses.created_by', '=', 'users.username')
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
    $datainfra = $query->get();

    
    $averagePerformance = $datainfra->pluck('total') // Ambil hanya data yang sudah terfilter
    ->map(function ($item) {
        return (float) str_replace('%', '', $item); // Ubah ke angka float
    })
    ->avg();

$indexinfra = $averagePerformance != 0 ? round(($averagePerformance * 100) / 100,2) : 0;

    // dd($averagePerformance,$indexinfra);

    //stock jetty
    $query = DB::table('stock_jts')
    ->select('stock_jts.*')
    ->join('users', 'stock_jts.created_by', '=', 'users.username')
    ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id');
    if ($user->role !== 'admin') 
    
    {
        $query->where('users.id_company', $companyId);
    } else {
        if ($companyId) {
            $query->where('users.id_company', $companyId);
        } else {
            $query->whereRaw('users.id_company', $companyId);             
        }
    }

            $data = $query->get();
    $planNominalsj = $data->sum(function ($p) {
        return floatval(str_replace(['.', ','], ['', '.'], $p->plan));
    });
    $data->transform(function ($item) {
    $item->sotckawal = floatval(str_replace(',', '.', str_replace('.', '', $item->sotckawal)));
    return $item;
    });
    
    $data->each(function ($item) {
        $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
    });
    //  dd($data);
    $totalHauling = (clone $query)->sum('totalhauling') ?? 0;
    $stokAwal = floatval($data->whereNotNull('sotckawal')->first()->sotckawal ?? 0);
    
    $akumulasi = $stokAwal;

    $data->map(function ($stock, $index) use (&$akumulasi, &$stock_akhir) {
        $stock->sotckawal = floatval($stock->sotckawal ?? 0);
        $stock->totalhauling = floatval($stock->totalhauling ?? 0);
        $stock->stockout = floatval($stock->stockout ?? 0);
        if ($index === 0) {
            $akumulasi = $stock->sotckawal; 
        }
        $akumulasi += $stock->totalhauling;
        $stock->akumulasi_stock = $akumulasi;    
        $akumulasi -= $stock->stockout;
        $stock->stock_akhir = $akumulasi;
        $stock_akhir = $stock->stock_akhir;
        return $stock;
    });
    $grandTotal = optional($data->last())->stock_akhir ?? 0;
    $indexstockjetty= $planNominalsj? round (($grandTotal/$planNominalsj)* 100,2) : 0;







        return view('pt.report', compact('totals',
        
        //nama perusahaan
        'companyName',
        'user',
        'perusahaans', 'companyId',
        //stock jetty
        'grandTotal','planNominalsj','indexstockjetty',
        //financial weight & index
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
        'totalRevenuea', 'totalRevenuep', //revenue 
        'totalvertikal', 'totalvertikals','persenlb', //laba rugi
        'verticalop','verticallp', 'persenop', //Operating Profit Margin
        'verticalslb','deviasilb','persenlr', //net profit
        'data','results',
        'planoppersen','actualoppersen', //Operasional Cost 
        //cogs
        'actualcogs',
        'plancogs',
        //cos of employe
        'actualcoe',
        'plancoe',
        //salary atau csr
        'actualcsr',
        'totplanscsr',

        //over burden dan coal
        'totalPlancoal',
        'totalActualcoal',
        'totalPlanob',
        'totalActualob',
        'indexoverburder',
        'indexcoalgetting',
        //pa
        'unitpa',
        // pembebasan lahan dan mining
        'finalAverage',
        'indexmining' ,
        //peolple
        'indexpeople',
        'totalpr',
        //infrastruktur
        'averagePerformance',
        'indexinfra'
    ));    }    
}
