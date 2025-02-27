<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\DetailNeraca;
use App\Models\CategoryNeraca;
use App\Models\SubNeraca;
use App\Models\HistoryLog;

class DetailNeracaController extends Controller
{
    //detail
    public function indexfinancial(Request $request)
    {
        $user = Auth::user();  

        $startDate = $request->input('start_date'); 
        $endDate = $request->input('end_date');    
        $companyId = $request->input('id_company');
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
        // Query data
        $query = DB::table('detail_neracas')
        ->join('sub_neracas', 'detail_neracas.sub_id', '=', 'sub_neracas.id')
        ->join('category_neracas', 'sub_neracas.kategori_id', '=', 'category_neracas.id')
        ->join('users', 'detail_neracas.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id')
        ->select(
            'category_neracas.namecategory as category',
            'sub_neracas.namesub as sub_category',
            'detail_neracas.*',
            'sub_neracas.id as sub_id', 
            'category_neracas.id as category_id', 
            'detail_neracas.id as detail_id' 
        );
        if ($user->role !== 'admin') {
            $query->where('users.id_company', $companyId);
        } else {
            if ($companyId) {
                $query->where('users.id_company', $companyId);
            } else {
                $query->whereRaw('users.id_company', $companyId);             
            }
        }     
        
        if ($startDate && $endDate) {
            $query->whereBetween('detail_neracas.tanggal', [$startDate, $endDate]);
        }
        $data = $query->orderBy('category_neracas.created_at', 'asc')
        ->get()
        ->groupBy('category');
        
        
        // $totalsAssets = $data->only(['CURRENT ASSETS', 'FIX ASSETS'])
        // ->map(function ($categories) {
        //     return $categories->sum('nominal');
        // })
        // ->sum();
        // $totalLiabilitas = $data->only(['EQUITY', 'LIABILITIES'])
        // ->map(function ($categories) {
        //     return $categories->sum('nominal');
        // })
        // ->sum();
        // //total control
        // $control= $totalLiabilitas - $totalsAssets;
        // // NILAI BENER JIKA 0
        // if ($control !== 0) {
        //     $note = "Salah: $control";
        // } else {
        //     $note = "Benar";
        // }
        
        $groupedData = $data->map(function ($categories, $categoryName) {
            $totalJenis = ['debit' => 0, 'credit' => 0];
        
            $categoriesGrouped = $categories->groupBy('sub_category')->map(function ($subItems, $subCategoryName) use (&$totalJenis) {
                // Konversi nilai debit & credit ke float agar tidak ada kesalahan perhitungan
                $subTotalDebit = $subItems->sum(function ($item) {
                    return (float) str_replace(',', '', $item->debit); 
                });
                $subTotalCredit = $subItems->sum(function ($item) {
                    return (float) str_replace(',', '', $item->credit);
                });
        
                // Menambahkan ke total keseluruhan
                $totalJenis['debit'] += $subTotalDebit;
                $totalJenis['credit'] += $subTotalCredit;
        
                return [
                    'sub_category' => $subCategoryName,
                    'sub_id' => $subItems->first()->sub_id ?? null, 
                    'details' => $subItems->map(function ($item) {
                        return [
                            'id' => $item->detail_id, 
                            'name' => $item->name,
                            'tanggal' => $item->tanggal,
                            'debit' => (float) str_replace(',', '', $item->debit), 
                            'credit' => (float) str_replace(',', '', $item->credit), 
                        ];
                    }),
                ];
            });
        
            return [
                'category_name' => $categoryName,
                'total' => $totalJenis,
                'sub_categories' => $categoriesGrouped,
                'category_id' => $categories->first()->category_id, // Ambil id kategori
            ];
        });
        
        // Cek apakah jumlah total benar
        // dd($groupedData);
        
        return view('financial.index', compact('groupedData','perusahaans', 'companyId'));
    }            
    public function formfinanc(Request $reques){
        $sub = SubNeraca::all();
        $sub = DB::table('sub_neracas')
        ->join('category_neracas', 'sub_neracas.kategori_id', '=', 'category_neracas.id')
        ->select('category_neracas.namecategory','sub_neracas.namesub','sub_neracas.id')
        ->get();

        return view ('financial.addData',compact('sub'));
   
    }

