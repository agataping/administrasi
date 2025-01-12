<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\PeopleReadinessController;
use App\Http\Controllers\kadisController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisteredUserController as ControllersRegisteredUserController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\PembebasanLahanController;
use App\Http\Controllers\MiningReadinessController;
use App\Http\Controllers\InfrastructureReadinessController;
use App\Http\Controllers\DeadlineCompensationController;
use App\Http\Controllers\BargingController;
use App\Http\Controllers\CsMiningReadinessController;
use App\Http\Controllers\DeadlineCompentsationCsController;
use App\Http\Controllers\NeracaController;
use App\Http\Controllers\HPPController;
use App\Http\Controllers\CSMothnlyProductionController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\PembebasanLahanCsController;
use App\Http\Controllers\HseController;
use App\Http\Controllers\OverberdenCoalController;
use App\Http\Controllers\DetailabarugiController;
use App\Http\Controllers\StockJtController;
use App\Http\Controllers\DetailNeracaController;



use App\Http\Controllers\UserController as ControllersUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//regitrasi akun
Route::post('/daftar', [RegistrasiController::class, 'store']);
Route::get('/register', [RegistrasiController::class, 'register'])->name('register');

// login
Route::get('/login',[LoginController::class,'create'])->name('login');
Route::post('/signin', [loginController::class, 'authentication'])->middleware('guest');
Route::post('/logout', [loginController::class, 'logout'])->middleware('auth');

Route::get('/dashboard', [DetailIsiSuratController::class, 'dashboard'])->middleware('auth')->name('dashboard');

//learning
//People Readiness 
Route::get('/dashboard', [PeopleReadinessController::class, 'dashboard'])->middleware('auth')->name('dashboard');
Route::get('/indexPeople', [PeopleReadinessController::class, 'indexPeople'])->middleware('auth')->name('indexPeople');
Route::get('/formPR', [PeopleReadinessController::class, 'formPR'])->middleware('auth')->name('formPR');
Route::get('/formupdate/{id}', [PeopleReadinessController::class, 'formupdate'])->middleware('auth')->name('formupdate');
Route::post('/createDataPR', [PeopleReadinessController::class, 'createDataPR'])->middleware('auth')->name('createDataPR');
Route::post('/updatedata/{id}', [PeopleReadinessController::class, 'updatedata'])->middleware('auth')->name('updatedata');
//pica
Route::get('/indexpicapeople', [PeopleReadinessController::class, 'indexpicapeople'])->middleware('auth')->name('indexpicapeople');
Route::get('/formpicapeople', [PeopleReadinessController::class, 'formpicapeople'])->middleware('auth')->name('formpicapeople');
Route::get('/formupdatepicapeople/{id}', [PeopleReadinessController::class, 'formupdatepicapeople'])->middleware('auth')->name('formupdatepicapeople');
Route::post('/createpicapeople', [PeopleReadinessController::class, 'createpicapeople'])->middleware('auth')->name('createpicapeople');
Route::post('/updatepicapeople/{id}', [PeopleReadinessController::class, 'updatepicapeople'])->middleware('auth')->name('updatepicapeople');
//
Route::get('/struktur', [PeopleReadinessController::class, 'struktur'])->middleware('auth')->name('struktur');
Route::get('/formbagan', [PeopleReadinessController::class, 'formbagan'])->middleware('auth')->name('formbagan');
Route::post('/createbagan', [PeopleReadinessController::class, 'createbagan'])->middleware('auth')->name('createbagan');



//mining
Route::get('/indexmining', [MiningReadinessController::class, 'indexmining'])->middleware('auth')->name('indexmining');
Route::get('/FormKategori', [MiningReadinessController::class, 'FormKategori'])->middleware('auth')->name('FormKategori');
Route::post('/createKatgori', [MiningReadinessController::class, 'createKatgori'])->middleware('auth')->name('createKatgori');
Route::get('/FormMining', [MiningReadinessController::class, 'FormMining'])->middleware('auth')->name('FormMining');
Route::post('/CreateMining', [MiningReadinessController::class, 'CreateMining'])->middleware('auth')->name('CreateMining');
Route::get('/FormMiningUpdate/{id}', [MiningReadinessController::class, 'FormMiningUpdate'])->middleware('auth')->name('FormMiningUpdate');
Route::post('/UpdateMining/{id}', [MiningReadinessController::class, 'UpdateMining'])->middleware('auth')->name('UpdateMining');
//picamining
Route::get('/picamining', [MiningReadinessController::class, 'picamining'])->middleware('auth')->name('picamining');
Route::get('/formpicamining', [MiningReadinessController::class, 'formpicamining'])->middleware('auth')->name('formpicamining');
Route::post('/createpicamining', [MiningReadinessController::class, 'createpicamining'])->middleware('auth')->name('createpicamining');
Route::post('/CreateMining', [MiningReadinessController::class, 'CreateMining'])->middleware('auth')->name('CreateMining');
Route::get('/formupdatepicamining/{id}', [MiningReadinessController::class, 'formupdatepicamining'])->middleware('auth')->name('formupdatepicamining');
Route::post('/updatepicamining/{id}', [MiningReadinessController::class, 'updatepicamining'])->middleware('auth')->name('updatepicamining');


