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

class PeopleReadinessController extends Controller
{
        public function dashboard()
        {
            if (Auth::check()) {
                $username = Auth::user()->name;
                return view('components.main', ['username' => $username]);
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
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $companyId = $request->input('id_company');
            $perusahaans = DB::table('perusahaans')->select('id', 'nama')->get();
    
            $query = DB::table('people_readinesses') 
            ->select('people_readinesses.*')
            ->join('users', 'people_readinesses.created_by', '=', 'users.username')
            ->join('perusahaans', 'users.id_company', '=', 'perusahaans.id');
        if ($user->role !== 'admin') {
            $query->where('users.id_company', $user->id_company);            } else {
                if ($companyId) {
                    $query->where('users.id_company', $companyId);
                } else {
                    $query->whereRaw('users.id_company', $companyId);             
                }
            }
            
            if ($startDate && $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]); // Tidak perlu menyebut nama tabel
            }
            
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
                $tot = 0; // Default jika Quantity tidak valid
            }
            

            return view('peoplereadiness.index', compact('data','averageQuality', 'averageQuantity','tot','perusahaans', 'companyId'));
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
            return redirect('/indexPeople')->with('success', 'Data berhasil diperbarui.');
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
            $peopleReadiness=PeopleReadiness::create($validatedData);    
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
        

        public function deletepeoplereadines ($id)
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
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
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
            
            if ($startDate && $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]); 
            }
           $data = $query->get();
            return view('picapeople.index', compact('data','perusahaans', 'companyId'));
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
            PicaPeople::create($validatedData);        
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
            
            $oldData = $peopleReadiness->toArray();
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

        public function deletepicapeole ($id)
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
        public function struktur()
        {
            $user = Auth::user();
            $companyId = request()->input('id_company'); // Menangkap request id_company
        
            $query = DB::table('gambars')
                ->select('gambars.*')
                ->leftJoin('users', 'gambars.created_by', '=', 'users.username')
                ->leftJoin('perusahaans', 'users.id_company', '=', 'perusahaans.id');
        
        if ($user->role !== 'admin') {
            $query->where('users.id_company', $user->id_company);            } else {
                if (!empty($companyId)) {
                    $query->where('users.id_company', $companyId);
                } else {
                    $query->whereRaw('users.id_company', $companyId);
                }
            }
        
            $gambar = $query->latest()->first();            
            return view('peoplereadiness.organisasi.index', compact('gambar'));
        }

        public function formbagan(){
            return view('peoplereadiness.organisasi.addGambar');
        }

        public function createbagan(Request $request)
        {
            $request->validate([
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $path = $file->store('gambar', 'public');
                Gambar::create([
                    'path' => $path,
                    'created_by' => auth()->user()->username, 
                ]);  

                return redirect('/struktur')->with('success', 'Image uploaded successfully.');
            
            }
            return back()->withErrors('Failed to upload image.');
        }
        
}            
    
    