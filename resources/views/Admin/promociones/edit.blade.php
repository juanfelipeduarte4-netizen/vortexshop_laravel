@extends('layouts.appadmin')

@section('titulo', '- Editar promoción')

@section('contenido')
<div style="max-width: 800px; margin: 0 auto; text-align: center;">
    <h2 class="vs-page-title">Editar <em>promoción</em></h2>
    <a href="{{ route('admin.promociones.index') }}" class="vs-nav-link" style="display:inline-block; margin-bottom:1rem;">← Volver al listado</a>

    @if ($errors->any())
        <div class="alert-vs-error mb-3" style="text-align: left;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="inf-card" style="max-width:800px; margin: 0 auto; text-align: left;">
        <form method="POST" action="{{ route('admin.promociones.update', $promocion) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="vs-form-label">Descripción</label>
                <textarea name="Descripcion" rows="2" class="vs-form-control">{{ old('Descripcion', $promocion->Descripcion) }}</textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="vs-form-label">Descuento (%)</label>
                    <input type="number" step="0.01" min="1" max="100" name="PorcentajeDescuento" value="{{ old('PorcentajeDescuento', $promocion->PorcentajeDescuento) }}" class="vs-form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="vs-form-label">Fecha de inicio</label>
                    <input type="date" name="FechaInicio" value="{{ old('FechaInicio', $promocion->FechaInicio->format('Y-m-d')) }}" class="vs-form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="vs-form-label">Fecha de fin</label>
                    <input type="date" name="FechaFin" value="{{ old('FechaFin', $promocion->FechaFin->format('Y-m-d')) }}" class="vs-form-control" required>
                </div>
            </div>

            <div class="mb-0">
                <label class="vs-form-label">Productos incluidos</label>

                @if ($productos->isEmpty())
                    <p class="vs-section-sub">No hay productos activos disponibles.</p>
                @else
                    <div class="vs-checklist">
                        @foreach ($productos as $producto)
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="productos[]"
                                    id="producto-{{ $producto->IdProducto }}"
                                    value="{{ $producto->IdProducto }}"
                                    @checked(collect(old('productos', $seleccionados))->contains($producto->IdProducto))
                                >
                                <label class="form-check-label" for="producto-{{ $producto->IdProducto }}">
                                    {{ $producto->Nombre }} — ${{ number_format($producto->Precio, 0, ',', '.') }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <button type="submit" class="btn-primary-vs mt-4" style="border:none;">Guardar cambios</button>
        </form>
    </div>
</div>
@endsection 