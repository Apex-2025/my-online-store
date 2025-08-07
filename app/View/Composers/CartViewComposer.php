<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class CartViewComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Отримуємо кошик із сесії. Якщо його немає, повертаємо порожній масив.
        $cart = Session::get('cart', []);

        // Обчислюємо загальну кількість товарів у кошику.
        $cartItemCount = count($cart);

        // Передаємо кількість товарів у view.
        $view->with('cartItemCount', $cartItemCount);
    }
}
