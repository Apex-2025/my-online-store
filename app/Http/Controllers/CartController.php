<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{
    /**
     * Відображає вміст кошика.
     */
    public function index()
    {
        $cartItems = [];
        $totalPrice = 0;

        if (Auth::check()) {
            // Для зареєстрованих користувачів отримуємо дані з бази даних
            $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        } else {
            // Для гостей отримуємо дані з сесії
            $sessionCart = Session::get('cart', []);
            $productIds = collect($sessionCart)->pluck('product_id');
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

            foreach ($sessionCart as $item) {
                if ($products->has($item['product_id'])) {
                    $cartItems[] = (object)[
                        'product' => $products->get($item['product_id']),
                        'quantity' => $item['quantity'],
                    ];
                }
            }
        }

        // Обчислюємо загальну суму
        foreach ($cartItems as $item) {
            $productPrice = $item->product->price ?? 0;
            $quantity = $item->quantity ?? 0;
            $totalPrice += $productPrice * $quantity;
        }

        return view('cart.index', compact('cartItems', 'totalPrice'));
    }

    /**
     * Додає товар до кошика.
     */
    public function add(Request $request, Product $product)
    {
        if (Auth::check()) {
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity');
            } else {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'quantity' => 1,
                ]);
            }
        } else {
            $cart = Session::get('cart', []);
            $found = false;

            foreach ($cart as $key => $item) {
                if ($item['product_id'] == $product->id) {
                    $cart[$key]['quantity']++;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $cart[] = [
                    'product_id' => $product->id,
                    'quantity' => 1,
                ];
            }

            Session::put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Товар додано до кошика!');
    }

    /**
     * Оновлює кількість товару в кошику.
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        if (Auth::check()) {
            $cartItem = CartItem::where('user_id', Auth::id())->where('product_id', $productId)->first();
            if ($cartItem) {
                $cartItem->quantity = $quantity;
                $cartItem->save();
            }
        } else {
            $cart = Session::get('cart', []);
            foreach ($cart as $key => $item) {
                if ($item['product_id'] == $productId) {
                    $cart[$key]['quantity'] = $quantity;
                    break;
                }
            }
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Кількість товару оновлено!');
    }

    /**
     * Видаляє товар з кошика.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $productId = $request->input('product_id');

        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->where('product_id', $productId)->delete();
        } else {
            $cart = Session::get('cart', []);
            $cart = array_filter($cart, fn($item) => $item['product_id'] != $productId);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Товар видалено з кошика.');
    }

    /**
     * Зливає вміст кошика сесії з кошиком авторизованого користувача.
     */
    public function mergeCart()
    {
        $sessionCart = Session::get('cart', []);

        if (!empty($sessionCart) && Auth::check()) {
            $user = Auth::user();

            foreach ($sessionCart as $item) {
                $cartItem = CartItem::where('user_id', $user->id)
                    ->where('product_id', $item['product_id'])
                    ->first();

                if ($cartItem) {
                    $cartItem->quantity += $item['quantity'];
                    $cartItem->save();
                } else {
                    CartItem::create([
                        'user_id' => $user->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                    ]);
                }
            }
            Session::forget('cart');
        }
    }

    /**
     * Відображає сторінку оформлення замовлення.
     */
    public function checkout()
    {
        // Логіка для отримання товарів з кошика та загальної суми
        // Ця логіка є ідентичною тій, що в методі 'index'
        $cartItems = [];
        $totalPrice = 0;

        if (Auth::check()) {
            $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        } else {
            $sessionCart = Session::get('cart', []);
            $productIds = collect($sessionCart)->pluck('product_id');
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

            foreach ($sessionCart as $item) {
                if ($products->has($item['product_id'])) {
                    $cartItems[] = (object)[
                        'product' => $products->get($item['product_id']),
                        'quantity' => $item['quantity'],
                    ];
                }
            }
        }

        foreach ($cartItems as $item) {
            $productPrice = $item->product->price ?? 0;
            $quantity = $item->quantity ?? 0;
            $totalPrice += $productPrice * $quantity;
        }

        // Перенаправлення, якщо кошик порожній
        if (empty($cartItems) || count($cartItems) === 0) {
            return redirect()->route('cart.index')->with('error', 'Ваш кошик порожній.');
        }

        $user = Auth::user();

        return view('checkout.index', compact('cartItems', 'totalPrice', 'user'));
    }

    /**
     * Зберігає замовлення в базі даних.
     */
    public function storeOrder(Request $request)
    {
        // Валідація даних з форми
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $cartItems = [];
        $totalPrice = 0;
        $isUserLoggedIn = Auth::check();

        if ($isUserLoggedIn) {
            $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        } else {
            $sessionCart = Session::get('cart', []);
            $productIds = collect($sessionCart)->pluck('product_id');
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

            foreach ($sessionCart as $item) {
                if ($products->has($item['product_id'])) {
                    $cartItems[] = (object)[
                        'product' => $products->get($item['product_id']),
                        'quantity' => $item['quantity'],
                    ];
                }
            }
        }

        // Перевірка, чи не порожній кошик перед збереженням
        if (empty($cartItems) || count($cartItems) === 0) {
            return redirect()->route('cart.index')->with('error', 'Ваш кошик порожній. Неможливо оформити замовлення.');
        }

        foreach ($cartItems as $item) {
            $productPrice = $item->product->price ?? 0;
            $quantity = $item->quantity ?? 0;
            $totalPrice += $productPrice * $quantity;
        }

        // Створення нового замовлення
        $order = Order::create([
            'user_id' => $isUserLoggedIn ? Auth::id() : null,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address'),
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // Збереження товарів замовлення
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // Очищення кошика
        if ($isUserLoggedIn) {
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            Session::forget('cart');
        }

        return redirect()->route('home')->with('success', 'Дякуємо за ваше замовлення! Ми зв\'яжемося з вами найближчим часом.');
    }
}
