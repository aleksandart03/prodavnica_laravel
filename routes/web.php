<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Enums\UserType;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;


use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Auth;

//Main Routes

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'show'])->name('products.index');
Route::get('/categories', [CategoryController::class, 'show'])->name('categories.index');
Route::view('/about', 'about')->name('about');
Route::get('/products/{id}', [ProductController::class, 'showProduct'])->name('products.show');


//Cart

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'addProductToCart'])->name('cart.add');
Route::delete('/cart/remove/{product}', [CartController::class, 'removeProductFromCart'])->name('cart.remove');
Route::patch('/cart/increase/{product}', [CartController::class, 'increaseQuantity'])->name('cart.increase');
Route::patch('/cart/decrease/{product}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');
Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::patch('/cart/update/{product}', [CartController::class, 'updateQuantity'])->name('cart.update');

//checkout

Route::get('/checkout', [OrderController::class, 'checkoutForm'])->name('checkout.form');
Route::post('/checkout', [OrderController::class, 'processCheckout'])->name('checkout.process');
Route::get('/checkout/confirmed', [OrderController::class, 'checkoutConfirmed'])->name('checkout.confirmed');


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
    Route::get('admin/products', [AdminProductController::class, 'index'])->name('admin.products');
    Route::get('admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('admin/products/save', [AdminProductController::class, 'save'])->name('admin.products.save');
    Route::get('admin/products/edit/{id}', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('admin/products/edit/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('admin/products/delete/{id}', [AdminProductController::class, 'delete'])->name('admin.products.delete');

    // Categories
    Route::get('admin/categories', [AdminCategoryController::class, 'index'])->name('admin.categories');
    Route::get('admin/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('admin/categories/save', [AdminCategoryController::class, 'save'])->name('admin.categories.save');
    Route::get('admin/categories/edit/{id}', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('admin/categories/edit/{id}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('admin/categories/delete/{id}', [AdminCategoryController::class, 'delete'])->name('admin.categories.delete');

    // Import/Export Products
    Route::get('admin/products/export', [AdminProductController::class, 'export'])->name('admin.products.export');
    Route::post('admin/products/import', [AdminProductController::class, 'import'])->name('admin.products.import');
    Route::get('categories/export', [AdminCategoryController::class, 'export'])->name('categories.export');
    Route::post('categories/import', [AdminCategoryController::class, 'import'])->name('categories.import');
});

//Products search

Route::get('/search-products', [ProductController::class, 'search'])->name('products.search');

Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');




require __DIR__ . '/auth.php';
