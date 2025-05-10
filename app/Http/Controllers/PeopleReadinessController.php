<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\PeopleReadiness;
use App\Models\picaPeople;
use App\Models\Gambar;
use App\Models\HistoryLog;
use App\Models\PlanTambang;
use Carbon\Carbon;
use App\Services\persentaseCompany as ServiceReportService;

class PeopleReadinessController extends Controller
{
    protected $reportService;

    public function __construct(ServiceReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function dashboard(Request $request)
    {
        //iup
        $user = auth()->user();
                if (auth()->user()->role === 'admin') {
            $dataiup = DB::table('perusahaans')
                ->where('perusahaans.induk', 'IUP')
                ->select('perusahaans.*')
                ->get();
        } else {
            $dataiup = DB::table('perusahaans')
                ->where('perusahaans.induk', 'IUP')
                ->select('perusahaans.*')
                ->get();
        }
        $childiup = [];
        $totalResultIndukiup = 0;
        $totalCompanyCountiup = count($dataiup);

        foreach ($dataiup as $company) {
            $childiup[$company->id] = $this->reportService->DataReport($request, $company->id);

            $totalResultIndukiup += $childiup[$company->id]['totalresultfinancial'] ?? 0;
            $totalResultIndukiup += $childiup[$company->id]['totalresultcostumer'] ?? 0;
            $totalResultIndukiup += $childiup[$company->id]['totalresultIPP'] ?? 0;
            $totalResultIndukiup += $childiup[$company->id]['resultlearning'] ?? 0;
        }

        if ($totalCompanyCountiup > 0) {
            $averageiup = round(($totalResultIndukiup / 4) / $totalCompanyCountiup, 2);
        } else {
            $averageiup = 0;
        }

        //NON energi 
                if (auth()->user()->role === 'admin') {
            $datanonenergi = DB::table('perusahaans')
                ->where('perusahaans.induk', 'Non Energi')
                ->select('perusahaans.*')
                ->get();
        } else {
            $datanonenergi = DB::table('perusahaans')
                ->where('perusahaans.induk', 'Non Energi')
                ->select('perusahaans.*')
                ->get();
        }
        $childnonenergi = [];
        $totalResultInduknonenergi = 0;
        $totalCompanyCountnonenergi = count($datanonenergi);

        foreach ($datanonenergi as $company) {
            $childnonenergi[$company->id] = $this->reportService->DataReport($request, $company->id);

            $totalResultInduknonenergi += $childnonenergi[$company->id]['totalresultfinancial'] ?? 0;
            $totalResultInduknonenergi += $childnonenergi[$company->id]['totalresultcostumer'] ?? 0;
            $totalResultInduknonenergi += $childnonenergi[$company->id]['totalresultIPP'] ?? 0;
            $totalResultInduknonenergi += $childnonenergi[$company->id]['resultlearning'] ?? 0;
        }

        if ($totalCompanyCountnonenergi > 0) {
            $averagenonenergi = round(($totalResultInduknonenergi / 4) / $totalCompanyCountnonenergi, 2);
        } else {
            $averagenonenergi = 0;
        }

        //kontaktor
                if (auth()->user()->role === 'admin') {
            $datakontaktor = DB::table('perusahaans')
                ->where('perusahaans.induk', 'Kontraktor')
                ->select('perusahaans.*')
                ->get();
        } else {
            $datakontaktor = DB::table('perusahaans')
                ->where('perusahaans.induk', 'Kontraktor')
                ->select('perusahaans.*')
                ->get();
        }
        $dataskontraktor = [];
        $totalResultIndukkontraktor = 0;
        $totalCompanyCountkontraktor = count($datakontaktor);

        foreach ($datakontaktor as $company) {
            $dataskontraktor[$company->id] = $this->reportService->DataReport($request, $company->id);

            $totalResultIndukkontraktor += $dataskontraktor[$company->id]['totalresultfinancial'] ?? 0;
            $totalResultIndukkontraktor += $dataskontraktor[$company->id]['totalresultcostumer'] ?? 0;
            $totalResultIndukkontraktor += $dataskontraktor[$company->id]['totalresultIPP'] ?? 0;
            $totalResultIndukkontraktor += $dataskontraktor[$company->id]['resultlearning'] ?? 0;
        }

        if ($totalCompanyCountkontraktor > 0) {
            $averagekontraktor = round(($totalResultIndukkontraktor / 4) / $totalCompanyCountkontraktor, 2);
        } else {
            $averagekontraktor = 0;
        }

        //marketing
                if (auth()->user()->role === 'admin') {
            $datamarketing = DB::table('perusahaans')
                ->where('perusahaans.induk', 'Marketing')
                ->select('perusahaans.*')
                ->get();
        } else {
            $datamarketing = DB::table('perusahaans')
                ->where('perusahaans.induk', 'Marketing')
                ->select('perusahaans.*')
                ->get();
        }
        $datasmarketting = [];
        $totalResultmarketing = 0;
        $totalCompanyCount = count($datamarketing);

        foreach ($datamarketing as $company) {
            $datasmarketting[$company->id] = $this->reportService->DataReport($request, $company->id);

            $totalResultmarketing += $datasmarketting[$company->id]['totalresultfinancial'] ?? 0;
            $totalResultmarketing += $datasmarketting[$company->id]['totalresultcostumer'] ?? 0;
            $totalResultmarketing += $datasmarketting[$company->id]['totalresultIPP'] ?? 0;
            $totalResultmarketing += $datasmarketting[$company->id]['resultlearning'] ?? 0;
        }

        if ($totalCompanyCount > 0) {
            $averagemarketing = round(($totalResultmarketing / 4) / $totalCompanyCount, 2);
        } else {
            $averagemarketing = 0;
        }



        $avargequbahgroup= round(($averageiup+$averagekontraktor+$averagenonenergi+$averagemarketing)/4,2);
        if (Auth::check()) {
            $username = Auth::user()->name;
            return view('components.main',compact('username','averageiup','averagekontraktor','averagenonenergi','averagemarketing','avargequbahgroup'));
        } else {
            // Handle the case when the user is not authenticated
            return redirect('/login');
        }
    }


    //PEOPLE READINES
    public function indexPeople(Request $request)
    {
        $user = Auth::user();


        //hitung total quantity dan quality
        $totalQuality = 0;
        $totalQuantity = 0;
        $count = 0;
        $tahun = Carbon::now()->year;
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $query = DB::table('people_readinesses')
            ->select('people_readinesses.*')
            ->join('users', 'people_readinesses.created_by', '=', 'users.username')
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
        $query->whereBetween('tanggal', [$startDate, $endDate]); // Tidak perlu menyebut nama tabel


        $data = $query->get();

        $totalQuality = 0;
        $totalQuantity = 0;
        $count = 0;

        foreach ($data as $d) {
            $qualityPlan = floatval(str_replace('%', '', trim($d->Quality_plan)));
            $quantityPlan = floatval(str_replace('%', '', trim($d->Quantity_plan)));

            if (is_numeric($qualityPlan) && is_numeric($quantityPlan)) {
                $totalQuality += $qualityPlan;
                $totalQuantity += $quantityPlan;
                $count++;
            }
        }

        if ($count > 0) {
            $averageQuality = $totalQuality / $count;
            $averageQuantity = $totalQuantity / $count;
        } else {
            $averageQuality = 0;
            $averageQuantity = 0;
        }

        if ($averageQuantity > 0) {
            $tot = (($averageQuality + $averageQuantity) / 2);
        } else {
            $tot = 0;
        }


        return view('peoplereadiness.index', compact('startDate', 'endDate', 'data', 'averageQuality', 'averageQuantity', 'tot', 'perusahaans', 'companyId'));
    }

    public function formPR()
    {
        $user = Auth::user();
        return view('peoplereadiness.addData');
    }

    public function formupdate($id)
    {
        $peopleReadiness = PeopleReadiness::findOrFail($id);
        return view('peoplereadiness.update', compact('peopleReadiness'));
    }

    public function updatedata(Request $request, $id)
    {
        $validatedData = $request->validate([
            'posisi' => 'required|string',
            'Fullfillment_plan' => 'required|integer',
            'Fullfillment_actual' => 'required|integer',
            'HSE_plan' => 'required|integer',
            'Leadership_plan' => 'required|integer',
            'Improvement_plan' => 'required|integer',
            'Quantity_plan' => 'required|string|max:11',
            'HSE_actual' => 'required|integer',
            'Leadership_actual' => 'required|integer',
            'Improvement_actual' => 'required|integer',
            'pou_pou_plan' => 'required|integer',
            'Quality_plan' => 'required|string',
            'pou_pou_actual' => 'required|integer',
            'note' => 'nullable|string',
            'tanggal' => 'required|date',

        ]);

        $validatedData['updated_by'] = auth()->user()->username;

        $peopleReadiness = PeopleReadiness::findOrFail($id);
        $oldData = $peopleReadiness->toArray();

        $peopleReadiness->update($validatedData);

        HistoryLog::create([
            'table_name' => 'people_readiness',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        return redirect('/indexPeople')->with('success', 'Data saved successfully.');
    }

    public function createDataPR(Request $request)
    {
        // dd($request->all());            
        $validatedData = $request->validate([
            'posisi' => 'required|string',
            'Fullfillment_plan' => 'required|integer',
            'Fullfillment_actual' => 'required|integer',
            'HSE_plan' => 'required|integer',
            'Leadership_plan' => 'required|integer',
            'Improvement_plan' => 'required|integer',
            'Quantity_plan' => 'required|string|max:11',
            'HSE_actual' => 'required|integer',
            'Leadership_actual' => 'required|integer',
            'Improvement_actual' => 'required|integer',
            'pou_pou_plan' => 'required|integer',
            'Quality_plan' => 'required|string',
            'pou_pou_actual' => 'required|integer',
            'note' => 'nullable|string',
            'tanggal' => 'required|date',


        ]);
        $validatedData['created_by'] = auth()->user()->username;
        $peopleReadiness = PeopleReadiness::create($validatedData);
        HistoryLog::create([
            'table_name' => 'people_readiness',
            'record_id' => $peopleReadiness->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexPeople')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }


    public function deletepeoplereadines($id)
    {
        $peopleReadiness = PeopleReadiness::findOrFail($id);
        $oldData = $peopleReadiness->toArray();

        // Hapus data dari tabel 
        $peopleReadiness->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'people_readiness',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);

        return redirect('/indexPeople')->with('success', 'Data deleted successfully.');
    }

    //PICA 
    public function indexpicapeople(Request $request)
    {
        $user = Auth::user();
        $tahun = Carbon::now()->year;
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $query = DB::table('pica_people')
            ->select('pica_people.*')
            ->join('users', 'pica_people.created_by', '=', 'users.username')
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
        return view('picapeople.index', compact('startDate', 'endDate', 'data', 'perusahaans', 'companyId'));
    }

    public function formpicapeople()
    {
        $user = Auth::user();
        return view('picapeople.addData');
    }

    public function formupdatepicapeople($id)
    {
        $data = picaPeople::findOrFail($id);
        return view('picapeople.update', compact('data'));
    }

    public function createpicapeople(Request $request)
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
        $peopleReadiness = PicaPeople::create($validatedData);
        HistoryLog::create([
            'table_name' => 'pica_people',
            'record_id' => $peopleReadiness->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexpicapeople')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function updatepicapeople(Request $request, $id)
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
        $PicaPeople = PicaPeople::findOrFail($id);

        $oldData = $PicaPeople->toArray();
        $PicaPeople->update($validatedData);

        HistoryLog::create([
            'table_name' => 'pica_people',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        return redirect('/indexpicapeople')->with('success', 'Data  berhasil disimpan.');
    }

    public function deletepicapeole($id)
    {
        $peopleReadiness = PeopleReadiness::findOrFail($id);
        $oldData = $peopleReadiness->toArray();

        // Hapus data dari tabel 
        $peopleReadiness->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'people_readiness',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);

        return redirect('/indexpicapeople')->with('success', 'Data deleted successfully.');
    }




    //gambar       
    public function struktur(Request $request)
    {
        $user = Auth::user();
        $companyId = request()->input('id_company');
        $tahun = Carbon::now()->year;
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;

        $query = DB::table('gambars')
            ->select('gambars.*')
            ->leftJoin('users', 'gambars.created_by', '=', 'users.username')
            ->leftJoin('perusahaans', 'users.id_company', '=', 'perusahaans.id');

        if ($user->role !== 'admin') {
            $query->where('users.id_company', $user->id_company);
        } else {
            if (!empty($companyId)) {
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




        $gambar = $query->get();
        return view('peoplereadiness.organisasi.index', compact('startDate', 'endDate', 'gambar'));
    }

    public function formbagan()
    {
        return view('peoplereadiness.organisasi.addGambar');
    }

    public function createbagan(Request $request)
    {
        $validatedData = $request->validate([
            'path' => 'nullable|file',
            'tanggal' => 'required|date',
        ]);

        if ($request->hasFile('path')) {
            $path = $request->file('path');
            $gambarPath = $path->store('uploads', 'public');
            $validatedData['path'] = $gambarPath;
        }

        $validatedData['created_by'] = auth()->user()->username;

        $Gambar = Gambar::create($validatedData);

        HistoryLog::create([
            'table_name' => 'gambars',
            'record_id' => $Gambar->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function formupdatestruktur($id)
    {
        $data = Gambar::FindOrFail($id);
        return view('peoplereadiness.organisasi.update', compact('data'));
    }

    public function updatedatadatastruktur(Request $request, $id)
    {
        $validatedData = $request->validate([
            'path' => 'nullable|file',
            'tanggal' => 'required|date',
        ]);

        $data = Gambar::findOrFail($id);
        $oldData = $data->toArray();

        if ($request->hasFile('path')) {
            $path = $request->file('path');
            $gambarPath = $path->store('uploads', 'public');
            $validatedData['path'] = $gambarPath;
        } else {
            // Gunakan path lama jika tidak upload file baru
            $validatedData['path'] = $data->path;
        }

        $validatedData['updated_by'] = auth()->user()->username;

        $data->update($validatedData);

        HistoryLog::create([
            'table_name' => 'gambars',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
        ]);

        return redirect('/struktur')->with('success', 'Data saved successfully.');
    }

    public function deletestruktur($id)
    {
        $data = Gambar::findOrFail($id);
        $oldData = $data->toArray();

        // Hapus data dari tabel 
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'gambars',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Data deleted successfully.');
    }





    public function indexplantambang(Request $request)
    {
        $user = Auth::user();
        $companyId = request()->input('id_company');
        $tahun = Carbon::now()->year;
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;

        $query = DB::table('planTambang')
            ->select('planTambang.*')
            ->join('users', 'planTambang.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id');

        if ($user->role !== 'admin') {
            $query->where('users.id_company', $user->id_company);
        } else {
            if (!empty($companyId)) {
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

        return view('plantambang.index', compact('data', 'endDate', 'startDate'));
    }

    public function formplantambang()
    {
        return view('plantambang.adddata');
    }

    public function createplantambang(Request $request)
    {
        $validatedData = $request->validate([
            'path' => 'nullable|file',
            'tanggal' => 'required|date',
        ]);

        if ($request->hasFile('path')) {
            $path = $request->file('path');
            $planTambang = $path->store('uploads', 'public');
            $validatedData['path'] = $planTambang;
        }

        $validatedData['created_by'] = auth()->user()->username;

        $data = PlanTambang::create($validatedData);

        HistoryLog::create([
            'table_name' => 'planTambang',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        return redirect()->back()->with('success', 'Data added successfully.');
    }
    public function formupdateplantambang($id)
    {
        $data = PlanTambang::FindOrFail($id);
        return view('plantambang.update', compact('data'));
    }

    public function updateplantambang(Request $request, $id)
    {
        $validatedData = $request->validate([
            'path' => 'nullable|file',
            'tanggal' => 'required|date',
        ]);

        $data = PlanTambang::findOrFail($id);
        $oldData = $data->toArray();

        if ($request->hasFile('path')) {
            $path = $request->file('path');
            $planTambang = $path->store('uploads', 'public');
            $validatedData['path'] = $planTambang;
        } else {
            // Gunakan path lama jika tidak upload file baru
            $validatedData['path'] = $data->path;
        }

        $validatedData['updated_by'] = auth()->user()->username;

        $data->update($validatedData);

        HistoryLog::create([
            'table_name' => 'planTambang',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
        ]);

        return redirect('/indexplantambang')->with('success', 'Data saved successfully.');
    }


    public function deleteplantambang($id)
    {
        $data = PlanTambang::findOrFail($id);
        $oldData = $data->toArray();

        // Hapus data dari tabel 
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'planTambang',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Data deleted successfully.');
    }
}
