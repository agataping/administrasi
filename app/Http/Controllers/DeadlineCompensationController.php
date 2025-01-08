<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\DeadlineCompensation;
use App\Models\PicaDeadline;

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


    public function picadeadline(Request $request)
    {
        $data = PicaDeadline::all();
        $year = $request->input('year');

        //filter tahun di laporan
        $reports = PicaDeadline::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();
        
    $years = PicaDeadline::selectRaw('YEAR(created_at) as year')
    ->distinct()
    ->orderBy('year', 'desc')
    ->pluck('year');
    
        return view('picadeadline.index', compact('data','reports','years', 'year'));
    }

    
    public function formpicadeadline()
    {
        $user = Auth::user();  
        return view('picadeadline.addData');
    }

    public function createpicadeadline(Request $request)
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
                PicaDeadline::create($validatedData);        
        return redirect('/picadeadline')->with('success', 'Surat berhasil disimpan.');
    }

    public function formupdatepicadeadline($id){
        $data = PicaDeadline::findOrFail($id);
        return view('picadeadline.update', compact('data'));
    }

    public function updatepicadealine(Request $request, $id)
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
        
                $PicaPeople = PicaDeadline::findOrFail($id);
                $PicaPeople->update($validatedData);
        
        return redirect('/picadeadline')->with('success', 'Surat berhasil disimpan.');
    }


}
