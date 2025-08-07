@extends('layouts.app')

@section('title', 'Редагувати Продукт')

@section('content')
    <div class="page-header">
        <h1>Редагувати Продукт: {{ $product->name }}</h1>
        <a href="{{ route('products.index') }}">Повернутися до списку</a>
    </div>

    <div class="container">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Назва Продукту:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                @error('name')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Опис:</label>
                <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
                @error('description')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Ціна:</label>
                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.001" min="0" required>
                @error('price')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="stock">Кількість на складі:</label>
                <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required>
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
                @if ($product->image)
                    <p>Поточне зображення:</p>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 150px; height: auto; margin-top: 10px;">
                @else
                    <p>Зображення відсутнє.</p>
                @endif
            </div>

            <div class="form-group">
                <button type="submit">Оновити Продукт</button>
            </div>
        </form>
    </div>
@endsection
