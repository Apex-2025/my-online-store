@props(['product'])

<div class="bg-white rounded-lg shadow-md flex flex-col h-full transition-transform duration-300 hover:scale-[1.03]">
    <a href="{{ route('products.show', $product) }}" class="block">
        @if($product->image)
            {{-- Створюємо контейнер для зображення --}}
            <div class="relative w-full h-48 flex items-center justify-center p-2">

                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="max-w-full max-h-full object-contain">
            </div>
        @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 p-2">
                Без зображення
            </div>
        @endif
    </a>
    <div class="p-4 flex-grow flex flex-col">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
        <p class="text-blue-600 font-bold text-xl mb-2">Ціна: {{ number_format($product->price, 3, '.', ' ') }} грн</p>
        <p class="text-gray-700 text-sm mb-2">{{ $product->description ?? 'Опис відсутній.' }}</p>
        <p class="text-gray-500 text-xs mb-4">Кількість: {{ $product->stock_quantity ?? 'В наявності' }}</p>

        <div class="mt-auto">
            <form action="{{ route('cart.add', $product) }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    Додати в кошик
                </button>
            </form>
        </div>
    </div>
</div>
