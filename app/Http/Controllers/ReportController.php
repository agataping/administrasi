<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\DB;
use App\Models\planBargings;
use App\Services\ReportService as ServiceReportService;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Dd;
use App\Services\ReportService;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ServiceReportService $reportService)
    {
        $this->reportService = $reportService;
    }
    public function reportkpi(Request $request)
    {
        $data = $this->reportService->DataReport($request);
        // dd($data);
        return view('pt.report', compact('data'));
    }
    public function indexpengkuran(Request $request)
    {
        $data= $this->reportService->DataReport($request);

        return view ('pengukuran.index', compact('data'));
    }
    public function indexkpi(Request $request)
    {
        $data= $this->reportService->DataReport($request);

        return view ('pengukuran.indexkpi', compact('data'));
    }
}
