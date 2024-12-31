<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InfrastructureReadiness;
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
    ]);
        
        $validatedData['updated_by'] = auth()->user()->username;
        
        $peopleReadiness = InfrastructureReadiness::findOrFail($id);
        $peopleReadiness->update($validatedData);
        
        return redirect('/indexPeople')->with('success', 'Data berhasil diperbarui.');
    }


}
