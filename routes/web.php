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


/*
|--------------------------------------------------------------------------
| Public Routes
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
| Register Routes
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('verified')
        ->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | MASTER USER
    |--------------------------------------------------------------------------
    */
    Route::prefix('master')->name('master.')->group(function () {

    Route::resource('user', UserController::class)->names([
        'index' => 'user',
        'store' => 'user.store',
        'update' => 'user.update',
        'destroy' => 'user.destroy',
    ]);

    Route::resource('pabrik', PabrikController::class)->names([
        'index' => 'pabrik',
        'store' => 'pabrik.store',
        'update' => 'pabrik.update',
        'destroy' => 'pabrik.destroy',
    ]);

    Route::resource('customer', CustomerController::class)->only([
        'index', 'store', 'update', 'destroy'
    ])->names([
        'index' => 'customer',
        'store' => 'customer.store',
        'update' => 'customer.update',
        'destroy' => 'customer.destroy',
    ]);

    Route::get('/diskon', [DiskonController::class, 'index'])->name('diskon');
    Route::post('/diskon', [DiskonController::class, 'store'])->name('diskon.store');
    Route::put('/diskon/{id}', [DiskonController::class, 'update'])->name('diskon.update');
    Route::delete('/diskon/{id}', [DiskonController::class, 'destroy'])->name('diskon.destroy');

    // BESI
    Route::resource('besi', BesiController::class)->only([
        'index', 'store', 'update', 'destroy'
        ])->names([
            'index'   => 'besi',
            'store'   => 'besi.store',
            'update'  => 'besi.update',
            'destroy' => 'besi.destroy',
        ]);

});

    // Route Timbangan
    Route::get('/timbangan', [TimbanganController::class, 'index'])->name('timbangan');
    Route::post('/timbangan', [TimbanganController::class, 'store'])->name('timbangan.store');
    Route::put('/timbangan/{id}', [TimbanganController::class, 'update'])->name('timbangan.update');
    Route::delete('/timbangan/{id}', [TimbanganController::class, 'destroy'])->name('timbangan.destroy');

    Route::get('/timbangan/cetak', [TimbanganController::class, 'cetak'])
    ->name('timbangan.cetak')
    ->middleware(['auth']);


});

Route::prefix('nota')->group(function () {
    Route::get('/nota', [App\Http\Controllers\NotaController::class, 'index'])
        ->name('nota.index');

    Route::post('/nota', [App\Http\Controllers\NotaController::class, 'store'])
        ->name('nota.store');
});
Route::get('/admin/nota/cetak', [NotaController::class, 'cetak'])
    ->name('admin.nota.cetak');



// Route::prefix('admin/nota')->name('admin.nota.')->group(function () {

//     // GET: Halaman daftar nota
//     Route::get('/', [NotaController::class, 'index'])->name('index');

//     // POST: Simpan nota
//     Route::post('/', [NotaController::class, 'store'])->name('store');

//     // GET: Halaman cetak nota
//     Route::get('/cetak', [NotaController::class, 'cetak'])->name('cetak');

// });



/*
|--------------------------------------------------------------------------
| Product Resource
|--------------------------------------------------------------------------
*/
Route::resource('products', ProductController::class);

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
