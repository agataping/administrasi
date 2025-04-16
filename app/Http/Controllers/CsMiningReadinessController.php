<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\csMiningReadiness;
use App\Models\KategoriCsMining;

class CsMiningReadinessController extends Controller
{
    public function indexCSmining(Request $request)
    {

        $data = DB::table('cs_mining_readinesses')
        ->join('kategori_cs_minings', 'cs_mining_readinesses.KatgoriDescription', '=', 'kategori_cs_minings.kategori')
        ->join('users', 'cs_mining_readinesses.created_by', '=', 'users.username')
        ->where('kategori_cs_minings.kategori', 'Lingkungan')
        ->select('cs_mining_readinesses.*', 'users.username as created_by')
        ->get();
    
      
        $dataP = DB::table('cs_mining_readinesses')
        ->join('kategori_cs_minings', 'cs_mining_readinesses.KatgoriDescription', '=', 'kategori_cs_minings.kategori')
        ->join('users', 'cs_mining_readinesses.created_by', '=', 'users.username')
        ->where('kategori_cs_minings.kategori', 'Penjualan')
        ->select('cs_mining_readinesses.*', 'users.username as created_by')
        ->get();  
        $dataK = DB::table('cs_mining_readinesses')
        ->join('kategori_cs_minings', 'cs_mining_readinesses.KatgoriDescription', '=', 'kategori_cs_minings.kategori')
        ->join('users', 'cs_mining_readinesses.created_by', '=', 'users.username')
        ->where('kategori_cs_minings.kategori', 'Keuangan')
        ->select('cs_mining_readinesses.*', 'users.username as created_by')
        ->get();  
        $dataL = DB::table('cs_mining_readinesses')
        ->join('kategori_cs_minings', 'cs_mining_readinesses.KatgoriDescription', '=', 'kategori_cs_minings.kategori')
        ->join('users', 'cs_mining_readinesses.created_by', '=', 'users.username')
        ->where('kategori_cs_minings.kategori', 'Legalitas')
        ->select('cs_mining_readinesses.*', 'users.username as created_by')
        ->get();      
        
        
        //filter tahun di laporan
        $year = $request->input('year');
        $reports = csMiningReadiness::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();



        //hitung total berdasarkan kategori
        $avarage = csMiningReadiness::selectRaw('REPLACE(Achievement, "%", "") as total_numeric')
        ->when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })
        
        ->where('KatgoriDescription', 'Lingkungan')
        ->get()
        ->avg('total_numeric');


        //hitung total berdasarkan kategori
        $avarageL = csMiningReadiness::selectRaw('REPLACE(Achievement, "%", "") as total_numeric')
        ->when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })
        
        ->where('KatgoriDescription', 'Legalitas')
        ->get()
        ->avg('total_numeric');

        //hitung total berdasarkan kategori
        $avarageP = csMiningReadiness::selectRaw('REPLACE(Achievement, "%", "") as total_numeric')
        ->when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })
        
        ->where('KatgoriDescription', 'Penjualan')
        ->get()
        ->avg('total_numeric');
        
        //hitung total berdasarkan kategori
        $avarageK = csMiningReadiness::selectRaw('REPLACE(Achievement, "%", "") as total_numeric')
        ->when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })
        
        ->where('KatgoriDescription', 'Keuangan')
        ->get()
        ->avg('total_numeric');



       $years = csMiningReadiness::selectRaw('YEAR(created_at) as year')
           ->distinct()
           ->orderBy('year', 'desc')
           ->pluck('year');




        return view('CSMining.index',compact('data','dataP','dataK','dataL','reports','years','year','avarage','avarageL','avarageP','avarageK'));
    }

        //UNTUK MENAMPILAKN FORM dan ADD DATA NAMA LABA RUGI
        public function FormKategoriCsMining()
        {
            return view('CSMining.formKategori');
        }
        
        public function createKatgoriCsMining(Request $request) {
            $validatedData = $request->validate([
              'kategori' => 'required|array',
              'kategori.*' => 'required|string',
            ]);
          
            foreach ($validatedData['kategori'] as $nama) {
                KategoriCsMining::create(['kategori' => $nama]);
            }
          
            return redirect('/indexCSmining')->with('success', 'Data saved successfully..');
          }
          
        //UNTUK MENAMPILAKN FORM dan ADD DATA NAMA LABA RUGI
        public function FormCsMining() {
            $kategori = KategoriCsMining::all();
            return view('CSMining.formMining', compact('kategori'));
        }        
        public function CreateCsMining(Request $request)
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

            csMiningReadiness::create($validatedData);
    
            return redirect('/indexCSmining')->with('success', 'Data saved successfully..');
        }

                //update data
                public function FormCsupdateMining($id)
                {
                    $kategori = KategoriCsMining::all();
                    $mining = csMiningReadiness::findOrFail($id);
        
                    return view('CSMining.updateMining',compact('mining','kategori'));
                }
        
                public function updateCsMining(Request $request, $id)
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
                    
                    $mining = csMiningReadiness::findOrFail($id);
                    $mining->update($validatedData);
                    
                    return redirect('/indexCSmining')->with('success', 'Data berhasil diperbarui.');
                }
        

}
