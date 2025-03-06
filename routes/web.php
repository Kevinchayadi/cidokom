<?php

use App\Http\Controllers\AfkirController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AyamController;
use App\Http\Controllers\BreedingController;
use App\Http\Controllers\ChickenSizeController;
use App\Http\Controllers\CommercialController;
use App\Http\Controllers\CustHandleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\HatcheryController;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\PakanController;
use App\Http\Controllers\PenController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\VaksinController;
use App\Models\CustHandle;
use App\Models\Hatchery;
use App\Models\Machine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::redirect('/','/login');
Route::get('/home',function(){
    return inertia::render('Home');
});
Route::prefix('download')->middleware(['auth','isAdmin'])->group(function(){
    Route::get('/pakan', [ExcelController::class, 'exportPakanExcel']);
    Route::get('/breeding/{id}', [ExcelController::class, 'exportBreedingExcel']);
    Route::get('/hatchery/{id}', [ExcelController::class, 'exportHatcheryExcel']);
    Route::get('/commercial/{id}', [ExcelController::class, 'exportCommercialExcel']);
    Route::get('/afkir', [ExcelController::class, 'exportAfkirExcel']);
    Route::get('/breeding-Quaratine', [ExcelController::class, 'exportBreedingQuaratineExcel']);
    Route::get('/commercial-Quaratine', [ExcelController::class, 'exportCommercialQuaratineExcel']);
    Route::get('/kandang', [ExcelController::class, 'exportKandangExcel']);
    Route::get('/chicken', [ExcelController::class, 'exportChickenExcel']);
    Route::get('/pen', [ExcelController::class, 'exportPenExcel']);
    Route::get('/vaksin', [ExcelController::class, 'exportVaksinExcel']);
    Route::get('/vaksinSchedule', [ExcelController::class, 'exportVaksinScheduleExcel']);
    Route::get('/admin', [ExcelController::class, 'exportAdminExcel']);
    Route::get('/machine', [ExcelController::class, 'exportMachineExcel']);


});

Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function(){
    Route::middleware(['isAnalyst'])->group(function(){
        Route::get('/dashboard', [DashboardController::class, 'adminIndex'])->name('admin.dashboard');
        Route::get('/hatchery', [HatcheryController::class, 'adminIndex'])->name('admin.hatchery');
        Route::get('/breeding', [BreedingController::class, 'adminIndex'])->name('admin.breeding');
        Route::get('/breeding-detail/{id}', [BreedingController::class, 'getBreedingDetail']);
        Route::get('/commercial', [CommercialController::class, 'adminIndex'])->name('admin.commercial');
        Route::get('/chicken', [ayamController::class, 'adminIndex'])->name('admin.chicken');
        Route::get('/afkir', [AfkirController::class, 'adminIndex'])->name('admin.afkir');
        Route::get('/breeding-Quaratine', [AfkirController::class, 'adminIndex2'])->name('admin.breeding.karantina');
        Route::get('/commercial-Quaratine', [AfkirController::class, 'adminIndex3'])->name('admin.commercial.karantina');
        Route::get('/summary', [DashboardController::class, 'summary'])->name('admin.sumary');
    });

    Route::middleware(['isSeller'])->group(function(){
        
        Route::get('/sales', [SaleController::class, 'salesIndex'])->name('admin.sales');
        Route::post('/createsales', [SaleController::class, 'storeSales'])->name('admin.sales.create');
        Route::put('/editSales/{id}', [SaleController::class, 'editSales'])->name('admin.sales.create');
    
        Route::get('/Residence', [ResidentController::class, 'ResidentIndex'])->name('admin.Residence');
        Route::post('/createResidence', [ResidentController::class, 'storeResident'])->name('admin.Residence.create');
        Route::put('/editResidence/{id}', [ResidentController::class, 'editResident'])->name('admin.Residence.create');
    
        Route::get('/CustHandle', [CustHandleController::class, 'SalesIndex'])->name('admin.CustHandle');
        Route::post('/createCustHandle', [CustHandleController::class, 'storeSales'])->name('admin.CustHandle.create');
        Route::put('/editCustHandle/{id}', [CustHandleController::class, 'editSales'])->name('admin.CustHandle.create');
    
        Route::get('/Customer', [CustomerController::class, 'CustomerIndex'])->name('admin.Customer');
        Route::post('/createCustomer', [CustomerController::class, 'storeCustomer'])->name('admin.Customer.create');
        Route::put('/editCustomer/{id}', [CustomerController::class, 'editCustomer'])->name('admin.Customer.create');
        
        Route::get('/ChickenSize', [ChickenSizeController::class, 'ChickenIndex'])->name('admin.ChickenSize');
        Route::post('/createChickenSize', [ChickenSizeController::class, 'storeChicken'])->name('admin.ChickenSize.create');
        Route::put('/editChickenSize/{id}', [ChickenSizeController::class, 'editChicken'])->name('admin.ChickenSize.create');

        Route::get('/Sales-Summary',[DashboardController::class, 'salesSummary'])->name('admin.salesSummary');
    });

    Route::get('/kandang', [KandangController::class, 'adminIndex'])->name('admin.kandang');
    Route::get('/pen', [PenController::class, 'adminIndex'])->name('admin.pen');
    Route::get('/Admin', [AuthController::class, 'adminIndex'])->name('admin.Admin');
    Route::get('/pakan', [PakanController::class, 'adminIndex'])->name('admin.pakan');
    Route::get('/vaksin', [VaksinController::class, 'adminIndex'])->name('admin.vaksin');
    Route::get('/vaksinSchedule', [VaksinController::class, 'adminIndex2'])->name('admin.vaksin.schedule');
    Route::get('/logout',[AuthController::class, 'logout'])->name('admin.logout');
    Route::post('/register', [AuthController::class, 'register'])->name('admin.register');
    Route::post('/createPakan', [PakanController::class, 'storePakan'])->name('admin.pakan.create');
    Route::put('/addPakan/{id}', [PakanController::class, 'addPakan'])->name('admin.pakan.create');
    Route::post('/createVaksin', [VaksinController::class, 'storevaksin'])->name('admin.vaksin.create');
    Route::put('/addVaksin/{id}', [VaksinController::class, 'addvaksin'])->name('admin.vaksin.create');

    
    //sales Functions


    
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

    Route::get('/machine', [MachineController::class, 'userIndex'])->name('user.machine');
    Route::get('/machine/create', [MachineController::class, 'createMachine'])->name('user.machine.create');
    Route::post('/machine/create', [MachineController::class,'storeMachine'])->name('user.machine.store');

    Route::get('/pen', [PenController::class, 'userIndex'])->name('user.penList');
    Route::get('/pen/create', [PenController::class, 'createPen'])->name('user.pen.create');
    Route::post('/pen/create', [PenController::class,'storePen'])->name('user.pen.store');
    Route::get('/pen/{id}', [PenController::class, 'kandangPen'])->name('user.penList.id');

    Route::get('/breeding', [BreedingController::class, 'userIndex'])->name('user.breeding');
    Route::get('/breeding/create', [BreedingController::class, 'createBreeding'])->name('user.breeding.create');
    Route::post('/breeding/create', [BreedingController::class,'storeBreeding'])->name('user.breeding.store');
    Route::get('/breeding/input/{id}', [BreedingController::class, 'inputBreeding'])->name('user.breeding.input');
    Route::post('/breeding/input', [BreedingController::class,'inputedBreeding'])->name('user.breeding.inputed');
    Route::post('/breeding/create', [BreedingController::class,'storeBreeding'])->name('user.breeding.store');
    Route::get('/breeding/vaccine/{id}', [BreedingController::class, 'addVaccine'])->name('user.breeding.vaccine');
    Route::post('/breeding/vaccine/{id}', [BreedingController::class,'storeVaccine'])->name('user.breeding.Vaccined');
    Route::get('/breeding/move/{id}', [BreedingController::class, 'moveForm'])->name('user.breeding.move');
    Route::post('/breeding/move/{id}', [BreedingController::class,'moveTable'])->name('user.breeding.moved');
    Route::get('/breeding/afkir/{id}', [BreedingController::class, 'AfkirALL'])->name('user.breeding.afkir');

    Route::get('/commercial', [CommercialController::class, 'userIndex'])->name('user.commercial');
    Route::get('/commercial/create', [CommercialController::class, 'createCommercial'])->name('user.commercial.create');
    Route::post('/commercial/create', [CommercialController::class,'storeCommercial'])->name('user.commercial.store');
    Route::get('/commercial/input/{id}', [CommercialController::class, 'dailyForm'])->name('user.commercial.input');
    Route::post('/commercial/input', [CommercialController::class,'dailyStore'])->name('user.commercial.inputed');
    Route::get('/commercial/vaccine/{id}', [CommercialController::class, 'addVaccine'])->name('user.commercial.vaccine');
    Route::post('/commercial/vaccine/{id}', [CommercialController::class,'storeVaccine'])->name('user.commercial.Vaccined');
    Route::get('/commercial/move/{id}', [CommercialController::class, 'moveForm'])->name('user.commercial.move');
    Route::post('/commercial/move/{id}', [CommercialController::class,'moveTable'])->name('user.commercial.moved');
    Route::get('/commercial/sale/{id}', [CommercialController::class, 'SaleALL'])->name('user.commercial.sale');

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
    Route::post('/commercial/moved/{id}', [HatcheryController::class,'moved'])->name('user.hatchery.finalInputed');


    Route::get('/pakan', [PakanController::class, 'userIndex'])->name('user.pakan');

    Route::get('/afkir', [AfkirController::class, 'afkir'])->name('user.afkir');
    Route::get('/afkir/input/{id}', [AfkirController::class, 'dailyAfkirForm'])->name('user.dailyAfkirForm');
    Route::post('/afkir/input/{id}', [AfkirController::class, 'storeAfkirForm'])->name('user.storeafkir');
    Route::get('/afkir/move/{id}', [AfkirController::class, 'moveForm'])->name('user.afkir.move');
    Route::post('/afkir/move/{id}', [AfkirController::class,'moveTable'])->name('user.afkir.moved');


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