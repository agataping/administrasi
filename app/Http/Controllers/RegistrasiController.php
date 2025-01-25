<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrasiController extends Controller
{
    public function register()
    {
        $data=Perusahaan::all();
        return view('auth.register',compact('data'));
    }

    public function store(Request $request)
    {


        $validate = $request->validate([
            'name' => 'required',
            'username' => 'required|min:5|max:255|unique:users',
            'password' => 'required|min:5|max:255',
            'id_company' => 'required',
            'role' => 'required',

            
        ]);
        $validate['password'] = Hash::make($validate['password']);
        $userMasuk =  User::create($validate);

        if ($userMasuk) {
            return redirect('/dashboaard')->with('success', 'Registrasi Berhasil');
            dd($userMasuk);

        } else {
            return back()->with('error', 'Registrasi Gagal');
        }
}}
