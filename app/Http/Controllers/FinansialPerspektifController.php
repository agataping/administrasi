<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\KategoriLabaRugi;
use App\Models\LabaRugi;

class FinansialPerspektifController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year');
        
        $reports = LabaRugi::when($year, function ($query, $year) {
            return $query->whereYear('created_at', $year);
        })->get();
    
        $years = LabaRugi::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
            $datas = DB::table('laba_rugis')
            ->join('kategori_laba_rugis', 'laba_rugis.Description', '=', 'kategori_laba_rugis.id')
            ->select('laba_rugis.id', 'laba_rugis.PlaYtd', 'laba_rugis.created_by', 'laba_rugis.Actualytd', 'kategori_laba_rugis.id as category_id', 'kategori_laba_rugis.DescriptionName')
            ->get();
        
        $structuredData = [];
        $categories = DB::table('kategori_laba_rugis')->get(); 
        
        foreach ($categories as $category) {
            if ($category->parent_id === null) {
                $mainCounter = count(array_filter($structuredData, fn($desc) => $desc['parent_id'] === null)) + 1;
                $categoryData = [
                    'id' => $category->id,
                    'name' => "{$mainCounter}. {$category->DescriptionName}",
                    'parent_id' => null,
                    'subcategories' => [],
                    'PlaYtd' => null,
                ];
        
                foreach ($categories as $subCategory) {
                    if ($subCategory->parent_id === $category->id) {
                        $categoryData['subcategories'][] = [
                            'id' => $subCategory->id,
                            'name' => "{$mainCounter}." . (count($categoryData['subcategories']) + 1) . " {$subCategory->DescriptionName}",
                            'PlaYtd' => null, 
                            'created_by' => $category->created_by,  // Menambahkan created_by
                        ];
                    }
                }
        
                $structuredData[] = $categoryData;
            }
        }
        
        foreach ($datas as $data) {
            foreach ($structuredData as &$category) {
                if ($category['id'] == $data->category_id && $category['parent_id'] === null) {
                    $category['PlaYtd'] = $data->PlaYtd;
                }
                foreach ($category['subcategories'] as &$subcategory) {
                    if ($subcategory['id'] == $data->category_id) {
                        $subcategory['PlaYtd'] = $data->PlaYtd;
                        $subcategory['Actualytd'] = $data->Actualytd;
                        $subcategory['created_by'] = $data->created_by;
                    }
                }
            }
        }
        return view('Finansial.index', compact('reports', 'years', 'year', 'datas', 'structuredData'));
    }
    

    //UNTUK MENAMPILAKN FORM dan ADD DATA NAMA LABA RUGI
    public function KFormLabarugi()
    {
        return view('Finansial.FormNamaLR');
    }
    
  
    public function createDeskripsi(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'DescriptionName' => 'required|string',  // Nama kategori utama harus berupa string
            'sub' => 'nullable|array',  // Subkategori bisa kosong atau array
            'sub.*' => 'nullable|string',  // Setiap subkategori harus berupa string (jika ada)
        ]);
        
        // Menyimpan kategori utama
        $kategori = KategoriLabaRugi::create([
            'DescriptionName' => $validatedData['DescriptionName'],
            'parent_id' => NULL,  // Karena ini adalah kategori utama
            'created_by' => auth()->user()->username,
        ]);
    
        // Mengecek apakah ada subkategori
        if (!empty($validatedData['sub'])) {
            // Menyimpan subkategori yang terkait dengan kategori utama
            foreach ($validatedData['sub'] as $sub) {
                // Memastikan subkategori tidak kosong
                if (!empty($sub)) {
                    KategoriLabaRugi::create([
                        'DescriptionName' => $sub,  // Subkategori yang sesuai dengan input
                        'parent_id' => $kategori->id,  // Menyambungkan subkategori dengan kategori utama
                        'created_by' => auth()->user()->username,
                    ]);
                }
            }
        }
    
    
        return redirect('/index')->with('success', 'Data berhasil disimpan.');
    }
        
    
    


        //UNTUK MENAMPILAKN FORM dan ADD LABA RUGI
        public function formLabaRugi()
        {
            
                $categories = KategoriLabaRugi::all(); // Ambil semua data dari database
                $numberedDescriptions = [];
            
                // Logic untuk menambahkan nomor dan menyusun kategori & subkategori
                foreach ($categories as $category) {
                    if ($category->parent_id === null) {
                        $mainCounter = count(array_filter($numberedDescriptions, fn($desc) => $desc['parent_id'] === null)) + 1;
                        $numberedDescriptions[] = [
                            'id' => $category->id,
                            'name' => "{$mainCounter}. {$category->DescriptionName}",
                            'parent_id' => null,
                        ];
            
                        // Subkategori
                        $subCounter = 1;
                        foreach ($categories as $subCategory) {
                            if ($subCategory->parent_id === $category->id) {
                                $numberedDescriptions[] = [
                                    'id' => $subCategory->id,
                                    'name' => "{$mainCounter}.{$subCounter} {$subCategory->DescriptionName}",
                                    'parent_id' => $category->id,
                                ];
                                $subCounter++;
                            }
                        }
                    }
                }
            

            
                        
            return view('Finansial.formLabaRugi',compact('numberedDescriptions'));
        }
        
        public function createLabarugi(Request $request)
        {
            {
                // Validasi input
                $request->validate([
                    'values.*.PlaYtd' => 'nullable|numeric',
                    'values.*.VerticalAnalisys1' => 'nullable|numeric',
                    'values.*.VerticalAnalisys' => 'nullable',
                    'values.*.Actualytd' => 'nullable|numeric',
                    'values.*.Deviation' => 'nullable|numeric',
                    'values.*.Percentage' => 'nullable',
                    'year' => 'required|integer'
                ]); 
                $tahun = $request->year;
                // Menyimpan data input untuk setiap deskripsi
                foreach ($request->values as $descriptionId => $inputData) {
                    LabaRugi::create([
                        'Description' => $descriptionId,
                        'PlaYtd' => $inputData['PlaYtd'],
                        'Actualytd' => $inputData['Actualytd'],
                        'Deviation' => $inputData['Deviation'],
                        'Percentage' => $inputData['Percentage'],
                        'VerticalAnalisys1' => $inputData['VerticalAnalisys1'],
                        'VerticalAnalisys' => $inputData['VerticalAnalisys'],
                        'year' => $tahun,
                        'created_by' => auth()->user()->username, 
                    ]);
                }
            }       
            return redirect('/index')->with('success', 'Data berhasil disimpan.');
        }
    

}
