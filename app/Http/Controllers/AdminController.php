<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HistoryLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function historylog(Request $request)
    {
        $user = Auth::user(); // Ambil user yang sedang login
        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');  
    
        $query = DB::table('history_logs')
            ->join('users', 'history_logs.user_id', '=', 'users.id')
            ->select('history_logs.*', 'users.username')
            ->where('users.id_company', $user->id_company); // Filter berdasarkan id_company user yang login
    
if ($startDate && $endDate) {
    $startDateFormatted = Carbon::parse($startDate)->startOfDay();
    $endDateFormatted = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('history_logs.created_at', [$startDate, $endDate]);
        }
    
        $data = $query->paginate(15);
    
        return view('historylog.index', compact('data'));
    }
        
    
}
