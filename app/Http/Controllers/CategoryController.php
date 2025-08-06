<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Відображає сторінку з усіма категоріями верхнього рівня.
     */
    public function index()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Відображає конкретну категорію та її дочірні категорії.
     */
    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $subcategories = $category->children;
        $products = $category->products;

        return view('categories.show', compact('category', 'subcategories', 'products'));
    }

    /**
     * Відображає сторінку для створення нової категорії.
     */
    public function create()
    {
        $categories = Category::all();
        return view('categories.create', compact('categories'));
    }

    /**
     * Зберігає нову категорію в базі даних.
     */
    public function store(Request $request)
    {
        // Валідація вхідних даних
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $slug = Str::slug($request->name, '-');

        // Перевірка на унікальність slug
        $originalSlug = $slug;
        $count = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $imagePath = null;
        // Обробка завантаження зображення
        if ($request->hasFile('image')) {
            // Зберігаємо зображення в папку 'public/categories'
            // Laravel автоматично додасть унікальне ім'я файлу
            $imagePath = $request->file('image')->store('public/categories');
            // Отримуємо шлях, який можна використовувати в asset()
            $imagePath = str_replace('public/', '', $imagePath);
        }

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'parent_id' => $request->parent_id,
            'image' => $imagePath, // <-- Зберігаємо шлях до зображення
        ]);

        return redirect()->route('categories.create')
            ->with('success', 'Категорію успішно додано!');
    }
}
