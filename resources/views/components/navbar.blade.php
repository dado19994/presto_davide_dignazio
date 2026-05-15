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
            <img src="{{ asset('media/logo1.png') }}" alt="VendoHub AI" class="navbar-logo">

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

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('article.featured') ? 'active' : '' }}"
                            href="{{ route('article.featured') }}">
                            In evidenza
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

                    <li class="nav-item dropdown user-menu">

                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">

                            {{ __('ui.hello') }}, {{ Auth::user()->name }}!

                        </a>

                        @php
                            $unreadMessages = \App\Models\Message::with(['sender', 'article'])
                                ->where('receiver_id', Auth::id())
                                ->where('read', false)
                                ->latest()
                                ->take(3)
                                ->get();
                        @endphp

                        <div class="dropdown-menu user-dropdown-menu">
                            <div class="user-dropdown-header">
                                <div class="user-dropdown-avatar">
                                    @if (Auth::user()->avatarUrl())
                                        <img src="{{ Auth::user()->avatarUrl() }}" alt="{{ Auth::user()->name }}">
                                    @else
                                        {{ mb_strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div>
                                    <strong>{{ trim(Auth::user()->name . ' ' . (Auth::user()->surname ?? '')) }}</strong>
                                    <span>{{ Auth::user()->email }}</span>
                                </div>
                            </div>

                            <form class="user-dropdown-search" method="GET" action="{{ route('article.searched') }}">
                                <input type="search" name="query" placeholder="Cerca subito un articolo..."
                                    value="{{ request('query') }}">
                                <button type="submit" aria-label="Cerca">
                                    <i class="fas fa-magnifying-glass"></i>
                                </button>
                            </form>

                            <div class="user-dropdown-grid">
                                <a class="user-dropdown-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}"
                                    href="{{ route('user.dashboard') }}">
                                    <i class="fas fa-chart-line"></i>
                                    <span>
                                        <strong>Dashboard</strong>
                                        <small>Vendite, performance e annunci</small>
                                    </span>
                                </a>

                                <a class="user-dropdown-link {{ request()->routeIs('user.profile') ? 'active' : '' }}"
                                    href="{{ route('user.profile') }}">
                                    <i class="fas fa-user"></i>
                                    <span>
                                        <strong>Profilo utente</strong>
                                        <small>Bio, avatar e zona</small>
                                    </span>
                                </a>

                                <a class="user-dropdown-link {{ request()->routeIs('ai.coach') ? 'active' : '' }}"
                                    href="{{ route('ai.coach') }}">
                                    <i class="fas fa-microchip"></i>
                                    <span>
                                        <strong>AI Listing Coach</strong>
                                        <small>Score e consigli annuncio</small>
                                    </span>
                                </a>

                                <a class="user-dropdown-link {{ request()->routeIs('create.article') ? 'active' : '' }}"
                                    href="{{ route('create.article') }}">
                                    <i class="fas fa-plus"></i>
                                    <span>
                                        <strong>Nuovo annuncio</strong>
                                        <small>Pubblica con anteprima live</small>
                                    </span>
                                </a>

                                <a class="user-dropdown-link {{ request()->routeIs('favorites.*') ? 'active' : '' }}"
                                    href="{{ route('favorites.index') }}">
                                    <i class="fas fa-heart"></i>
                                    <span>
                                        <strong>Preferiti</strong>
                                        <small>Articoli salvati</small>
                                    </span>
                                </a>

                                <a class="user-dropdown-link {{ request()->routeIs('cart.*') ? 'active' : '' }}"
                                    href="{{ route('cart.index') }}">
                                    <i class="fas fa-bag-shopping"></i>
                                    <span>
                                        <strong>Carrello</strong>
                                        <small>{{ count(session('cart', [])) }} articoli</small>
                                    </span>
                                </a>
                            </div>

                            <div class="user-dropdown-chat">
                                <div class="user-dropdown-section-title">
                                    <span>Chat</span>
                                    <strong>{{ $unreadMessages->count() }}</strong>
                                </div>
                                @forelse ($unreadMessages as $message)
                                    @if ($message->article)
                                        <a href="{{ route('article.show', $message->article) }}" class="user-chat-link">
                                            <i class="fas fa-comment-dots"></i>
                                            <span>
                                                <strong>{{ $message->sender?->name ?? 'Utente' }}</strong>
                                                <small>{{ str($message->content)->limit(52) }}</small>
                                            </span>
                                        </a>
                                    @endif
                                @empty
                                    <p class="user-chat-empty mb-0">Nessun nuovo messaggio.</p>
                                @endforelse
                            </div>

                            <div class="user-dropdown-quick">
                                <a href="{{ route('seller.show', Auth::user()) }}">Profilo pubblico</a>
                                <a href="{{ route('article.featured') }}">Annunci in evidenza</a>
                                @if (Auth::user()->is_revisor)
                                    <a href="{{ route('revisor.index') }}">Area revisore</a>
                                @endif
                            </div>

                            <button class="user-dropdown-logout" type="button"
                                onclick="event.preventDefault(); document.querySelector('#form-logout').submit();">
                                <i class="fas fa-arrow-right-from-bracket"></i>
                                {{ __('ui.logout') }}
                            </button>

                            <form action="{{ route('logout') }}" method="POST" class="d-none" id="form-logout">
                                @csrf
                            </form>

                        </div>
                    </li>
                @else
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">

                            {{ __('ui.hello') }}, {{ __('ui.guest') }}!

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

            <div class="navbar-actions">
                <a href="{{ route('cart.index') }}"
                    class="nav-link cart-nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                    <i class="fas fa-bag-shopping"></i>
                    <span>{{ __('ui.cart') }}</span>
                    @if (session('cart') && count(session('cart')) > 0)
                        <span class="navbar-revisor-badge">{{ count(session('cart')) }}</span>
                    @endif
                </a>

                {{-- SEARCH --}}
                <form class="navbar-search navbar-search-collapsed" method="GET" action="{{ route('article.searched') }}">

                    <div class="input-group bg-white rounded overflow-hidden border">

                        <input type="search" name="query" class="form-control border-0" placeholder="{{ __('ui.search') }}..."
                            value="{{ request('query') }}">

                        <button class="btn border-0 bg-white px-3" type="submit" aria-label="Cerca">
                            <i class="fas fa-magnifying-glass"></i>
                        </button>

                    </div>
                </form>

                <div class="navbar-locales">
                    <x-_locale lang="it" />
                    <x-_locale lang="uk" />
                    <x-_locale lang="es" />
                </div>
            </div>

        </div>
    </div>
</nav>
