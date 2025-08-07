@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Деталі замовлення #{{ $order->id }}</h1>
                        <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">Повернутися до списку</a>
                    </div>

                    {{-- Компоненти для flash-повідомлень --}}
                    @if(session('success'))
                        <x-alert type="success" :message="session('success')" />
                    @endif
                    @if(session('error'))
                        <x-alert type="error" :message="session('error')" />
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        {{-- Інформація про замовлення --}}
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Інформація про замовлення</h2>
                            <p class="mb-2"><strong>Статус:</strong>
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $order->status }}
                            </span>
                            </p>
                            <p class="mb-2"><strong>Загальна сума:</strong> <span class="font-medium">{{ number_format($order->total_price, 2) }} грн</span></p>
                            <p class="mb-2"><strong>Дата замовлення:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                            <p class="mb-2"><strong>Оновлено:</strong> {{ $order->updated_at->format('d.m.Y H:i') }}</p>
                        </div>

                        {{-- Інформація про клієнта --}}
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Інформація про клієнта</h2>
                            <p class="mb-2"><strong>Ім'я:</strong> {{ $order->user->name ?? $order->customer_name }}</p>
                            <p class="mb-2"><strong>Email:</strong> {{ $order->user->email ?? $order->customer_email }}</p>
                            <p class="mb-2"><strong>Телефон:</strong> {{ $order->customer_phone ?? 'Не вказано' }}</p>
                            <p class="mb-2"><strong>Адреса:</strong> {{ $order->customer_address ?? 'Не вказано' }}</p>
                        </div>
                    </div>

                    {{-- Товари в замовленні --}}
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Товари в замовленні</h2>
                    <div class="overflow-x-auto mb-8 shadow-md rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Продукт</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Кількість</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ціна за одиницю</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Загальна ціна</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->product->name ?? 'Продукт видалено' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($item->price, 2) }} грн</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($item->quantity * $item->price, 2) }} грн</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Форма для зміни статусу замовлення --}}
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Змінити статус замовлення</h2>
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex flex-col sm:flex-row items-start sm:items-end space-y-4 sm:space-y-0 sm:space-x-4">
                        @csrf
                        @method('PUT')

                        <div class="sm:flex-grow">
                            <x-forms.select
                                name="status"
                                label="Статус"
                                :options="['pending' => 'В очікуванні', 'processing' => 'В обробці', 'completed' => 'Виконано', 'cancelled' => 'Скасовано']"
                                :selected="$order->status"
                                class="w-full sm:w-auto"
                            />
                        </div>

                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out w-full sm:w-auto">
                            Оновити статус
                        </button>
                    </form>

                    {{-- Блок для відображення помилок валідації, якщо вони є --}}
                    @if ($errors->has('status'))
                        <div class="mt-4 text-red-500 text-sm">
                            {{ $errors->first('status') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
