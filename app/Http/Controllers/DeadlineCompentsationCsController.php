<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeadlineCompentsationCostumers;

class DeadlineCompentsationCsController extends Controller
{
    public function indexdeadlineCostumers( Request $request)
    {
        $data = DeadlineCompentsationCostumers::all();
        $year = $request->input('year');
        $reports = DeadlineCompentsationCostumers::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();
       $years = DeadlineCompentsationCostumers::selectRaw('YEAR(created_at) as year')
           ->distinct()
           ->orderBy('year', 'desc')
           ->pluck('year');

        return view('deadlinecompensationCs.index', compact ('reports','years','year','data'));
    }

    public function formDeadlineCs()
    {
        return view('deadlinecompensationCs.adddata');
    }
    public function createdeadlineCs(Request $request)
    {
        $validatedData = $request->validate([

            'Keterangan' => 'required',
            'MasaSewa' => 'required',
            'Nominalsewa' => 'required',
            'ProgresTahun' => 'required',
            'JatuhTempo' => 'required',

        ]);

        $validatedData['created_by'] = auth()->user()->username;
        DeadlineCompentsationCostumers::create($validatedData);

        return redirect('/indexdeadlineCostumers')->with('success', 'data berhasil disimpan.');
    }

        //update data
        public function formupdateDeadlineCs($id)
        {
            $data = DeadlineCompentsationCostumers::FindOrFail($id);
            
            return view('deadlinecompensationCs.updatedata',compact('data'));
        }

        public function updatedeadlineCs(Request $request, $id)
        {
            $validatedData = $request->validate([
    
                'Keterangan' => 'required',
                'MasaSewa' => 'required',
                'Nominalsewa' => 'required',
                'ProgresTahun' => 'required',
                'JatuhTempo' => 'required',
    
            ]);
    
            $validatedData['updated_by'] = auth()->user()->username;
            
            $DeadlineCompentsationCostumers = DeadlineCompentsationCostumers::findOrFail($id);
            $DeadlineCompentsationCostumers->update($validatedData);
            return redirect('/indexdeadlineCostumers')->with('success', 'data berhasil disimpan.');
        }

    
}
