<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додати новий продукт</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<x-app-layout>
    <div class="page-header">
        <h1>Додати новий продукт</h1>
        <a href="{{ route('admin.products.index') }}">Повернутися до списку</a>
    </div>

    <div class="container">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Назва Продукту:</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Опис:</label>
                <textarea id="description" name="description">{{ old('description') }}</textarea>
                @error('description')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Ціна:</label>
                <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.001" min="0" required>
                @error('price')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="stock">Кількість на складі:</label>
                <input type="number" id="stock" name="stock" value="{{ old('stock') }}" min="0" required>
                @error('stock')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Зображення:</label>
                <input type="file" id="image" name="image" accept="image/*">
                @error('image')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit">Додати Продукт</button>
            </div>
        </form>
    </div>
</x-app-layout>
</body>
</html>
