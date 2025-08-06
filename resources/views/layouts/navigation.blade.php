<nav>
    <div class="logo">
        <a href="{{ route('home') }}">
            <!-- Використовуємо route('home') для посилання на головну сторінку -->
            <img src="{{ asset('images/my_logo.png') }}" alt="Логотип" class="h-10">
        </a>
    </div>

    <ul>
        <!-- Використовуємо route('home') для посилання на продукти -->
        <li><a href="{{ route('home') }}">Продукти</a></li>

        {{-- Dropdown for Categories --}}
        <li class="has-dropdown">
            <a href="{{ route('categories.index') }}">Категорії</a> {{-- Посилання на сторінку всіх категорій --}}
            <ul class="dropdown-menu">
                @foreach($categoriesNav as $category)
                    <li>
                        <a href="{{ route('categories.show', $category->slug) }}">{{ $category->name }}</a>
                        @if($category->children->isNotEmpty())
                            <ul class="submenu">
                                @foreach($category->children as $child)
                                    <li><a href="{{ route('categories.show', $child->slug) }}">{{ $child->name }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </li>

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

