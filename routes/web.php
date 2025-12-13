<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\{
    ProfileController,
    ProductController,
    Auth\RegisteredUserController,
    UserController,
    PabrikController,
    CustomerController,
    DiskonController,
    BesiController,
    TimbanganController,
    DashboardController,
    NotaController,
    MutasiStockController,
    StockOpnameController,
    LaporanController,
    UserSettingController
};

// =====================
// PUBLIC
// =====================
Route::get('/', fn() => view('welcome'));
Route::get('/test', fn() => view('test'));

// =====================
// REGISTER
// =====================
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// =====================
// AUTH
// =====================
Route::middleware(['auth'])->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('verified')
        ->name('dashboard');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])
        ->middleware('verified')
        ->name('dashboard.chartData');
    Route::get('/dashboard/jenis-besi-chart', [DashboardController::class, 'jenisBesiChart'])
        ->middleware('verified')
        ->name('dashboard.jenisBesiChart');



    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // =====================
    // MASTER DATA
    // =====================
    Route::prefix('master')->name('master.')->group(function () {

        // USER
        Route::resource('user', UserController::class)->names([
            'index' => 'user',
            'store' => 'user.store',
            'update' => 'user.update',
            'destroy' => 'user.destroy',
        ]);

        Route::post(
            'user/{user}/reset-password',
            [UserController::class, 'resetPassword']
        )->name('user.reset_password');

        // PABRIK
        Route::resource('pabrik', PabrikController::class)->names([
            'index' => 'pabrik',
            'store' => 'pabrik.store',
            'update' => 'pabrik.update',
            'destroy' => 'pabrik.destroy',
        ]);

        // CUSTOMER
        Route::resource('customer', CustomerController::class)
            ->only(['index', 'store', 'update', 'destroy'])
            ->names([
                'index' => 'customer',
                'store' => 'customer.store',
                'update' => 'customer.update',
                'destroy' => 'customer.destroy',
            ]);

        // DISKON
        Route::get('/diskon', [DiskonController::class, 'index'])->name('diskon');
        Route::post('/diskon', [DiskonController::class, 'store'])->name('diskon.store');
        Route::put('/diskon/{id}', [DiskonController::class, 'update'])->name('diskon.update');
        Route::delete('/diskon/{id}', [DiskonController::class, 'destroy'])->name('diskon.destroy');
        Route::get('/diskon/search', [DiskonController::class, 'search'])->name('diskon.search');

        // BESI
        Route::resource('besi', BesiController::class)
            ->only(['index', 'store', 'update', 'destroy'])
            ->names([
                'index' => 'besi',
                'store' => 'besi.store',
                'update' => 'besi.update',
                'destroy' => 'besi.destroy',
            ]);
    });

    // =====================
    // TIMBANGAN
    // =====================
    Route::get('/besi/search', [TimbanganController::class, 'searchBesi'])
        ->name('besi.search');

    Route::get('/timbangan', [TimbanganController::class, 'index'])->name('timbangan');
    Route::post('/timbangan', [TimbanganController::class, 'store'])->name('timbangan.store');
    Route::put('/timbangan/{id}', [TimbanganController::class, 'update'])->name('timbangan.update');
    Route::delete('/timbangan/{id}', [TimbanganController::class, 'destroy'])->name('timbangan.destroy');

    Route::get('/timbangan/get-besi/{id}', [TimbanganController::class, 'getBesi']);
    Route::get('/timbangan/get-timbangan/{id}', [TimbanganController::class, 'getTimbangan']);

    Route::get('/timbangan/cetak', [TimbanganController::class, 'cetak'])->name('timbangan.cetak');
    Route::post('/timbangan/set-cetak', [TimbanganController::class, 'setCetak'])->name('timbangan.setCetak');
    Route::post('/timbangan/set-transfer', [TimbanganController::class, 'setTransfer'])->name('timbangan.setTransfer');
    Route::post('/timbangan/mark-cetak', [TimbanganController::class, 'markCetak']);

    Route::get('/search-pabrik', [TimbanganController::class, 'searchPabrik'])->name('pabrik.search');
    Route::get('/search-customer', [TimbanganController::class, 'searchCustomer'])->name('customer.search');

    // =====================
    // NOTA
    // =====================
    Route::prefix('nota')->group(function () {
        Route::get('/', [NotaController::class, 'index'])->name('nota.index');
        Route::post('/', [NotaController::class, 'store'])->name('nota.store');
    });

    Route::get('/admin/nota/cetak', [NotaController::class, 'cetak'])->name('admin.nota.cetak');
    Route::get('/nota/create', [NotaController::class, 'create'])->name('nota.create');

    // =====================
    // MUTASI STOCK
    // =====================
    Route::prefix('admin/mutasi-stock')->name('admin.mutasi_stock.')->group(function () {
        Route::get('/', [MutasiStockController::class, 'index'])->name('index');
        Route::post('/store', [MutasiStockController::class, 'store'])->name('store');
        Route::delete('/{id}', [MutasiStockController::class, 'destroy'])->name('destroy');
        Route::get('/get-data', [MutasiStockController::class, 'getData'])->name('getdata');
    });

    // =====================
    // STOCK OPNAME
    // =====================
    Route::get('/admin/stock-opname', [StockOpnameController::class, 'index'])
        ->name('admin.stock-opname.index');

    Route::post('/admin/stock-opname', [StockOpnameController::class, 'store'])
        ->name('admin.stock-opname.store');

    // ✅ ROUTE YANG DIBUTUHKAN (BESI BY PABRIK)
    Route::get(
        '/api/besi-by-pabrik/{pabrik}',
        [StockOpnameController::class, 'besiByPabrik']
    )->name('besi.by-pabrik');

    // =====================
    // LAPORAN
    // =====================
    Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('/admin/laporan/pembelian', [LaporanController::class, 'pembelian'])->name('admin.laporan.pembelian');
    Route::get('/admin/laporan/penjualan', [LaporanController::class, 'penjualan'])->name('admin.laporan.penjualan');

    // =====================
    // USER SETTING
    // =====================
    Route::get('/user/settings', [UserSettingController::class, 'index'])->name('user.settings');
    Route::post('/user/settings/profile', [UserSettingController::class, 'updateProfile'])->name('user.settings.updateProfile');
    Route::post('/user/settings/password', [UserSettingController::class, 'updatePassword'])->name('user.settings.updatePassword');
});

// =====================
// PRODUCT (contoh)
// =====================
Route::resource('products', ProductController::class);

// =====================
// AUTH DEFAULT
// =====================
require __DIR__ . '/auth.php';
