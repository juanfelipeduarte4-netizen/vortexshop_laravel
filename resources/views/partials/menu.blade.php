<header class="vs-navbar">
    <div class="container-fluid px-4">
        <div class="row align-items-center py-3">

            <div class="col-auto">
                <a href="{{ route('inicio') }}" class="vs-logo" style="text-decoration:none;">Vortex<span>Shop</span></a>
            </div>

            <div class="col d-flex justify-content-center gap-4">
                <a href="{{ route('inicio') }}" class="vs-nav-link">Inicio</a>
                <a href="{{ route('catalogo.index') }}" class="vs-nav-link">Catálogo</a>
                <a href="{{ route('nosotros.index') }}" class="vs-nav-link">Nosotros</a>
                <a href="{{ route('soporte.create') }}" class="vs-nav-link">Buzon de Sugerencias</a>
            </div>

            <div class="col-auto d-flex align-items-center gap-3">
                <a href="{{ route('carrito.index') }}" class="vs-nav-link position-relative" title="Mi carrito" style="font-size:16px;">
                    🛒
                    @if ($cantidadCarrito > 0)
                        <span class="badge bg-primary rounded-pill position-absolute top-0 start-100 translate-middle" style="font-size:9px;">
                            {{ $cantidadCarrito }}
                        </span>
                    @endif
                </a>

                @auth
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn-ingresar-nav" style="border:none;">Cerrar Sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="vs-nav-link">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="btn-ingresar-nav">Registrarse</a>
                @endauth
            </div>

        </div>
    </div>
</header>
