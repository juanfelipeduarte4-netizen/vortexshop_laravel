<nav class="vs-admin-nav">
    <div class="container-fluid px-4">
        <div class="row align-items-center py-3">
            <div class="col-auto">
                <a class="vs-admin-brand" href="{{ route('admin.dashboard') }}">Vortex<span>Shop</span> Admin</a>
            </div>
            <div class="col d-flex gap-4 flex-wrap">
                <a class="vs-admin-link {{ request()->routeIs('admin.dashboard') ? 'activo' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="vs-admin-link {{ request()->routeIs('admin.categorias.*') ? 'activo' : '' }}" href="{{ route('admin.categorias.index') }}">Categorías</a>
                <a class="vs-admin-link {{ request()->routeIs('admin.productos.*') ? 'activo' : '' }}" href="{{ route('admin.productos.index') }}">Productos</a>
                <a class="vs-admin-link {{ request()->routeIs('admin.promociones.*') ? 'activo' : '' }}" href="{{ route('admin.promociones.index') }}">Promociones</a>
                <a class="vs-admin-link {{ request()->routeIs('admin.soporte.*') ? 'activo' : '' }}" href="{{ route('admin.soporte.index') }}">Buzón de Sugerencias</a>
                <a class="vs-admin-link {{ request()->routeIs('admin.nosotros') ? 'activo' : '' }}" href="{{ route('admin.nosotros') }}">Nosotros</a>
                <a class="vs-admin-link" href="{{ route('inicio') }}" target="_blank">Ver tienda</a>
            </div>
            <div class="col-auto">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="vs-admin-logout">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</nav>