@extends('layouts.appadmin')

@section('contenido')

@php
    $inventarioActual = $producto->inventario->first();
    $imagenActual = $producto->imagenes->first();
@endphp

<h2 class="vs-page-title">Editar <em>Producto</em></h2>
<p class="vs-section-sub" style="margin-bottom:1.6rem;">{{ $producto->Nombre }}</p>

<div class="row g-4">

    {{-- COLUMNA IZQUIERDA: FORMULARIO --}}
    <div class="col-12 col-lg-7">
        <form action="{{ route('admin.productos.update', $producto->IdProducto) }}" method="POST" enctype="multipart/form-data" id="form-producto">
            @csrf
            @method('PUT')

            <div class="inf-card">
                <h5 class="inf-section-title" style="font-size:.9rem;">Datos generales</h5>

                <div class="mb-3">
                    <label class="vs-form-label">Categoría</label>
                    <select name="IdCategoria" id="in-categoria" class="vs-form-control" required>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->IdCategoria }}" {{ $producto->IdCategoria == $categoria->IdCategoria ? 'selected' : '' }}>
                                {{ $categoria->Nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="vs-form-label">Nombre del producto</label>
                    <input type="text" name="Nombre" id="in-nombre" class="vs-form-control" value="{{ $producto->Nombre }}" required>
                </div>

                <div class="mb-0">
                    <label class="vs-form-label">Descripción</label>
                    <textarea name="Descripcion" id="in-descripcion" class="vs-form-control" rows="3">{{ $producto->Descripcion }}</textarea>
                </div>
            </div>

            {{-- Color/Talla/Stock viven en inventario, no en producto --}}
            <div class="inf-card">
                <h5 class="inf-section-title" style="font-size:.9rem;">Variante</h5>
                <div class="row">
                    <div class="col-6">
                        <label class="vs-form-label">Color</label>
                        <input type="text" name="Color" id="in-color" class="vs-form-control" value="{{ old('Color', $inventarioActual->Color ?? '') }}" required>
                    </div>
                    <div class="col-6">
                        <label class="vs-form-label">Talla</label>
                        <input type="text" name="Talla" id="in-talla" class="vs-form-control" value="{{ old('Talla', $inventarioActual->Talla ?? '') }}" required>
                    </div>
                </div>
            </div>

            <div class="inf-card">
                <h5 class="inf-section-title" style="font-size:.9rem;">Precio &amp; inventario</h5>
                <div class="row">
                    <div class="col-6">
                        <label class="vs-form-label">Precio</label>
                        <input type="number" step="0.01" min="0" name="Precio" id="in-precio" class="vs-form-control" value="{{ $producto->Precio }}" required>
                    </div>
                    <div class="col-6">
                        <label class="vs-form-label">Stock</label>
                        <input type="number" min="0" name="Stock" id="in-stock" class="vs-form-control" value="{{ old('Stock', $inventarioActual->Stock ?? 0) }}" required>
                    </div>
                </div>
            </div>

            {{-- La imagen vive en la tabla imagen, no en producto --}}
            <div class="inf-card">
                <h5 class="inf-section-title" style="font-size:.9rem;">Imagen</h5>
                <label class="vs-dropzone" for="in-imagen" id="dropzone">
                    @if($imagenActual)
                        <img id="preview-img-input" src="{{ asset('storage/' . $imagenActual->Ruta) }}" style="display:block;">
                    @else
                        <span id="dropzone-texto">Haz clic para elegir una imagen<br><small style="color:var(--dim);">JPG o PNG, máx. 2MB</small></span>
                        <img id="preview-img-input" style="display:none;">
                    @endif
                </label>
                <input type="file" name="Imagen" id="in-imagen" accept="image/*" class="d-none">
                <small style="color:var(--muted); font-size:11px; display:block; margin-top:.5rem;">Deja en blanco para conservar la imagen actual.</small>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn-primary-vs" style="border:none;">Actualizar producto</button>
                <a href="{{ route('admin.productos.index') }}" class="btn-secondary-vs">Cancelar</a>
            </div>
        </form>
    </div>

    {{-- COLUMNA DERECHA: VISTA PREVIA EN VIVO --}}
    <div class="col-12 col-lg-5">
        <p class="vs-section-sub" style="margin-bottom:.6rem;">Así se ve en el catálogo</p>
        <div class="vs-prod-card" style="position:sticky; top:20px;">
            <div class="vs-prod-img" id="preview-img-wrap" style="display:flex; align-items:center; justify-content:center; overflow:hidden;">
                <img id="preview-img" src="{{ $imagenActual ? asset('storage/' . $imagenActual->Ruta) : '' }}"
                     style="{{ $imagenActual ? 'display:block;' : 'display:none;' }} width:100%; height:100%; object-fit:cover;">
                <span id="preview-img-placeholder" style="{{ $imagenActual ? 'display:none;' : '' }} color:var(--ghost); font-size:11px; letter-spacing:2px; text-transform:uppercase;">Sin imagen</span>
            </div>
            <div class="vs-prod-body">
                <p class="vs-prod-cat" id="preview-categoria">{{ $producto->categoria->Nombre ?? 'Categoría' }}</p>
                <p class="vs-prod-name" id="preview-nombre">{{ $producto->Nombre }}</p>
                <p class="vs-prod-price" id="preview-precio">${{ number_format($producto->Precio, 0, ',', '.') }}</p>
                <div class="vs-prod-footer">
                    <span class="vs-badge" id="preview-variante">{{ $inventarioActual->Color ?? '—' }} · {{ $inventarioActual->Talla ?? '—' }}</span>
                    <span class="vs-badge" id="preview-stock" style="border-color:var(--border); color:var(--muted); background:none;">Stock: {{ $inventarioActual->Stock ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    const $ = (id) => document.getElementById(id);

    $('in-nombre').addEventListener('input', e => { $('preview-nombre').textContent = e.target.value || 'Nombre del producto'; });
    $('in-categoria').addEventListener('change', e => { $('preview-categoria').textContent = e.target.options[e.target.selectedIndex]?.text || 'Categoría'; });
    $('in-precio').addEventListener('input', e => { $('preview-precio').textContent = '$' + parseFloat(e.target.value || 0).toLocaleString('es-CO', { minimumFractionDigits: 0 }); });

    function actualizarVariante() {
        $('preview-variante').textContent = ($('in-color').value || '—') + ' · ' + ($('in-talla').value || '—');
    }
    $('in-color').addEventListener('input', actualizarVariante);
    $('in-talla').addEventListener('input', actualizarVariante);

    $('in-stock').addEventListener('input', e => { $('preview-stock').textContent = 'Stock: ' + (e.target.value || 0); });

    $('in-imagen').addEventListener('change', e => {
        const archivo = e.target.files[0];
        if (!archivo) return;
        const url = URL.createObjectURL(archivo);
        $('preview-img').src = url;
        $('preview-img').style.display = 'block';
        $('preview-img-placeholder').style.display = 'none';
        $('preview-img-input').src = url;
        $('preview-img-input').style.display = 'block';
        const texto = $('dropzone-texto'); if (texto) texto.style.display = 'none';
    });
</script>
@endsection