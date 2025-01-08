<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InfrastructureReadiness;
use App\Models\Picainfrastruktur;
class InfrastructureReadinessController extends Controller
{
    public function indexInfrastructureReadiness(Request $request)
    {
        //  data
        $data = InfrastructureReadiness::all();
        $year = $request->input('year');
    
        // Hitung rata-rata "total" dengan menghapus simbol '%' terlebih dahulu
        $averagePerformance = InfrastructureReadiness::selectRaw('REPLACE(total, "%", "") as total_numeric')
            ->when($year, function ($query, $year) {
                return $query->whereYear('created_at', $year);
            })
            ->get()
            ->avg('total_numeric');
    
        // Filter laporan berdasarkan tahun
        $reports = InfrastructureReadiness::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();
    
        $years = InfrastructureReadiness::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
    
        return view('InfrastructureReadines.index', compact('data', 'year', 'years', 'reports', 'averagePerformance'));
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
    ]);
        
        $validatedData['updated_by'] = auth()->user()->username;
        
        $peopleReadiness = InfrastructureReadiness::findOrFail($id);
        $peopleReadiness->update($validatedData);
        
        return redirect('/indexPeople')->with('success', 'Data berhasil diperbarui.');
    }



    public function picainfrastruktur(Request $request)
    {
        $user = Auth::user();  
        $data = Picainfrastruktur::all();
        $year = $request->input('year');

        //filter tahun di laporan
        $reports = Picainfrastruktur::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();
        
    $years = Picainfrastruktur::selectRaw('YEAR(created_at) as year')
    ->distinct()
    ->orderBy('year', 'desc')
    ->pluck('year');
    
        return view('picainfra.index', compact('data','reports','years', 'year'));
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
                ]);
                $validatedData['updated_by'] = auth()->user()->username;
        
                $PicaPeople = Picainfrastruktur::findOrFail($id);
                $PicaPeople->update($validatedData);
        
        return redirect('/picainfrastruktur')->with('success', 'Surat berhasil disimpan.');
    }



}
