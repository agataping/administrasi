<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PembebasanLahan;

class PembebasanLahanController extends Controller
{
        //UNTUK index pembebasan lahan
        public function indexPembebasanLahan(Request $request)
        {
         $data= PembebasanLahan::all();
         $year = $request->input('year');

        //filter tahun di laporan
        $reports = PembebasanLahan::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();
    
        $years = PembebasanLahan::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
            return view('pembebasanlahan.index',compact('data','reports','years','year'));
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
                'Achievement' => 'required',
                

            ]);
    
            $validatedData['updated_by'] = auth()->user()->username;

            $PembebasanLahan = PembebasanLahan::findOrFail($id);
            $PembebasanLahan->update($validatedData);
            return redirect('/indexPembebasanLahan')->with('success', 'data berhasil disimpan.');

        }
    
}
