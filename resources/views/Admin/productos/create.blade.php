@extends('layouts.appadmin')

@section('contenido')
<h2 class="vs-page-title">Crear <em>Producto</em></h2>
<p class="vs-section-sub" style="margin-bottom:1.6rem;">Completa los datos y mira cómo se vería en el catálogo</p>

<div class="row g-4">

    {{-- COLUMNA IZQUIERDA: FORMULARIO --}}
    <div class="col-12 col-lg-7">
        <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data" id="form-producto">
            @csrf

            {{-- Sección: datos generales --}}
            <div class="inf-card">
                <h5 class="inf-section-title" style="font-size:.9rem;">Datos generales</h5>

                <div class="mb-3">
                    <label class="vs-form-label">Categoría</label>
                    <select name="IdCategoria" id="in-categoria" class="vs-form-control" required>
                        <option value="">Seleccione una categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->IdCategoria }}">{{ $categoria->Nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="vs-form-label">Nombre del producto</label>
                    <input type="text" name="Nombre" id="in-nombre" class="vs-form-control" placeholder="Ej: Camiseta Polo" required>
                </div>

                <div class="mb-0">
                    <label class="vs-form-label">Descripción</label>
                    <textarea name="Descripcion" id="in-descripcion" class="vs-form-control" rows="3" placeholder="Detalles del producto..."></textarea>
                </div>
            </div>

            {{-- Sección: variante --}}
            <div class="inf-card">
                <h5 class="inf-section-title" style="font-size:.9rem;">Variante</h5>
                <div class="row">
                    <div class="col-6">
                        <label class="vs-form-label">Color</label>
                        <input type="text" name="Color" id="in-color" class="vs-form-control" placeholder="Ej: Azul" value="{{ old('Color') }}" required>
                        @error('Color') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-6">
                        <label class="vs-form-label">Talla</label>
                        <input type="text" name="Talla" id="in-talla" class="vs-form-control" placeholder="Ej: M" value="{{ old('Talla') }}" required>
                        @error('Talla') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- Sección: precio y stock --}}
            <div class="inf-card">
                <h5 class="inf-section-title" style="font-size:.9rem;">Precio &amp; inventario</h5>
                <div class="row">
                    <div class="col-6">
                        <label class="vs-form-label">Precio</label>
                        <input type="number" step="0.01" min="0" name="Precio" id="in-precio" class="vs-form-control" placeholder="0.00" required>
                    </div>
                    <div class="col-6">
                        <label class="vs-form-label">Stock</label>
                        <input type="number" name="Stock" id="in-stock" class="vs-form-control" min="0" value="{{ old('Stock', 0) }}" required>
                        @error('Stock') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- Sección: imagen --}}
            <div class="inf-card">
                <h5 class="inf-section-title" style="font-size:.9rem;">Imagen</h5>
                <label class="vs-dropzone" for="in-imagen" id="dropzone">
                    <span id="dropzone-texto">Haz clic para elegir una imagen<br><small style="color:var(--dim);">JPG o PNG, máx. 2MB</small></span>
                    <img id="preview-img-input" style="display:none;">
                </label>
                <input type="file" name="Imagen" id="in-imagen" accept="image/*" class="d-none">
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn-primary-vs" style="border:none;">Guardar producto</button>
                <a href="{{ route('admin.productos.index') }}" class="btn-secondary-vs">Cancelar</a>
            </div>
        </form>
    </div>

    {{-- COLUMNA DERECHA: VISTA PREVIA EN VIVO --}}
    <div class="col-12 col-lg-5">
        <p class="vs-section-sub" style="margin-bottom:.6rem;">Así se vería en el catálogo</p>
        <div class="vs-prod-card" style="position:sticky; top:20px;">
            <div class="vs-prod-img" id="preview-img-wrap" style="display:flex; align-items:center; justify-content:center; overflow:hidden;">
                <img id="preview-img" style="display:none; width:100%; height:100%; object-fit:cover;">
                <span id="preview-img-placeholder" style="color:var(--ghost); font-size:11px; letter-spacing:2px; text-transform:uppercase;">Sin imagen</span>
            </div>
            <div class="vs-prod-body">
                <p class="vs-prod-cat" id="preview-categoria">Categoría</p>
                <p class="vs-prod-name" id="preview-nombre">Nombre del producto</p>
                <p class="vs-prod-price" id="preview-precio">$0</p>
                <div class="vs-prod-footer">
                    <span class="vs-badge" id="preview-variante">— · —</span>
                    <span class="vs-badge" id="preview-stock" style="border-color:var(--border); color:var(--muted); background:none;">Stock: 0</span>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    const $ = (id) => document.getElementById(id);

    $('in-nombre').addEventListener('input', e => {
        $('preview-nombre').textContent = e.target.value || 'Nombre del producto';
    });

    $('in-categoria').addEventListener('change', e => {
        const texto = e.target.options[e.target.selectedIndex]?.text;
        $('preview-categoria').textContent = (texto && texto !== 'Seleccione una categoría') ? texto : 'Categoría';
    });

    $('in-precio').addEventListener('input', e => {
        const valor = parseFloat(e.target.value || 0);
        $('preview-precio').textContent = '$' + valor.toLocaleString('es-CO', { minimumFractionDigits: 0 });
    });

    function actualizarVariante() {
        const color = $('in-color').value || '—';
        const talla = $('in-talla').value || '—';
        $('preview-variante').textContent = color + ' · ' + talla;
    }
    $('in-color').addEventListener('input', actualizarVariante);
    $('in-talla').addEventListener('input', actualizarVariante);

    $('in-stock').addEventListener('input', e => {
        $('preview-stock').textContent = 'Stock: ' + (e.target.value || 0);
    });

    $('in-imagen').addEventListener('change', e => {
        const archivo = e.target.files[0];
        if (!archivo) return;
        const url = URL.createObjectURL(archivo);

        $('preview-img').src = url;
        $('preview-img').style.display = 'block';
        $('preview-img-placeholder').style.display = 'none';

        $('preview-img-input').src = url;
        $('preview-img-input').style.display = 'block';
        $('dropzone-texto').style.display = 'none';
    });
</script>
@endsection