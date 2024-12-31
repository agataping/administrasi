<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\PeopleReadiness;

class PeopleReadinessController extends Controller
{
        public function dashboard(){
        if (Auth::check()) {
            $username = Auth::user()->name;
            return view('components.main', ['username' => $username]);
        } else {
            // Handle the case when the user is not authenticated
            return redirect('/login');
        }
    }
    
    public function indexPeople(Request $request)
    {
        $user = Auth::user();  
        $data = PeopleReadiness::all();
        $year = $request->input('year');

        //filter tahun di laporan
        $reports = PeopleReadiness::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();
    
        $years = PeopleReadiness::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        //hitung total quantity dan quality
        $totalQuality = 0;
        $totalQuantity = 0;
        $count = 0; 
    
        foreach ($data as $d) {
            $qualityPlan = floatval(str_replace('%', '', $d->Quality_plan));
            $quantityPlan = floatval(str_replace('%', '', $d->Quantity_plan));
    
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
    
        $tot = ($averageQuality + $averageQuantity) / 2;
        return view('PeopleReadiness.index', compact('data','reports','years', 'year','averageQuality', 'averageQuantity','tot'));
    }

    public function formPR()
    {
        $user = Auth::user();  
        return view('PeopleReadiness.addData');
    }

    public function formupdate($id){
        $peopleReadiness = PeopleReadiness::findOrFail($id);
        return view('PeopleReadiness.update', compact('peopleReadiness'));
    }

    //update
    public function updatedata(Request $request, $id)
    {
        $validatedData = $request->validate([
            'posisi' => 'required|string',
            'Fullfillment_plan' => 'required|integer',
            'Fullfillment_actual' => 'required|integer',
            'HSE_plan' => 'required|integer',
            'Leadership_plan' => 'required|integer',
            'Improvement_plan' => 'required|integer',
            'Quantity_plan' => 'required|string|max:11',
            'HSE_actual' => 'required|integer',
            'Leadership_actual' => 'required|integer',
            'Improvement_actual' => 'required|integer',
            'pou_pou_plan' => 'required|integer',
            'Quality_plan' => 'required|string',
            'pou_pou_actual' => 'required|integer',
        ]);
        
        $validatedData['updated_by'] = auth()->user()->username;
        
        $peopleReadiness = PeopleReadiness::findOrFail($id);
        $peopleReadiness->update($validatedData);
        
        return redirect('/indexPeople')->with('success', 'Data berhasil diperbarui.');
    }
    
    //add
    public function createDataPR(Request $request)
    {
                // dd($request->all());


                $validatedData = $request->validate([
                    'posisi' => 'required|string',
                    'Fullfillment_plan' => 'required|integer',
                    'Fullfillment_actual' => 'required|integer',
                    'HSE_plan' => 'required|integer',
                    'Leadership_plan' => 'required|integer',
                    'Improvement_plan' => 'required|integer',
                    'Quantity_plan' => 'required|string|max:11',
                    'HSE_actual' => 'required|integer',
                    'Leadership_actual' => 'required|integer',
                    'Improvement_actual' => 'required|integer',
                    'pou_pou_plan' => 'required|integer',
                    'Quality_plan' => 'required|string',
                    'pou_pou_actual' => 'required|integer',
                ]);
                $validatedData['created_by'] = auth()->user()->username;
                PeopleReadiness::create($validatedData);        
        return redirect('/indexPeople')->with('success', 'Surat berhasil disimpan.');
    }


}
