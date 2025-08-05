<nav>
    <div class="logo">
        <a href="{{ route('home') }}">
            <!-- Використовуємо route('home') для посилання на головну сторінку -->
            <span class="text-white text-lg font-bold">Мій Магазин</span>
        </a>
    </div>

    <ul>
        <!-- Використовуємо route('home') для посилання на продукти -->
        <li><a href="{{ route('home') }}">Продукти</a></li>
        <li><a href="{{ route('about') }}">Про нас</a></li>
        <li><a href="{{ route('contact') }}">Контакти</a></li>
        <li><a href="{{ route('cart.index') }}">Кошик</a></li>
        @auth
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();">
                        Вийти
                    </a>
                </form>
            </li>
        @else
            <li><a href="{{ route('login') }}">Увійти</a></li>
            <li><a href="{{ route('register') }}">Зареєструватись</a></li>
        @endauth
    </ul>
</nav>
