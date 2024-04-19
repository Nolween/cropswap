<?php

use App\Http\Controllers\BlogArticleCommentController;
use App\Http\Controllers\BlogArticleController;
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
    Route::get('/swap/index', function () {
        return Inertia::render(
            'Admin/Swap/Index',
            [
                'title' => 'Admin Swap Index',
            ]
        );
    })->name('admin.swap.index');
    Route::get('/swap/create', function () {
        return Inertia::render(
            'Admin/Swap/Create'
        );
    })->name('admin.swap.create');

    // USERS PART
    Route::get('/users/index', function () {
        return Inertia::render(
            'Admin/User/Index',
            [
                'title' => 'Admin User Index',
            ]
        );
    })->name('admin.user.index');

    Route::get('/users/create', function () {
        return Inertia::render(
            'Admin/User/Create'
        );
    })->name('admin.user.create');

    Route::get('/users/{id}', function ($id) {
        return Inertia::render(
            'Admin/User/Show'
        );
    })->name('admin.user.show');
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
});


