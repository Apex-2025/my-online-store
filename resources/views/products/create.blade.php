<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додати новий продукт</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<nav>
    <div class="logo">
        <a href="{{ url('/') }}"><img src="{{ asset('images/my_logo.png') }}" alt="Логотип"></a>
    </div>
    <ul>
        <li><a href="{{ route('dashboard') }}">Адмін панель</a></li>
        <li><a href="{{ route('products.index') }}">Продукти</a></li>
        @auth
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        Вийти
                    </a>
                </form>
            </li>
        @else
            <li><a href="{{ route('login') }}">Увійти</a></li>
            <li><a href="{{ route('register') }}">Зареєструватись</a></li>
        @endauth
    </ul>
</nav>

<div class="page-header">
    <h1>Додати новий продукт</h1>
    <a href="{{ route('products.index') }}">Повернутися до списку</a>
</div>

<div class="container">
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
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

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