//hse
Route::get('/indexhse', [HseController::class, 'indexhse'])->middleware('auth')->name('indexhse');
Route::get('/formhse', [HseController::class, 'formhse'])->middleware('auth')->name('formhse');
Route::post('/createhse', [HseController::class, 'createhse'])->middleware('auth')->name('createhse');
Route::get('/formupdatehse/{id}', [HseController::class, 'formupdatehse'])->middleware('auth')->name('formupdatehse');
Route::post('/updatehse/{id}', [HseController::class, 'updatehse'])->middleware('auth')->name('updatehse');
//kategorihse
Route::get('/formkategorihse', [HseController::class, 'formkategorihse'])->middleware('auth')->name('formkategorihse');
Route::post('/createkategorihse', [HseController::class, 'createkategorihse'])->middleware('auth')->name('createkategorihse');
//picahse
Route::get('/picahse', [HseController::class, 'picahse'])->middleware('auth')->name('picahse');
Route::get('/formpicahse', [HseController::class, 'formpicahse'])->middleware('auth')->name('formpicahse');
Route::post('/createpicahse', [HseController::class, 'createpicahse'])->middleware('auth')->name('createpicahse');
Route::get('/formupdatepicahse/{id}', [HseController::class, 'formupdatepicahse'])->middleware('auth')->name('formupdatepicahse');
Route::post('/updatepicahse/{id}', [HseController::class, 'updatepicahse'])->middleware('auth')->name('updatepicahse');


//pembebasan lahan
Route::get('/indexPembebasanLahan', [PembebasanLahanController::class, 'indexPembebasanLahan'])->middleware('auth')->name('indexPembebasanLahan');
Route::get('/formlahan', [PembebasanLahanController::class, 'formlahan'])->middleware('auth')->name('formlahan');
Route::get('/formUpdatelahan/{id}', [PembebasanLahanController::class, 'formUpdatelahan'])->middleware('auth')->name('formUpdatelahan');
Route::post('/createPembebasanLahan', [PembebasanLahanController::class, 'createPembebasanLahan'])->middleware('auth')->name('createPembebasanLahan');
Route::post('/updatePembebasanLahan/{id}', [PembebasanLahanController::class, 'updatePembebasanLahan'])->middleware('auth')->name('updatePembebasanLahan');

//PICApembebasan lahan
Route::get('/picapl', [PembebasanLahanController::class, 'picapl'])->middleware('auth')->name('picapl');
Route::get('/formpicapl', [PembebasanLahanController::class, 'formpicapl'])->middleware('auth')->name('formpicapl');
Route::get('/formupdatepicapl/{id}', [PembebasanLahanController::class, 'formupdatepicapl'])->middleware('auth')->name('formupdatepicapl');
Route::post('/createpicapl', [PembebasanLahanController::class, 'createpicapl'])->middleware('auth')->name('createpicapl');
Route::post('/updatepicapl/{id}', [PembebasanLahanController::class, 'updatepicapl'])->middleware('auth')->name('updatepicapl');


