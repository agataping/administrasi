<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PembebasanLahanCs;
class PembebasanLahanCsController extends Controller
{
    public function indexPembebasanLahanCS(Request $request)
    {
     $data= PembebasanLahanCs::all();
     $year = $request->input('year');

    //filter tahun di laporan
    $reports = PembebasanLahanCs::when($year, function ($query, $year) {
        return $query->whereYear('created_at', $year);
    })->get();

    $years = PembebasanLahanCs::selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');
        return view('pembebasanlahanCS.index',compact('data','reports','years','year'));
    }

    public function formlahanCS()
    {
        return view('pembebasanlahanCS.addData');
    }
    //create data
    public function createPembebasanLahanCs(Request $request)
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
        PembebasanLahanCs::create($validatedData);

        return redirect('/indexPembebasanLahanCs')->with('success', 'Data saved successfully..');

    }

    //update data
    public function formUpdatelahanCs($id)
    {
        $pembebasanLahan =PembebasanLahanCs::findOrFail($id);
        return view('pembebasanlahanCS.updatedata',compact('pembebasanLahan'));
    }

    public function updatePembebasanLahanCs(Request $request, $id)
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

        $PembebasanLahanCs = PembebasanLahanCs::findOrFail($id);
        $PembebasanLahanCs->update($validatedData);
        return redirect('/indexPembebasanLahanCs')->with('success', 'Data saved successfully..');

    }

}
