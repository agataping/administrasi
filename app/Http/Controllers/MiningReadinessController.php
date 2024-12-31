<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\KategoriMiniR;
use App\Models\MiningReadiness;

class MiningReadinessController extends Controller
{
    public function indexmining(Request $request)
    {
        $data = DB::table('mining_readinesses')
        ->join('kategori_mini_r_s', 'mining_readinesses.KatgoriDescription', '=', 'kategori_mini_r_s.kategori')
        ->join('users', 'mining_readinesses.created_by', '=', 'users.username')
        ->where('kategori_mini_r_s.kategori', 'Lingkungan')
        ->select('mining_readinesses.*', 'users.username as created_by')
        ->get();
    
      
        $dataP = DB::table('mining_readinesses')
        ->join('kategori_mini_r_s', 'mining_readinesses.KatgoriDescription', '=', 'kategori_mini_r_s.kategori')
        ->join('users', 'mining_readinesses.created_by', '=', 'users.username')
        ->where('kategori_mini_r_s.kategori', 'Penjualan')
        ->select('mining_readinesses.*', 'users.username as created_by')
        ->get();  
        $dataK = DB::table('mining_readinesses')
        ->join('kategori_mini_r_s', 'mining_readinesses.KatgoriDescription', '=', 'kategori_mini_r_s.kategori')
        ->join('users', 'mining_readinesses.created_by', '=', 'users.username')
        ->where('kategori_mini_r_s.kategori', 'Keuangan')
        ->select('mining_readinesses.*', 'users.username as created_by')
        ->get();  
        $dataL = DB::table('mining_readinesses')
        ->join('kategori_mini_r_s', 'mining_readinesses.KatgoriDescription', '=', 'kategori_mini_r_s.kategori')
        ->join('users', 'mining_readinesses.created_by', '=', 'users.username')
        ->where('kategori_mini_r_s.kategori', 'Legalitas')
        ->select('mining_readinesses.*', 'users.username as created_by')
        ->get();      
        
        
        //filter tahun di laporan
        $year = $request->input('year');
        $reports = MiningReadiness::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();



        //hitung total berdasarkan kategori
        $avarage = MiningReadiness::selectRaw('REPLACE(Achievement, "%", "") as total_numeric')
        ->when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })
        
        ->where('KatgoriDescription', 'Lingkungan')
        ->get()
        ->avg('total_numeric');


        //hitung total berdasarkan kategori
        $avarageL = MiningReadiness::selectRaw('REPLACE(Achievement, "%", "") as total_numeric')
        ->when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })
        
        ->where('KatgoriDescription', 'Legalitas')
        ->get()
        ->avg('total_numeric');

        //hitung total berdasarkan kategori
        $avarageP = MiningReadiness::selectRaw('REPLACE(Achievement, "%", "") as total_numeric')
        ->when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })
        
        ->where('KatgoriDescription', 'Penjualan')
        ->get()
        ->avg('total_numeric');
        
        //hitung total berdasarkan kategori
        $avarageK = MiningReadiness::selectRaw('REPLACE(Achievement, "%", "") as total_numeric')
        ->when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })
        
        ->where('KatgoriDescription', 'Keuangan')
        ->get()
        ->avg('total_numeric');



       $years = MiningReadiness::selectRaw('YEAR(created_at) as year')
           ->distinct()
           ->orderBy('year', 'desc')
           ->pluck('year');
        return view('Mining.index',compact('data','dataP','dataK','dataL','reports','years','year','avarage','avarageL','avarageP','avarageK'));
         }




        //UNTUK MENAMPILAKN FORM dan ADD DATA NAMA LABA RUGI
        public function FormKategori()
        {
            return view('Mining.formKategori');
        }
        
        public function createKatgori(Request $request) {
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
          
        //UNTUK MENAMPILAKN FORM dan ADD DATA NAMA LABA RUGI
        public function FormMining()
        {
            $kategori = KategoriMiniR::all();
            return view('Mining.formMining',compact('kategori'));
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

            return redirect('/indexmining')->with('success', 'data berhasil disimpan.');
        }


        //update data
        public function FormMiningUpdate($id)
        {
            $kategori = KategoriMiniR::all();
            $mining = MiningReadiness::findOrFail($id);

            return view('Mining.updateMining',compact('mining','kategori'));
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
    
        


}
