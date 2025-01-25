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
        
            return back()->with('success', 'Data berhasil disimpan.');
            }
        
        }




        //iup dll
        public function iup()
        {
            $data = DB::table('perusahaans')->where('induk', 'IUP')->get();
            return view('pt.iup',compact('data'));
        }

        public function nonenergi()
        {
            $data = DB::table('perusahaans')->where('induk', 'Non Energi')->get();
            return view('pt.nonenergi',compact('data'));
        }
        public function kontraktor()
        {
            $data = DB::table('perusahaans')->where('induk', 'Kontraktor')->get();
            return view('pt.kontraktor',compact('data'));
        }
        public function mineral()
        {
            $data = DB::table('perusahaans')->where('induk', 'Marketing')->get();
            return view('pt.mineral',compact('data'));
        } 

}
