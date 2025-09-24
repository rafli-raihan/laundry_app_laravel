<?php

use Illuminate\Support\Facades\Route;

Route::get('/', action: [App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('loginAction', [App\Http\Controllers\LoginController::class, 'loginAction'])->name('loginAction');
Route::get('logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::resource('dashboard', App\Http\Controllers\DashboardController::class);
});

Route::middleware(['auth', 'administrator'])->group(function () {
    Route::resource('level', App\Http\Controllers\LevelController::class);
    Route::resource('user', App\Http\Controllers\UserController::class);
    Route::resource('service', App\Http\Controllers\TypeOfServiceController::class);
});

Route::middleware(['auth', 'adopt'])->group(function () {
    Route::post('/transactions', [App\Http\Controllers\TransOrderController::class, 'store']);
    Route::put('/transactions/{id}', [App\Http\Controllers\TransOrderController::class, 'update']);

    Route::resource('order', App\Http\Controllers\TransOrderController::class);
    Route::get('/order-json', [App\Http\Controllers\TransOrderController::class, 'getOrders'])
        ->name('order.json');
    Route::get('/order-json/{id}', [App\Http\Controllers\TransOrderController::class, 'getSingleOrder']);
    Route::put('/order-json-update-status/{id}', [App\Http\Controllers\TransOrderController::class, 'updateOrderStatus']);
    Route::post('/submit-pickup/', [App\Http\Controllers\TransOrderController::class, 'submitPickup']);


    Route::resource('customer', App\Http\Controllers\CustomerController::class);
    Route::get("print_struk/{id}", [App\Http\Controllers\TransOrderController::class, 'printStruk'])->name('print_struk');
});

Route::middleware(['auth', 'pimpinan'])->group(function () {
    Route::get("report", [App\Http\Controllers\ReportController::class, 'report'])->name('report');
    Route::post("report", [App\Http\Controllers\ReportController::class, 'reportFilter'])->name('reportFilter');
    Route::get("print_laporan", [App\Http\Controllers\ReportController::class, 'printLaporan'])->name('print_laporan');
});


/*
Roles:
- Administrator (Super Admin): menambahkan akun user, layanan, dan menentukan serta menambah level dari user.
- Adopt (Admin / Operator): mengelola data customer, transaksi, dan mencetak struk.
- Pimpinan: melihat laporan transaksi berdasarkan tanggal tertentu.
*/
