<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Важливо використовувати цей фасад
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index(): View
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Product $product): RedirectResponse
    {
        // Отримуємо поточний кошик з сесії або створюємо новий, якщо його немає
        $cart = Session::get('cart', []);

        // Перевіряємо, чи продукт вже існує в кошику
        if (isset($cart[$product->id])) {
            // Якщо існує, просто збільшуємо кількість
            $cart[$product->id]['quantity']++;
        } else {
            // Якщо не існує, додаємо його як новий елемент
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
            ];
        }

        // Зберігаємо оновлений кошик назад у сесію
        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Продукт успішно додано до кошика!');
    }

    /**
     * Update the quantity of a product in the cart.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => 'required|numeric',
            'quantity' => 'required|numeric|min:1',
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Кількість оновлено!');
        }

        return redirect()->back()->with('error', 'Продукт не знайдено у кошику.');
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(Request $request): RedirectResponse
    {
        $request->validate(['id' => 'required|numeric']);

        $cart = Session::get('cart', []);

        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Продукт видалено з кошика.');
        }

        return redirect()->back()->with('error', 'Продукт не знайдено у кошику.');
    }

    /**
     * Clear the cart.
     */
    public function clear(): RedirectResponse
    {
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'Кошик очищено!');
    }
}
