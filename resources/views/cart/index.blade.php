@extends('layouts.guest')

@section('content')
    <div class="container py-12">
        <div class="page-header">
            <h1>Кошик</h1>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (empty($cartItems) || count($cartItems) === 0)
            <div class="bg-white p-6 shadow-md rounded-md text-center">
                <p class="text-lg text-gray-700">Ваш кошик порожній.</p>
                <a href="{{ route('home') }}" class="inline-block mt-4 px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                    Повернутися до покупок
                </a>
            </div>
        @else
            <div class="bg-white shadow-md rounded-md overflow-hidden">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Товар</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ціна</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Кількість</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Разом</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Дії</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($cartItems as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @php
                                            // Цей рядок спрощено, оскільки тепер $item завжди є об'єктом
                                            $product = $item->product;
                                        @endphp
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if ($product && $product->image)
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">?</div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $product->name ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->price ?? '0.00' }} грн</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <form action="{{ route('cart.update') }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-16 border-gray-300 rounded-md shadow-sm text-center">
                                        <button type="submit" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">Оновити</button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ ($product->price ?? 0) * ($item->quantity ?? 0) }} грн
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="text-red-600 hover:text-red-900">Видалити</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="bg-gray-50 p-6 flex justify-between items-center border-t border-gray-200">
                    <a href="{{ route('home') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        Продовжити покупки
                    </a>
                    <span class="text-lg font-bold text-gray-900">Загальна сума: {{ $totalPrice }} грн</span>
                </div>
                <div class="flex justify-end p-6 border-t border-gray-200">
                    <a href="#" class="px-6 py-3 bg-green-500 text-white font-bold rounded-lg hover:bg-green-600 transition">
                        Оформити замовлення
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
