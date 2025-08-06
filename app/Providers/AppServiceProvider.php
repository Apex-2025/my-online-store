<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;

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
        // View Composer для навігаційного меню
        View::composer(['layouts.navigation'], function ($view) {
            $categories = Category::whereNull('parent_id')->with('children')->get();
            $view->with('categoriesNav', $categories);
        });
    }
}
