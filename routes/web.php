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
use App\Http\Controllers\finansialPerspektifController;
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

//mining
Route::get('/indexmining', [MiningReadinessController::class, 'indexmining'])->middleware('auth')->name('indexmining');
Route::get('/FormKategori', [MiningReadinessController::class, 'FormKategori'])->middleware('auth')->name('FormKategori');
Route::post('/createKatgori', [MiningReadinessController::class, 'createKatgori'])->middleware('auth')->name('createKatgori');
Route::get('/FormMining', [MiningReadinessController::class, 'FormMining'])->middleware('auth')->name('FormMining');
Route::post('/CreateMining', [MiningReadinessController::class, 'CreateMining'])->middleware('auth')->name('CreateMining');

Route::get('/FormMiningUpdate/{id}', [MiningReadinessController::class, 'FormMiningUpdate'])->middleware('auth')->name('FormMiningUpdate');
Route::post('/UpdateMining/{id}', [MiningReadinessController::class, 'UpdateMining'])->middleware('auth')->name('UpdateMining');



//pembebasan lahan
Route::get('/indexPembebasanLahan', [PembebasanLahanController::class, 'indexPembebasanLahan'])->middleware('auth')->name('indexPembebasanLahan');
Route::get('/formlahan', [PembebasanLahanController::class, 'formlahan'])->middleware('auth')->name('formlahan');
Route::get('/formUpdatelahan/{id}', [PembebasanLahanController::class, 'formUpdatelahan'])->middleware('auth')->name('formUpdatelahan');
Route::post('/createPembebasanLahan', [PembebasanLahanController::class, 'createPembebasanLahan'])->middleware('auth')->name('createPembebasanLahan');
Route::post('/updatePembebasanLahan/{id}', [PembebasanLahanController::class, 'updatePembebasanLahan'])->middleware('auth')->name('updatePembebasanLahan');

//InfrastructureReadiness
Route::get('/indexInfrastructureReadiness', [InfrastructureReadinessController::class, 'indexInfrastructureReadiness'])->middleware('auth')->name('indexInfrastructureReadiness');
Route::get('/formupdateInfrastructureReadiness/{id}', [InfrastructureReadinessController::class, 'formupdateInfrastructureReadiness'])->middleware('auth')->name('formupdateInfrastructureReadiness');
Route::get('/fromadd', [InfrastructureReadinessController::class, 'fromadd'])->middleware('auth')->name('fromadd');
Route::post('/updateInfrastructureReadiness/{id}', [InfrastructureReadinessController::class, 'updateInfrastructureReadiness'])->middleware('auth')->name('updateInfrastructureReadiness');
Route::post('/createInfrastructureReadiness', [InfrastructureReadinessController::class, 'createInfrastructureReadiness'])->middleware('auth')->name('createInfrastructureReadiness');

//deadline
Route::get('/indexdeadline', [DeadlineCompensationController::class, 'indexdeadline'])->middleware('auth')->name('indexdeadline');
Route::get('/formaddMR', [DeadlineCompensationController::class, 'formaddMR'])->middleware('auth')->name('formaddMR');
Route::get('/formupdateDeadlineCompen/{id}', [DeadlineCompensationController::class, 'formupdateDeadlineCompen'])->middleware('auth')->name('formupdateDeadlineCompen');
Route::post('/createupdate', [DeadlineCompensationController::class, 'createupdate'])->middleware('auth')->name('createupdate');
Route::post('/createdeadline', [DeadlineCompensationController::class, 'createdeadline'])->middleware('auth')->name('createdeadline');
Route::post('/updatedeadline/{id}', [DeadlineCompensationController::class, 'updatedeadline'])->middleware('auth')->name('updatedeadline');



//cs perspektif
//barging
Route::get('/indexbarging', [BargingController::class, 'indexbarging'])->middleware('auth')->name('indexbarging');
Route::get('/formbarging', [BargingController::class, 'formbarging'])->middleware('auth')->name('formbarging');
Route::get('/updatebarging/{id}', [BargingController::class, 'updatebarging'])->middleware('auth')->name('updatebarging');
Route::post('/createbarging', [BargingController::class, 'createbarging'])->middleware('auth')->name('createbarging');
Route::post('/updatedatabarging/{id}', [BargingController::class, 'updatedatabarging'])->middleware('auth')->name('updatedatabarging');

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
// 1 laa rugi
Route::get('/index', [finansialPerspektifController::class, 'index'])->middleware('auth')->name('index');
Route::get('/KFormLabarugi', [finansialPerspektifController::class, 'KFormLabarugi'])->middleware('auth')->name('KFormLabarugi');
Route::post('/createDeskripsi', [finansialPerspektifController::class, 'createDeskripsi'])->middleware('auth')->name('createDeskripsi');
Route::get('/formLabaRugi', [finansialPerspektifController::class, 'formLabaRugi'])->middleware('auth')->name('formLabaRugi');
Route::post('/createLabrugi', [finansialPerspektifController::class, 'createLabarugi'])->middleware('auth')->name('createLabarugi');

//neraca
Route::get('/indexneraca', [NeracaController::class, 'indexneraca'])->middleware('auth')->name('indexneraca');
Route::get('/kategorineraca', [NeracaController::class, 'kategorineraca'])->middleware('auth')->name('kategorineraca');
Route::post('/createkategorineraca', [NeracaController::class, 'createkategorineraca'])->middleware('auth')->name('createkategorineraca');
Route::get('/neraca', [NeracaController::class, 'neraca'])->middleware('auth')->name('neraca');
Route::post('/createneraca', [NeracaController::class, 'createneraca'])->middleware('auth')->name('createneraca');

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


//perusahaan PerusahaanController
Route::get('/indexpt', [PerusahaanController::class, 'indexpt'])->middleware('auth')->name('indexpt');
Route::get('/perusahaan', [PerusahaanController::class, 'perusahaan'])->middleware('auth')->name('perusahaan');
Route::post('/createperusahaan', [PerusahaanController::class, 'createperusahaan'])->middleware('auth')->name('createperusahaan');
Route::get('/iup', [PerusahaanController::class, 'iup'])->middleware('auth')->name('iup');
Route::get('/kontraktor', [PerusahaanController::class, 'kontraktor'])->middleware('auth')->name('kontraktor');
Route::get('/mineral', [PerusahaanController::class, 'mineral'])->middleware('auth')->name('mineral');
Route::get('/nonenergi', [PerusahaanController::class, 'nonenergi'])->middleware('auth')->name('nonenergi');
Route::get('/dummy', [PerusahaanController::class, 'dummy'])->middleware('auth')->name('dummy');
