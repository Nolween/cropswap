<?php

use App\Http\Controllers\BlogArticleCommentController;
use App\Http\Controllers\BlogArticleController;
use App\Http\Controllers\CropController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMessageController;
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


Route::get('/', [HomeController::class, 'index'])->name('home');


// Connected Account
Route::prefix('account')->middleware(['auth', 'verified'])->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/informations', [UserController::class, 'show'])->name('account.informations');
    Route::put('/informations', [UserController::class, 'update'])->name('account.informations.update');
    Route::get('/crop', [CropController::class, 'show'])->name('account.crop.show');
    Route::put('/crop/{crop}', [CropController::class, 'update'])->name('account.crop.update');
    Route::post('/crop/{crop}/swap', [CropController::class, 'updateSwap'])->name('account.crop.swap');
});

// BLOG ROUTES
Route::group(['prefix' => 'blog'], function () {
    // List of articles
    Route::get('/', [BlogArticleController::class, 'homeBlog'])->name('blog');
    Route::get('/index', [BlogArticleController::class, 'index'])->name('blog.index');
    Route::get('/index/{tag}', [BlogArticleController::class, 'index'])->name('blog.index.tag');
    Route::get('/{tag}', [BlogArticleController::class, 'homeBlog'])->name('blog.tag');
    // Show article
    Route::get('/article/{blogArticle}', [BlogArticleController::class, 'show'])->name('blog.show');
//  Comments
    Route::post('/article/comment', [BlogArticleCommentController::class, 'store'])->name('blog.comment.store');
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

    Route::get('/', [CropController::class, 'index'])->name('crop.index');
});


// MESSAGES PART
Route::group(['prefix' => 'messages'], function () {
    Route::post('/', [UserMessageController::class, 'store'])->name('messages.store');
    Route::get('/', [UserMessageController::class, 'index'])->name('messages.index');
});


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
