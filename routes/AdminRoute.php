<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::group(['middleware' => 'web'], function () {
    Route::post('/dobackendlogin', [AdminAuthController::class, 'backendlogin'])->name('dobackendlogin');
    Route::get('/dashboard',[AdminAuthController::class, 'Dashboard'])->name("backenddashboard");
    Route::get('/login', [AdminAuthController::class, 'login'])->name('login');
    Route::post('/tenant_create',[AdminAuthController::class, 'TenantCreate'])->name("tenant_create");
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::post('/customer_create',[AdminAuthController::class, 'CustomersCreate'])->name("customer_create");
});
