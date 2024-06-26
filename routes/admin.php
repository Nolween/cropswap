<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BlogArticleCommentController;
use App\Http\Controllers\BlogArticleController;
use App\Http\Controllers\CropController;
use App\Http\Controllers\SwapController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMessageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\IsAdminAuthenticated;

Route::prefix('admin')->middleware(IsAdminAuthenticated::class)->group(function () {
    // ADMIN DASHBOARD
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // CROP PART
    Route::prefix('crop')->group(function () {
        Route::get('index', [CropController::class, 'adminIndex'])->name('admin.crop.index');
    });

    // SWAP PART
    Route::prefix('swap')->group(function () {
        Route::get('/index', [SwapController::class, 'adminIndex'])->name('admin.swap.index');
        Route::get('/create', [SwapController::class, 'create'])->name('admin.swap.create');
        Route::get('/{swap}', [SwapController::class, 'show'])->name('admin.swap.show');
        Route::post('/', [SwapController::class, 'store'])->name('admin.swap.store');
        Route::put('/{swap}', [SwapController::class, 'update'])->name('admin.swap.update');
        Route::delete('/{swap}', [SwapController::class, 'destroy'])->name('admin.swap.destroy');
    });

    //    BLOG ARTICLES PART
    Route::prefix('blog-articles')->group(function () {
        Route::get('/index', [BlogArticleController::class, 'adminIndex'])->name('admin.blog-article.index');
        Route::get('/create', [BlogArticleController::class, 'create'])->name('admin.blog-article.create');
        Route::get('/{blogArticle}', [BlogArticleController::class, 'edit'])->name('admin.blog-article.edit');
        Route::put('/{blogArticle}', [BlogArticleController::class, 'update'])->name('admin.blog-article.update');
        Route::post('/', [BlogArticleController::class, 'store'])->name('admin.blog-article.store');
    });
    // BLOG COMMENT ROUTES
    Route::prefix('comment')->group(function () {
        Route::delete('/{blogArticleComment}', [BlogArticleCommentController::class, 'destroy'])->name(
            'comment.destroy'
        );
    });

    // USERS PART
    Route::prefix('users')->group(function () {
        Route::get('/index', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('/{user}', [UserController::class, 'adminShow'])->name('admin.user.show');

        Route::get('/create', function () {
            return Inertia::render(
                'Admin/User/Create'
            );
        })->name('admin.user.create');
    });
});


