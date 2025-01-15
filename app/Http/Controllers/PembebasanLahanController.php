<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PembebasanLahan;
use App\Models\PicaPl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PembebasanLahanController extends Controller
{
        //UNTUK index pembebasan lahan
        public function indexPembebasanLahan(Request $request)
        {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            
            // Query untuk mengambil data dari tabel pembebasan_lahans
            $query = DB::table('pembebasan_lahans')
                ->select('*'); // Memilih semua kolom dari tabel
            
            // Filter berdasarkan rentang tanggal jika ada
            if ($startDate && $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            }
            
            // Mendapatkan data
            $data = $query->get();
        
            // Menghitung rata-rata achievement dengan mengonversi nilai % menjadi angka
            $averageAchievement = $data->average(function ($item) {
                // Menghapus simbol % dan mengubah nilai menjadi float
                return (float)str_replace('%', '', $item->Achievement);
            });

            return view('pembebasanlahan.index',compact('data','averageAchievement'));
        }

        public function formlahan()
        {
            return view('pembebasanlahan.addData');
        }
        //create data
        public function createPembebasanLahan(Request $request)
        {
            $validatedData = $request->validate([

                'NamaPemilik' => 'required',
                'LuasLahan' => 'required',
                'KebutuhanLahan' => 'required',
                'Progress' => 'required',
                'Status' => 'nullable',
                'targetselesai' => 'nullable',
                'Achievement' => 'required',
                'tanggal' => 'required|date',

                

            ]);
    
            $validatedData['created_by'] = auth()->user()->username;
            PembebasanLahan::create($validatedData);

            return redirect('/indexPembebasanLahan')->with('success', 'data berhasil disimpan.');

        }

        //update data
        public function formUpdatelahan($id)
        {
            $pembebasanLahan =PembebasanLahan::findOrFail($id);
            return view('pembebasanlahan.updatedata',compact('pembebasanLahan'));
        }

        public function updatePembebasanLahan(Request $request, $id)
        {
            $validatedData = $request->validate([

                'NamaPemilik' => 'required',
                'LuasLahan' => 'required',
                'KebutuhanLahan' => 'required',
                'Progress' => 'required',
                'Status' => 'nullable',
                'targetselesai' => 'nullable',
                'Achievement' => 'required',
                'tanggal' => 'required|date',
                

            ]);
    
            $validatedData['updated_by'] = auth()->user()->username;

            $PembebasanLahan = PembebasanLahan::findOrFail($id);
            $PembebasanLahan->update($validatedData);
            return redirect('/indexPembebasanLahan')->with('success', 'data berhasil disimpan.');

        }

        public function picapl(Request $request)
        {
            $user = Auth::user();
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            
            $query = DB::table('pica_pls') 
                ->select('*'); // Memilih semua kolom dari tabel
            
            if ($startDate && $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]); // Tidak perlu menyebut nama tabel
            }
            
            $data = $query->get();
                        
            return view('picapl.index', compact('data'));
        }
        
        public function formpicapl()
        {
            $user = Auth::user();
            return view('picapl.addData');
        }
        
        public function createpicapl(Request $request)
        {
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
            PicaPl::create($validatedData);
            
            return redirect('/picapl')->with('success', 'Data berhasil disimpan.');
        }
        
        public function formupdatepicapl($id)
        {
            $data = PicaPl::findOrFail($id);
            return view('picapl.update', compact('data'));
        }
        
        public function updatepicapl(Request $request, $id)
        {
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
            
            $PicaPeople = PicaPl::findOrFail($id);
            $PicaPeople->update($validatedData);
            
            return redirect('/picapl')->with('success', 'data berhasil disimpan.');
        }

    
}
