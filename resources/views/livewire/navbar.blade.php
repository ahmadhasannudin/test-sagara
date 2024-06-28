<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/" style="padding-left: 50px">TEST SAGARA</a>
    <button class="navbar-toggler" style="margin-right: 50px" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    @guest
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="padding-right: 50px;">
                <li class="nav-item {{ $currentRoute == 'login' ? 'active' : '' }}">
                    <a class="nav-link" wire:navigate href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item {{ $currentRoute == 'register' ? 'active' : '' }}">
                    <a class="nav-link" wire:navigate href="{{ route('register') }}">Register</a>
                </li>
            </ul>
        </div>
    @endguest

    @auth
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ $currentRoute == 'import' ? 'active' : '' }}">
                    <a class="nav-link" wire:navigate href="{{ route('import') }}">Import</a>
                </li>
                <li class="nav-item {{ $currentRoute == 'service' ? 'active' : '' }}">
                    <a class="nav-link" wire:navigate href="{{ route('service') }}">Service</a>
                </li>
                <li class="nav-item {{ $currentRoute == 'tag' ? 'active' : '' }}">
                    <a class="nav-link" wire:navigate href="{{ route('tag') }}">Tag</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown" style="padding-right: 50px">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ auth()->user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="nav-link" wire:navigate href="{{ route('logout') }}">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    @endauth
</nav>
