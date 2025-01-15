<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeadlineCompentsationCostumers;

class DeadlineCompentsationCsController extends Controller
{
    public function indexdeadlineCostumers( Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $query = DB::table('deadline_compensation') 
            ->select('*'); // Memilih semua kolom dari tabel
        
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]); // Tidak perlu menyebut nama tabel
        }
        
        $data = $query->get();
        

        return view('deadlinecompensationCs.index', compact ('data'));
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
            'tanggal' => 'required|date',


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
                'tanggal' => 'required|date',

    
            ]);
    
            $validatedData['updated_by'] = auth()->user()->username;
            
            $DeadlineCompentsationCostumers = DeadlineCompentsationCostumers::findOrFail($id);
            $DeadlineCompentsationCostumers->update($validatedData);
            return redirect('/indexdeadlineCostumers')->with('success', 'data berhasil disimpan.');
        }

    
}