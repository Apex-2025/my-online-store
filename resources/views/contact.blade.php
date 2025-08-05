@extends('layouts.guest')

@section('content')
    <div class="container py-12">
        <div class="page-header">
            <h1>Контакти</h1>
        </div>
        <div class="bg-white p-6 shadow-md rounded-md">
            <p class="text-lg text-gray-700">
                Якщо у вас є запитання, пропозиції або ви хочете зв'язатися з нами, будь ласка, скористайтеся нашою контактною інформацією.
            </p>
            <ul class="list-disc list-inside mt-4 text-lg text-gray-700">
                <li>Електронна пошта: <a href="mailto:support@my-online-store.local">support@my-online-store.local</a></li>
                <li>Телефон: +38 (099) 123-45-67</li>
                <li>Адреса: м. Дніпро, вул. Центральна, 10</li>
            </ul>
        </div>
    </div>
@endsection
