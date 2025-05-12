<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Enums\UserType;

use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    if (!Auth::check() || Auth::user()->usertype == UserType::Admin) {
        return redirect()->route('admin.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/dashboard', [AdminHomeController::class, 'index'])->name('admin.dashboard');
    // Products
    Route::get('admin/products', [ProductController::class, 'index'])->name('admin.products');
    Route::get('admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('admin/products/save', [ProductController::class, 'save'])->name('admin.products.save');
    Route::get('admin/products/edit/{id}', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('admin/products/edit/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('admin/products/delete/{id}', [ProductController::class, 'delete'])->name('admin.products.delete');

    // Categories
    Route::get('admin/categories', [CategoryController::class, 'index'])->name('admin.categories');
    Route::get('admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('admin/categories/save', [CategoryController::class, 'save'])->name('admin.categories.save');
    Route::get('admin/categories/edit/{id}', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('admin/categories/edit/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('admin/categories/delete/{id}', [CategoryController::class, 'delete'])->name('admin.categories.delete');
});


require __DIR__ . '/auth.php';

//Route::get('admin/dashboard', [HomeController::class, 'index']);

//Route::get('admin/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'admin']);