    public function createfinanc(Request $request){
        $validatedData = $request->validate([
            'debit' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'credit' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'name' => 'required|string',
            'sub_id' => 'required|string',
            'tanggal' => 'required|date',
        ]);
        
        function convertToCorrectNumber($value) {
            if ($value === '' || $value === null) {
                return 0; // Jika kosong, set ke 0
            }
            $value = str_replace('.', '', $value);  // Hapus titik pemisah ribuan
            $value = str_replace(',', '.', $value); // Ubah koma desimal ke titik (format internasional)
            return floatval($value); // Pastikan menjadi angka
        }
        
        $validatedData['debit'] = convertToCorrectNumber($validatedData['debit']);
        $validatedData['credit'] = convertToCorrectNumber($validatedData['credit']);
                // Tambahkan created_by
        $validatedData['created_by'] = auth()->user()->username;
        // Simpan data ke database
        $data=DetailNeraca::create($validatedData);
        HistoryLog::create([
            'table_name' => 'detail_neracas', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexfinancial')->with('success', 'Data added successfully.');
        }
    
        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function formupdatefinancial($id)
    {
        $sub = DB::table('sub_neracas')
        ->join('category_neracas', 'sub_neracas.kategori_id', '=', 'category_neracas.id')
        ->select('category_neracas.namecategory','sub_neracas.namesub','sub_neracas.id')
        ->get();
        $data = DetailNeraca::FindOrFail($id);
        return view('financial.update.updatedetail',compact('data','sub'));
    }

    public function updatedetailfinan(Request $request, $id){
        $validatedData = $request->validate([
            'debit' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'credit' => 'nullable|regex:/^[\d,]+(\.\d{1,2})?$/',
            'name' => 'required|string',
            'sub_id' => 'required|string',
            'tanggal' => 'required|date',
        ]);
        
        // Format nominal untuk menghapus koma
        function convertToCorrectNumber($value) {
            if ($value === '' || $value === null) {
                return 0; 
            }
            $value = str_replace('.', '', $value);  
            $value = str_replace(',', '.', $value); 
            return floatval($value); 
        }
        
        $validatedData['debit'] = convertToCorrectNumber($validatedData['debit']);
        $validatedData['credit'] = convertToCorrectNumber($validatedData['credit']);
        $validatedData['updated_by'] = auth()->user()->username;
        $data = DetailNeraca::findOrFail($id);
        $oldData = $data->toArray();
        
        $data->update($validatedData);
        

        HistoryLog::create([
            'table_name' => 'detailsneracas', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
        ]);
        return redirect('/indexfinancial')->with('success', 'Data berhasil disimpan.');

    }
    
    //categori
    public function indexcategoryneraca(Request $request){
        $user = Auth::user(); 
        $companyId = $request->input('company_id'); 
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

    
        $query = DB::table('category_neracas')
            ->select('category_neracas.*')
            ->join('users', 'category_neracas.created_by', '=', 'users.username')
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
    
        $kat = $query->get(); 

        return view('financial.indexcategory',compact('kat','companyId','perusahaans'));
    }
    public function categoryneraca()
    {
        $user = Auth::user();  
        return view('financial.categoryform');
    }

    public function createcategoryneraca (Request $request)
    {
        $validatedData = $request->validate([
            'namecategory' => 'required|string',
        ]);
        $validatedData['created_by'] = auth()->user()->username;
        $data=CategoryNeraca::create($validatedData);
        HistoryLog::create([
            'table_name' => 'category_neracas', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexfinancial')->with('success', 'Data added successfully.');
        }
    
        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function formupdatecatneraca($id){
        $data = categoryneraca::FindOrFail($id);
        return view ('financial.update.updatecategory',compact('data'));
    }

    public function updatecatneraca(Request $request, $id)
    {
        $validatedData = $request->validate([
            'namecategory' => 'required|string',
        ]);
        $validatedData['updated_by'] = auth()->user()->username;
        $data = CategoryNeraca::findOrFail($id);
        $oldData = $data->toArray();
        
        $data->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'category_neracas', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
        ]);
        return redirect('/indexfinancial')->with('success', 'Data berhasil disimpan.');

 
    }
    public function deltecategoryneraca ($id)
    {
        $data = CategoryNeraca::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'category_neracas', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect()->back()->with('success', 'Data deleted successfully.');
    }

    //sub
    public function indexsubneraca(Request $request){
        $user = Auth::user(); 
        $companyId = $request->input('company_id'); 
        $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();

    
        $query = DB::table('sub_neracas')
            ->select('sub_neracas.*')
            ->join('users', 'sub_neracas.created_by', '=', 'users.username')
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
    
        $kat = $query->get(); 

        return view('financial.indexsub',compact('kat','companyId','perusahaans'));
    }
    public function subneraca()
    {
        $user = Auth::user();  
        $kat = CategoryNeraca::all();
        return view('financial.subform',compact('kat'));
    }

    public function createsubneraca (Request $request)
    {
        $validatedData = $request->validate([
            'namesub' => 'required|string',
            'kategori_id' => 'required|string',
        ]);
        $validatedData['created_by'] = auth()->user()->username;
        $data=SubNeraca::create($validatedData);
        HistoryLog::create([
            'table_name' => 'sub_neracas', 
            'record_id' => $data->id, 
            'action' => 'create',
            'old_data' => null, 
            'new_data' => json_encode($validatedData), 
            'user_id' => auth()->id(), 
        ]);
        if ($request->input('action') == 'save') {
            return redirect('/indexfinancial')->with('success', 'Data added successfully.');
        }
    
        return redirect()->back()->with('success', 'Data added successfully.');

    }

    public function formupdatesubneraca($id)
    {
        $kat = CategoryNeraca::all();
        $data = SubNeraca::FindorFail($id);
 
        return view ('financial.update.updatesub',compact('data','kat'));
    }

    public function updatesubneraca(Request $request, $id)
    {
        $validatedData = $request->validate([
            'namesub' => 'required|string',
            'kategori_id' => 'required|string',
        ]);
        $validatedData['updated_by'] = auth()->user()->username;
        $data = SubNeraca::findOrFail($id);
        $oldData = $data->toArray();
        
        $data->update($validatedData);
        
        HistoryLog::create([
            'table_name' => 'sub_neracas', 
            'record_id' => $id, 
            'action' => 'update', 
            'old_data' => json_encode($oldData), 
            'new_data' => json_encode($validatedData), 
        ]);

        return redirect('/indexfinancial')->with('success', 'Data berhasil disimpan.');

    }

    public function deletefinancial ($id)
    {
        $data = DetailNeraca::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'detailneracas', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect('/indexfinancial')->with('success', 'Data deleted successfully.');
    }

    public function deletesubfinan($id)
    {
        $data = SubNeraca::findOrFail($id);
        $oldData = $data->toArray();
        
        // Hapus data dari tabel 
        $data->delete();
        
        // Simpan log ke tabel history_logs
        HistoryLog::create([
            'table_name' => 'sub_neracas', 
            'record_id' => $id, 
            'action' => 'delete', 
            'old_data' => json_encode($oldData), 
            'new_data' => null, 
            'user_id' => auth()->id(), 
        ]);
        return redirect()->back()->with('success', 'Data deleted successfully.');
    }




}
