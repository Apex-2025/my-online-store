<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Цей маршрут тепер показує список продуктів, роблячи його "головною" сторінкою магазину.
// Він викликає метод 'index' контролера ProductController.
Route::get('/', [ProductController::class, 'index'])->name('home');

// Дашборд доступний лише для авторизованих користувачів, верифікацію email ми прибрали.
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Маршрути для профілю, доступні тільки після авторизації.
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Маршрути для управління продуктами - тепер вони доступні для всіх!
// Всі CRUD-операції (створення, редагування, видалення) будуть захищені ролями у самому контролері.
Route::resource('products', ProductController::class);

require __DIR__.'/auth.php';
