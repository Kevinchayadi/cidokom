<?php

use App\Http\Controllers\AfkirController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AyamController;
use App\Http\Controllers\BreedingController;
use App\Http\Controllers\CommercialController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\HatcheryController;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\PakanController;
use App\Http\Controllers\PenController;
use App\Models\Hatchery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/','/login');
Route::get('/home',function(){
    return inertia::render('Home');
});

Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'adminIndex'])->name('admin.dashboard');
    Route::get('/hatchery', [HatcheryController::class, 'adminIndex'])->name('admin.hatchery');
    Route::get('/breeding', [BreedingController::class, 'adminIndex'])->name('admin.breeding');
    Route::get('/breeding-detail/{id}', [BreedingController::class, 'getBreedingDetail']);
    Route::get('/commercial', [CommercialController::class, 'adminIndex'])->name('admin.commercial');
    Route::get('/chicken', [ayamController::class, 'adminIndex'])->name('admin.chicken');
    Route::get('/afkir', [AfkirController::class, 'adminIndex'])->name('admin.afkir');
    Route::get('/kandang', [KandangController::class, 'adminIndex'])->name('admin.kandang');
    Route::get('/pen', [PenController::class, 'adminIndex'])->name('admin.pen');
    Route::get('/pakan', [PakanController::class, 'adminIndex'])->name('admin.pakan');
    Route::get('/logout',[AuthController::class, 'logout'])->name('admin.logout');
    
});


Route::prefix('user')->middleware(['auth','isUser'])->group(function(){
    Route::get('/getegg/{id}', [HatcheryController::class, 'getegg']); 
    Route::get('/anotheregg/{id}', [HatcheryController::class, 'anotheregg']); 
    Route::get('/dashboard',[DashboardController::class, 'userIndex'])->name('user.dashboard');
    Route::get('/ayam', [AyamController::class, 'userIndex'])->name('user.ayamList');
    Route::get('/ayam/create', [AyamController::class, 'createAyam'])->name('user.ayam.create');
    Route::post('/ayam/create', [AyamController::class,'storeAyam'])->name('user.ayam.store');
    Route::get('/farm', [KandangController::class, 'userIndex'])->name('user.kandangList');
    Route::get('/farm/create', [KandangController::class, 'createKandang'])->name('user.kandang.create');
    Route::post('/farm/create', [KandangController::class,'storeKandang'])->name('user.kandang.store');
    Route::get('/pen', [PenController::class, 'userIndex'])->name('user.penList');
    Route::get('/pen/create', [PenController::class, 'createPen'])->name('user.pen.create');
    Route::post('/pen/create', [PenController::class,'storePen'])->name('user.pen.store');
    Route::get('/pen/{id}', [PenController::class, 'kandangPen'])->name('user.penList.id');
    Route::get('/breeding', [BreedingController::class, 'userIndex'])->name('user.breeding');
    Route::get('/breeding/create', [BreedingController::class, 'createBreeding'])->name('user.breeding.create');
    Route::post('/breeding/create', [BreedingController::class,'storeBreeding'])->name('user.breeding.store');
    Route::get('/breeding/input/{id}', [BreedingController::class, 'inputBreeding'])->name('user.breeding.input');
    Route::post('/breeding/input', [BreedingController::class,'inputedBreeding'])->name('user.breeding.inputed');
    Route::get('/commercial', [CommercialController::class, 'userIndex'])->name('user.commercial');
    Route::get('/commercial/create', [CommercialController::class, 'createCommercial'])->name('user.commercial.create');
    Route::post('/commercial/create', [CommercialController::class,'storeCommercial'])->name('user.commercial.store');
    Route::get('/commercial/input/{id}', [CommercialController::class, 'dailyForm'])->name('user.commercial.input');
    Route::post('/commercial/input', [CommercialController::class,'dailyStore'])->name('user.commercial.inputed');
    Route::get('/hatchery', [HatcheryController::class, 'userIndex'])->name('user.hatchery');
    Route::get('/hatchery/create', [HatcheryController::class, 'createHatchery'])->name('user.hatchery.create');
    Route::post('/hatchery/create', [HatcheryController::class,'storeHatchery'])->name('user.hatchery.store');
    Route::get('/hatchery/threeInput/{id}', [HatcheryController::class, 'threeInputHatchery'])->name('user.hatchery.threeInput');
    Route::post('/hatchery/threeInput', [HatcheryController::class,'threeInputedHatchery'])->name('user.hatchery.threeInputed');
    Route::get('/hatchery/eightynInput/{id}', [HatcheryController::class, 'eightynInputHatchery'])->name('user.hatchery.eightynInput');
    Route::post('/hatchery/eightynInput', [HatcheryController::class,'eightynInputedHatchery'])->name('user.hatchery.eightynInputed');
    Route::get('/hatchery/finalInput/{id}', [HatcheryController::class, 'finalInputHatchery'])->name('user.hatchery.finalInput');
    Route::post('/hatchery/finalInput', [HatcheryController::class,'finalInputedHatchery'])->name('user.hatchery.finalInputed');
    Route::get('/hatchery/move/{id}', [HatcheryController::class,'move'])->name('user.hatchery.finalInputed');
    Route::post('/commercial/moved', [HatcheryController::class,'move'])->name('user.hatchery.finalInputed');
    Route::get('/pakan', [PakanController::class, 'userIndex'])->name('user.pakan');
    Route::get('/afkir', [AfkirController::class, 'afkir'])->name('user.afkir');
    Route::get('/afkir/input/{id}', [AfkirController::class, 'dailyAfkirForm'])->name('user.dailyAfkirForm');
    Route::post('/afkir/input/{id}', [AfkirController::class, 'dailyAfkirForm'])->name('user.dailyAfkirForm');


    Route::get('/logout',[AuthController::class, 'logout'])->name('user.logout');
});


    Route::get('/uploadbreeding', [ExcelController::class, 'breedingupload'])->name('breeding.upload');;
    Route::get('/uploadcommercial', [ExcelController::class,'commercialupload'])->name('commercial.upload');
    Route::post('/uploadbreeding', [ExcelController::class, 'breedingstore'])->name('breeding.store');;
    Route::post('/uploadcommercial', [ExcelController::class,'commercialstore'])->name('commercial.store');


Route::middleware('isGuest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginIndex'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login')->name('storelogin');
    Route::get('/register', [AuthController::class,'registerIndex'])->name('registerForm');
    Route::post('/register', [AuthController::class,'register'])->name('register');

});