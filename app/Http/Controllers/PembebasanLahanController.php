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
         $data= PembebasanLahan::all();
         $averageAchievement = $data->average(function ($item) {
             return (float)str_replace('%', '', $item->Achievement);
            });

         $year = $request->input('year');

        //filter tahun di laporan
        $reports = PembebasanLahan::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();
    
        $years = PembebasanLahan::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
            return view('pembebasanlahan.index',compact('data','reports','years','year','averageAchievement'));
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
                

            ]);
    
            $validatedData['updated_by'] = auth()->user()->username;

            $PembebasanLahan = PembebasanLahan::findOrFail($id);
            $PembebasanLahan->update($validatedData);
            return redirect('/indexPembebasanLahan')->with('success', 'data berhasil disimpan.');

        }

        public function picapl(Request $request)
        {
            $user = Auth::user();
            $data = PicaPl::all();
            $year = $request->input('year');
            
            $reports = PicaPl::when($year, function ($query, $year) {
                return $query->whereYear('created_at', $year);
            })->get();
            
            $years = PicaPl::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
            
            return view('picapl.index', compact('data', 'reports', 'years', 'year',));
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
            ]);
            $validatedData['updated_by'] = auth()->user()->username;
            
            $PicaPeople = PicaPl::findOrFail($id);
            $PicaPeople->update($validatedData);
            
            return redirect('/picapl')->with('success', 'data berhasil disimpan.');
        }

    
}
