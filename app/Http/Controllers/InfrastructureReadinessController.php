<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InfrastructureReadiness;
use App\Models\Picainfrastruktur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InfrastructureReadinessController extends Controller
{
    public function indexInfrastructureReadiness(Request $request)
    {
        // Mendapatkan tanggal dari input pengguna
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Query untuk mengambil data dari tabel infrastructure_readinesses
        $query = DB::table('infrastructure_readinesses')
            ->select('*'); // Memilih semua kolom
        
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]); // Filter berdasarkan rentang tanggal
        }
        
        $data = $query->get();
    
        // Menghitung rata-rata performance berdasarkan kolom 'total'
        $averagePerformance = DB::table('infrastructure_readinesses')
            ->selectRaw('REPLACE(total, "%", "") as total_numeric')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            })
            ->get()
            ->map(function ($item) {
                // Konversi nilai ke numerik
                return (float) $item->total_numeric;
            })
            ->avg();
    
        // Mengirim data ke view
        return view('InfrastructureReadines.index', compact('data', 'averagePerformance'));
    }
        public function fromadd()
    {
        return view('InfrastructureReadines.addData');
    }


    public function createInfrastructureReadiness(Request $request)
    {

            $validatedData = $request->validate([ 
                'ProjectName' => 'required',
                'Preparation' => 'nullable',
                'Construction' => 'nullable',
                'Commissiong' => 'nullable',
                'KelayakanBangunan' => 'required',
                'Kelengakapan' => 'required',
                'Kebersihan' => 'required',
                'total' => 'required',
                'note' => 'nullable|string',
                'tanggal' => 'required|date',

            ]);
    
            $validatedData['created_by'] = auth()->user()->username;
            InfrastructureReadiness::create($validatedData); 

        return redirect('/indexInfrastructureReadiness')->with('success', 'data berhasil disimpan.');

    }

    public function formupdateInfrastructureReadiness($id){
        $data = InfrastructureReadiness::findOrFail($id);
        return view('InfrastructureReadines.updatedata', compact('data'));
    }

    //update
    public function updateInfrastructureReadiness(Request $request, $id)
    {
        $validatedData = $request->validate([
            'ProjectName' => 'required',
            'Preparation' => 'nullable',
            'Construction' => 'nullable',
            'Commissiong' => 'nullable',
            'KelayakanBangunan' => 'required',
            'Kelengakapan' => 'required',
            'Kebersihan' => 'required',
            'total' => 'required',
            'note' => 'nullable|string',
            'tanggal' => 'required|date',

    ]);
        
        $validatedData['updated_by'] = auth()->user()->username;
        
        $peopleReadiness = InfrastructureReadiness::findOrFail($id);
        $peopleReadiness->update($validatedData);
        
        return redirect('/indexPeople')->with('success', 'Data berhasil diperbarui.');
    }



    public function picainfrastruktur(Request $request)
    {
        $user = Auth::user();  
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $query = DB::table('picainfrastrukturs') 
            ->select('*'); // Memilih semua kolom dari tabel
        
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]); // Tidak perlu menyebut nama tabel
        }
        
        $data = $query->get();
        
    
        return view('picainfra.index', compact('data'));
    }

    
    public function formpicainfra()
    {
        $user = Auth::user();  
        return view('picainfra.addData');
    }

    public function createpicainfra(Request $request)
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
                Picainfrastruktur::create($validatedData);        
        return redirect('/picainfrastruktur')->with('success', 'Surat berhasil disimpan.');
    }

    public function formupdatepicainfra($id){
        $data = Picainfrastruktur::findOrFail($id);
        return view('picainfra.update', compact('data'));
    }

    public function updatepicainfra(Request $request, $id)
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
        
                $PicaPeople = Picainfrastruktur::findOrFail($id);
                $PicaPeople->update($validatedData);
        
        return redirect('/picainfrastruktur')->with('success', 'Surat berhasil disimpan.');
    }



}
