<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\KategoriMiniR;
use App\Models\MiningReadiness;
use App\Models\PicaMining;
use App\Models\HistoryLog;

class MiningReadinessController extends Controller
{
    public function indexmining(Request $request)
    {
        $user = Auth::user();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $query = DB::table('mining_readinesses')
            ->join('kategori_mini_r_s', 'mining_readinesses.KatgoriDescription', '=', 'kategori_mini_r_s.kategori')
            ->join('users', 'mining_readinesses.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select('kategori_mini_r_s.kategori', 'kategori_mini_r_s.*', 'mining_readinesses.*');
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
            $query->whereBetween('mining_readinesses.tanggal', [$startDate, $endDate]);
        }
        $data = $query->get();


        $data->transform(function ($item) {
            $achievement = str_replace('%', '', $item->Achievement);
            $item->average_achievement = $achievement ? (float)$achievement : 0;
            return $item;
        });
        $groupedData = $data->groupBy('kategori')->map(function ($items) {
            $total = $items->sum(function ($item) {
                return (float)str_replace('%', '', $item->Achievement);
            });
            $count = $items->count();
            $average = $count > 0 ? $total / $count : 0;
            return $items->map(function ($item) use ($average) {
                $item->average_achievement = $average;
                return $item;
            });
        });
        $totalAllCategories = $groupedData->map(function ($items) {
            $totalAchievement = $items->sum(function ($item) {
                return (float)str_replace('%', '', $item->Achievement);
            });
            $count = $items->count();
            return $count > 0 ? $totalAchievement / $count : 0;
        })->sum();
        //hitung tot. aspect 
        $totalCategories = $groupedData->count();
        $totalAspect = $totalCategories > 0 ? round($totalAllCategories / $totalCategories, 2) : 0;

        //cek hitungan sesuai gak + cocokin hitungan di excel 
        // dd([
        //     'totalAllCategories' => $totalAllCategories,
        //     'totalCategories' => $totalCategories,
        //     'totalAspect' => $totalAspect,
        // ]);
        //  total "Legal Aspect"
        $groupedData = $groupedData->map(function ($items, $key) use ($totalAspect) {
            if ($key === 'Legal Aspect') {
                return $items->map(function ($item) use ($totalAspect) {
                    $item->average_achievement = $totalAspect;
                    return $item;
                });
            }
            return $items;
        });
        return view('mining.index', compact('groupedData', 'totalAspect', 'perusahaans', 'companyId'));
    }

    public function FormKategori()
    {
        return view('mining.formKategori');
    }


    public function createKatgori(Request $request)
    {
        $validatedData = $request->validate([
            'kategori' => 'required',
        ]);
        $validatedData['created_by'] = auth()->user()->username;
        $data = KategoriMiniR::create($validatedData);

        HistoryLog::create([
            'table_name' => 'kategori_mini_r_s',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexmining')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }
    public function formupdatecategorymining($id)
    {
        $data = KategoriMiniR::findOrFail($id);
        return view('mining.updatecategory', compact('data'));
    }
    public function updatecategorymining(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kategori' => 'required',
        ]);

        $validatedData['updated_by'] = auth()->user()->username;

        $KategoriMiniR = KategoriMiniR::findOrFail($id);
        $oldData = $KategoriMiniR->toArray();

        $KategoriMiniR->update($validatedData);

        HistoryLog::create([
            'table_name' => 'kategori_mini_r_s',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);

        return redirect('/indexmining')->with('success', 'Data savedsuccessfully.');
    }


    public function FormMining()
    {
        $kategori = KategoriMiniR::all();
        return view('mining.formMining', compact('kategori'));
    }

    public function CreateMining(Request $request)
    {
        $validatedData = $request->validate([
            'Description' => 'required',
            'NomerLegalitas' => 'nullable',
            'status' => 'nullable',
            'Achievement' => 'required',
            'tanggal' => 'nullable',
            'berlaku' => 'nullable',
            'nomor' => 'required',
            'filling' => 'nullable',
            'KatgoriDescription' => 'required',
        ]);

        $validatedData['created_by'] = auth()->user()->username;
        $data = MiningReadiness::create($validatedData);
        HistoryLog::create([
            'table_name' => 'mining_readinesses',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexmining')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function FormMiningUpdate($id)
    {
        $kategori = KategoriMiniR::all();
        $mining = MiningReadiness::findOrFail($id);
        return view('mining.updateMining', compact('mining', 'kategori'));
    }

    public function UpdateMining(Request $request, $id)
    {
        $validatedData = $request->validate([
            'Description' => 'required',
            'NomerLegalitas' => 'nullable',
            'status' => 'nullable',
            'Achievement' => 'required',
            'tanggal' => 'nullable',
            'berlaku' => 'nullable',
            'nomor' => 'required',
            'filling' => 'nullable',
            'KatgoriDescription' => 'required',
        ]);

        $validatedData['updated_by'] = auth()->user()->username;

        $mining = MiningReadiness::findOrFail($id);
        $oldData = $mining->toArray();

        $mining->update($validatedData);

        HistoryLog::create([
            'table_name' => 'mining_readinesses  ',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        return redirect('/indexmining')->with('success', ' Data saved successfully.');
    }

    public function deleteminig($id)
    {
        $data = MiningReadiness::findOrFail($id);
        $oldData = $data->toArray();

        // Hapus data dari tabel 
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'mining_readinesses  ',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect('/indexmining')->with('success', 'Data deleted successfully.');
    }

    public function picamining(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();


        $query = DB::table('pica_minings')
            ->select('pica_minings.*')
            ->join('users', 'pica_minings.created_by', '=', 'users.username')
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

        return view('picamining.index', compact('data', 'perusahaans', 'companyId'));
    }

    public function formpicamining()
    {
        $user = Auth::user();
        return view('picamining.addData');
    }

    public function createpicamining(Request $request)
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
        $data = PicaMining::create($validatedData);
        HistoryLog::create([
            'table_name' => 'pica_minings  ',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/picamining')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function formupdatepicamining($id)
    {
        $data = PicaMining::findOrFail($id);
        return view('picamining.update', compact('data'));
    }

    public function updatepicamining(Request $request, $id)
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

        $PicaPeople = PicaMining::findOrFail($id);
        $oldData = $PicaPeople->toArray();

        $PicaPeople->update($validatedData);

        HistoryLog::create([
            'table_name' => 'pica_minings  ',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        return redirect('/picamining')->with('success', 'data savedsuccessfully.');
    }

    public function deletepicamining($id)
    {
        $data = PicaMining::findOrFail($id);
        $oldData = $data->toArray();

        // Hapus data dari tabel 
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'pica_minings',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect('/')->with('success', 'Data deleted successfully.');
    }
}
