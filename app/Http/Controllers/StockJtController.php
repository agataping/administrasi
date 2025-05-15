<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Picastockjt;
use App\Models\StockJt;
use App\Models\Barging;
use Carbon\date;
use App\Models\HistoryLog;
use Illuminate\Support\Facades\Log;

class StockJtController extends Controller
{
    //detail
    public function dashboardstockjt(Request $request)
    {
        $user = Auth::user();
        $tahun = Carbon::now()->year;
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
        $query = DB::table('stock_jts')
            ->select('stock_jts.*')
            ->join('users', 'stock_jts.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id');

        if ($user->role !== 'admin') {
            $query->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $query->where('users.id_company', $companyId);
            }
        }

        // Mengatur tanggal filter jika tidak ada input
        if (!$startDate || !$endDate) {
            $startDate = Carbon::createFromDate($tahun, 1, 1)->startOfDay();
            $endDate = Carbon::createFromDate($tahun, 12, 31)->endOfDay();
        } else {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
        }

        // Hanya ambil data tahun yang sesuai dengan filter
        $query->whereBetween('stock_jts.date', [$startDate, $endDate])
            ->orderBy('stock_jts.date', 'asc');

        // Ambil data stok awal (sotckawal) dari tahun sebelumnya, hanya yang terbaru
        $stokAwalQuery = DB::table('stock_jts')
            ->join('users', 'stock_jts.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')

            ->select('sotckawal', 'date')
            ->whereNotNull('sotckawal')
            ->whereDate('stock_jts.date', '<', "$tahun-01-01")
            ->orderByDesc('date')
            ->limit(1);

        if ($user->role !== 'admin') {
            $stokAwalQuery->where('users.id_company', $user->id_company);
        } elseif ($companyId) {
            $stokAwalQuery->where('users.id_company', $companyId);
        }

        // Ambil stok awal yang terbaru
        $stokAwal = $stokAwalQuery->pluck('sotckawal')->first() ?? 0;

        // Mengambil data utama
        $data = $query->get();

        // Menghitung total plan nominal
        $planNominal = $data->sum(function ($p) {
            return floatval(str_replace(['.', ','], ['', '.'], $p->plan));
        });

        // Transformasi sotckawal menjadi angka float
        $data->transform(function ($item) {
            $item->sotckawal = floatval(str_replace(',', '.', str_replace('.', '', $item->sotckawal)));
            return $item;
        });

        // Menambahkan ekstensi file jika ada
        $data->each(function ($item) {
            $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
        });

        // Menghitung total hauling
        $totalHauling = $data->sum(function ($item) {
            return isset($item->totalhauling) && is_numeric($item->totalhauling)
                ? $item->totalhauling
                : 0;
        });

        $akumulasi = floatval($stokAwal ?? 0);
        // Menggunakan stok awal yang sudah didapatkan
        $data->each(function ($stock) use (&$akumulasi) {
            // Pastikan nilai sotckawal, totalhauling, dan stockout adalah angka (float)
            $stock->sotckawal = floatval($stock->sotckawal ?? 0);
            $stock->totalhauling = floatval($stock->totalhauling ?? 0);
            $stock->stockout = floatval($stock->stockout ?? 0);

            // Log untuk memverifikasi nilai yang digunakan
            // Log::info("Stok ID: {$stock->id}, sotckawal: {$stock->sotckawal}, totalhauling: {$stock->totalhauling}, stockout: {$stock->stockout}, Akumulasi: {$akumulasi}");

            // Akumulasi stok masuk
            $akumulasi += $stock->totalhauling;
            $stock->akumulasi_stock = $akumulasi;
        });

        $prevStockAkhir = floatval($stokAwal); // Pastikan stok awal adalah angka
        $totalStockOut = 0; // Variabel untuk menyimpan total stockout

        $data->each(function ($stock) use (&$prevStockAkhir, &$totalStockOut) {
            // Pastikan nilai-nilai tersebut adalah float
            $stock->sotckawal = floatval($stock->sotckawal ?? 0);
            $stock->totalhauling = floatval($stock->totalhauling ?? 0);
            $stock->stockout = floatval($stock->stockout ?? 0);

            // Jika sotckawal <= 0, gunakan prevStockAkhir
            if ($stock->sotckawal <= 0) {
                $stock->sotckawal = $prevStockAkhir;  // Gunakan stok sebelumnya jika stokawal <= 0
            }

            // Perhitungan stock_akhir: stokawal + totalhauling - stockout
            $stock->stock_akhir = ($stock->sotckawal + $stock->totalhauling) - $stock->stockout;

            // Akumulasi total stockout
            $totalStockOut += $stock->stockout;

            // Set prevStockAkhir untuk iterasi berikutnya
            $prevStockAkhir = $stock->stock_akhir;
        });
        $grandTotal = optional($data->last())->akumulasi_stock ?? 0;

