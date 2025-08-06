@extends('layouts.guest')

@section('content')
    <div class="container mx-auto py-12">
        <div class="page-header mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Ваш кошик</h1>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if(empty($cartItems))
            <div class="text-center text-gray-500 text-lg">Ваш кошик порожній.</div>
        @else
            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <div class="divide-y divide-gray-200">
                    @foreach ($cartItems as $item)
                        <div class="flex items-center justify-between py-4">
                            <div class="flex items-center">
                                @if ($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-16 w-16 object-cover rounded-md mr-4">
                                @endif
                                <div>
                                    <div class="text-lg font-medium text-gray-900">{{ $item->product->name }}</div>
                                    <div class="text-sm text-gray-500">{{ number_format($item->product->price, 2) }} грн</div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <form action="{{ route('cart.update') }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-16 text-center border-gray-300 rounded-md shadow-sm">
                                    <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">Оновити</button>
                                </form>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                    <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none">Видалити</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-200">
                    <span class="text-2xl font-bold text-gray-900">Загальна сума:</span>
                    <span class="text-2xl font-bold text-gray-900">{{ number_format($totalPrice, 2) }} грн</span>
                </div>

                {{-- Кнопка "Оформити замовлення" --}}
                <div class="mt-8">
                    <a href="{{ route('checkout.index') }}" class="w-full inline-block text-center px-6 py-3 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Оформити замовлення
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
