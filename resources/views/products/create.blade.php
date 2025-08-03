<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Додати Продукт</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        <h1>Додати Новий Продукт</h1>
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <label for="name">Назва:</label><br>
            <input type="text" id="name" name="name"><br><br>

            <label for="description">Опис:</label><br>
            <textarea id="description" name="description"></textarea><br><br>

            <label for="price">Ціна:</label><br>
            <input type="text" id="price" name="price"><br><br>

            <label for="stock">Кількість:</label><br>
            <input type="number" id="stock" name="stock"><br><br>

            <button type="submit">Зберегти Продукт</button>
        </form>
        <a href="{{ route('products.index') }}">Повернутись до списку</a>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
