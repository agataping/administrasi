<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetailIsiSurat;
use App\Models\pengirimSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DetailIsiSuratController extends Controller
{
    
    public function dashboard(){
        if (Auth::check()) {
            $username = Auth::user()->name;
            return view('components.main', ['username' => $username]);
        } else {
            // Handle the case when the user is not authenticated
            return redirect('/login');
        }
    }
    


    //show file atau media yang diinput
    public function show($fileId)
    {
        $file = DetailIsiSurat::findOrFail($fileId);

        $fileData = [
            'file_url' => Storage::url($file->file_blob),
        ];

        return response()->json($fileData);
    }

    //menmpilkan data di index
    public function index()
    {
        $user = Auth::user();
    
        $data = DB::table('detail_isi_surat')
            ->join('users', 'detail_isi_surat.id_pengirim', '=', 'users.id')
            ->select('detail_isi_surat.*', 'users.name')
            ->where('id_pengirim', auth()->id())
            ->get();
    
        $fileController = new DetailIsiSuratController();
    
        $fileUrls = [];
    
        foreach ($data as $surat) {
            $fileUrl = $fileController->show($surat->id)->getData()->file_url;
            $fileUrls[$surat->id] = $fileUrl;
        }
    
        return view('suratMasuk.index', compact('data', 'fileUrls'));
    }
    
    public function suratMasuk()
    {
        return view('suratMasuk.addData');
    }
    public function createsuratMasuk(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'judul_surat' => 'required|string',
            'sifat_surat' => 'required|string',
            'tingkat_urgensi' => 'required|string',
            'nomor_refrensi' => 'required|string',
            'tanggal_terima' => 'required|date',
            'tanggal_surat' => 'required|date',
            'hal' => 'required|string',
            'isi_ringkas' => 'required|string',
            'file_blob' => 'nullable|file|max:10240', 
            'nama_pengirim' => 'required|string',
            'identitas_pengirim' => 'required|string',
            'jabatan' => 'required|string',
            'NomorNaskah' => 'required|string',
            'jenisNaskah' => 'required|string',
        ]);

        $nomorNaskah = DetailIsiSurat::create([
            'jenisNaskah' => $request->judul_surat,
            'judul_surat' => $request->judul_surat,
            'sifat_surat' => $request->sifat_surat,
            'tingkat_urgensi' => $request->tingkat_urgensi,
            'nomor_refrensi' => $request->nomor_refrensi,
            'tanggal_terima' => $request->tanggal_terima,
            'tanggal_surat' => $request->tanggal_surat,
            'NomorNaskah' => $request->NomorNaskah,
            'hal' => $request->hal,
            'isi_ringkas' => $request->isi_ringkas,
            'file_blob' => $request->file('file_blob') ? $request->file('file_blob')->store('files') : null,
            'id_pengirim' => auth()->id(),
        ]);

        $detailIsiSurat = pengirimSurat::create([
            'nama_pengirim' => $request->nama_pengirim,
            'identitas_pengirim' => $request->identitas_pengirim,
            'jabatan' => $request->jabatan,
            'id_user' => auth()->id(),

        ]);


        return redirect('/index')->with('success', 'Data saved successfully.');
    }

    //hapus data
    public function deleteSuratMasuk($id)
    {
        // Find data based on ID and delete
        $suratMasuk = DetailIsiSurat::find($id);
    
        if (!$suratMasuk) {
            return redirect()->route('index')->with('error', 'Surat tidak ditemukan.');
        }
    
        // Delete associated file if it exists
        $fileFullPath = storage_path('app/files/' . $suratMasuk->file_blob);
    
        if (file_exists($fileFullPath)) {
            unlink($fileFullPath);
        }
    
        // Delete record from the table
        $suratMasuk->delete();
    
        return redirect()->route('index')->with('success', 'Surat berhasil dihapus.');
    }

    public function logsuratmasuk()
{
    $idPengguna = auth()->user()->id;

    // Menampilkan surat keluar yang memiliki tujuan sesuai dengan jabatan pengguna
    $dataSuratKeluar = DB::table('surat_keluar')
        ->join('pengirim_surat', 'surat_keluar.tujuan', '=', 'pengirim_surat.jabatan')
        ->where('pengirim_surat.id_user', $idPengguna)
        ->get();
                $fileUrls = [];
    
        // Anda perlu mengisi $fileUrls dengan URL file dari data yang telah Anda ambil
        foreach ($dataSuratKeluar as $item) {
            // Misalnya, Anda memiliki kolom 'file_name' yang menyimpan nama file di tabel
            $fileUrls[] = asset('storage/' . $item->file_blob);
        }


    return view('suratMasuk.logSuratmasuk', compact('dataSuratKeluar','fileUrls'));
}

    
    }