//InfrastructureReadiness
Route::get('/indexInfrastructureReadiness', [InfrastructureReadinessController::class, 'indexInfrastructureReadiness'])->middleware('auth')->name('indexInfrastructureReadiness');
Route::get('/formupdateInfrastructureReadiness/{id}', [InfrastructureReadinessController::class, 'formupdateInfrastructureReadiness'])->middleware('auth')->name('formupdateInfrastructureReadiness');
Route::get('/fromadd', [InfrastructureReadinessController::class, 'fromadd'])->middleware('auth')->name('fromadd');
Route::post('/updateInfrastructureReadiness/{id}', [InfrastructureReadinessController::class, 'updateInfrastructureReadiness'])->middleware('auth')->name('updateInfrastructureReadiness');
Route::post('/createInfrastructureReadiness', [InfrastructureReadinessController::class, 'createInfrastructureReadiness'])->middleware('auth')->name('createInfrastructureReadiness');
//picainfra
Route::get('/picainfrastruktur', [InfrastructureReadinessController::class, 'picainfrastruktur'])->middleware('auth')->name('picainfrastruktur');
Route::get('/formupdatepicainfra/{id}', [InfrastructureReadinessController::class, 'formupdatepicainfra'])->middleware('auth')->name('formupdatepicainfra');
Route::get('/formpicainfra', [InfrastructureReadinessController::class, 'formpicainfra'])->middleware('auth')->name('formpicainfra');
Route::post('/updatepicainfra/{id}', [InfrastructureReadinessController::class, 'updatepicainfra'])->middleware('auth')->name('updatepicainfra');
Route::post('/createpicainfra', [InfrastructureReadinessController::class, 'createpicainfra'])->middleware('auth')->name('createpicainfra');

//deadline
Route::get('/indexdeadline', [DeadlineCompensationController::class, 'indexdeadline'])->middleware('auth')->name('indexdeadline');
Route::get('/formaddMR', [DeadlineCompensationController::class, 'formaddMR'])->middleware('auth')->name('formaddMR');
Route::get('/formupdateDeadlineCompen/{id}', [DeadlineCompensationController::class, 'formupdateDeadlineCompen'])->middleware('auth')->name('formupdateDeadlineCompen');
Route::post('/createupdate', [DeadlineCompensationController::class, 'createupdate'])->middleware('auth')->name('createupdate');
Route::post('/createdeadline', [DeadlineCompensationController::class, 'createdeadline'])->middleware('auth')->name('createdeadline');
Route::post('/updatedeadline/{id}', [DeadlineCompensationController::class, 'updatedeadline'])->middleware('auth')->name('updatedeadline');

Route::get('/picadeadline', [DeadlineCompensationController::class, 'picadeadline'])->middleware('auth')->name('picadeadline');
Route::get('/formpicadeadline', [DeadlineCompensationController::class, 'formpicadeadline'])->middleware('auth')->name('formpicadeadline');
Route::get('/formupdatepicadeadline/{id}', [DeadlineCompensationController::class, 'formupdatepicadeadline'])->middleware('auth')->name('formupdatepicadeadline');
Route::post('/createpicadeadline', [DeadlineCompensationController::class, 'createpicadeadline'])->middleware('auth')->name('createpicadeadline');
Route::post('/updatepicadealine/{id}', [DeadlineCompensationController::class, 'updatepicadealine'])->middleware('auth')->name('updatepicadealine');




//cs perspektif
//barging
Route::get('/indexbarging', [BargingController::class, 'indexbarging'])->middleware('auth')->name('indexbarging');
Route::get('/formbarging', [BargingController::class, 'formbarging'])->middleware('auth')->name('formbarging');
Route::get('/updatebarging/{id}', [BargingController::class, 'updatebarging'])->middleware('auth')->name('updatebarging');
Route::post('/createbarging', [BargingController::class, 'createbarging'])->middleware('auth')->name('createbarging');
Route::post('/updatedatabarging/{id}', [BargingController::class, 'updatedatabarging'])->middleware('auth')->name('updatedatabarging');
//picabarging
Route::get('/indexpicabarging', [BargingController::class, 'indexpicabarging'])->middleware('auth')->name('indexpicabarging');
Route::get('/formpicabarging', [BargingController::class, 'formpicabarging'])->middleware('auth')->name('formpicabarging');
Route::get('/updatepicabarging/{id}', [BargingController::class, 'updatepicabarging'])->middleware('auth')->name('updatepicabarging');
Route::post('/createpicabarging', [BargingController::class, 'createpicabarging'])->middleware('auth')->name('createpicabarging');
Route::post('/updatedatapicabarging/{id}', [BargingController::class, 'updatedatapicabarging'])->middleware('auth')->name('updatedatapicabarging');
//plan bargings
Route::get('/indexPlan', [BargingController::class, 'indexPlan'])->middleware('auth')->name('indexPlan');
Route::post('/updatePlan', [BargingController::class, 'updatePlan'])->middleware('auth')->name('updatePlan');

