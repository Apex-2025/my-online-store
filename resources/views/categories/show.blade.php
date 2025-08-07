@extends('layouts.guest')

@section('content')
    <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">{{ $category->name }}</h1>

        @if($subcategories->isNotEmpty())
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Підкатегорії</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-12">
                @foreach($subcategories as $subcategory)
                    <a href="{{ route('categories.show', $subcategory->slug) }}" class="block overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                        @if($subcategory->image)
                            <img src="{{ asset('storage/' . $subcategory->image) }}" alt="{{ $subcategory->name }}" class="w-full h-40 object-cover">
                        @else
                            <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-500">
                                Без зображення
                            </div>
                        @endif
                        <div class="p-4 text-center">
                            <h2 class="text-lg font-medium text-gray-900">{{ $subcategory->name }}</h2>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        @if($products->isNotEmpty())
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Товари в категорії</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
{{--                    <a href="{{ route('products.show', $product) }}" class="block overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">--}}
{{--                        @if($product->image)--}}
{{--                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">--}}
{{--                        @else--}}
{{--                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">--}}
{{--                                Без зображення--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                        <div class="p-4">--}}
{{--                            <h3 class="text-lg font-medium text-gray-900">{{ $product->name }}</h3>--}}
{{--                            <p class="text-sm text-gray-600">{{ number_format($product->price, 2) }} грн</p>--}}
{{--                        </div>--}}
{{--                    </a>--}}
                @endforeach
            </div>
        @elseif($subcategories->isEmpty())
            <div class="text-center text-gray-500 text-lg">У цій категорії немає підкатегорій чи товарів.</div>
        @endif
    </div>
@endsection
