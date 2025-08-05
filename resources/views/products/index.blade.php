@extends('layouts.guest')

@section('content')
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
            <div class="products-grid">
                @foreach ($products as $product)
                    <div class="product-card">
                        <a href="{{ route('products.show', $product->id) }}" class="product-link">
                            <h3>{{ $product->name }}</h3>
                            <p class="product-price">Ціна: {{ number_format($product->price, 3, '.', '') }}</p>
                            <div class="product-image-wrapper">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image product-image-main">
                                @else
                                    <div class="no-image-placeholder">
                                        <span>Без зображення</span>
                                    </div>
                                @endif
                            </div>
                            <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                            <p class="product-stock">Кількість: {{ $product->stock }}</p>
                        </a>

                        <!-- Форма для додавання товару в кошик -->
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="add-to-cart-button">Додати в кошик</button>
                        </form>

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
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
