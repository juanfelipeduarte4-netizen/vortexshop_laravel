@extends('layouts.appadmin')

@section('contenido')
<h2 class="vs-page-title">Panel de <em>Control</em></h2>
<div class="vs-divisor" style="margin-bottom:1.6rem;"><span></span><span></span></div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="vs-stat-card vs-stat-accent-blue">
            <p class="vs-stat-label">Productos activos</p>
            <p class="vs-stat-value">{{ $stats['productos_activos'] }}</p>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="vs-stat-card vs-stat-accent-cream">
            <p class="vs-stat-label">Total productos</p>
            <p class="vs-stat-value">{{ $stats['total_productos'] }}</p>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="vs-stat-card vs-stat-accent-blue">
            <p class="vs-stat-label">Categorías</p>
            <p class="vs-stat-value">{{ $stats['total_categorias'] }}</p>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="vs-stat-card vs-stat-accent-amber">
            <p class="vs-stat-label">Stock bajo / agotado</p>
            <p class="vs-stat-value">{{ $stats['stock_bajo'] }} / {{ $stats['agotados'] }}</p>
        </div>
    </div>
</div>

<h5 class="inf-section-title" style="font-size:.9rem;">Últimos productos creados</h5>
<table class="vs-table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Precio</th>
        </tr>
    </thead>
    <tbody>
        @forelse($ultimosProductos as $p)
            <tr>
                <td>{{ $p->Nombre }}</td>
                <td>{{ $p->categoria->Nombre ?? 'N/A' }}</td>
                <td>${{ number_format($p->Precio, 2, ',', '.') }}</td>
            </tr>
        @empty
            <tr><td colspan="3" class="text-center vs-section-sub py-4">Aún no hay productos creados.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection