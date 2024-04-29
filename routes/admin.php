<?php

use App\Http\Controllers\BlogArticleCommentController;
use App\Http\Controllers\BlogArticleController;
use App\Http\Controllers\SwapController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMessageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\IsAdminAuthenticated;

Route::prefix('admin')->middleware(IsAdminAuthenticated::class)->group(function () {
    // ADMIN DASHBOARD
    Route::get('dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard');
    // CROP PART
    Route::get('/crop/index', function () {
        return Inertia::render(
            'Admin/Crop/Index',
            [
                'title' => 'Admin Crop Index',
            ]
        );
    })->name('admin.crop.index');
    // SWAP PART
    Route::prefix('swap')->group(function () {
        Route::get('/index', [SwapController::class, 'index'])->name('admin.swap.index');
        Route::get('/create', function () {
            return Inertia::render(
                'Admin/Swap/Create'
            );
        })->name('admin.swap.create');
    });

    // USERS PART
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
        Route::get('/{user}', [UserController::class, 'show'])->name('admin.user.show');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('admin.user.destroy');

        Route::get('/create', function () {
            return Inertia::render(
                'Admin/User/Create'
            );
        })->name('admin.user.create');
    });
});


