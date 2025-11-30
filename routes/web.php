<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controller Imports
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PabrikController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\BesiController;
use App\Http\Controllers\TimbanganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\MutasiStockController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserSettingController;



/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome'); // nanti diganti home
});

Route::get('/test', function () {
    return view('test');
});


/*
|--------------------------------------------------------------------------
| REGISTER (tanpa login wajib)
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);



/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('verified')
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | PROFILE USER
    |--------------------------------------------------------------------------
    */
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | MASTER DATA (User, Pabrik, Customer, Diskon, Besi)
    |--------------------------------------------------------------------------
    */
    Route::prefix('master')->name('master.')->group(function () {

        // USERS
        Route::resource('user', UserController::class)->names([
            'index'   => 'user',
            'store'   => 'user.store',
            'update'  => 'user.update',
            'destroy' => 'user.destroy',
        ]);

        // PABRIK
        Route::resource('pabrik', PabrikController::class)->names([
            'index'   => 'pabrik',
            'store'   => 'pabrik.store',
            'update'  => 'pabrik.update',
            'destroy' => 'pabrik.destroy',
        ]);

        // CUSTOMER
        Route::resource('customer', CustomerController::class)->only([
            'index', 'store', 'update', 'destroy'
        ])->names([
            'index'   => 'customer',
            'store'   => 'customer.store',
            'update'  => 'customer.update',
            'destroy' => 'customer.destroy',
        ]);

        // DISKON
        Route::get('/diskon', [DiskonController::class, 'index'])->name('diskon');
        Route::post('/diskon', [DiskonController::class, 'store'])->name('diskon.store');
        Route::put('/diskon/{id}', [DiskonController::class, 'update'])->name('diskon.update');
        Route::delete('/diskon/{id}', [DiskonController::class, 'destroy'])->name('diskon.destroy');

        // MASTER BESI
        Route::resource('besi', BesiController::class)->only([
            'index', 'store', 'update', 'destroy'
        ])->names([
            'index'   => 'besi',
            'store'   => 'besi.store',
            'update'  => 'besi.update',
            'destroy' => 'besi.destroy',
        ]);
    });



    /*
    |--------------------------------------------------------------------------
    | TIMBANGAN
    |--------------------------------------------------------------------------
    */

    // Autocomplete Besi untuk Timbangan
    Route::get('/besi/search', [TimbanganController::class, 'searchBesi'])
        ->name('besi.search');   // dipakai untuk dropdown di modal tambah/edit timbangan

    // CRUD Timbangan
    Route::get('/timbangan', [TimbanganController::class, 'index'])->name('timbangan');
    Route::post('/timbangan', [TimbanganController::class, 'store'])->name('timbangan.store');
    Route::put('/timbangan/{id}', [TimbanganController::class, 'update'])->name('timbangan.update');
    Route::delete('/timbangan/{id}', [TimbanganController::class, 'destroy'])->name('timbangan.destroy');
Route::get('/timbangan/get-besi/{id}', [TimbanganController::class, 'getBesi']);

    // Cetak Timbangan
    Route::get('/timbangan/cetak', [TimbanganController::class, 'cetak'])
        ->name('timbangan.cetak');
    Route::post('/timbangan/set-cetak', [TimbanganController::class, 'setCetak'])->name('timbangan.setCetak');
Route::post('/timbangan/set-transfer', [TimbanganController::class, 'setTransfer'])->name('timbangan.setTransfer');
Route::post('/timbangan/mark-cetak', [TimbanganController::class, 'markCetak']);




    /*
    |--------------------------------------------------------------------------
    | NOTA
    |--------------------------------------------------------------------------
    */
    Route::prefix('nota')->group(function () {
        Route::get('/nota', [NotaController::class, 'index'])->name('nota.index');
        Route::post('/nota', [NotaController::class, 'store'])->name('nota.store');
    });

    Route::get('/admin/nota/cetak', [NotaController::class, 'cetak'])
        ->name('admin.nota.cetak');

    Route::get('/nota/create', [NotaController::class, 'create'])
        ->name('nota.create');



    /*
    |--------------------------------------------------------------------------
    | MUTASI STOCK
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/mutasi-stock', [MutasiStockController::class, 'index'])
        ->name('admin.mutasi_stock.index');


    /*
    |--------------------------------------------------------------------------
    | STOCK OPNAME
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/stock-opname', [StockOpnameController::class, 'index'])
        ->name('admin.stock-opname.index');


    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/laporan', [LaporanController::class, 'index'])
        ->name('admin.laporan.index');


    /*
    |--------------------------------------------------------------------------
    | USER SETTING (UNTUK ADMIN)
    |--------------------------------------------------------------------------
    */

    Route::get('/user/settings', [UserSettingController::class, 'index'])->name('user.settings');
    Route::post('/user/settings/profile', [UserSettingController::class, 'updateProfile'])->name('user.settings.updateProfile');
    Route::post('/user/settings/password', [UserSettingController::class, 'updatePassword'])->name('user.settings.updatePassword');
});



/*
|--------------------------------------------------------------------------
| PRODUCT (Contoh resource)
|--------------------------------------------------------------------------
*/
Route::resource('products', ProductController::class);


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (login, logout, lupa password, dll)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
