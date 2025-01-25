<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HistoryLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function historylog(Request $request)
    {
        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');  
        $query = DB::table('history_logs')
        ->join('users', 'history_logs.user_id', '=', 'users.id')
        ->select('history_logs.*', 'users.username');
        if ($startDate && $endDate) {
            $query->whereBetween('history_logs.created_at', [$startDate, $endDate]);
        }
        $data = $query->paginate(15);
        return view('historylog.index',compact('data'));
    }
    
}
