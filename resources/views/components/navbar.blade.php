{{-- <nav class="navbar navbar-expand-lg navbar-dark custom-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('homepage') }}">Story1</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('homepage') ? 'active' : '' }}"
                        href="{{ route('homepage') }}">{{ __('ui.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('article.index') ? 'active' : '' }}"
                        href="{{ route('article.index') }}">{{ __('ui.allArticles') }}</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('byCategory') ? 'active' : '' }}"
                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('ui.categories') }}
                    </a>
                    <ul class="dropdown-menu">
                        @foreach ($categories ?? [] as $category)
                            <li><a href="{{ route('byCategory', ['category' => $category]) }}"
                                    class="dropdown-item text-capitalize">{{ $category->name }}</a>
                            </li>
                            @if (!$loop->last)
                                <hr class="dropdown-divider">
                            @endif
                        @endforeach
                    </ul>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('create.article') ? 'active' : '' }}"
                            href="{{ route('create.article') }}">{{ __('ui.createArticle') }}</a>
                    </li>
                    @if (Auth::user()->is_revisor)
                        <li class="nav-item">
                            <a class="nav-link navbar-revisor-link {{ request()->routeIs('revisor.*') ? 'active' : '' }}"
                                href="{{ route('revisor.index') }}">{{ __('ui.revisorArea') }}
                                <span class="navbar-revisor-badge">{{ App\Models\Article::toBeRevisionedCount() }}</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Ciao, {{ Auth::user()->name }}!
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.querySelector('#form-logout').submit();">Logout</a>
                            </li>
                            <form action="{{ route('logout') }}" method="POST" class="d-none" id="form-logout">@csrf
                            </form>
                        </ul>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Ciao, utente!
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('login') }}">Accedi</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Registrati</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
            <form class="d-flex ms-lg-3 col-12 col-lg-3" method="GET" action="{{ route('article.searched') }}">
                <div class="input-group bg-white rounded overflow-hidden border">
                    <input type="search" name="query" class="form-control border-0" placeholder="Cerca..."
                        value="{{ request('query') }}">

                    <button class="btn border-0 bg-white px-3" type="submit">
                        🔍
                    </button>
                </div>
            </form>
            <x-_locale lang="it"/>
            <x-_locale lang="uk"/>
            <x-_locale lang="es"/>
        </div>
    </div>
</nav> --}}

<nav class="navbar navbar-expand-lg navbar-dark custom-navbar sticky-top">
    <div class="container">

        <a class="navbar-brand fw-bold" href="{{ route('homepage') }}">
            VendoHub AI
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                {{-- HOME --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('homepage') ? 'active' : '' }}"
                        href="{{ route('homepage') }}">
                        {{ __('ui.home') }}
                    </a>
                </li>

                {{-- ALL ARTICLES --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('article.index') ? 'active' : '' }}"
                        href="{{ route('article.index') }}">
                        {{ __('ui.allArticles') }}
                    </a>
                </li>

                {{-- CATEGORIES --}}
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle {{ request()->routeIs('byCategory') ? 'active' : '' }}"
                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('ui.categories') }}
                    </a>

                    <ul class="dropdown-menu">

                        @foreach ($categories ?? [] as $category)
                            <li>
                                <a href="{{ route('byCategory', ['category' => $category]) }}"
                                    class="dropdown-item text-capitalize">
                                    {{ $category->name }}
                                </a>
                            </li>

                            @if (!$loop->last)
                                <hr class="dropdown-divider">
                            @endif
                        @endforeach

                    </ul>
                </li>

                {{-- AUTH --}}
                @auth

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('create.article') ? 'active' : '' }}"
                            href="{{ route('create.article') }}">
                            {{ __('ui.createArticle') }}
                        </a>
                    </li>

                    @if (Auth::user()->is_revisor)
                        <li class="nav-item">
                            <a class="nav-link navbar-revisor-link {{ request()->routeIs('revisor.*') ? 'active' : '' }}"
                                href="{{ route('revisor.index') }}">

                                {{ __('ui.revisorArea') }}

                                <span class="navbar-revisor-badge">
                                    {{ App\Models\Article::toBeRevisionedCount() }}
                                </span>

                            </a>
                        </li>
                    @endif

                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">

                            {{ __('ui.hello') }}, {{ Auth::user()->name }}!

                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.querySelector('#form-logout').submit();">
                                    {{ __('ui.logout') }}
                                </a>
                            </li>

                            <form action="{{ route('logout') }}" method="POST" class="d-none" id="form-logout">
                                @csrf
                            </form>

                        </ul>
                    </li>
                @else
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">

                            {{ __('ui.hello') }}, utente!

                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <a class="dropdown-item" href="{{ route('login') }}">
                                    {{ __('ui.login') }}
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('register') }}">
                                    {{ __('ui.register') }}
                                </a>
                            </li>

                        </ul>
                    </li>

                @endauth

            </ul>

            {{-- SEARCH --}}
            <form class="d-flex ms-lg-3 col-12 col-lg-3" method="GET" action="{{ route('article.searched') }}">

                <div class="input-group bg-white rounded overflow-hidden border">

                    <input type="search" name="query" class="form-control border-0" placeholder="Cerca..."
                        value="{{ request('query') }}">

                    <button class="btn border-0 bg-white px-3" type="submit">
                        🔍
                    </button>

                </div>
            </form>

            {{-- LANGUAGE SWITCHER --}}
            <x-_locale lang="it" />
            <x-_locale lang="uk" />
            <x-_locale lang="es" />

        </div>
    </div>
</nav>
