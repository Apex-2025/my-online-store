<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Список Продуктів</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
    <img src="{{ asset('images/my_logo.png') }}" alt="Логотип" style="width: 100px; height: auto;">
        <h1>Список Продуктів</h1>
        <a href="{{ route('products.create') }}">Додати новий продукт</a>
        <p>Тут буде список усіх продуктів...</p>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
