@extends('layouts.guest')

@section('content')
    <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Категорії</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="block overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-500">
                            Без зображення
                        </div>
                    @endif
                    <div class="p-4 text-center">
                        <h2 class="text-lg font-medium text-gray-900">{{ $category->name }}</h2>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
