<?php

use App\Http\Controllers\BlogArticleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });


Route::get('/', function () {
    return Inertia::render(
        'Home',
        [
            'title' => 'Home Page',
        ]
    );
})->name('home');


// Connected Account
Route::prefix('account')->middleware(['auth', 'verified'])->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/informations', function () {
        return Inertia::render('Account/Informations');
    })->name('account.informations');
    Route::get('/crop', function () {
        return Inertia::render('Account/Crop');
    })->name('account.crop.show');
});

// BLOG ROUTES
Route::group(['prefix' => 'blog'], function () {
    // List of articles
    Route::get('/', [BlogArticleController::class, 'homeBlog'])->name('blog');
    Route::get('/index', [BlogArticleController::class, 'index'])->name('blog.index');
    // Show article
    Route::get('/{id}', function ($id) {
        return Inertia::render(
            'Blog/Show',
            [
                'title' => 'Blog Page',
                'id'    => $id,
            ]
        );
    })->name('blog.show');
});

// CROP ROUTES
Route::group(['prefix' => 'crop'], function () {
    Route::get('/{id}', function ($id) {
        return Inertia::render(
            'Crop/Show',
            [
                'title' => 'Crop Page',
                'id'    => $id,
            ]
        );
    })->name('crop.show');

    Route::get('/', function () {
        return Inertia::render(
            'Crop/Index',
            [
                'title' => 'Crops Search Page',
            ]
        );
    })->name('crop.index');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
