<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Головна сторінка, що показує список продуктів
Route::get('/', [ProductController::class, 'index'])->name('home');

// Дашборд для авторизованих користувачів
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Маршрути для профілю
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', 'ProfileController@update')->name('profile.update');
    Route::delete('/profile', 'ProfileController@destroy')->name('profile.destroy');
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
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// --- Нові маршрути для статичних сторінок ---
Route::get('/about-us', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

require __DIR__.'/auth.php';
