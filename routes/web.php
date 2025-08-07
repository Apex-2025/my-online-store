<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Головна сторінка, що показує список продуктів
Route::get('/', [ProductController::class, 'index'])->name('home');

// Маршрути для профілю
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Маршрути для управління продуктами
Route::resource('products', ProductController::class);

// --- Маршрути для кошика ---
// Додавання товару в кошик
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
// Відображення сторінки кошика
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
// Оновлення кількості товару в кошику
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
// Видалення товару з кошика
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// ---маршрути для статичних сторінок ---
Route::get('/about-us', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// --- Маршрути для оформлення замовлення ---
// Маршрут для сторінки оформлення замовлення (відображення форми)
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');
// Маршрут для обробки форми оформлення замовлення (збереження)
Route::post('/checkout', [CartController::class, 'storeOrder'])->name('checkout.store');

// --- Маршрути для управління категоріями ---
// Маршрут для відображення всіх категорій (верхнього рівня)
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
// Маршрут для відображення конкретної категорії або підкатегорії
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Маршрути для створення/збереження категорій (адмін-панель)
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

// --- Маршрути для адміністративної панелі ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Головна сторінка адмін-панелі
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Маршрути для управління продуктами в адмін-панелі
    Route::resource('products', \App\Http\Controllers\Admin\AdminProductController::class);

    // Маршрути для управління категоріями в адмін-панелі
    Route::resource('categories', \App\Http\Controllers\Admin\AdminCategoryController::class);

    // Маршрути для управління замовленнями в адмін-панелі
    Route::resource('orders', \App\Http\Controllers\Admin\AdminOrderController::class)->except(['create', 'store']); // Замовлення створюються через checkout
});

require __DIR__.'/auth.php';
