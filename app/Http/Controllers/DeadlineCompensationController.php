<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeadlineCompensation;

class DeadlineCompensationController extends Controller
{
    public function indexdeadline(Request $request)
    {
        $data =DeadlineCompensation::all();
        $year = $request->input('year');
        $reports = DeadlineCompensation::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();

        $years =DeadlineCompensation::selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');


        return view('deadlinecompensation.index',compact('reports', 'data','years','year'));
    }

    public function formaddMR()
    {
        return view('deadlinecompensation.addData');
    }



    //create
    public function createdeadline(Request $request)
    {
        $validatedData = $request->validate([

            'Keterangan' => 'required',
            'MasaSewa' => 'required',
            'Nominalsewa' => 'required',
            'ProgresTahun' => 'required',
            'JatuhTempo' => 'required',

        ]);

        $validatedData['created_by'] = auth()->user()->username;
        DeadlineCompensation::create($validatedData);

        return redirect('/indexdeadline')->with('success', 'data berhasil disimpan.');

    }
    public function formupdateDeadlineCompen($id)
    {
        $deadline =DeadlineCompensation::findOrFail($id);
        return view('deadlinecompensation.updatedata', compact('deadline'));
    }
    public function updatedeadline(Request $request, $id)
    {
        $validatedData = $request->validate([

            'Keterangan' => 'required',
            'MasaSewa' => 'required',
            'Nominalsewa' => 'required',
            'ProgresTahun' => 'required',
            'JatuhTempo' => 'required',

        ]);

        $validatedData['updated_by'] = auth()->user()->username;
        $DeadlineCompensation = DeadlineCompensation::findOrFail($id);
        $DeadlineCompensation->update($validatedData);
        return redirect('/indexdeadline')->with('success', 'data berhasil disimpan.');

    }

}
