@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Створити новий продукт</h1>

                {{-- Новий компонент для flash-повідомлень --}}
                @if(session('success'))
                    <x-alert type="success" :message="session('success')" />
                @endif

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <x-forms.input name="name" label="Назва продукту" required />

                    <x-forms.textarea name="description" label="Опис" />

                    <x-forms.input name="price" label="Ціна" type="number" step="0.01" min="0" required />

                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Зображення продукту:</label>
                        <input type="file" name="image" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('image')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-forms.select
                        name="category_id"
                        label="Категорія"
                        :options="$categories->pluck('name', 'id')->toArray()"
                        :selected="old('category_id')"
                    />

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Створити
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Скасувати
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
