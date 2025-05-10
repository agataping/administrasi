<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\DB;
use App\Services\persentaseCompany as ServiceReportService;

class PerusahaanController extends Controller
{
    protected $reportService;

    public function __construct(ServiceReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function dummy()
    {
        return view('pt.tmanual');
    }

    //UNTUK MENAMPILAKN FORM dan ADD DATA NAMA LABA RUGI
    public function perusahaan()
    {
        return view('pt.formPt');
    }

    public function createPerusahaan(Request $request)
    { {
            $validatedData = $request->validate([
                'induk' => 'required',
                'nama' => 'required',
            ]);

            Perusahaan::create($validatedData);

            return back()->with('success', 'Data saved successfully.');
        }
    }




    //iup dll
    public function iup(Request $request)
    {

            // dd($data);


        $user = auth()->user();
        if (auth()->user()->role === 'admin') {
            $data = DB::table('perusahaans')
                ->where('perusahaans.induk', 'IUP')
                ->select('perusahaans.*')
                ->get();
        } else {
            $data = DB::table('perusahaans')
                ->where('perusahaans.induk', 'IUP')
                ->select('perusahaans.*')
                ->get();
        }
        $datas = [];
        $totalResultInduk = 0;
        $totalCompanyCount = count($data);

        foreach ($data as $company) {
            $datas[$company->id] = $this->reportService->DataReport($request, $company->id);

            $totalResultInduk += $datas[$company->id]['totalresultfinancial'] ?? 0;
            $totalResultInduk += $datas[$company->id]['totalresultcostumer'] ?? 0;
            $totalResultInduk += $datas[$company->id]['totalresultIPP'] ?? 0;
            $totalResultInduk += $datas[$company->id]['resultlearning'] ?? 0;
        }

        if ($totalCompanyCount > 0) {
            $totalResultIndukPerInduk = round(($totalResultInduk / 4) / $totalCompanyCount, 2);
        } else {
            $totalResultIndukPerInduk = 0;
        }
        return view('pt.iup', compact('data', 'datas', 'totalResultIndukPerInduk'));
    }

    public function nonenergi(Request $request)
    {
        $user = auth()->user();
        if (auth()->user()->role === 'admin') {
            $data = DB::table('perusahaans')
                ->where('perusahaans.induk', 'Non Energi')
                ->select('perusahaans.*')
                ->get();
        } else {
            $data = DB::table('perusahaans')
                ->where('perusahaans.induk', 'Non Energi')
                ->select('perusahaans.*')
                ->get();
        }
        $datas = [];
        $totalResultInduk = 0;
        $totalCompanyCount = count($data);

        foreach ($data as $company) {
            $datas[$company->id] = $this->reportService->DataReport($request, $company->id);

            $totalResultInduk += $datas[$company->id]['totalresultfinancial'] ?? 0;
            $totalResultInduk += $datas[$company->id]['totalresultcostumer'] ?? 0;
            $totalResultInduk += $datas[$company->id]['totalresultIPP'] ?? 0;
            $totalResultInduk += $datas[$company->id]['resultlearning'] ?? 0;
        }

        if ($totalCompanyCount > 0) {
            $totalResultIndukPerInduk = round(($totalResultInduk / 4) / $totalCompanyCount, 2);
        } else {
            $totalResultIndukPerInduk = 0;
        }
        return view('pt.nonenergi', compact('data', 'datas','totalResultIndukPerInduk'));
    }
    public function kontraktor(Request $request)
    {
        $user = auth()->user();
        if (auth()->user()->role === 'admin') {
            $data = DB::table('perusahaans')
                ->where('perusahaans.induk', 'Kontraktor')
                ->select('perusahaans.*')
                ->get();
        } else {
            $data = DB::table('perusahaans')
                ->where('perusahaans.induk', 'Kontraktor')
                ->select('perusahaans.*')
                ->get();
        }
        $datas = [];
        $totalResultInduk = 0;
        $totalCompanyCount = count($data);

        foreach ($data as $company) {
            $datas[$company->id] = $this->reportService->DataReport($request, $company->id);

            $totalResultInduk += $datas[$company->id]['totalresultfinancial'] ?? 0;
            $totalResultInduk += $datas[$company->id]['totalresultcostumer'] ?? 0;
            $totalResultInduk += $datas[$company->id]['totalresultIPP'] ?? 0;
            $totalResultInduk += $datas[$company->id]['resultlearning'] ?? 0;
        }

        if ($totalCompanyCount > 0) {
            $totalResultIndukPerInduk = round(($totalResultInduk / 4) / $totalCompanyCount, 2);
        } else {
            $totalResultIndukPerInduk = 0;
        }

        return view('pt.kontraktor', compact('data', 'datas','totalResultIndukPerInduk'));
    }
    public function marketing(Request $request)
    {
        $user = auth()->user();
        if (auth()->user()->role === 'admin') {
            $data = DB::table('perusahaans')
                ->where('perusahaans.induk', 'Marketing')
                ->select('perusahaans.*')
                ->get();
        } else {
            $data = DB::table('perusahaans')
                ->where('perusahaans.induk', 'Marketing')
                ->select('perusahaans.*')
                ->get();
        }
        $datas = [];
        $totalResultInduk = 0;
        $totalCompanyCount = count($data);

        foreach ($data as $company) {
            $datas[$company->id] = $this->reportService->DataReport($request, $company->id);

            $totalResultInduk += $datas[$company->id]['totalresultfinancial'] ?? 0;
            $totalResultInduk += $datas[$company->id]['totalresultcostumer'] ?? 0;
            $totalResultInduk += $datas[$company->id]['totalresultIPP'] ?? 0;
            $totalResultInduk += $datas[$company->id]['resultlearning'] ?? 0;
        }

        if ($totalCompanyCount > 0) {
            $totalResultIndukPerInduk = round(($totalResultInduk / 4) / $totalCompanyCount, 2);
        } else {
            $totalResultIndukPerInduk = 0;
        }

        return view('pt.marketing', compact('data', 'datas','totalResultIndukPerInduk'));
    }
}
