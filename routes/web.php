<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordController;

// Guest Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Authenticated Routes (Admin & Cashier)
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/account/password', [PasswordController::class, 'edit'])->name('account.password.edit');
    Route::put('/account/password', [PasswordController::class, 'update'])->name('account.password.update');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Invoices (Penjualan) - Accessible by Cashier & Admin
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'pdf'])->name('invoices.pdf');
    Route::resource('invoices', InvoiceController::class);

    // Bills (Pembelian) - Accessible by Cashier & Admin
    Route::get('bills/{bill}/pdf', [BillController::class, 'pdf'])->name('bills.pdf');
    Route::resource('bills', BillController::class);
});

// Admin Only Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('contacts', ContactController::class);
    Route::resource('products', ProductController::class);

    Route::get('/company/edit', [\App\Http\Controllers\CompanyProfileController::class, 'edit'])->name('company.edit');
    Route::put('/company/update', [\App\Http\Controllers\CompanyProfileController::class, 'update'])->name('company.update');

    Route::resource('users', UserController::class);
    Route::get('/users/{user}/password', [PasswordController::class, 'resetUserForm'])->name('users.password.edit');
    Route::put('/users/{user}/password', [PasswordController::class, 'resetUser'])->name('users.password.update');
});
