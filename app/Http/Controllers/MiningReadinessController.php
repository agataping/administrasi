<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\KategoriMiniR;
use App\Models\MiningReadiness;
use App\Models\PicaMining;

class MiningReadinessController extends Controller
{
    public function indexmining(Request $request)
    {
        //filter data perbaikan pakai tanggal
        $year = $request->input('year');
        $reports = MiningReadiness::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();
        
        $years = MiningReadiness::selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');
        
        //ngambil data
        $data = DB::table('mining_readinesses')
        ->join('kategori_mini_r_s', 'mining_readinesses.KatgoriDescription', '=', 'kategori_mini_r_s.kategori')
        ->join('users', 'mining_readinesses.created_by', '=', 'users.username')
        ->when($year, function ($query, $year) {
            return $query->whereYear('mining_readinesses.created_at', $year);
        })
        ->select(
            'kategori_mini_r_s.kategori',
            'mining_readinesses.Description',
            'mining_readinesses.NomerLegalitas',
            'mining_readinesses.tanggal',
            'mining_readinesses.status',
            'mining_readinesses.berlaku',
            'mining_readinesses.nomor',
            'mining_readinesses.id',
            'mining_readinesses.Achievement',
            'mining_readinesses.filling',
            'mining_readinesses.created_by',
            'mining_readinesses.KatgoriDescription'
            )
            ->get();

            //hitung achievement, konversi data, kelompok+hitung data by"kategori"
            $data->transform(function ($item) 
            {
                $achievement = str_replace('%', '', $item->Achievement);
                $item->average_achievement = $achievement ? (float)$achievement : 0;
                return $item;
            });
            $groupedData = $data->groupBy('kategori')->map(function ($items) {
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
            //hitung tot. aspect 
            $totalCategories = $groupedData->count(); 
            $totalAspect = round($totalAllCategories / $totalCategories, 2);
            //cek hitungan sesuai gak + cocokin hitungan di excel 
            // dd([
            //     'totalAllCategories' => $totalAllCategories,
            //     'totalCategories' => $totalCategories,
            //     'totalAspect' => $totalAspect,
            // ]);
            //  total "Legal Aspect"
            $groupedData = $groupedData->map(function ($items, $key) use ($totalAspect) {
                if ($key === 'Legal Aspect') {
                    return $items->map(function ($item) use ($totalAspect) {
                        $item->average_achievement = $totalAspect;
                        return $item;
                    });
                }
                return $items;
            });
            return view('Mining.index', compact('groupedData', 'reports', 'years', 'year','totalAspect'));
        }
        
        public function FormKategori()
        {
            return view('Mining.formKategori');
        }
        
        public function createKatgori(Request $request)
        
        {
            $validatedData = $request->validate([
                'kategori' => 'required|array',
                'kategori.*' => 'required|string',
            ]);
            $createdBy = auth()->user()->username;
            
            foreach ($validatedData['kategori'] as $nama) {
                KategoriMiniR::create(['kategori' => $nama]);
            }
            
            return redirect('/indexmining')->with('success', 'Data berhasil disimpan.');
        }
        
        public function FormMining()
        {
            $kategori = KategoriMiniR::all();
            return view('Mining.formMining', compact('kategori'));
        }
        
        public function CreateMining(Request $request)
        {
            $validatedData = $request->validate([
                'Description' => 'required',
                'NomerLegalitas' => 'nullable',
                'status' => 'nullable',
                'Achievement' => 'required',
                'tanggal' => 'nullable',
                'berlaku' => 'nullable',
                'nomor' => 'required',
                'filling' => 'nullable',
                'KatgoriDescription' => 'required',
            ]);
            
            $validatedData['created_by'] = auth()->user()->username;
            MiningReadiness::create($validatedData);
            
            return redirect('/indexmining')->with('success', 'Data berhasil disimpan.');
        }
        
        public function FormMiningUpdate($id)
        {
            $kategori = KategoriMiniR::all();
            $mining = MiningReadiness::findOrFail($id);
            
            return view('Mining.updateMining', compact('mining', 'kategori'));
        }
        
        public function UpdateMining(Request $request, $id)
        {
            $validatedData = $request->validate([
                'Description' => 'required',
                'NomerLegalitas' => 'nullable',
                'status' => 'nullable',
                'Achievement' => 'required',
                'tanggal' => 'nullable',
                'berlaku' => 'nullable',
                'nomor' => 'required',
                'filling' => 'nullable',
                'KatgoriDescription' => 'required',
            ]);
            
            $validatedData['updated_by'] = auth()->user()->username;
            
            $mining = MiningReadiness::findOrFail($id);
            $mining->update($validatedData);
            
            return redirect('/indexmining')->with('success', 'Data berhasil diperbarui.');
        }
        
        public function picamining(Request $request)
        {
            $user = Auth::user();
            $data = PicaMining::all();
            $year = $request->input('year');
            
            $reports = PicaMining::when($year, function ($query, $year) {
                return $query->whereYear('created_at', $year);
            })->get();
            
            $years = PicaMining::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
            
            return view('picamining.index', compact('data', 'reports', 'years', 'year',));
        }
        
        public function formpicamining()
        {
            $user = Auth::user();
            return view('picamining.addData');
        }
        
        public function createpicamining(Request $request)
        {
            $validatedData = $request->validate([
                'problem' => 'required|string',
                'corectiveaction' => 'required|string',
                'cause' => 'required|string',
                'duedate' => 'required|string',
                'pic' => 'required|string',
                'status' => 'required|string',
                'remerks' => 'required|string',
            ]);
            $validatedData['created_by'] = auth()->user()->username;
            PicaMining::create($validatedData);
            
            return redirect('/picamining')->with('success', 'Data berhasil disimpan.');
        }
        
        public function formupdatepicamining($id)
        {
            $data = PicaMining::findOrFail($id);
            return view('picamining.update', compact('data'));
        }
        
        public function updatepicamining(Request $request, $id)
        {
            $validatedData = $request->validate([
                'problem' => 'required|string',
                'corectiveaction' => 'required|string',
                'cause' => 'required|string',
                'duedate' => 'required|string',
                'pic' => 'required|string',
                'status' => 'required|string',
                'remerks' => 'required|string',
            ]);
            $validatedData['updated_by'] = auth()->user()->username;
            
            $PicaPeople = PicaMining::findOrFail($id);
            $PicaPeople->update($validatedData);
            
            return redirect('/picamining')->with('success', 'data berhasil disimpan.');
        }
        
        


}
