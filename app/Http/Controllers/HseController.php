<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\kategoriHse;
use App\Models\Hse;
use App\Models\PicaHse;
use App\Models\HistoryLog;

class HseController extends Controller
{
    public function indexhse(Request $request)
    {
        $user = Auth::user();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
        $query = DB::table('hses')
            ->join('kategori_hses', 'hses.kategori_id', '=', 'kategori_hses.id')
            ->join('users', 'hses.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select('hses.*', 'kategori_hses.*', 'kategori_hses.name as kategori_name', 'users.username as created_by');
        if ($user->role !== 'admin') {
            $query->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $query->where('users.id_company', $companyId);
            } else {
                $query->whereRaw('users.id_company', $companyId);
            }
        }
        if ($startDate && $endDate) {
            $query->whereBetween('hses.date', [$startDate, $endDate]);
        }

        $data = $query->orderBy('kategori_hses.name')
            ->get()
            ->groupBy('kategori_name');
        $data->each(function ($items) {
            $items->each(function ($item) {
                $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
            });
        });

        return view('hse.index', compact('data', 'perusahaans', 'companyId'));
    }
    public function indexcategoryhse(Request $request)
    {
        $user = Auth::user();
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
        $query = DB::table('kategori_hses')
            ->select('kategori_hses.*')
            ->join('users', 'kategori_hses.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id');

        if ($user->role !== 'admin') {
            $query->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $query->where('users.id_company', $companyId);
            } else {
                $query->whereRaw('users.id_company', $companyId);
            }
        }

        $data = $query->get(); 
        // $data = DB::table('kategori_hses')->get();
        // dd($data);

        // dd($data);
        return view('hse.indexcategory', compact('data'));
    }

    public function deletecategoryhse($id)
    {
        $data = kategoriHse::findOrFail($id);
        $oldData = $data->toArray();

        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'kategori_hses',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect()->back()->with('success', 'Data deleted successfully.');
    }

    public function formkategorihse()
    {
        return view('hse.formkategori');
    }
    public function formhse()
    {
        $data = kategoriHse::all();
        return view('hse.addData', compact('data'));
    }

    public function createhse(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required',
            'plan' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'actual' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'file' => 'nullable|file',
            'keterangan' => 'nullable',
            'kategori_id' => 'required',

        ]);
        function convertToCorrectNumber($value)
        {
            if ($value === '' || $value === null) {
                return 0;
            }
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
            return floatval($value);
        }

        // Tentukan mana yang diset null
        $validatedData['actual'] = convertToCorrectNumber($validatedData['actual']);
        $validatedData['plan'] = convertToCorrectNumber($validatedData['actual']);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            $validatedData['file'] = $filePath;
        }

        $validatedData['created_by'] = auth()->user()->username;
        $data = Hse::create($validatedData);
        HistoryLog::create([
            'table_name' => 'hses',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexhse')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function createkategorihse(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        $validatedData['created_by'] = auth()->user()->username;
        $data = kategoriHse::create($validatedData);
        HistoryLog::create([
            'table_name' => 'kategori_hses',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);

        return redirect('/indexhse')->with('success', 'Data berhasil disimpan.');
    }
    public function formupdatecategoryhse($id)
    {
        $data = kategoriHse::findOrFail($id);
        return view('hse.updatecategory', compact('data'));
    }
    public function updatecategoryhse(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $validatedData['updated_by'] = auth()->user()->username;

        $kategoriHse = kategoriHse::findOrFail($id);
        $oldData = $kategoriHse->toArray();

        $kategoriHse->update($validatedData);

        HistoryLog::create([
            'table_name' => 'kategori_hses',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);

        return redirect('/indexhse')->with('success', 'Data berhasil disimpan.');
    }

    public function updatehse(Request $request, $id)
    {
        $validatedData = $request->validate([
            'plan' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'actual' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'file' => 'nullable|file',
            'date' => 'required',
            'keterangan' => 'nullable',
            'kategori_id' => 'required',
        ]);
        function convertToCorrectNumber($value)
        {
            if ($value === '' || $value === null) {
                return 0;
            }
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
            return floatval($value);
        }

        // Tentukan mana yang diset null
        $validatedData['actual'] = convertToCorrectNumber($validatedData['actual']);
        $validatedData['plan'] = convertToCorrectNumber($validatedData['actual']);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            $validatedData['file'] = $filePath;
        }
        $validatedData['updated_by'] = auth()->user()->username;

        $hse = Hse::findOrFail($id);
        $oldData = $hse->toArray();

        $hse->update($validatedData);

        HistoryLog::create([
            'table_name' => 'hses',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        return redirect('/indexhse')->with('success', 'Data berhasil diperbarui.');
    }

    public function formupdatehse($id)
    {
        $kategori = kategoriHse::all();
        $hse = hse::findOrFail($id);

        return view('hse.update', compact('hse', 'kategori'));
    }

    public function deletehse($id)
    {
        $data = Hse::findOrFail($id);
        $oldData = $data->toArray();

        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'hses',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect('/indexhse')->with('success', 'Data deleted successfully.');
    }


    public function picahse(Request $request)
    {
        $user = Auth::user();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $query = DB::table('pica_hses')
            ->select('pica_hses.*')
            ->join('users', 'pica_hses.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id');

        if ($user->role !== 'admin') {
            $query->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $query->where('users.id_company', $companyId);
            } else {
                $query->whereRaw('users.id_company', $companyId);
            }
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        }

        $data = $query->get();
        return view('picahse.index', compact('data', 'perusahaans', 'companyId'));
    }


    public function formpicahse()
    {
        $user = Auth::user();
        return view('picahse.addData');
    }

    public function createpicahse(Request $request)
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
            'tanggal' => 'required|date',
        ]);
        $validatedData['created_by'] = auth()->user()->username;
        $data = PicaHse::create($validatedData);
        HistoryLog::create([
            'table_name' => 'pica_hses',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        return redirect('/picahse')->with('success', 'Surat berhasil disimpan.');
    }

    public function formupdatepicahse($id)
    {
        $data = PicaHse::findOrFail($id);
        return view('picahse.update', compact('data'));
    }

    public function updatepicahse(Request $request, $id)
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
            'tanggal' => 'required|date',
        ]);
        $validatedData['updated_by'] = auth()->user()->username;

        $data = PicaHse::findOrFail($id);
        $oldData = $data->toArray();

        $data->update($validatedData);

        HistoryLog::create([
            'table_name' => 'pica_hses',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/picahse')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function deletepicahse($id)
    {
        $data = Picahse::findOrFail($id);
        $oldData = $data->toArray();

        // Hapus data dari tabel 
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'pica_hses',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect('/picahse')->with('success', 'Data deleted successfully.');
    }
}
