<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\DB;

class PerusahaanController extends Controller
{


    public function dummy()
    {
        return view('pt.tmanual');
    }

        //UNTUK MENAMPILAKN FORM dan ADD DATA NAMA LABA RUGI
        public function perusahaan()
        {
            return view('pt.formPt');
        }
        
        public function createPerusahaan(Request $request) {
            {
                $validatedData = $request->validate([
                    'induk' => 'required',
                    'nama' => 'required',
                ]);
        
                Perusahaan::create($validatedData);
        
            return back()->with('success', 'Data saved successfully.');
            }
        
        }




        //iup dll
        public function iup()
        {
            $user = auth()->user();
            if (auth()->user()->role === 'admin') {
                $data = DB::table('perusahaans')
                ->where('perusahaans.induk', 'IUP')
                ->select('perusahaans.*')
                ->get();
            } else {
                $data = DB::table('perusahaans')
                ->where('perusahaans.induk', 'IUP')
                ->select('perusahaans.*')
                ->get();
            }

            return view('pt.iup', compact('data'));
        }
                
        public function nonenergi()
        {
            $user = auth()->user();
            if (auth()->user()->role === 'admin') {
                $data = DB::table('perusahaans')
                ->where('perusahaans.induk', 'Non Energi')
                ->select('perusahaans.*')
                ->get();
            } else {
                $data = DB::table('perusahaans')
                ->where('perusahaans.induk', 'Non Energi')
                ->select('perusahaans.*')
                ->get();
            }
            return view('pt.nonenergi',compact('data'));
        }
        public function kontraktor()
        {
            $user = auth()->user();
            if (auth()->user()->role === 'admin') {
                $data = DB::table('perusahaans')
                ->where('perusahaans.induk', 'Kontraktor')
                ->select('perusahaans.*')
                ->get();
            } else {
                $data = DB::table('perusahaans')
                ->where('perusahaans.induk', 'Kontraktor')
                ->select('perusahaans.*')
                ->get();
            }
            return view('pt.kontraktor',compact('data'));
        }
        public function mineral()
        {
            $user = auth()->user();
            if (auth()->user()->role === 'admin') {
                $data = DB::table('perusahaans')
                ->where('perusahaans.induk', 'Marketing')
                ->select('perusahaans.*')
                ->get();
            } else {
                $data = DB::table('perusahaans')
                ->where('perusahaans.induk', 'Marketing')
                ->select('perusahaans.*')
                ->get();
            }
            return view('pt.mineral',compact('data'));
        } 

}
