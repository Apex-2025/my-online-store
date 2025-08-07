<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
//use App\View\Composers\CartViewComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.navigation', function ($view) {
            $categories = Category::whereNull('parent_id')->with('children')->get();
            $view->with('categoriesNav', $categories);

            // Логіка для кошика: розраховуємо загальну кількість
            $cart = Session::get('cart', []);
            $cartItemCount = 0;
            foreach ($cart as $item) {
                $cartItemCount += $item['quantity'];
            }
            $view->with('cartItemCount', $cartItemCount);
        });
    }
}