//stock jt
Route::get('/stockjt', [StockJtController::class, 'stockjt'])->middleware('auth')->name('stockjt');
Route::get('/formstockjt', [StockJtController::class, 'formstockjt'])->middleware('auth')->name('formstockjt');
Route::get('/formupdatestockjt/{id}', [StockJtController::class, 'formupdatestockjt'])->middleware('auth')->name('formupdatestockjt');
Route::post('/createstockjt', [StockJtController::class, 'createstockjt'])->middleware('auth')->name('createstockjt');
Route::post('/updatestockjt/{id}', [StockJtController::class, 'updatestockjt'])->middleware('auth')->name('updatestockjt');

//pica
Route::get('/picastockjt', [StockJtController::class, 'picastockjt'])->middleware('auth')->name('picastockjt');
Route::get('/formpicasjt', [StockJtController::class, 'formpicasjt'])->middleware('auth')->name('formpicasjt');
Route::get('/formupdatesjt/{id}', [StockJtController::class, 'formupdatesjt'])->middleware('auth')->name('formupdatesjt');
Route::post('/createsjt', [StockJtController::class, 'createsjt'])->middleware('auth')->name('createsjt');
Route::post('/updatesjt/{id}', [StockJtController::class, 'updatesjt'])->middleware('auth')->name('updatesjt');

//deadlineindexdeadlineCs
Route::get('/indexdeadlineCostumers', [DeadlineCompentsationCsController::class, 'indexdeadlineCostumers'])->middleware('auth')->name('indexdeadlineCostumers');
Route::get('/formupdateDeadlineCs/{id}', [DeadlineCompentsationCsController::class, 'formupdateDeadlineCs'])->middleware('auth')->name('formupdateDeadlineCs');
Route::post('/createdeadlineCs', [DeadlineCompentsationCsController::class, 'createdeadlineCs'])->middleware('auth')->name('createdeadlineCs');
Route::get('/formDeadlineCs', [DeadlineCompentsationCsController::class, 'formDeadlineCs'])->middleware('auth')->name('formDeadlineCs');
Route::post('/updatedeadlineCs/{id}', [DeadlineCompentsationCsController::class, 'updatedeadlineCs'])->middleware('auth')->name('updatedeadlineCs');
//M production
Route::get('/indexmproduction', [CSMothnlyProductionController::class, 'indexmproduction'])->middleware('auth')->name('indexmproduction');
Route::get('/formMProduksi', [CSMothnlyProductionController::class, 'formMProduksi'])->middleware('auth')->name('formMProduksi');
Route::get('/formUpdateMProduksi/{id}', [CSMothnlyProductionController::class, 'formUpdateMProduksi'])->middleware('auth')->name('formUpdateMProduksi');
Route::post('/createMproduksi', [CSMothnlyProductionController::class, 'createMproduksi'])->middleware('auth')->name('createMproduksi');
Route::post('/updateMproduksi/{id}', [CSMothnlyProductionController::class, 'updateMproduksi'])->middleware('auth')->name('updateMproduksi');

//mining cs
Route::get('/indexCSmining', [CsMiningReadinessController::class, 'indexCSmining'])->middleware('auth')->name('indexCSmining');
Route::get('/FormKategoriCsMining', [CsMiningReadinessController::class, 'FormKategoriCsMining'])->middleware('auth')->name('FormKategoriCsMining');
Route::post('/createKatgoriCsMining', [CsMiningReadinessController::class, 'createKatgoriCsMining'])->middleware('auth')->name('createKatgoriCsMining');
Route::get('/FormCsMining', [CsMiningReadinessController::class, 'FormCsMining'])->middleware('auth')->name('FormCsMining');
Route::post('/CreateCsMining', [CsMiningReadinessController::class, 'CreateCsMining'])->middleware('auth')->name('CreateCsMining');
Route::get('/FormCsupdateMining/{id}', [CsMiningReadinessController::class, 'FormCsupdateMining'])->middleware('auth')->name('FormCsupdateMining');
Route::post('/updateCsMining/{id}', [CsMiningReadinessController::class, 'updateCsMining'])->middleware('auth')->name('updateCsMining');

