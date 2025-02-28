<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PembebasanLahan;
use App\Models\PicaPl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\HistoryLog;

class PembebasanLahanController extends Controller
{
    //UNTUK index pembebasan lahan
    public function indexPembebasanLahan(Request $request)
    {
        $user = Auth::user();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $query = DB::table('pembebasan_lahans')
            ->select('pembebasan_lahans.*')
            ->join('users', 'pembebasan_lahans.created_by', '=', 'users.username')
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

        $averageAchievement = $data->average(function ($item) {
            return (float)str_replace('%', '', $item->Achievement);
        });

        return view('pembebasanlahan.index', compact('data', 'averageAchievement', 'perusahaans', 'companyId'));
    }

    public function formlahan()
    {
        return view('pembebasanlahan.addData');
    }

    //create data
    public function createPembebasanLahan(Request $request)
    {
        $validatedData = $request->validate([
            'NamaPemilik' => 'required',
            'LuasLahan' => 'required',
            'KebutuhanLahan' => 'required',
            'Progress' => 'required',
            'Status' => 'nullable',
            'targetselesai' => 'nullable',
            'Achievement' => 'required',
            'tanggal' => 'required|date',
        ]);
        $validatedData['created_by'] = auth()->user()->username;
        $data = PembebasanLahan::create($validatedData);
        HistoryLog::create([
            'table_name' => 'pembebasan_lahans ',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexPembebasanLahan')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    //update data
    public function formUpdatelahan($id)
    {
        $pembebasanLahan = PembebasanLahan::findOrFail($id);
        return view('pembebasanlahan.updatedata', compact('pembebasanLahan'));
    }

    public function updatePembebasanLahan(Request $request, $id)
    {
        $validatedData = $request->validate([

            'NamaPemilik' => 'required',
            'LuasLahan' => 'required',
            'KebutuhanLahan' => 'required',
            'Progress' => 'required',
            'Status' => 'nullable',
            'targetselesai' => 'nullable',
            'Achievement' => 'required',
            'tanggal' => 'required|date',


        ]);
        $validatedData['updated_by'] = auth()->user()->username;
        $PembebasanLahan = PembebasanLahan::findOrFail($id);
        $oldData = $PembebasanLahan->toArray();
        $PembebasanLahan->update($validatedData);

        HistoryLog::create([
            'table_name' => 'pembebasan_lahans ',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        return redirect('/indexPembebasanLahan')->with('success', 'data berhasil disimpan.');
    }
    public function deletepembebasanlahan($id)
    {
        $data = pembebasan_lahans::findOrFail($id);
        $oldData = $data->toArray();
        $data->delete();

        HistoryLog::create([
            'table_name' => 'pembebasan_lahans ',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect('/indexPembebasanLahan')->with('success', 'Data deleted successfully.');
    }

    public function picapl(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $query = DB::table('pica_pls')
            ->select('pica_pls.*')
            ->join('users', 'pica_pls.created_by', '=', 'users.username')
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

        return view('picapl.index', compact('data', 'perusahaans', 'companyId'));
    }

    public function formpicapl()
    {
        $user = Auth::user();
        return view('picapl.addData');
    }

    public function createpicapl(Request $request)
    {
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
        $data = PicaPl::create($validatedData);
        HistoryLog::create([
            'table_name' => 'pica_pls  ',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/picapl')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function formupdatepicapl($id)
    {
        $data = PicaPl::findOrFail($id);
        return view('picapl.update', compact('data'));
    }

    public function updatepicapl(Request $request, $id)
    {
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

        $data = PicaPl::findOrFail($id);
        $oldData = $data->toArray();

        $data->update($validatedData);

        HistoryLog::create([
            'table_name' => 'pica_pls  ',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);

        return redirect('/picapl')->with('success', 'data berhasil disimpan.');
    }

    public function deletepicapl($id)
    {
        $data = PicaPl::findOrFail($id);
        $oldData = $data->toArray();

        // Hapus data dari tabel 
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'pica_pls',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect('/picapl')->with('success', 'Data deleted successfully.');
    }
}
