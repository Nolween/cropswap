<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\IsAdminAuthenticated;

Route::middleware(IsAdminAuthenticated::class)->group(function () {
    Route::get('admin/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard');
});

Route::get('/admin/crop/index', function () {
    return Inertia::render('Admin/Crop/Index',
    [
        'title' => 'Admin Crop Index',
    ]);
})->name('admin.crop.index');


Route::get('/admin/swap/index', function () {
    return Inertia::render('Admin/Swap/Index',
    [
        'title' => 'Admin Swap Index',
    ]);
})->name('admin.swap.index');


Route::get('/admin/users/index', function () {
    return Inertia::render('Admin/User/Index',
    [
        'title' => 'Admin User Index',
    ]);
})->name('admin.user.index');


