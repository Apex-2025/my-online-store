<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="my-page-section">
        <div class="my-container">
            <div class="my-card">
                <div class="my-card-content">
                    {{ __("Ви увійшли в систему!") }}
                    @role('Super Admin|Admin')
                    <div class="my-action-buttons">
                        <p>
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Керування Продуктами
                            </a>
                        </p>
                    </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
