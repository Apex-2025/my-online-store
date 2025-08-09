<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index(): View
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            $cartItems = collect();
            $totalPrice = 0;
            return view('cart.index', compact('cartItems', 'totalPrice'));
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $cartItems = collect($cart)->map(function ($item, $productId) use ($products) {
            if ($products->has($productId)) {
                return (object)[
                    'product' => $products->get($productId),
                    'quantity' => $item['quantity'],
                ];
            }
            return null;
        })->filter()->values();

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'totalPrice'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Product $product): RedirectResponse
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Продукт успішно додано до кошика!');
    }

    /**
     * Update the quantity of a product in the cart.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric|min:1',
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
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
        $request->validate(['product_id' => 'required|numeric']);

        $cart = Session::get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
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

    /**
     * Display the checkout page.
     */
    public function checkout(): View|RedirectResponse
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Кошик порожній. Додайте товари, щоб оформити замовлення.');
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $cartItems = collect($cart)->map(function ($item, $productId) use ($products) {
            $product = $products->get($productId);
            if ($product) {
                return (object)[
                    'product' => $product,
                    'quantity' => $item['quantity'],
                ];
            }
            return null;
        })->filter()->values();

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $user = auth()->check() ? auth()->user() : null;

        return view('checkout.index', compact('cartItems', 'totalPrice', 'user'));
    }

    /**
     * Handle the checkout form submission and store the order.
     */
    public function storeOrder(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Ваш кошик порожній.');
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $cartItems = collect($cart)->map(function ($item, $productId) use ($products) {
            $product = $products->get($productId);
            if ($product) {
                return (object)[
                    'product' => $product,
                    'quantity' => $item['quantity'],
                ];
            }
            return null;
        })->filter()->values();

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => auth()->id(),
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            DB::commit();

            Session::forget('cart');
            return redirect()->route('products.index')->with('success', 'Ваше замовлення успішно оформлено! Дякуємо за покупку.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Під час оформлення замовлення виникла помилка. Спробуйте ще раз.');
        }
    }
}
