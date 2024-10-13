<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdpostUserAuthController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuperAdminAuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\BranchAdminAuthController;
use App\Http\Controllers\BuyerAuthController;
use App\Http\Controllers\FinanceAuthController;
use App\Http\Controllers\HrAuthController;
use App\Http\Controllers\ItAuthController;










Route::get('/', function () {
    return view('welcome');
});

// User routes
Route::group(['prefix' => 'user'], function() {
    Route::get('login', [UserAuthController::class, 'showLoginForm'])->name('user.login');
    Route::post('login', [UserAuthController::class, 'login']);
    Route::get('register', [UserAuthController::class, 'showRegisterForm'])->name('user.register');
    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('logout', [UserAuthController::class, 'logout'])->name('user.logout');

    Route::get('dashboard', [UserAuthController::class, 'dashboard'])->middleware('auth:user')->name('user.dashboard');
});

// SuperAdmin routes
Route::group(['prefix' => 'superadmin'], function() {
    Route::get('login', [SuperAdminAuthController::class, 'showLoginForm'])->name('superadmin.login');
    Route::post('login', [SuperAdminAuthController::class, 'login']);
    Route::get('register', [SuperAdminAuthController::class, 'showRegisterForm'])->name('superadmin.register');
    Route::post('register', [SuperAdminAuthController::class, 'register']);
    Route::post('logout', [SuperAdminAuthController::class, 'logout'])->name('superadmin.logout');

    Route::get('dashboard', [SuperAdminAuthController::class, 'dashboard'])->middleware('auth:superadmin')->name('superadmin.dashboard');
});
// Admin routes
Route::group(['prefix' => 'admin'], function() {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::get('register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('register', [AdminAuthController::class, 'register']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::get('dashboard', [AdminAuthController::class, 'dashboard'])->middleware('auth:admin')->name('admin.dashboard');
});

// AdpostUser routes
Route::group(['prefix' => 'adpostuser'], function() {
    Route::get('login', [AdpostUserAuthController::class, 'showLoginForm'])->name('adpostuser.login');
    Route::post('login', [AdpostUserAuthController::class, 'login']);
    Route::get('register', [AdpostUserAuthController::class, 'showRegisterForm'])->name('adpostuser.register');
    Route::post('register', [AdpostUserAuthController::class, 'register']);
    Route::post('logout', [AdpostUserAuthController::class, 'logout'])->name('adpostuser.logout');

    Route::get('dashboard', [AdpostUserAuthController::class, 'dashboard'])->middleware('auth:adpostuser')->name('adpostuser.dashboard');
});

// BranchAdmin routes
Route::group(['prefix' => 'branchadmin'], function() {
    Route::get('login', [BranchAdminAuthController::class, 'showLoginForm'])->name('branchadmin.login');
    Route::post('login', [BranchAdminAuthController::class, 'login']);
    Route::get('register', [BranchAdminAuthController::class, 'showRegisterForm'])->name('branchadmin.register');
    Route::post('register', [BranchAdminAuthController::class, 'register']);
    Route::post('logout', [BranchAdminAuthController::class, 'logout'])->name('branchadmin.logout');

    Route::get('dashboard', [BranchAdminAuthController::class, 'dashboard'])->middleware('auth:branchadmin')->name('branchadmin.dashboard');
});

// Buyer routes
Route::group(['prefix' => 'buyer'], function() {
    Route::get('login', [BuyerAuthController::class, 'showLoginForm'])->name('buyer.login');
    Route::post('login', [BuyerAuthController::class, 'login']);
    Route::get('register', [BuyerAuthController::class, 'showRegisterForm'])->name('buyer.register');
    Route::post('register', [BuyerAuthController::class, 'register']);
    Route::post('logout', [BuyerAuthController::class, 'logout'])->name('buyer.logout');

    Route::get('dashboard', [BuyerAuthController::class, 'dashboard'])->middleware('auth:buyer')->name('buyer.dashboard');
});

// Finance routes
Route::group(['prefix' => 'finance'], function() {
    Route::get('login', [FinanceAuthController::class, 'showLoginForm'])->name('finance.login');
    Route::post('login', [FinanceAuthController::class, 'login']);
    Route::get('register', [FinanceAuthController::class, 'showRegisterForm'])->name('finance.register');
    Route::post('register', [FinanceAuthController::class, 'register']);
    Route::post('logout', [FinanceAuthController::class, 'logout'])->name('finance.logout');

    Route::get('dashboard', [FinanceAuthController::class, 'dashboard'])->middleware('auth:finance')->name('finance.dashboard');
});

// HR routes
Route::group(['prefix' => 'hr'], function() {
    Route::get('login', [HrAuthController::class, 'showLoginForm'])->name('hr.login');
    Route::post('login', [HrAuthController::class, 'login']);
    Route::get('register', [HrAuthController::class, 'showRegisterForm'])->name('hr.register');
    Route::post('register', [HrAuthController::class, 'register']);
    Route::post('logout', [HrAuthController::class, 'logout'])->name('hr.logout');

    Route::get('dashboard', [HrAuthController::class, 'dashboard'])->middleware('auth:hr')->name('hr.dashboard');
});

// IT routes
Route::group(['prefix' => 'it'], function() {
    Route::get('login', [ItAuthController::class, 'showLoginForm'])->name('it.login');
    Route::post('login', [ItAuthController::class, 'login']);
    Route::get('register', [ItAuthController::class, 'showRegisterForm'])->name('it.register');
    Route::post('register', [ItAuthController::class, 'register']);
    Route::post('logout', [ItAuthController::class, 'logout'])->name('it.logout');

    Route::get('dashboard', [ItAuthController::class, 'dashboard'])->middleware('auth:it')->name('it.dashboard');
});
