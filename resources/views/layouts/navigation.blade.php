<nav>
    <div class="logo">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/my_logo.png') }}" alt="Логотип" class="h-10">
        </a>
    </div>

    <ul>
        {{-- Посилання на адмін-панель, видиме тільки для адміністраторів --}}
        @can('admin')
            <li><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active-nav-link' : '' }}">Адмін-панель</a></li>
        @endcan

        <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active-nav-link' : '' }}">Головна</a></li>

        {{-- Dropdown for Categories --}}
        <li class="has-dropdown">
            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active-nav-link' : '' }}">Категорії</a>
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

        <li><a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active-nav-link' : '' }}">Про нас</a></li>
        <li><a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active-nav-link' : '' }}">Контакти</a></li>
        <li>
            <a href="{{ route('cart.index') }}" class="relative inline-flex items-center nav-link {{ request()->routeIs('cart.index') ? 'active-nav-link' : '' }}">
                Кошик
                @if(isset($cartItemCount) && $cartItemCount > 0)
                    <span class="ml-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">
                {{ $cartItemCount }}
            </span>
                @endif
            </a>
        </li>

        @auth
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();" class="nav-link">
                        Вийти
                    </a>
                </form>
            </li>
        @else
            <li><a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active-nav-link' : '' }}">Увійти</a></li>
            <li><a href="{{ route('register') }}" class="nav-link {{ request()->routeIs('register') ? 'active-nav-link' : '' }}">Зареєструватись</a></li>
        @endauth
    </ul>
</nav>
