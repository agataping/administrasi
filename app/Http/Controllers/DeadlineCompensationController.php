<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PeopleReadiness;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\DeadlineCompensation;
use App\Models\PicaDeadline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\HistoryLog;

class DeadlineCompensationController extends Controller
{
    public function indexdeadline(Request $request)
    {
        $user = Auth::user();

        $tahun = Carbon::now()->year;
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $query = DB::table('deadline_compensation')
            ->select('deadline_compensation.*')
            ->join('users', 'deadline_compensation.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id');

        if ($user->role !== 'admin') {
            $query->where('users.id_company', $companyId);
        } else {
            if ($companyId) {
                $query->where('users.id_company', $companyId);
            } else {
                $query->whereRaw('users.id_company', $companyId);
            }
        }
        if (!$startDate || !$endDate) {
            $startDate = Carbon::createFromDate($tahun, 1, 1)->startOfDay();
            $endDate = Carbon::createFromDate($tahun, 12, 31)->endOfDay();
        } else {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
        }
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        

        $data = $query->get();
        return view('deadlinecompensation.index', compact('startDate', 'endDate','data', 'perusahaans', 'companyId'));
    }

    public function formaddMR()
    {
        return view('deadlinecompensation.addData');
    }

    public function createdeadline(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'Keterangan' => 'required',
            'MasaSewa' => 'required',
            'Nominalsewa' => 'required',
            'ProgresTahun' => 'required',
            'JatuhTempo' => 'required',
        ]);

        $validatedData['created_by'] = auth()->user()->username;
        $data = DeadlineCompensation::create($validatedData);
        HistoryLog::create([
            'table_name' => 'deadline_compensation  ',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexdeadline')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function formupdateDeadlineCompen($id)
    {
        $deadline = DeadlineCompensation::findOrFail($id);
        return view('deadlinecompensation.updatedata', compact('deadline'));
    }


    public function updatedeadline(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'Keterangan' => 'required',
            'MasaSewa' => 'required',
            'Nominalsewa' => 'required',
            'ProgresTahun' => 'required',
            'JatuhTempo' => 'required',
        ]);
        $validatedData['updated_by'] = auth()->user()->username;
        $DeadlineCompensation = DeadlineCompensation::findOrFail($id);
        $oldData = $peopleReadiness->toArray();
        $DeadlineCompensation->update($validatedData);
        HistoryLog::create([
            'table_name' => 'deadline_compensation  ',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        return redirect('/indexdeadline')->with('success', 'Data saved successfully.');
    }

    public function deletedeadline($id)
    {
        $data = PeopleReadiness::findOrFail($id);
        $oldData = $data->toArray();
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'deadline_compensation  ',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect('/indexdeadline')->with('success', 'Data deleted successfully.');
    }


    //PICA
    public function picadeadline(Request $request)
    {
        $user = Auth::user();
        $tahun = Carbon::now()->year;
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $query = DB::table('picai_dealines')
            ->select('picai_dealines.*')
            ->join('users', 'picai_dealines.created_by', '=', 'users.username')
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

        if (!$startDate || !$endDate) {
            $startDate = Carbon::createFromDate($tahun, 1, 1)->startOfDay();
            $endDate = Carbon::createFromDate($tahun, 12, 31)->endOfDay();
        } else {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
        }
        $query->whereBetween('tanggal', [$startDate, $endDate]);

        $data = $query->get();
        return view('picadeadline.index', compact('startDate', 'endDate', 'data', 'perusahaans', 'companyId'));
    }

    public function formpicadeadline()
    {
        $user = Auth::user();
        return view('picadeadline.addData');
    }

    public function createpicadeadline(Request $request)
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
        $data = PicaDeadline::create($validatedData);
        HistoryLog::create([
            'table_name' => 'picai_dealines  ',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/picadeadline')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function formupdatepicadeadline($id)
    {
        $data = PicaDeadline::findOrFail($id);
        return view('picadeadline.update', compact('data'));
    }

    public function updatepicadealine(Request $request, $id)
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

        $PicaPeople = PicaDeadline::findOrFail($id);
        $oldData = $PicaPeople->toArray();

        $PicaPeople->update($validatedData);

        HistoryLog::create([
            'table_name' => 'picai_dealines  ',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        return redirect('/picadeadline')->with('success', 'Data saved successfully.');
    }

    public function deletepicadeadline($id)
    {
        $data = PicaDeadline::findOrFail($id);
        $oldData = $data->toArray();
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'picai_dealines  ',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect('/')->with('success', 'Data deleted successfully.');
    }
}