//pembebasan lahan cs
Route::get('/indexPembebasanLahanCs', [PembebasanLahanCsController::class, 'indexPembebasanLahanCs'])->middleware('auth')->name('indexPembebasanLahanCs');
Route::get('/formlahanCs', [PembebasanLahanCsController::class, 'formlahanCs'])->middleware('auth')->name('formlahan');
Route::get('/formUpdatelahanCs/{id}', [PembebasanLahanCsController::class, 'formUpdatelahanCs'])->middleware('auth')->name('formUpdatelahanCs');
Route::post('/createPembebasanLahanCs', [PembebasanLahanCsController::class, 'createPembebasanLahanCs'])->middleware('auth')->name('createPembebasanLahanCs');
Route::post('/updatePembebasanLahanCs/{id}', [PembebasanLahanCsController::class, 'updatePembebasanLahanCs'])->middleware('auth')->name('updatePembebasanLahanCs');



//finansial persepektif
//detail
Route::get('/labarugi', [DetailabarugiController::class, 'labarugi'])->middleware('auth')->name('labarugi');
Route::get('/formlabarugi', [DetailabarugiController::class, 'formlabarugi'])->middleware('auth')->name('formlabarugi');
Route::get('/formupdatelabarugi/{id}', [DetailabarugiController::class, 'formupdatelabarugi'])->middleware('auth')->name('formupdatelabarugi');
Route::post('/updatelabarugi/{id}', [DetailabarugiController::class, 'updatelabarugi'])->middleware('auth')->name('updatelabarugi');
Route::post('/createlabarugi', [DetailabarugiController::class, 'createlabarugi'])->middleware('auth')->name('createlabarugi');
//category
Route::get('/categorylabarugi', [DetailabarugiController::class, 'categorylabarugi'])->middleware('auth')->name('categorylabarugi');
Route::post('/createkatlabarugi', [DetailabarugiController::class, 'createkatlabarugi'])->middleware('auth')->name('createkatlabarugi');
//sub
Route::get('/sublr', [DetailabarugiController::class, 'sublr'])->middleware('auth')->name('sublr');
Route::post('/createsub', [DetailabarugiController::class, 'createsub'])->middleware('auth')->name('createsub');
//pica
Route::get('/picalr', [DetailabarugiController::class, 'picalr'])->middleware('auth')->name('picalr');
Route::get('/formpicalr', [DetailabarugiController::class, 'formpicalr'])->middleware('auth')->name('formpicalr');
Route::get('/formupdatepicalr/{id}', [DetailabarugiController::class, 'formupdatepicalr'])->middleware('auth')->name('formupdatepicalr');
Route::post('/createpicalr', [DetailabarugiController::class, 'createpicalr'])->middleware('auth')->name('createpicalr');
Route::post('/updatepicalr/{id}', [DetailabarugiController::class, 'updatepicalr'])->middleware('auth')->name('updatepicalr');

//neraca
Route::get('/indexfinancial', [DetailNeracaController::class, 'indexfinancial'])->middleware('auth')->name('indexfinancial');
Route::get('/formfinanc', [DetailNeracaController::class, 'formfinanc'])->middleware('auth')->name('formfinanc');
Route::get('/formupdatefinanc/{id}', [DetailNeracaController::class, 'formupdatefinanc'])->middleware('auth')->name('formupdatefinanc');
Route::post('/createfinanc', [DetailNeracaController::class, 'createfinanc'])->middleware('auth')->name('createfinanc');
Route::post ('/updatefiananc/{id}', [DetailNeracaController::class, 'updatefiananc'])->middleware('auth')->name('updatefiananc');
//category
Route::get('/categoryneraca', [DetailNeracaController::class, 'categoryneraca'])->middleware('auth')->name('categoryneraca');
Route::post('/createcategoryneraca', [DetailNeracaController::class, 'createcategoryneraca'])->middleware('auth')->name('createcategoryneraca');
//sub
Route::get('/subneraca', [DetailNeracaController::class, 'subneraca'])->middleware('auth')->name('subneraca');
Route::post('/createsubneraca', [DetailNeracaController::class, 'createsubneraca'])->middleware('auth')->name('createsubneraca');


//hpp 
Route::get('/indexhpp', [HPPController::class, 'indexhpp'])->middleware('auth')->name('indexhpp');
Route::get('/hpp', [HPPController::class, 'hpp'])->middleware('auth')->name('hpp');
Route::post('/addhpp', [HPPController::class, 'addhpp'])->middleware('auth')->name('addhpp');


