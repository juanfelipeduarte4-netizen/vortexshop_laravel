@extends('layouts.app')

@section('titulo', 'Mi carrito · VortexShop')

@section('content')
<section class="vs-section">
    <div class="container-fluid px-4">
        <h2 class="vs-section-title">Mi <em>carrito</em></h2>
        <p class="vs-section-sub">{{ $carrito->cantidadTotal() }} artículo(s)</p>

        @if ($huboAjusteStock)
            <div class="alert-vs-error mb-3" style="max-width:700px;">
                ⚠ Algunos productos de tu carrito ya no tienen stock suficiente. Ajusta la cantidad o elimínalos antes de continuar.
            </div>
        @endif

        @if ($carrito->items->isEmpty())
            <p style="color:var(--muted);">Tu carrito está vacío. <a href="{{ route('catalogo') }}" class="vs-nav-link">Ver catálogo →</a></p>
        @else
            <div class="vs-panel">
                <table class="vs-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Variante</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($carrito->items as $item)
                            <tr>
                                <td>{{ $item->producto->Nombre }}</td>
                                <td>
                                    {{ $item->inventario->Color }} · {{ $item->inventario->Talla }}
                                    @if ($item->Cantidad > $item->inventario->Stock)
                                        <br><span class="vs-badge-agotado">solo quedan {{ $item->inventario->Stock }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->producto->tienePromocionVigente())
                                        ${{ number_format($item->producto->precioFinal(), 0, ',', '.') }}
                                        <s style="color:var(--dim); font-size:11px;">${{ number_format($item->producto->Precio, 0, ',', '.') }}</s>
                                    @else
                                        ${{ number_format($item->producto->Precio, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td style="max-width:110px;">
                                    <form method="POST" action="{{ route('carrito.actualizar', $item) }}" class="d-flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="Cantidad" value="{{ $item->Cantidad }}" min="1" max="{{ $item->inventario->Stock }}" class="vs-form-control" style="padding:6px 8px; font-size:13px;">
                                        <button type="submit" class="vs-btn-sm">↻</button>
                                    </form>
                                </td>
                                <td>${{ number_format($item->subtotal(), 0, ',', '.') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('carrito.eliminar', $item) }}" onsubmit="return confirm('¿Quitar este producto del carrito?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="vs-btn-sm vs-btn-sm-danger">Quitar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-end mt-3">
                    <div class="text-end">
                        <p class="vs-form-label" style="margin-bottom:4px;">Total</p>
                        <p style="color:var(--cream); font-size:24px; font-family:'Cormorant Garamond',serif;">
                            ${{ number_format($carrito->total(), 0, ',', '.') }}
                        </p>
                        <button class="btn-ingresar mt-2" style="width:auto; padding:10px 28px;" disabled title="Proceso de pago: próximamente">
                            Finalizar compra
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection