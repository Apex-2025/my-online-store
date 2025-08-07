@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Редагувати категорію: {{ $category->name }}</h1>

                {{-- Новий компонент для flash-повідомлень --}}
                @if(session('success'))
                    <x-alert type="success" :message="session('success')" />
                @endif

                <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <x-forms.input name="name" label="Назва категорії" :value="$category->name" required />

                    <x-forms.select
                        name="parent_id"
                        label="Батьківська категорія"
                        :options="$categories->pluck('name', 'id')->toArray()"
                        :selected="old('parent_id', $category->parent_id)"
                    />

                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Зображення категорії:</label>
                        @if($category->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="h-20 w-20 object-cover rounded">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('image')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Оновити
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Скасувати
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
