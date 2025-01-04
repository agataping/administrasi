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
        ->select('laba_rugis.Description', 'laba_rugis.PlaYtd', 
        'laba_rugis.created_by', 'laba_rugis.Actualytd',
        'laba_rugis.VerticalAnalisys1',
        'laba_rugis.VerticalAnalisys',
        'laba_rugis.Deviation',
        'laba_rugis.Percentage', 
        'kategori_laba_rugis.id as category_id', 'kategori_laba_rugis.DescriptionName')
        ->get();
        
        $structuredData = [];
        // $categories = DB::table('kategori_laba_rugis')->get(); 
        $categories = DB::table('kategori_laba_rugis')
        ->join('laba_rugis', 'kategori_laba_rugis.id', '=', 'laba_rugis.Description')
        ->select(
            'laba_rugis.Description', 
            'laba_rugis.PlaYtd', 
            'laba_rugis.created_by', 
            'laba_rugis.Actualytd', 
            'laba_rugis.VerticalAnalisys1',
            'laba_rugis.VerticalAnalisys',
            'laba_rugis.Deviation',
            'laba_rugis.Percentage', 
            
            'kategori_laba_rugis.DescriptionName', 
            'kategori_laba_rugis.parent_id', 
            'kategori_laba_rugis.id as id'
            )
            ->get();
            
            // dd($categories); 
            
            
            foreach ($categories as $category) {
                // dd($category);
                if ($category->parent_id === null) {
                    
                    $mainCounter = count(array_filter($structuredData, fn($desc) => $desc['parent_id'] === null)) + 1;
                    $categoryData = [
                        'id' => $category->id,
                        'name' => "{$mainCounter}. {$category->DescriptionName}",
                        'parent_id' => null,
                        'PlaYtd' => $category->PlaYtd ?? null,  // Default ke null jika tidak ada
                        'ActualYtd' => $category->ActualYtd ?? null,  // Default ke null jika tidak ada                    
                        'VerticalAnalisys1' => $category->VerticalAnalisys1 ?? null,  // Default ke null jika tidak ada
                        'VerticalAnalisys' => $category->VerticalAnalisys ?? null,  // Default ke null jika tidak ada                    
                        'Deviation' => $category->Deviation ?? null,  // Default ke null jika tidak ada
                        'Percentage' => $category->Percentage ?? null,  // Default ke null jika tidak ada       
                        'created_by' => $category->created_by,             
                        'subcategories' => [],
                    ];
                    
                    foreach ($categories as $subCategory) {
                        if ($subCategory->parent_id === $category->id) {
                            $categoryData['subcategories'][] = [
                                'id' => $subCategory->id,
                                'name' => "{$mainCounter}." . (count($categoryData['subcategories']) + 1) . " {$subCategory->DescriptionName}",
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
                        $category['Actualytd'] = $data->Actualytd;
                        $category['VerticalAnalisys1'] = $data->VerticalAnalisys1;
                        $category['VerticalAnalisys'] = $data->VerticalAnalisys;
                        $category['Deviation'] = $data->Deviation;
                        $category['Percentage'] = $data->Percentage;
                        $category['created_by'] = $data->created_by;
                        
                        
                    }
                    foreach ($category['subcategories'] as &$subcategory) {
                        if ($subcategory['id'] == $data->category_id) {
                            $subcategory['Actualytd'] = $data->Actualytd;
                            
                            $subcategory['created_by'] = $data->created_by;
                        }
                    }
                }
            }
            return view('Finansial.index', compact('reports', 'years', 'year', 'datas', 'structuredData'));
        }
        
        
    //UNTUK MENAMPILAKN FORM dan ADD DATA NAMA LABA RUGI
    public function KFormLabarugi(Request $request)
    {
        $form_type = $request->input('form_type', 'kategori');
        $data= KategoriLabaRugi::all();
        return view('Finansial.FormNamaLR',compact('data','form_type'));
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
            foreach ($validatedData['sub'] as $sub) {
                if (!empty($sub)) {
                    KategoriLabaRugi::create([
                        'DescriptionName' => $sub,  
                        'parent_id' => $kategori->id,  
                        'created_by' => auth()->user()->username,
                    ]);
                }
            }
        }
    
    
        return redirect('/index')->with('success', 'Data berhasil disimpan.');
    }

    public function addSubkategori(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'kategori_id' => 'required|exists:kategori_laba_rugi,id', // Pastikan kategori ada di tabel
            'subkategori_name' => 'required|string',  // Subkategori harus berupa string
        ]);
        
        // Ambil kategori berdasarkan ID
        $kategori = KategoriLabaRugi::find($validatedData['kategori_id']);
        
        // Menyimpan subkategori yang terkait dengan kategori yang sudah ada
        KategoriLabaRugi::create([
            'DescriptionName' => $validatedData['subkategori_name'],  
            'parent_id' => $kategori->id,  
            'created_by' => auth()->user()->username,
        ]);
        
        return redirect()->back()->with('success', 'Subkategori berhasil ditambahkan.');
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
                    'values.*.PlaYtd' => 'nullable',
                    'values.*.VerticalAnalisys1' => 'nullable',
                    'values.*.VerticalAnalisys' => 'nullable',
                    'values.*.Actualytd' => 'nullable',
                    'values.*.Deviation' => 'nullable|numeric',
                    'values.*.Percentage' => 'nullable',
                    'year' => 'required|integer'
                ]); 
                $tahun = $request->year;
                // Menyimpan data input untuk setiap deskripsi
                foreach ($request->values as $descriptionId => $inputData) {
                    LabaRugi::create([
                        'Description' => $descriptionId,
                        'PlaYtd' => isset($inputData['PlaYtd']) ? $inputData['PlaYtd'] : null,
                        'Deviation' => isset($inputData['Deviation']) ? $inputData['Deviation'] : null,
                        'Actualytd' => isset($inputData['Actualytd']) ? $inputData['Actualytd'] : null,
                        'Percentage' => isset($inputData['Percentage']) ? $inputData['Percentage'] : null,
                        'VerticalAnalisys' => isset($inputData['VerticalAnalisys']) ? $inputData['VerticalAnalisys'] : null,

                        'VerticalAnalisys1' => isset($inputData['VerticalAnalisys1']) ? $inputData['VerticalAnalisys1'] : null,
                        'year' => $tahun,
                        'created_by' => auth()->user()->username, 
                    ]);
                }
            }       
            return redirect('/index')->with('success', 'Data berhasil disimpan.');
        }
    //update
    public function formupdateLabaRugi()
    {
        $datas = DB::table('laba_rugis')
        ->join('kategori_laba_rugis', 'laba_rugis.Description', '=', 'kategori_laba_rugis.id')
        ->select('laba_rugis.Description', 'laba_rugis.PlaYtd', 
        'laba_rugis.created_by', 'laba_rugis.Actualytd',
        'laba_rugis.VerticalAnalisys1',
        'laba_rugis.VerticalAnalisys',
        'laba_rugis.Deviation',
        'laba_rugis.Percentage', 
        'kategori_laba_rugis.id as category_id', 'kategori_laba_rugis.DescriptionName')
        ->get();
    
    $structuredData = [];
    // $categories = DB::table('kategori_laba_rugis')->get(); 
    $categories = DB::table('kategori_laba_rugis')
    ->join('laba_rugis', 'kategori_laba_rugis.id', '=', 'laba_rugis.Description')
    ->select(
        'laba_rugis.Description', 
        'laba_rugis.PlaYtd', 
        'laba_rugis.created_by', 
        'laba_rugis.Actualytd', 
        'laba_rugis.VerticalAnalisys1',
        'laba_rugis.VerticalAnalisys',
        'laba_rugis.Deviation',
        'laba_rugis.Percentage', 

        'kategori_laba_rugis.DescriptionName', 
        'kategori_laba_rugis.parent_id', 
        'kategori_laba_rugis.id as id'
    )
    ->get();

// dd($categories); // Debug data


    foreach ($categories as $category) {
        // dd($category);
        if ($category->parent_id === null) {
            
            $mainCounter = count(array_filter($structuredData, fn($desc) => $desc['parent_id'] === null)) + 1;
            $categoryData = [
                'id' => $category->id,
                'name' => "{$mainCounter}. {$category->DescriptionName}",
                'parent_id' => null,
                'PlaYtd' => $category->PlaYtd ?? null,  // Default ke null jika tidak ada
                'ActualYtd' => $category->ActualYtd ?? null,  // Default ke null jika tidak ada                    
                'VerticalAnalisys1' => $category->VerticalAnalisys1 ?? null,  // Default ke null jika tidak ada
                'VerticalAnalisys' => $category->VerticalAnalisys ?? null,  // Default ke null jika tidak ada                    
                'Deviation' => $category->Deviation ?? null,  // Default ke null jika tidak ada
                'Percentage' => $category->Percentage ?? null,  // Default ke null jika tidak ada       
                'created_by' => $category->created_by,             
                'subcategories' => [],
            ];
    
            foreach ($categories as $subCategory) {
                if ($subCategory->parent_id === $category->id) {

                    $categoryData['subcategories'][] = [
                        'id' => $subCategory->id,
                        'name' => "{$mainCounter}." . (count($categoryData['subcategories']) + 1) . " {$subCategory->DescriptionName}",
                        'ActualYtd' => $subCategory->ActualYtd ?? null,
                        'parent_id' => $subCategory->parent_id ?? null,  // Default ke null jika tidak ada                    

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
                $category['Actualytd'] = $data->Actualytd;
                $category['VerticalAnalisys1'] = $data->VerticalAnalisys1;
                $category['VerticalAnalisys'] = $data->VerticalAnalisys;
                $category['Deviation'] = $data->Deviation;
                $category['Percentage'] = $data->Percentage;
                $category['created_by'] = $data->created_by;


            }
            foreach ($category['subcategories'] as &$subcategory) {
                if ($subcategory['id'] == $data->category_id) {
                    $subcategory['Actualytd'] = $data->Actualytd;

                    $subcategory['created_by'] = $data->created_by;
                }
            }
        }
    }

        
        return view('Finansial.updatedata', compact('structuredData'));
    }

    //update data

    public function updateLabarugi(Request $request){
        $request->validate([
            'values.*.PlaYtd' => 'nullable',
            'values.*.VerticalAnalisys1' => 'nullable',
            'values.*.VerticalAnalisys' => 'nullable',
            'values.*.Actualytd' => 'nullable',
            'values.*.Deviation' => 'nullable|numeric',
            'values.*.Percentage' => 'nullable',
        ]);
        // dd($request->all());

        
        // Menyimpan atau memperbarui data input untuk setiap deskripsi
        foreach ($request->values as $descriptionId => $inputData) {
            // Cari data yang sudah ada berdasarkan Description dan year
            $labaRugi = LabaRugi::where('Description', $descriptionId)
                                ->first();
        
            // Jika data ditemukan, lakukan update
            if ($labaRugi) {
                $labaRugi->PlaYtd = isset($inputData['PlaYtd']) ? $inputData['PlaYtd'] : $labaRugi->PlaYtd;
                $labaRugi->Deviation = isset($inputData['Deviation']) ? $inputData['Deviation'] : $labaRugi->Deviation;
                $labaRugi->Actualytd = isset($inputData['Actualytd']) ? $inputData['Actualytd'] : $labaRugi->Actualytd;
                
                $labaRugi->Percentage = isset($inputData['Percentage']) ? $inputData['Percentage'] : $labaRugi->Percentage;
                $labaRugi->VerticalAnalisys = isset($inputData['VerticalAnalisys']) ? $inputData['VerticalAnalisys'] : $labaRugi->VerticalAnalisys;
                $labaRugi->VerticalAnalisys1 = isset($inputData['VerticalAnalisys1']) ? $inputData['VerticalAnalisys1'] : $labaRugi->VerticalAnalisys1;
        
                // Update atribut 'updated_by' dan simpan perubahan
                $labaRugi->updated_by = auth()->user()->username;
                $labaRugi->save();
            }
        }
        return redirect('/index')->with('success', 'Data berhasil disimpan.');

    }
       



}
