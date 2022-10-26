<header>
    <h1>FLY Car</h1>
    <nav>
        <ul>
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Inicio</a></li>
            <li><a href="{{ route('vehicles.index') }}"
                    class="{{ request()->routeIs('vehicles.*') ? 'active' : '' }}">Vehículos</a></li>
            @can('admin.users.index')
                <li><a href="{{ route('admin.users.index') }}"
                        class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Usuarios</a></li>
            @endcan
            {{-- <li><a href="{{ route('offers.index') }}" class="{{ request()->routeIs('offers.*') ? 'active' : '' }}">Ofertas</a></li> --}}
        </ul>
    </nav>
</header>
