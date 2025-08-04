<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Валідація даних
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Макс. 2MB
        ]);

        // 2. Обробка завантаження зображення
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $imagePath = $request->file('image')->storeAs('products', $imageName, 'public');
        }

        // 3. Створення нового продукту
        $product = Product::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'stock' => $validatedData['stock'],
            'image' => $imagePath, // Зберігаємо шлях до зображення у базі даних
        ]);
        // 4. Перенаправлення користувача
        return redirect()->route('products.index')->with('success', 'Продукт успішно додано!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product) // Змінено: Product $product
    {
        // Для show методу ми можемо відобразити деталі одного продукту.
        // Це поки не реалізовано, але аргумент Product $product вже готовий.
        // return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product) // Змінено: Product $product
    {
        // Тепер $product вже містить знайдений продукт за ID з URL
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product) // Змінено: Product $product
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Макс. 2MB
        ]);

        // Обробка оновлення зображення
        if ($request->hasFile('image')) {
            // Видаляємо старе зображення, якщо воно існує
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imageName = time() . '.' . $request->image->extension();
            $imagePath = $request->file('image')->storeAs('products', $imageName, 'public');
            $validatedData['image'] = $imagePath;
        } else {
            // Якщо нове зображення не завантажено, зберігаємо існуючий шлях
            $validatedData['image'] = $product->image;
        }

        $product->update($validatedData); // Оновлюємо продукт

        return redirect()->route('products.index')->with('success', 'Продукт успішно оновлено!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product) // Змінено: Product $product
    {
        // Видаляємо зображення, якщо воно існує
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete(); // Видаляємо продукт з бази даних

        return redirect()->route('products.index')->with('success', 'Продукт успішно видалено!');
    }
}
