@extends('layouts.guest')

@section('content')
    <div class="container mx-auto py-12">
        <div class="page-header mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Оформлення замовлення</h1>
        </div>

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Форма для введення даних користувача --}}
            <div class="lg:col-span-2 bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Ваші дані</h2>
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Поле "Ім'я" --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Ім'я</label>
                            <input type="text" id="name" name="name" value="{{ $user->name ?? old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Поле "Електронна пошта" --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Електронна пошта</label>
                            <input type="email" id="email" name="email" value="{{ $user->email ?? old('email') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Поле "Номер телефону" --}}
                        <div class="md:col-span-2">
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Номер телефону</label>
                            <input type="text" id="phone_number" name="phone_number" value="{{ $user->phone_number ?? old('phone_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            @error('phone_number')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Поле "Адреса доставки" --}}
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700">Адреса доставки</label>
                            <textarea id="address" name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('address') }}</textarea>
                            @error('address')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Підтвердження замовлення --}}
                    <div class="mt-6">
                        <button type="submit" class="w-full px-4 py-2 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Підтвердити замовлення
                        </button>
                    </div>
                </form>
            </div>

            {{-- Підсумок замовлення --}}
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Ваше замовлення</h2>
                <div class="divide-y divide-gray-200">
                    @foreach ($cartItems as $item)
                        <div class="flex items-center justify-between py-4">
                            <div class="flex items-center">
                                @if ($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-12 w-12 object-cover rounded-md mr-4">
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->quantity }} x {{ number_format($item->product->price, 2) }} грн</div>
                                </div>
                            </div>
                            <div class="text-sm font-medium text-gray-900">
                                {{ number_format($item->product->price * $item->quantity, 2) }} грн
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200">
                    <span class="text-xl font-bold text-gray-900">Загальна сума:</span>
                    <span class="text-xl font-bold text-gray-900">{{ number_format($totalPrice, 2) }} грн</span>
                </div>
            </div>
        </div>
    </div>
@endsection
