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
    public function reportkpi() {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $companyName = DB::table('detailabarugis')
                ->join('users', 'detailabarugis.created_by', '=', 'users.username')
                ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
                ->select('perusahaans.nama as company_name')
                ->distinct() 
                ->get();
            

        } else {
            // Jika bukan admin, ambil perusahaan user sendiri
            $companyName = DB::table('users')
                ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
                ->select('perusahaans.nama as company_name')
                ->where('users.id', $user->id)
                ->first();
            
            if (!$companyName) {
                return response()->json(['message' => 'Perusahaan tidak ditemukan'], 404);
            }
        }
        
               
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

            ->where(function($query) {
                if(auth()->user()->role === 'admin') {
                    $query->where('detailabarugis.created_by', '!=', '');
                } else {
                    $query->where('detailabarugis.created_by', auth()->user()->username);
                }
            });
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
            ->where('category_labarugis.namecategory', 'Cost of Goods Sold (COGS)')
            ->get()
            ->sum(function ($item) {
                return (float)str_replace(',', '', $item->nominalactual ?? 0);
        });
        $totalplancogas = (clone $query)
            ->where('category_labarugis.namecategory', 'Cost of Goods Sold (COGS)')
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
            //operasional
            $planoppersen = $totalRevenuep ? ($planoperasional / $totalRevenuep) * 100 : 0;
            $actualoppersen = $totalRevenuep ? ($totalactualOp / $totalRevenuea) * 100 : 0;
            // dd($actualoppersen);
            //operating profit
            $totalplanlp = $totalplanlr-$planoperasional;
            $totalactualOp = $actualoperasional-$totalactuallr;
            $verticallp = $totalRevenuep ? ($totalplanlp / $totalRevenuep) * 100 : 0;
            $verticalop = $totalRevenuea ? ($totalactualOp / $totalRevenuea) * 100 : 0;
            $deviasiop = $totalplanlp-$totalactualOp;
            $persenop = $totalplanlp ? ($totalactualOp / $totalplanlp) * 100 : 0;
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
    
        // Memetakan data untuk menampilkan laporan KPI
        $totals = $data->map(function ($categories, $jenisName) use ($totalRevenuep, $totalRevenuea) {
            return [
                'jenis_name' => $jenisName,
                'categories' => $categories->map(function ($kategori) use ($totalRevenuep, $totalRevenuea) {
                    $totalPlan = $kategori->sum(fn($item) => (float) str_replace(',', '', $item->nominalplan ?? 0));
                    $totalActual = $kategori->sum(fn($item) => (float) str_replace(',', '', $item->nominalactual ?? 0));
    
                    // Calculate deviation and percentage here
                    $deviation = $totalPlan - $totalActual;
                    $percentage = $totalPlan != 0 ? ($totalActual / $totalPlan) * 100 : 0;
                    $vertikalanalisis = $totalRevenuep ? ($totalPlan / $totalRevenuep) * 100 : 0;
                    $vertikalanalisiss = $totalRevenuea ? ($totalPlan / $totalRevenuea) * 100 : 0;
    
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
        ->join('plan_bargings', 'bargings.kuota', '=', 'plan_bargings.kuota')
        ->leftJoin('users', 'bargings.created_by', '=', 'users.username') 

        ->select('bargings.*', 'plan_bargings.nominal', 'bargings.kuota')
        ->where(function($query) {
            if(auth()->user()->role === 'admin') {
                $query->where('bargings.created_by', '!=', '');
            } else {
                $query->where('bargings.created_by', auth()->user()->username);
            }
        });        
        $data = $query->get();
        
        $categories = ['Ekspor', 'Domestik'];
        $results = [];
        
        $totalPlanAll = $data->sum('nominal'); 
        // dd($totalPlanAll);
        $totalActualAll = $data->sum(function ($d) {
            return floatval(str_replace(',', '', $d->quantity));
        });
        $index= $totalPlanAll? ($totalActualAll/$totalPlanAll)* 100 : 0;
        
        $results['total'] = [
            'Plan' => number_format($totalPlanAll, 2, ',', '.'),
            'Actual' => number_format($totalActualAll, 2, ',', '.'),
            'Index' => $index
            
        ];
        
        foreach ($categories as $category) {
            $filteredData = $data->where('kuota', $category);
            
            $totalPlan = $filteredData->sum('nominal'); 
            $totalActual = $filteredData->sum(function ($d) {
                return floatval(str_replace(',', '', $d->quantity));
            });
            $index= $totalPlan? ($totalActual/$totalPlan)* 100 : 0;
            
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

        ->select( 'kategori_overcoals.name as kategori_name','overberden_coal.*')
        ->where(function($query) {
            if(auth()->user()->role === 'admin') {
                $query->where('overberden_coal.created_by', '!=', '');
            } else {
                $query->where('overberden_coal.created_by', auth()->user()->username);
            }
        });        $data = $query->get();
        $totalPlancoal = $data->where('kategori_name', 'Coal Getting')->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalplan ?? 0);
        });
        
        $totalActualcoal = $data->where('kategori_name', 'Coal Getting')->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalactual ?? 0);
        });
        
        $percentageactual = $totalPlancoal != 0 ? ($totalActualcoal / $totalPlancoal) * 100 : 0;

        // Inisialisasi total nilai untuk Over Burden
        $totalPlanob = $data->where('kategori_name', 'Over Burden')->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalplan ?? 0);
        });
        // dd($totalPlanob);
        $totalActualob = $data->where('kategori_name', 'Over Burden')->sum(function ($item) {
            return (float)str_replace(',', '', $item->nominalactual ?? 0);
        });
        $percentageob = $totalPlanob != 0 ? ($totalActualob / $totalPlanob) * 100 : 0;


        //PA 
        $query = DB::table('units')
        ->join('produksi_pas', 'units.id', '=', 'produksi_pas.unit_id')
        ->leftJoin('users', 'units.created_by', '=', 'users.username') 
        ->select(
            'units.unit as units',
            'produksi_pas.plan as pas_plan',
            'produksi_pas.actual as pas_actual',
        )
        ->where(function($query) {
            if(auth()->user()->role === 'admin') {
                $query->where('units.created_by', '!=', '');
            } else {
                $query->where('units.created_by', auth()->user()->username);
            }
        });    
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
    
        $indexpa = $totalPasPlan != 0 ? ($totalPasActual / $totalPasPlan) * 100 : 0;
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

    ->select('*')
    ->where(function($query) {
        if(auth()->user()->role === 'admin') {
            $query->where('pembebasan_lahans.created_by', '!=', '');
        } else {
            $query->where('pembebasan_lahans.created_by', auth()->user()->username);
        }
    });    
    $dataPembebasan = $query->get();
    
    $averageAchievement = $dataPembebasan->average(function ($item) {
        return (float)str_replace('%', '', $item->Achievement);
    });
    
    // Mining Readiness
    $query = DB::table('mining_readinesses')
    ->join('kategori_mini_r_s', 'mining_readinesses.KatgoriDescription', '=', 'kategori_mini_r_s.kategori')
    ->join('users', 'mining_readinesses.created_by', '=', 'users.username')
    ->select('kategori_mini_r_s.kategori', 'mining_readinesses.*')
    ->where(function($query) {
        if(auth()->user()->role === 'admin') {
            $query->where('mining_readinesses.created_by', '!=', '');
        } else {
            $query->where('mining_readinesses.created_by', auth()->user()->username);
        }
    });    
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
    $indexmining = $finalAverage != 0 ? ($finalAverage * 100) / 100 : 0;


    //people readiness
    $totalQuality = 0;
    $totalQuantity = 0;
    $count = 0; 
    $querypeople = DB::table('people_readinesses') 
    ->join('users', 'people_readinesses.created_by', '=', 'users.username') 

    ->select('*')
    ->where(function($query) {
        if(auth()->user()->role === 'admin') {
            $query->where('people_readinesses.created_by', '!=', '');
        } else {
            $query->where('people_readinesses.created_by', auth()->user()->username);
        }
    });   $people = $querypeople->get();
    
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
    $indexpeople = $totalpr != 0 ? ($totalpr * 100) / 100 : 0;


    //infrastruktur
    $queryinfra = DB::table('infrastructure_readinesses')
    ->join('users', 'infrastructure_readinesses.created_by', '=', 'users.username') 
    ->select('*')
    ->where(function($query) {
        if(auth()->user()->role === 'admin') {
            $query->where('infrastructure_readinesses.created_by', '!=', '');
        } else {
            $query->where('infrastructure_readinesses.created_by', auth()->user()->username);
        }
    });    $datainfra = $queryinfra->get();
    $averagePerformance = DB::table('infrastructure_readinesses')
    ->selectRaw('REPLACE(total, "%", "") as total_numeric')
    ->get()
    ->map(function ($item) {
        return (float) $item->total_numeric;
    })
    ->avg();

    $indexinfra = $averagePerformance != 0 ? ($averagePerformance * 100) / 100 : 0;
    //stock jetty
    $query = DB::table('stock_jts')
    ->select('stock_jts.*')
    ->join('users', 'stock_jts.created_by', '=', 'users.username')
    ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
    ->where('stock_jts.created_by', auth()->user()->username);
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
    $indexstockjetty= $planNominalsj? ($grandTotal/$planNominalsj)* 100 : 0;







        return view('pt.report', compact('totals',
        //nama perusahaan
        'companyName',
        'user',
        //stock jetty
        'grandTotal','planNominalsj','indexstockjetty',
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
        'percentageob',
        'percentageactual',
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
