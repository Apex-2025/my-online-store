@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Компоненти для flash-повідомлень, які ми створили --}}
                    @if(session('success'))
                        <x-alert type="success" :message="session('success')" />
                    @endif
                    @if(session('error'))
                        <x-alert type="error" :message="session('error')" />
                    @endif

                    <h1 class="text-2xl font-bold mb-4">Адміністративна панель</h1>
                    <p>Ласкаво просимо до адмін-панелі! Тут ви можете керувати продуктами, категоріями та замовленнями.</p>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.products.index') }}" class="block p-6 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition">
                            <h2 class="text-xl font-semibold">Керування продуктами</h2>
                            <p class="mt-2 text-sm">Додавайте, редагуйте та видаляйте товари.</p>
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="block p-6 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition">
                            <h2 class="text-xl font-semibold">Керування категоріями</h2>
                            <p class="mt-2 text-sm">Створюйте та організовуйте категорії.</p>
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="block p-6 bg-purple-500 text-white rounded-lg shadow hover:bg-purple-600 transition">
                            <h2 class="text-xl font-semibold">Керування замовленнями</h2>
                            <p class="mt-2 text-sm">Переглядайте та обробляйте замовлення клієнтів.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