//internal P
//1. pa ua
Route::get('/indexpaua', [ProduksiController::class, 'indexpaua'])->middleware('auth')->name('indexpaua');
Route::get('/unit', [ProduksiController::class, 'unit'])->middleware('auth')->name('unit');
Route::post('/createunit', [ProduksiController::class, 'createunit'])->middleware('auth')->name('createunit');
Route::get('/produksi', [ProduksiController::class, 'produksi'])->middleware('auth')->name('produksi');
Route::post('/createproduksi', [ProduksiController::class, 'createproduksi'])->middleware('auth')->name('createproduksi');
Route::get('/formupdateProduksi/{id}', [ProduksiController::class, 'formupdateProduksi'])->middleware('auth')->name('formupdateProduksi');
Route::post('/updateproduksi/{id}', [ProduksiController::class, 'updateproduksi'])->middleware('auth')->name('updateproduksi');
//pica pa ua
Route::get('/picapaua', [ProduksiController::class, 'picapaua'])->middleware('auth')->name('picapaua');
Route::post('/createpicapaua', [ProduksiController::class, 'createpicapaua'])->middleware('auth')->name('createpicapaua');
Route::get('/formpicapaua', [ProduksiController::class, 'formpicapaua'])->middleware('auth')->name('formpicapaua');
Route::get('/formupdatepicapaua/{id}', [ProduksiController::class, 'formupdatepicapaua'])->middleware('auth')->name('formupdatepicapaua');
Route::post('/updatepicapaua/{id}', [ProduksiController::class, 'updatepicapaua'])->middleware('auth')->name('updatepicapaua');
//ob coal
Route::get('/indexovercoal', [OverberdenCoalController::class, 'indexovercoal'])->middleware('auth')->name('indexovercoal');
Route::get('/formovercoal', [OverberdenCoalController::class, 'formovercoal'])->middleware('auth')->name('formovercoal');
Route::post('/createovercoal', [OverberdenCoalController::class, 'createovercoal'])->middleware('auth')->name('createovercoal');
Route::get('/formupdateovercoal/{id}', [OverberdenCoalController::class, 'formupdateovercoal'])->middleware('auth')->name('formupdateovercoal');
Route::post('/updateovercoal/{id}', [OverberdenCoalController::class, 'updateovercoal'])->middleware('auth')->name('updateovercoal');
//kategori
Route::get('/formkategoriobc', [OverberdenCoalController::class, 'formkategoriobc'])->middleware('auth')->name('formkategoriobc');
Route::post('/createkatgeoriobc', [OverberdenCoalController::class, 'createkatgeoriobc'])->middleware('auth')->name('createkatgeoriobc');
//pica
Route::get('/picaobc', [OverberdenCoalController::class, 'picaobc'])->middleware('auth')->name('picaobc');
Route::get('/formpicaobc', [OverberdenCoalController::class, 'formpicaobc'])->middleware('auth')->name('formpicaobc');
Route::post('/createpicaobc', [OverberdenCoalController::class, 'createpicaobc'])->middleware('auth')->name('createpicaobc');
Route::get('/formupdatepicaobc/{id}', [OverberdenCoalController::class, 'formupdatepicaobc'])->middleware('auth')->name('formupdatepicaobc');
Route::post('/updatepicaobc/{id}', [OverberdenCoalController::class, 'updatepicaobc'])->middleware('auth')->name('updatepicaobc');



//perusahaan PerusahaanController
Route::get('/indexpt', [PerusahaanController::class, 'indexpt'])->middleware('auth')->name('indexpt');
Route::get('/perusahaan', [PerusahaanController::class, 'perusahaan'])->middleware('auth')->name('perusahaan');
Route::post('/createperusahaan', [PerusahaanController::class, 'createperusahaan'])->middleware('auth')->name('createperusahaan');
Route::get('/iup', [PerusahaanController::class, 'iup'])->middleware('auth')->name('iup');
Route::get('/kontraktor', [PerusahaanController::class, 'kontraktor'])->middleware('auth')->name('kontraktor');
Route::get('/mineral', [PerusahaanController::class, 'mineral'])->middleware('auth')->name('mineral');
Route::get('/nonenergi', [PerusahaanController::class, 'nonenergi'])->middleware('auth')->name('nonenergi');
Route::get('/dummy', [PerusahaanController::class, 'dummy'])->middleware('auth')->name('dummy');
