<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category; // Додано
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Додано

class AdminProductController extends Controller
{
    /**
     * Відображає список усіх продуктів.
     */
    public function index()
    {
        $products = Product::with('category')->paginate(10); // Завантажуємо категорію продукту
        return view('admin.products.index', compact('products'));
    }

    /**
     * Відображає форму для створення нового продукту.
     */
    public function create()
    {
        $categories = Category::all(); // Отримуємо всі категорії для вибору
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Зберігає новий продукт.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'nullable|exists:categories,id', // Валідація для категорії
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/products'); // Зберігаємо в public/products
            $imagePath = str_replace('public/', '', $imagePath); // Отримуємо шлях без "public/"
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Продукт успішно додано!');
    }

    /**
     * Відображає форму для редагування продукту.
     */
    public function edit(Product $product)
    {
        $categories = Category::all(); // Отримуємо всі категорії для вибору
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Оновлює існуючий продукт.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // Видаляємо старе зображення, якщо воно існує
            if ($imagePath) {
                Storage::delete('public/' . $imagePath);
            }
            $imagePath = $request->file('image')->store('public/products');
            $imagePath = str_replace('public/', '', $imagePath);
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Продукт успішно оновлено!');
    }

    /**
     * Видаляє продукт.
     */
    public function destroy(Product $product)
    {
        // Видаляємо зображення, якщо воно існує
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Продукт успішно видалено.');
    }
}
