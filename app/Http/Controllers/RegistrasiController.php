<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegistrasiController extends Controller
{

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Old password is incorrect!']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password has been successfully updated!');
    }
    public function register()
    {
        $data = Perusahaan::all();
        // $data = DB::table('perusahaans')
        // ->join('users', 'perusahaans.id', '=', 'users.id_company')
        // ->select('perusahaans.id', 'perusahaans.nama', 'perusahaans.induk') // Pilih kolom yang diperlukan
        // ->where('users.id_company', $admin->id_company)
        // ->groupBy('perusahaans.id', 'perusahaans.nama', 'perusahaans.induk')  // Masukkan semua kolom
        // ->get();

        $admin = Auth::user();
        $users = DB::table('users')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select(
                'users.*',
                'perusahaans.*',
                DB::raw('TIMESTAMPDIFF(DAY, users.updated_at, NOW()) as hari_tidak_aktif')
            )
            ->where('users.id_company', $admin->id_company)
            ->get();


        return view('auth.register', compact('data', 'users'));
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
            return redirect('/dashboard')->with('success', 'Registrasi Berhasil');
            dd($userMasuk);
        } else {
            return back()->with('error', 'Registrasi Gagal');
        }
    }
}
