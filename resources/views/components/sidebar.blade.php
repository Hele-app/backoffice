<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidebar">
    <div class="scroll-wrapper scrollbar-inner" style="position: relative;">
        <div class="scrollbar-inner scroll-content" style="height: 1024px; margin-bottom: 0px; margin-right: 0px; max-height: none;">
            <!-- Brand -->
            <div class="sidenav-header  align-items-center">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>

                @auth
                <h6 class="navbar-heading p-0 text-muted">
                    {{ Auth::user()->email }}
                </h6>
                @endauth
                <hr class="my-3" />
            </div>
            <div class="navbar-inner">
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <!-- Nav items -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">{{ __('Tableau de bord') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('professionals.index') }}">{{ __('Professionnels') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('youngs.index') }}">{{ __('Jeunes') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('establishments.index') }}">{{ __('Etablissements') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('map.index') }}">{{ __('Points d\'intérêt') }}</a>
                        </li>
                    </ul>
                    <hr class="my-3" />
                    <ul class="navbar-nav">
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Connexion') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Inscription') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Deconnexion') }}

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </a>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
