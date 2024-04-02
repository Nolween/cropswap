<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\IsAdminAuthenticated;

Route::middleware(IsAdminAuthenticated::class)->group(function () {
    // ADMIN DASHBOARD
    Route::get('admin/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard');
    // CROP PART
    Route::get('/admin/crop/index', function () {
        return Inertia::render(
            'Admin/Crop/Index',
            [
                'title' => 'Admin Crop Index',
            ]
        );
    })->name('admin.crop.index');
    // SWAP PART
    Route::get('/admin/swap/index', function () {
        return Inertia::render(
            'Admin/Swap/Index',
            [
                'title' => 'Admin Swap Index',
            ]
        );
    })->name('admin.swap.index');
    // USERS PART
    Route::get('/admin/users/index', function () {
        return Inertia::render(
            'Admin/User/Index',
            [
                'title' => 'Admin User Index',
            ]
        );
    })->name('admin.user.index');

    Route::get('/admin/users/create', function () {
        return Inertia::render(
            'Admin/User/Create'
        );
    })->name('admin.user.create');

    Route::get('/admin/users/{id}', function ($id) {
        return Inertia::render(
            'Admin/User/Show'
        );
    })->name('admin.user.show');
});