        // Menyimpan total hasil akhir
        $grandTotalstockakhir = optional($data->last())->stock_akhir ?? 0;

        Log::info('Grand Total Stock Akhir:', [
            'grandTotalstockakhir' => $grandTotalstockakhir
        ]);


        // Sekarang kamu bisa pakai:
        // dd([
        //     'stok_awal' => $stokAwal,
        //     'total_hauling' => $totalHauling,
        //     'total_stockout' => $totalStockOut,
        //     'stock_akhir_terakhir' => $prevStockAkhir,
        // ]);

        return view('stockjt.indexmenu', compact('startDate', 'endDate', 'data', 'grandTotalstockakhir'));
    }


    public function stockjt(Request $request)
    {
        $user = Auth::user();
        $tahun = Carbon::now()->year;
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();


        $query = DB::table('bargings')
            ->select('bargings.*')
            ->join('users', 'bargings.created_by', '=', 'users.username')
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

        // Filter berdasarkan tanggal jika ada input
        if (!$startDate || !$endDate) {
            $startDate = Carbon::createFromDate($tahun, 1, 1)->startOfDay();
            $endDate = Carbon::createFromDate($tahun, 12, 31)->endOfDay();
        } else {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
        }
        $query->whereBetween('bargings.tanggal', [$startDate, $endDate]);


        $data = $query->get();
        $totalQuantity = 0;
        $count = 0;

        foreach ($data as $d) {
            $quantity = str_replace(['.', ','], ['', '.'], $d->quantity);
            $quantity = floatval($quantity);

            if (is_numeric($quantity)) {
                $totalQuantity += $quantity;
                $count++;
            }
        }
        $data = $data->map(function ($d) {
            $d->formatted_quantity = number_format(floatval(str_replace(['.', ','], ['', '.'], $d->quantity)), 0, ',', '.');
            return $d;
        });
        // dd($totalQuantity);


        $query = DB::table('stock_jts')
            ->join('users', 'stock_jts.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select('stock_jts.*');

        if ($user->role !== 'admin') {
            $query->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $query->where('users.id_company', $companyId);
            }
        }

        if (!$startDate || !$endDate) {
            $startDate = Carbon::createFromDate($tahun, 1, 1)->startOfDay();
            $endDate = Carbon::createFromDate($tahun, 12, 31)->endOfDay();
        } else {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
        }

        $query->whereBetween('stock_jts.date', [$startDate, $endDate]);

        // Ambil data stok awal (sotckawal) dari tahun sebelumnya, hanya yang terbaru
        $tanggalInput = Carbon::parse($request->date)->toDateString();

        $stokAwalQuery = DB::table('stock_jts')
            ->join('users', 'stock_jts.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
            ->select('sotckawal', 'date')
            ->whereNotNull('sotckawal')
            ->whereDate('stock_jts.date', '<=', $tanggalInput) // ambil yang sama atau sebelum tanggal input
            ->orderByDesc('date')
            ->limit(1);

        if ($user->role !== 'admin') {
            $stokAwalQuery->where('users.id_company', $user->id_company);
        } elseif ($companyId) {
            $stokAwalQuery->where('users.id_company', $companyId);
        }

        $stokAwal = $stokAwalQuery->pluck('sotckawal')->first() ?? 0;


        // Mengambil data utama
        $data = $query->get();

        // Menghitung total plan nominal
        $planNominal = $data->sum(function ($p) {
            return floatval(str_replace(['.', ','], ['', '.'], $p->plan));
        });

        // Transformasi sotckawal menjadi angka float
        $data->transform(function ($item) {
            $item->sotckawal = floatval(str_replace(',', '.', str_replace('.', '', $item->sotckawal)));
            return $item;
        });

        // Menambahkan ekstensi file jika ada
        $data->each(function ($item) {
            $item->file_extension = pathinfo($item->file ?? '', PATHINFO_EXTENSION);
        });

        // Menghitung total hauling
        $totalHauling = (clone $query)->sum('totalhauling') ?? 0;
        $akumulasi = floatval($stokAwal ?? 0);
        $data->each(function ($stock) use (&$akumulasi) {
            $stock->sotckawal = floatval($stock->sotckawal ?? 0);
            $stock->totalhauling = floatval($stock->totalhauling ?? 0);
            $stock->stockout = floatval($stock->stockout ?? 0);

            // Log::info("Stok ID: {$stock->id}, sotckawal: {$stock->sotckawal}, totalhauling: {$stock->totalhauling}, stockout: {$stock->stockout}, Akumulasi: {$akumulasi}");

            $akumulasi += $stock->totalhauling;
            $stock->akumulasi_stock = $akumulasi;
        });

        $prevStockAkhir = floatval($stokAwal);
        $totalStockOut = 0;

        $data->each(function ($stock) use (&$prevStockAkhir, &$totalStockOut) {
            $stock->sotckawal = floatval($stock->sotckawal ?? 0);
            $stock->totalhauling = floatval($stock->totalhauling ?? 0);
            $stock->stockout = floatval($stock->stockout ?? 0);

            if ($stock->sotckawal <= 0) {
                $stock->sotckawal = $prevStockAkhir;
            }

            $stock->stock_akhir = ($stock->sotckawal + $stock->totalhauling) - $stock->stockout;

            $totalStockOut += $stock->stockout;

            $prevStockAkhir = $stock->stock_akhir;

            // Log::info('Iterasi perhitungan:', [
            //     'sotckawal' => $stock->sotckawal,
            //     'totalhauling' => $stock->totalhauling,
            //     'stockout' => $stock->stockout,
            //     'stock_akhir' => $stock->stock_akhir,
            //     'prevStockAkhir' => $prevStockAkhir
            // ]);
        });
        $grandTotal = optional($data->last())->akumulasi_stock ?? 0;

        $grandTotalstockakhir = optional($data->last())->stock_akhir ?? 0;

        // Log::info('Grand Total Stock Akhir:', [
        //     'grandTotalstockakhir' => $grandTotalstockakhir
        // ]);


        return view('stockjt.index', compact(
            'startDate',
            'endDate',
            'data',
            'totalHauling',
            'grandTotal',
            'perusahaans',
            'companyId',
            'planNominal',
            'grandTotalstockakhir',
            'totalQuantity',
            'totalStockOut'
        ));
    }
    public function formstockjt(Request $request)
    {
        $data = Barging::whereYear('tanggal', now()->year)->get();
        return view('stockjt.adddata', compact('data'));
    }
    public function createstockjt(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'sotckawal' => 'nullable|regex:/^-?[0-9.,]+$/',
            'stockout' => 'nullable|regex:/^-?[0-9.,]+$/',
            'plan' => 'nullable|regex:/^-?[0-9.,]+$/',
            'shifpertama' => 'nullable|regex:/^-?[0-9.,]+$/',
            'shifkedua' => 'nullable|regex:/^-?[0-9.,]+$/',
            'totalhauling' => 'nullable|regex:/^-?[0-9.,]+$/',
            'lokasi' => 'required',
            'file' => 'nullable|file',
        ]);

        // Konversi inputan nominal agar bersih dari titik/koma
        $validatedData['plan'] = convertToCorrectNumber($validatedData['plan']);
        $validatedData['sotckawal'] = convertToCorrectNumber($validatedData['sotckawal']);
        $validatedData['stockout'] = convertToCorrectNumber($validatedData['stockout'] ?? null);
        $validatedData['shifpertama'] = convertToCorrectNumber($validatedData['shifpertama']);
        $validatedData['shifkedua'] = convertToCorrectNumber($validatedData['shifkedua']);
        $validatedData['totalhauling'] = convertToCorrectNumber($validatedData['totalhauling']);
        // Upload file jika ada
        $filePath = $request->hasFile('file') ? $request->file('file')->store('uploads', 'public') : null;

        // Cek apakah sudah ada data stockawal sebelumnya
        $existingStockAwal = StockJt::whereNotNull('sotckawal')->first();

        // Jika user menginput stock awal dan sudah ada sebelumnya, maka hapus data sebelumnya
        if ($validatedData['sotckawal'] !== null && $existingStockAwal) {
            $existingStockAwal->delete();
        }

        // Simpan data baru
        $data = StockJt::create([
            'date' => $validatedData['date'],
            'sotckawal' => $validatedData['sotckawal'],
            'stockout' => $validatedData['stockout'],
            'plan' => $validatedData['plan'],
            'file' => $filePath,
            'shifpertama' => $validatedData['shifpertama'],
            'shifkedua' => $validatedData['shifkedua'],
            'lokasi' => $validatedData['lokasi'],
            'totalhauling' => $validatedData['totalhauling'],
            'created_by' => auth()->user()->username,
        ]);

        // Simpan log riwayat
        HistoryLog::create([
            'table_name' => 'stock_jts',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($data),
            'user_id' => auth()->id(),
        ]);

        // Arahkan kembali setelah simpan
        if ($request->input('action') == 'save') {
            return redirect('/stockjt')->with('success', 'Data berhasil ditambahkan.');
        }


        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function formupdatestockjt($id)
    {
        $barging = Barging::all();
        $data = StockJt::findOrFail($id);
        return view('stockjt.update', compact('data', 'barging'));
    }

    public function updatestockjt(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'date' => 'required|date',
            'sotckawal' => 'nullable|regex:/^-?[0-9.,]+$/',
            'stockout' => 'nullable|regex:/^-?[0-9.,]+$/',
            'plan' => 'nullable|regex:/^-?[0-9.,]+$/',
            'shifkedua' => 'nullable|regex:/^-?[0-9.,]+$/',
            'shifpertama' => 'nullable|regex:/^-?[0-9.,]+$/',
            'totalhauling' => 'nullable|regex:/^-?[0-9.,]+$/',
            'lokasi' => 'required|string',
            'file' => 'nullable|file',
            // regex:/^-?[0-9.,]+$/
        ]);



        $validatedData = $request->all();

        $validatedData['stockawal'] = convertToCorrectNumber($validatedData['stockawal'] ?? 0);
        $validatedData['plan'] = convertToCorrectNumber($validatedData['plan'] ?? 0);
        $validatedData['stockout'] = convertToCorrectNumber($validatedData['stockout'] ?? 0);
        $validatedData['shifpertama'] = convertToCorrectNumber($validatedData['shifpertama'] ?? 0);
        $validatedData['shifkedua'] = convertToCorrectNumber($validatedData['shifkedua'] ?? 0);
        $validatedData['totalhauling'] = convertToCorrectNumber($validatedData['totalhauling'] ?? 0);


        $data = StockJt::findOrFail($id);
        $oldData = $data->toArray();

        if ($request->hasFile('file')) {
            if ($data->file) {
                Storage::disk('public')->delete($data->file);
            }

            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
            $validatedData['file'] = $filePath;
        }

        // Simpan user yang mengupdate
        $validatedData['updated_by'] = auth()->user()->username;

        // Update data
        $data->update($validatedData);

        // Simpan log perubahan
        HistoryLog::create([
            'table_name' => 'stock_jts',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);

        return redirect('/stockjt')->with('success', 'Data updated successfully.');
    }

    public function deletestockjt($id)
    {
        $data = StockJt::findOrFail($id);
        $oldData = $data->toArray();

        // Hapus data dari tabel 
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'stock_jts',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect('/stockjt')->with('success', 'Data deleted successfully.');
    }



    //Pica
    public function picastockjt(Request $request)
    {
        $user = Auth::user();
        $tahun = Carbon::now()->year;
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : null;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : null;

        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

        $query = DB::table('picastockjts')
            ->select('picastockjts.*')
            ->join('users', 'picastockjts.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id');


        if ($user->role !== 'admin') {
            $query->where('users.id_company', $user->id_company);
        } else {
            if ($companyId) {
                $query->where('users.id_company', $companyId);
            } else {
                $query->whereRaw('users.id_company', $companyId); // Mencegah admin melihat semua data secara default
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


        return view('picastokjt.index', compact('startDate', 'endDate', 'data', 'perusahaans', 'companyId'));
    }

    public function formpicasjt()
    {
        $user = Auth::user();
        return view('picastokjt.addData');
    }

    public function createsjt(Request $request)
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
        $data = Picastockjt::create($validatedData);
        HistoryLog::create([
            'table_name' => '',
            'record_id' => $data->id,
            'action' => 'create',
            'old_data' => null,
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/picastockjt')->with('success', 'Data added successfully.');
        }

        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function formupdatesjt($id)
    {
        $data = Picastockjt::findOrFail($id);
        return view('picastokjt.update', compact('data'));
    }

    public function updatesjt(Request $request, $id)
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

        $data = Picastockjt::findOrFail($id);
        $oldData = $data->toArray();

        $data->update($validatedData);

        HistoryLog::create([
            'table_name' => 'picastockjts',
            'record_id' => $id,
            'action' => 'update',
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($validatedData),
            'user_id' => auth()->id(),
        ]);
        return redirect('/picastockjt')->with('success', 'data saved successfully.');
    }

    public function deletepicastockjt($id)
    {
        $data = Picastockjt::findOrFail($id);
        $oldData = $data->toArray();

        // Hapus data dari tabel 
        $data->delete();

        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => '',
            'record_id' => $id,
            'action' => 'delete',
            'old_data' => json_encode($oldData),
            'new_data' => null,
            'user_id' => auth()->id(),
        ]);
        return redirect('/picastockjt')->with('success', 'Data deleted successfully.');
    }
}
function convertToCorrectNumber($value)
{
    if ($value === '' || $value === null) {
        return 0;
    }

    $value = str_replace(',', '.', $value);

    return floatval(preg_replace('/[^\d.]/', '', $value));
}
