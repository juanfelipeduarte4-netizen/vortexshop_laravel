@extends('layouts.app')

@section('titulo', '- Catálogo')

@section('contenido')
<div class="container-fluid px-4 py-4">
    <div class="row g-4">

        {{-- FILTROS --}}
        <div class="col-12 col-lg-3">
            <h5 class="vs-section-title" style="font-size:1.3rem;">Filtros</h5>
            <div class="inf-card">
                <form method="GET" action="{{ route('catalogo.index') }}">
                    <div class="mb-3">
                        <label class="vs-form-label">Buscar</label>
                        <input type="text" name="q" class="vs-form-control" value="{{ request('q') }}" placeholder="Nombre o descripción...">
                    </div>

                    <div class="mb-3">
                        <label class="vs-form-label">Categoría</label>
                        <select name="categoria" class="vs-form-control">
                            <option value="">Todas</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->IdCategoria }}" {{ request('categoria') == $categoria->IdCategoria ? 'selected' : '' }}>
                                    {{ $categoria->Nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if($tallas->count())
                    <div class="mb-3">
                        <label class="vs-form-label">Talla</label>
                        <select name="talla" class="vs-form-control">
                            <option value="">Todas</option>
                            @foreach($tallas as $talla)
                                <option value="{{ $talla }}" {{ request('talla') == $talla ? 'selected' : '' }}>{{ $talla }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    @if($colores->count())
                    <div class="mb-3">
                        <label class="vs-form-label">Color</label>
                        <select name="color" class="vs-form-control">
                            <option value="">Todos</option>
                            @foreach($colores as $color)
                                <option value="{{ $color }}" {{ request('color') == $color ? 'selected' : '' }}>{{ $color }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="vs-form-label">Precio mín.</label>
                            <input type="number" name="precio_min" class="vs-form-control" value="{{ request('precio_min') }}">
                        </div>
                        <div class="col-6">
                            <label class="vs-form-label">Precio máx.</label>
                            <input type="number" name="precio_max" class="vs-form-control" value="{{ request('precio_max') }}">
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-vs w-100" style="border:none;">Filtrar</button>
                    <a href="{{ route('catalogo.index') }}" class="btn-secondary-vs w-100 mt-2 text-center d-block">Limpiar</a>
                </form>
            </div>
        </div>

        {{-- RESULTADOS --}}
        <div class="col-12 col-lg-9">
            <p class="vs-section-sub">{{ $productos->total() }} producto(s) encontrado(s)</p>

            <div class="row g-3">
                @forelse($productos as $producto)
                    @php $img = $producto->imagenes->first() ?? null; @endphp
                    <div class="col-6 col-md-4">
                        <div class="vs-prod-card h-100 d-flex flex-column">
                            <div class="vs-prod-img" style="{{ $img ? 'background-image:url(' . asset('storage/'.$img->Ruta) . '); background-size:cover; background-position:center;' : '' }}"></div>
                            <div class="vs-prod-body flex-grow-1 d-flex flex-column">
                                <p class="vs-prod-cat">{{ $producto->categoria->Nombre ?? 'Sin categoría' }}</p>
                                <p class="vs-prod-name">{{ $producto->Nombre }}</p>
                                @if($producto->tieneDescuento())
                                    <p class="vs-prod-price">
                                        ${{ number_format($producto->precioFinal(), 0, ',', '.') }}
                                        <s>${{ number_format($producto->Precio, 0, ',', '.') }}</s>
                                    </p>
                                @else
                                    <p class="vs-prod-price">${{ number_format($producto->Precio, 0, ',', '.') }}</p>
                                @endif
                                <div class="vs-prod-footer mt-auto">
                                    <a href="{{ route('catalogo.show', $producto->IdProducto) }}" class="btn-secondary-vs" style="padding:6px 14px; font-size:11px;">Ver detalle</a>
                                    @if($producto->tieneDescuento())
                                        <span class="vs-badge">-{{ rtrim(rtrim(number_format($producto->promocionVigente()->PorcentajeDescuento, 2), '0'), '.') }}%</span>
                                    @endif
                                    <form action="{{ route('carrito.agregar', $producto->IdProducto) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="cantidad" value="1">
                                        <button type="submit" class="vs-btn-carrito">+ Carrito</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="vs-section-sub" style="text-align:center; padding:3rem 0;">No se encontraron productos con esos filtros.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $productos->links() }}
            </div>
        </div>

    </div>
</div>
@endsection