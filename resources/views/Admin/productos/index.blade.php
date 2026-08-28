@extends('layouts.appadmin')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="vs-page-title">Listado de <em>Productos</em></h2>
    <a href="{{ route('admin.productos.create') }}" class="btn-primary-vs" style="border:none;">Nuevo producto</a>
</div>

<table class="vs-table">
    <thead>
        <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($productos as $producto)
            <tr style="{{ $producto->Estado === 'inactivo' ? 'opacity:.5;' : '' }}">
                <td>
                    @if($producto->imagenes->isNotEmpty())
                        <img src="{{ asset('storage/' . $producto->imagenes->first()->Ruta) }}"
                             alt="{{ $producto->Nombre }}" class="vs-thumb">
                    @else
                        <div class="vs-thumb" style="background:var(--blue-bg);"></div>
                    @endif
                </td>
                <td>{{ $producto->Nombre }}</td>
                <td>{{ $producto->categoria->Nombre ?? 'N/A' }}</td>
                <td>${{ number_format($producto->Precio, 2, ',', '.') }}</td>
                <td>{{ $producto->inventario->sum('Stock') }}</td>
                <td>
                    <span class="vs-badge" style="{{ $producto->Estado !== 'activo' ? 'color:var(--muted); border-color:var(--border); background:none;' : '' }}">
                        {{ ucfirst($producto->Estado) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.productos.edit', $producto->IdProducto) }}" class="vs-btn-editar">Editar</a>

                    @if($producto->Estado === 'activo')
                        <form action="{{ route('admin.productos.destroy', $producto->IdProducto) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Dar de baja este producto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="vs-btn-eliminar">Dar de baja</button>
                        </form>
                    @else
                        <form action="{{ route('admin.productos.reactivar', $producto->IdProducto) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="vs-btn-editar">Reactivar</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center vs-section-sub py-4">No hay productos registrados.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">
    {{ $productos->links() }}
</div>
@endsection