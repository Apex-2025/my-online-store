<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список Продуктів</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<nav>
    <div class="logo">
        <a href="{{ url('/') }}"><img src="{{ asset('images/my_logo.png') }}" alt="Логотип"></a>
    </div>
    <ul>
        <li><a href="{{ route('dashboard') }}">Дашборд</a></li>
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
    <h1>Список Продуктів</h1>
    @role('Super Admin|Admin')
    <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
        Додати новий продукт
    </a>
    @endrole
</div>

<div class="container">
    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

        <h2>Наші Продукти:</h2>
        @if ($products->isEmpty())
            <p>Наразі немає доданих продуктів.</p>
        @else
            <div class="products-grid"> {{-- Додаємо контейнер для сітки --}}
                @foreach ($products as $product)
                    <div class="product-card"> {{-- Кожен продукт тепер картка --}}
                        <h3>{{ $product->name }}</h3>
                        <p class="product-price">Ціна: {{ number_format($product->price, 3, '.', '') }}</p>
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                        @else
                            <p class="no-image-placeholder">Без зображення</p>
                        @endif
                        <p class="product-description">{{ Str::limit($product->description, 100) }}</p> {{-- Обмежуємо опис --}}
                        <p class="product-stock">Кількість: {{ $product->stock }}</p>


                        @role('Super Admin|Admin')
                        <div class="product-actions mt-2">
                            <a href="{{ route('products.edit', $product->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Редагувати
                            </a>

                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Ви впевнені, що хочете видалити цей продукт?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150 ml-2">
                                    Видалити
                                </button>
                            </form>
                        </div>
                        @endrole
                        {{-- <a href="{{ route('products.show', $product->id) }}" class="details-button">Детальніше</a> --}}
                    </div>
                @endforeach
            </div>
        @endif
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
