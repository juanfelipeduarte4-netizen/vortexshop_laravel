@extends('layouts.app')

@section('titulo', '- Mi carrito')

@section('contenido')
<section class="vs-section">
    <div class="container-fluid px-4">
        <h2 class="vs-section-title" style="font-size:1.8rem;">Mi <em>carrito</em></h2>
        <p class="vs-section-sub">{{ count($carrito) }} artículo(s)</p>

        @if (session('error'))
            <div class="alert-vs-error mb-3" style="max-width:700px;">{{ session('error') }}</div>
        @endif

        @if (count($carrito) === 0)
            <p style="color:var(--muted);">Tu carrito está vacío. <a href="{{ route('catalogo.index') }}" class="vs-nav-link">Ver catálogo →</a></p>
        @else
            <div class="vs-panel">
                <table class="vs-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Producto</th>
                            <th>Talla</th>
                            <th>Color</th>
                            <th>Precio unitario</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($carrito as $id => $item)
                            <tr>
                                <td>
                                    @if ($item['imagen'] ?? null)
                                        <img src="{{ asset('storage/' . $item['imagen']) }}" alt="{{ $item['nombre'] }}" class="vs-thumb">
                                    @else
                                        <div class="vs-thumb" style="background:var(--blue-bg);"></div>
                                    @endif
                                </td>
                                <td>
                                    {{ $item['nombre'] }}
                                    @if($item['insuficiente'])
                                        <br><span class="vs-badge-agotado">Solo quedan {{ $item['stock_actual'] }} disponibles</span>
                                    @endif
                                </td>
                                <td>{{ $item['talla'] }}</td>
                                <td>{{ $item['color'] }}</td>
                                <td>
                                    @if($item['tiene_descuento'])
                                        ${{ number_format($item['precio_final'], 0, ',', '.') }}
                                        <s style="color:var(--dim); font-size:12px;">${{ number_format($item['precio_original'], 0, ',', '.') }}</s>
                                    @else
                                        ${{ number_format($item['precio_original'], 0, ',', '.') }}
                                    @endif
                                </td>
                                <td style="max-width:120px;">
                                    <form method="POST" action="{{ route('carrito.actualizar', $id) }}" class="d-flex gap-2">
                                        @csrf
                                        <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" max="{{ $item['stock_actual'] }}"
                                               class="vs-form-control" style="padding:6px 8px; font-size:13px;">
                                        <button type="submit" class="vs-btn-sm">↻</button>
                                    </form>
                                </td>
                                <td>${{ number_format($item['precio_final'] * $item['cantidad'], 0, ',', '.') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('carrito.eliminar', $id) }}" onsubmit="return confirm('¿Quitar este producto del carrito?');">
                                        @csrf
                                        <button type="submit" class="vs-btn-sm vs-btn-sm-danger">Quitar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <form method="POST" action="{{ route('carrito.vaciar') }}" onsubmit="return confirm('¿Vaciar todo el carrito?');">
                        @csrf
                        <button type="submit" class="btn-secondary-vs" style="border-color:#e57373; color:#e57373;">Vaciar carrito</button>
                    </form>

                    <div class="text-end">
                        <p class="vs-form-label" style="margin-bottom:4px;">Total</p>
                        <p style="color:var(--cream); font-size:24px; font-family:'Cormorant Garamond',serif; margin-bottom:.6rem;">
                            ${{ number_format($total, 0, ',', '.') }}
                        </p>
                        <button class="btn-ingresar" style="width:auto; padding:10px 28px;" disabled title="Proceso de pago: próximamente">
                            Finalizar compra
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection