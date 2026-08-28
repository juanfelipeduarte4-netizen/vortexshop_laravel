@extends('layouts.app')

@section('titulo', '- ' . $producto->Nombre)

@section('contenido')

@php
    $stockTotal = $producto->inventario->sum('Stock');
    $imagen = $producto->imagenes->first();
@endphp

<div class="container-fluid px-4 py-4">
    <div class="row g-4">
        <div class="col-12 col-md-6">
            <div class="vs-prod-img" style="height:420px; border-radius:4px; {{ $imagen ? 'background-image:url('.asset('storage/'.$imagen->Ruta).'); background-size:cover; background-position:center;' : '' }}">
                @unless($imagen)
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <span style="color:var(--ghost); font-size:12px; letter-spacing:2px; text-transform:uppercase;">Sin imagen</span>
                    </div>
                @endunless
            </div>
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
            <p class="vs-section-sub" style="margin-bottom:1.2rem;">Stock disponible: {{ $stockTotal }}</p>

            <form action="{{ route('carrito.agregar', $producto->IdProducto) }}" method="POST">
                @csrf
                <div class="mb-3" style="max-width:150px;">
                    <input type="number" name="cantidad" value="1" min="1" max="{{ $stockTotal }}" class="vs-form-control">
                </div>
                <button type="submit" class="btn-primary-vs" style="border:none;" {{ $stockTotal < 1 ? 'disabled' : '' }}>
                    {{ $stockTotal < 1 ? 'Sin stock' : 'Agregar al carrito' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection