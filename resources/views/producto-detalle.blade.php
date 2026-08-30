@extends('layouts.app')

@section('titulo', '- ' . $producto->Nombre)

@section('contenido')

@php
    $imagen = $producto->imagenes->first();
    $stockTotal = $producto->inventario->sum('Stock');
@endphp

<div class="container-fluid px-4 py-4">
    <div class="row g-4">
        <div class="col-12 col-md-6">
            <div class="vs-prod-img" id="imagen-principal" style="height:420px; border-radius:4px; {{ $imagen ? 'background-image:url('.asset('storage/'.$imagen->Ruta).'); background-size:cover; background-position:center;' : '' }}">
                @unless($imagen)
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <span style="color:var(--ghost); font-size:12px; letter-spacing:2px; text-transform:uppercase;">Sin imagen</span>
                    </div>
                @endunless
            </div>

            @if($producto->imagenes->count() > 1)
                <div class="d-flex gap-2 mt-2">
                    @foreach($producto->imagenes as $img)
                        <img src="{{ asset('storage/' . $img->Ruta) }}"
                             class="vs-thumb-selector {{ $loop->first ? 'activa' : '' }}"
                             style="width:56px; height:56px; object-fit:cover; border-radius:3px; cursor:pointer; border:2px solid {{ $loop->first ? 'var(--blue)' : 'var(--border)' }};"
                             onclick="document.getElementById('imagen-principal').style.backgroundImage = 'url({{ asset('storage/'.$img->Ruta) }})';
                                      document.querySelectorAll('.vs-thumb-selector').forEach(t => t.style.borderColor = 'var(--border)');
                                      this.style.borderColor = 'var(--blue)';">
                    @endforeach
                </div>
            @endif
        </div>

        <div class="col-12 col-md-6">
            <p class="vs-prod-cat">{{ $producto->categoria->Nombre ?? 'Sin categoría' }}</p>
            <h1 class="vs-hero-title" style="font-size:2.2rem; text-align:left;">{{ $producto->Nombre }}</h1>
            <p style="color:var(--muted); font-size:14px; line-height:1.7; margin:1rem 0;">{{ $producto->Descripcion }}</p>

            @if($producto->tieneDescuento())
                <p class="vs-prod-price" style="font-size:1.8rem;">
                    ${{ number_format($producto->precioFinal(), 0, ',', '.') }}
                    <s style="font-size:1.1rem;">${{ number_format($producto->Precio, 0, ',', '.') }}</s>
                    <span class="vs-badge" style="vertical-align:middle;">-{{ rtrim(rtrim(number_format($producto->promocionVigente()->PorcentajeDescuento, 2), '0'), '.') }}%</span>
                </p>
            @else
                <p class="vs-prod-price" style="font-size:1.8rem;">${{ number_format($producto->Precio, 0, ',', '.') }}</p>
            @endif

            @if($producto->inventario->isEmpty())
                <p class="vs-section-sub">No hay variantes disponibles para este producto.</p>
            @else
                <form action="{{ route('carrito.agregar', '__ID__') }}" method="POST" id="form-agregar-carrito">
                    @csrf

                    <p class="vs-form-label" style="margin-top:1rem;">Color y talla</p>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @foreach($producto->inventario as $variante)
                            <label class="vs-variante-opcion {{ $variante->Stock < 1 ? 'agotada' : '' }}">
                                <input type="radio" name="id_inventario" value="{{ $variante->IdInventario }}"
                                       data-stock="{{ $variante->Stock }}"
                                       {{ $loop->first && $variante->Stock > 0 ? 'checked' : '' }}
                                       {{ $variante->Stock < 1 ? 'disabled' : '' }}>
                                <span>{{ $variante->Color }} · {{ $variante->Talla }}</span>
                                <small>{{ $variante->Stock > 0 ? $variante->Stock . ' disp.' : 'Agotado' }}</small>
                            </label>
                        @endforeach
                    </div>

                    <p class="vs-section-sub" id="texto-stock" style="margin-bottom:1rem;"></p>

                    <div class="mb-3" style="max-width:150px;">
                        <input type="number" name="cantidad" id="input-cantidad" value="1" min="1" class="vs-form-control">
                    </div>

                    <button type="submit" class="btn-primary-vs" id="btn-agregar" style="border:none;">
                        Agregar al carrito
                    </button>
                </form>

                <script>
                    const radios = document.querySelectorAll('input[name="id_inventario"]');
                    const form = document.getElementById('form-agregar-carrito');
                    const inputCantidad = document.getElementById('input-cantidad');
                    const textoStock = document.getElementById('texto-stock');
                    const btnAgregar = document.getElementById('btn-agregar');

                    function actualizarSegunSeleccion() {
                        const seleccionado = document.querySelector('input[name="id_inventario"]:checked');

                        document.querySelectorAll('.vs-variante-opcion').forEach(op => {
                            op.style.borderColor = 'var(--border)';
                            op.style.background = 'var(--surface)';
                        });
                        if (seleccionado) {
                            const opcion = seleccionado.closest('.vs-variante-opcion');
                            opcion.style.borderColor = 'var(--blue)';
                            opcion.style.background = 'var(--blue-bg)';
                        }

                        if (!seleccionado) {
                            textoStock.textContent = 'Selecciona color y talla.';
                            btnAgregar.disabled = true;
                            return;
                        }
                        const stock = parseInt(seleccionado.dataset.stock, 10);
                        inputCantidad.max = stock;
                        if (parseInt(inputCantidad.value, 10) > stock) inputCantidad.value = stock;
                        textoStock.textContent = 'Stock disponible: ' + stock;
                        btnAgregar.disabled = stock < 1;
                        form.action = form.action.replace(/\/agregar\/[^/]+$/, '/agregar/' + seleccionado.value);
                    }

                    radios.forEach(r => r.addEventListener('change', actualizarSegunSeleccion));
                    actualizarSegunSeleccion();
                </script>
            @endif
        </div>
    </div>
</div>
@endsection