@extends('layouts.guest')

@section('content')
    <div class="my-page-section">
        <div class="my-container">
            <div class="my-card">
                <div class="my-card-content">
                    <h2>Привіт, {{ Auth::user()->name }}!</h2>
                    <p>Ви успішно увійшли в систему.</p>
                    <div class="my-action-buttons">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Переглянути продукти
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
