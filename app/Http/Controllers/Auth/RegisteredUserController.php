<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $validate = $request->validate([
            'nama' => 'required',
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
    }
}
