<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrasiController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {

        $validate = $request->validate([
            'name' => 'required',
            'username' => 'required|min:5|max:255|unique:users',
            'password' => 'required|min:5|max:255',
            'role' => 'required',

            
        ]);
        $validate['password'] = Hash::make($validate['password']);
        $userMasuk =  User::create($validate);

        if ($userMasuk) {
            return redirect('/login')->with('success', 'Registrasi Berhasil');
            dd($userMasuk);

        } else {
            return back()->with('error', 'Registrasi Gagal');
        }
}}
