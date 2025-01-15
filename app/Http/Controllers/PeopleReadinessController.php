<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\PeopleReadiness;
use App\Models\picaPeople;
use App\Models\Gambar;

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


        //hitung total quantity dan quality
        $totalQuality = 0;
        $totalQuantity = 0;
        $count = 0; 
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $query = DB::table('people_readinesses') 
            ->select('*'); 
        
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]); // Tidak perlu menyebut nama tabel
        }
        
        $data = $query->get();
        
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
        return view('PeopleReadiness.index', compact('data','averageQuality', 'averageQuantity','tot'));
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
            'note' => 'nullable|string',
            'tanggal' => 'required|date',

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
                    'note' => 'nullable|string',
                    'tanggal' => 'required|date',


                ]);
                $validatedData['created_by'] = auth()->user()->username;
                PeopleReadiness::create($validatedData);        
        return redirect('/indexPeople')->with('success', 'Surat berhasil disimpan.');
    }



    public function indexpicapeople(Request $request)
    {
        $user = Auth::user();  
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $query = DB::table('pica_people') 
            ->select('*'); // Memilih semua kolom dari tabel
        
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]); // Tidak perlu menyebut nama tabel
        }
        
        $data = $query->get();
        
    
        return view('picapeople.index', compact('data'));
    }

    
    public function formpicapeople()
    {
        $user = Auth::user();  
        return view('picapeople.addData');
    }

    public function createpicapeople(Request $request)
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
                PicaPeople::create($validatedData);        
        return redirect('/indexpicapeople')->with('success', 'Surat berhasil disimpan.');
    }

    public function formupdatepicapeople($id){
        $data = picaPeople::findOrFail($id);
        return view('picapeople.update', compact('data'));
    }

    public function updatepicapeople(Request $request, $id)
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
        
                $PicaPeople = PicaPeople::findOrFail($id);
                $PicaPeople->update($validatedData);
        
        return redirect('/indexpicapeople')->with('success', 'Surat berhasil disimpan.');
    }


    //gambar atau struktur organisasi
    public function struktur(){
        $gambar = Gambar::latest()->first();
        return view('PeopleReadiness.organisasi.index', compact('gambar'));
    }
    public function formbagan(){
        return view('PeopleReadiness.organisasi.addGambar');
    }
    public function createbagan(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Menangani file gambar
        if ($request->hasFile('gambar')) {
            // Ambil file gambar yang diupload
            $file = $request->file('gambar');
            
            // Tentukan path penyimpanan gambar
            $path = $file->store('gambar', 'public'); // Menyimpan gambar di 'storage/app/public/gambar'
    
            // Simpan path gambar ke tabel gambar
            Gambar::create([
                'path' => $path,
            ]);
        
                return back()->with('success', 'Image uploaded successfully');
        }

        return back()->withErrors('Failed to upload image.');
    }
    
}            
