@extends('layouts.guest')

@section('content')
    <div class="page-header">
        <h1>Список Продуктів</h1>
        @role('Super Admin|Admin')
        @endrole
    </div>

    <div class="container">
        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <h2>Наші Продукти:</h2>
        @if ($products->isEmpty())
            <p>Наразі немає доданих продуктів.</p>
        @else
            <div class="products-grid">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @endif
    </div>
@endsection
