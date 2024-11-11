<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::get('/example-page', [PageController::class, 'showExamplePage']);

//Login Routelari
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register Routelari
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Product ve Admin sayfasi Routelari
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Ürün yönetimi routelari
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('admin.products.index'); //urun goruntuleme
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update'); //urun duzenleme
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy'); //urun silme

    // Kategori yönetimi rotaları
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index'); // Kategori görüntüleme
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update'); // Kategori düzenleme
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy'); // Kategori silme

    // Alt kategori yönetimi rotaları
    Route::get('/categories/{category}/subcategories/create', [SubcategoryController::class, 'create'])->name('admin.subcategories.create');
    Route::post('/categories/{category}/subcategories', [SubcategoryController::class, 'store'])->name('admin.subcategories.store');
    Route::get('/categories/{category}/subcategories/{subcategory}/edit', [SubcategoryController::class, 'edit'])->name('admin.subcategories.edit');
    Route::put('/categories/{category}/subcategories/{subcategory}', [SubcategoryController::class, 'update'])->name('admin.subcategories.update'); // Alt kategori düzenleme
    Route::delete('/categories/{category}/subcategories/{subcategory}', [SubcategoryController::class, 'destroy'])->name('admin.subcategories.destroy'); // Alt kategori silme
    Route::get('/categories/{categoryId}/subcategories/{productId?}', [CategoryController::class, 'getSubcategories']);//secili kategoriye ait alt kategoriyi getir
});

//Product rate
Route::post('/rate-product', [RatingController::class, 'rateProduct'])->name('rate.product'); //add to rating table
Route::post('/remove-rating', [RatingController::class, 'removeRating'])->name('remove.rating'); //remove from rating table
Route::post('/check-user-rating', [RatingController::class, 'checkUserRating']);

//product genel
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show'); // Belirli bir ürünün detay sayfası
