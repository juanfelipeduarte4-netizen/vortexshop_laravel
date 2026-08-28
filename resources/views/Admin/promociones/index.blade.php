@extends('layouts.appadmin')

@section('titulo', '- Promociones')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="vs-page-title">Promociones</h1>
        <p class="vs-section-sub mb-0">{{ $promociones->total() }} promoción(es) registrada(s)</p>
    </div>
    <a href="{{ route('admin.promociones.create') }}" class="btn-primary-vs" style="border:none;">+ Nueva promoción</a>
</div>

@if (session('exito'))
    <div class="vs-alert-exito mb-3">{{ session('exito') }}</div>
@endif

<table class="vs-table">
    <thead>
        <tr>
            <th>Descripción</th>
            <th>Descuento</th>
            <th>Vigencia</th>
            <th>Productos</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($promociones as $promocion)
            @php
                $estado = $promocion->estado();
                $badgeClase = match($estado) {
                    'vigente' => 'inf-badge-simple',
                    'futura'  => 'inf-badge-param',
                    default   => 'inf-badge-multi',
                };
            @endphp
            <tr>
                <td>{{ $promocion->Descripcion ?: '—' }}</td>
                <td>{{ $promocion->PorcentajeDescuento }}%</td>
                <td>{{ $promocion->FechaInicio->format('d/m/Y') }} → {{ $promocion->FechaFin->format('d/m/Y') }}</td>
                <td>{{ $promocion->productos_count }}</td>
                <td><span class="inf-badge {{ $badgeClase }}">{{ $estado }}</span></td>
                <td class="d-flex gap-1">
                    <a href="{{ route('admin.promociones.edit', $promocion) }}" class="vs-btn-editar">Editar</a>
                    <form method="POST" action="{{ route('admin.promociones.destroy', $promocion) }}" onsubmit="return confirm('¿Eliminar esta promoción?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="vs-btn-eliminar">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center vs-section-sub py-4">No hay promociones registradas todavía.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">
    {{ $promociones->links() }}
</div>
@endsection