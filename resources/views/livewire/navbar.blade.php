<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/" style="padding-left: 50px">TEST SAGARA</a>
    <button class="navbar-toggler" style="margin-right: 50px" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{ $currentRoute == 'import' ? 'active' : '' }}">
                <a class="nav-link" wire:navigate href="{{ route('import') }}">Import</a>
            </li>
            <li class="nav-item {{ $currentRoute == 'provinsi' ? 'active' : '' }}">
                <a class="nav-link" wire:navigate href="{{ route('provinsi') }}">Provinsi</a>
            </li>
            <li class="nav-item {{ $currentRoute == 'kabupaten' ? 'active' : '' }}">
                <a class="nav-link" wire:navigate href="{{ route('kabupaten') }}">Kabupaten</a>
            </li>
        </ul>
    </div>
</nav>
