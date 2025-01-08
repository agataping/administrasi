<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\kategoriHse;
use App\Models\Hse;
use App\Models\PicaHse;
class HseController extends Controller
{
    public function indexhse(Request $request)
    {
        $data = DB::table('hses')
        ->join('kategori_hses', 'hses.kategori_id', '=', 'kategori_hses.id')
        ->join('users', 'hses.created_by', '=', 'users.username')
        ->select(
            'hses.id',
            'hses.nameindikator',
            'hses.target',
            'hses.nilai',
            'hses.indikator',
            'hses.keterangan',
            'kategori_hses.name as kategori_name',
            'users.username as created_by'
        )
        ->orderBy('kategori_hses.name') 
        ->get()
        ->groupBy('kategori_name'); 
    
    
        
        //filter tahun di laporan
        $year = $request->input('year');
        $reports = Hse::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();

       $years = Hse::selectRaw('YEAR(created_at) as year')
           ->distinct()
           ->orderBy('year', 'desc')
           ->pluck('year');
        return view('hse.index',compact('data','reports','years','year'));
    }

        public function formkategorihse()
        {
            return view('hse.formkategori');
            
        }
        public function formhse()
        {
            $data = kategoriHse :: all();
            return view('hse.addData',compact('data'));
        }

        public function createhse(Request $request)
        {
            $validatedData = $request->validate([
                'nameindikator' => 'required',
                'date' => 'required',
                'indikator' => 'nullable',
                'target' => 'nullable',
                'nilai' => 'required',
                'keterangan' => 'nullable',
                'kategori_id' => 'required',
            ]);
    
            $validatedData['created_by'] = auth()->user()->username;
            Hse::create($validatedData);

            return redirect('/indexhse')->with('success', 'data berhasil disimpan.');
        }

        public function createkategorihse(Request $request) {
            $validatedData = $request->validate([
              'name' => 'required',
            ]);
            $createdBy = auth()->user()->username;
            kategoriHse::create($validatedData);  
            return redirect('/indexhse')->with('success', 'Data berhasil disimpan.');
        }

        public function updatehse(Request $request, $id)
        {
            $validatedData = $request->validate([
                'nameindikator' => 'required',
                'indikator' => 'nullable',
                'target' => 'nullable',
                'nilai' => 'required',
                'date' => 'required',

                'keterangan' => 'nullable',
                'kategori_id' => 'required',
        ]);
            
            $validatedData['updated_by'] = auth()->user()->username;
            
            $hse = Hse::findOrFail($id);
            $hse->update($validatedData);
            
            return redirect('/indexhse')->with('success', 'Data berhasil diperbarui.');
        }

        public function formupdatehse($id)
        {
            $kategori = kategoriHse::all();
            $hse = hse::findOrFail($id);

            return view('hse.update',compact('hse','kategori'));
        }

        public function picahse(Request $request)
        {
            $user = Auth::user();  
            $data = PicaHse::all();
            $year = $request->input('year');
    
            //filter tahun di laporan
            $reports = PicaHse::when($year, function ($query, $year) {
                return $query->whereYear('created_at', $year);
            })->get();
            
            $years = PicaHse::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
            
            return view('picahse.index', compact('data','reports','years', 'year'));
            
        }
    
        
        public function formpicahse()
        {
            $user = Auth::user();  
            return view('picahse.addData');
        }
    
        public function createpicahse(Request $request)
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
                    PicaHse::create($validatedData);        
            return redirect('/picahse')->with('success', 'Surat berhasil disimpan.');
        }
    
        public function formupdatepicahse($id){
            $data = PicaHse::findOrFail($id);
            return view('picahse.update', compact('data'));
        }
    
        public function updatepicahse(Request $request, $id)
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
            
                    $PicaPeople =PicaHse::findOrFail($id);
                    $PicaPeople->update($validatedData);
            
            return redirect('/picahse')->with('success', 'Surat berhasil disimpan.');
        }



}
