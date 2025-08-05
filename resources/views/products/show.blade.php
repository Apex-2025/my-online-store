@extends('layouts.guest')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="product-detail-card">
                <div class="grid md:grid-cols-2 gap-8 items-start">
                    <div class="product-image-container">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image-large">
                        @else
                            <div class="no-image-placeholder-large">
                                Без зображення
                            </div>
                        @endif
                    </div>

                    <div class="product-details-content">
                        <h1 class="text-3xl font-bold">{{ $product->name }}</h1>
                        <p class="text-xl text-blue-600 font-semibold my-4">
                            Ціна: {{ number_format($product->price, 3, '.', '') }} грн
                        </p>
                        <p class="text-lg text-gray-700 leading-relaxed mb-6">
                            {{ $product->description }}
                        </p>
                        <div class="text-gray-600 mb-6">
                            <p class="mb-2"><strong>Кількість на складі:</strong> {{ $product->stock }} од.</p>
                            <p><strong>Доступність:</strong> {{ $product->stock > 0 ? 'В наявності' : 'Немає в наявності' }}</p>
                        </div>

                        <div class="flex items-center space-x-4">
                            <button class="add-to-cart-button">Додати в кошик</button>

                            @role('Super Admin|Admin')
                            <a href="{{ route('products.edit', $product->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md font-semibold text-xs uppercase hover:bg-blue-600">
                                Редагувати
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Ви впевнені, що хочете видалити цей продукт?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md font-semibold text-xs uppercase hover:bg-red-700">
                                    Видалити
                                </button>
                            </form>
                            @endrole
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
