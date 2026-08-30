<?php $__env->startSection('contenido'); ?>

<?php
    $inventarioActual = $producto->inventario->first();
    $imagenActual = $producto->imagenes->first();
    $todasLasImagenes = $producto->imagenes;
?>

<h2 class="vs-page-title">Editar <em>Producto</em></h2>
<p class="vs-section-sub" style="margin-bottom:1.6rem;"><?php echo e($producto->Nombre); ?></p>

<div class="row g-4">

    
    <div class="col-12 col-lg-7">
        <form action="<?php echo e(route('admin.productos.update', $producto->IdProducto)); ?>" method="POST" enctype="multipart/form-data" id="form-producto">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="inf-card">
                <h5 class="inf-section-title" style="font-size:.9rem;">Datos generales</h5>

                <div class="mb-3">
                    <label class="vs-form-label">Categoría</label>
                    <select name="IdCategoria" id="in-categoria" class="vs-form-control" required>
                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($categoria->IdCategoria); ?>" <?php echo e($producto->IdCategoria == $categoria->IdCategoria ? 'selected' : ''); ?>>
                                <?php echo e($categoria->Nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="vs-form-label">Nombre del producto</label>
                    <input type="text" name="Nombre" id="in-nombre" class="vs-form-control" value="<?php echo e($producto->Nombre); ?>" required>
                </div>

                <div class="mb-0">
                    <label class="vs-form-label">Descripción</label>
                    <textarea name="Descripcion" id="in-descripcion" class="vs-form-control" rows="3"><?php echo e($producto->Descripcion); ?></textarea>
                </div>
            </div>

            
            <div class="inf-card">
                <h5 class="inf-section-title" style="font-size:.9rem;">Variante</h5>
                <div class="row">
                    <div class="col-6">
                        <label class="vs-form-label">Color</label>
                        <input type="text" name="Color" id="in-color" class="vs-form-control" value="<?php echo e(old('Color', $inventarioActual->Color ?? '')); ?>" required>
                    </div>
                    <div class="col-6">
                        <label class="vs-form-label">Talla</label>
                        <input type="text" name="Talla" id="in-talla" class="vs-form-control" value="<?php echo e(old('Talla', $inventarioActual->Talla ?? '')); ?>" required>
                    </div>
                </div>
            </div>

            <div class="inf-card">
                <h5 class="inf-section-title" style="font-size:.9rem;">Precio &amp; inventario</h5>
                <div class="row">
                    <div class="col-6">
                        <label class="vs-form-label">Precio</label>
                        <input type="number" step="0.01" min="0" name="Precio" id="in-precio" class="vs-form-control" value="<?php echo e($producto->Precio); ?>" required>
                    </div>
                    <div class="col-6">
                        <label class="vs-form-label">Stock</label>
                        <input type="number" min="0" name="Stock" id="in-stock" class="vs-form-control" value="<?php echo e(old('Stock', $inventarioActual->Stock ?? 0)); ?>" required>
                    </div>
                </div>
            </div>

            
            <div class="inf-card">
                <h5 class="inf-section-title" style="font-size:.9rem;">Imágenes</h5>

                <?php if($todasLasImagenes->isNotEmpty()): ?>
                    <p class="vs-form-label">Imágenes actuales — marca las que quieras borrar</p>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <?php $__currentLoopData = $todasLasImagenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="vs-imagen-existente">
                                <img src="<?php echo e(asset('storage/' . $img->Ruta)); ?>">
                                <span>
                                    <input type="checkbox" name="eliminar_imagenes[]" value="<?php echo e($img->IdImagen); ?>">
                                    Borrar
                                </span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <label class="vs-dropzone" for="in-imagenes" id="dropzone">
                    <span id="dropzone-texto">Haz clic para agregar más imágenes<br><small style="color:var(--dim);">JPG o PNG, máx. 2MB c/u</small></span>
                </label>
                <input type="file" name="Imagenes[]" id="in-imagenes" accept="image/*" multiple class="d-none">
                <div id="miniaturas-nuevas" class="d-flex flex-wrap gap-2 mt-2"></div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn-primary-vs" style="border:none;">Actualizar producto</button>
                <a href="<?php echo e(route('admin.productos.index')); ?>" class="btn-secondary-vs">Cancelar</a>
            </div>
        </form>
    </div>

    
    <div class="col-12 col-lg-5">
        <p class="vs-section-sub" style="margin-bottom:.6rem;">Así se ve en el catálogo</p>
        <div class="vs-prod-card" style="position:sticky; top:20px;">
            <div class="vs-prod-img" id="preview-img-wrap" style="display:flex; align-items:center; justify-content:center; overflow:hidden;">
                <img id="preview-img" src="<?php echo e($imagenActual ? asset('storage/' . $imagenActual->Ruta) : ''); ?>"
                     style="<?php echo e($imagenActual ? 'display:block;' : 'display:none;'); ?> width:100%; height:100%; object-fit:cover;">
                <span id="preview-img-placeholder" style="<?php echo e($imagenActual ? 'display:none;' : ''); ?> color:var(--ghost); font-size:11px; letter-spacing:2px; text-transform:uppercase;">Sin imagen</span>
            </div>
            <div class="vs-prod-body">
                <p class="vs-prod-cat" id="preview-categoria"><?php echo e($producto->categoria->Nombre ?? 'Categoría'); ?></p>
                <p class="vs-prod-name" id="preview-nombre"><?php echo e($producto->Nombre); ?></p>
                <p class="vs-prod-price" id="preview-precio">$<?php echo e(number_format($producto->Precio, 0, ',', '.')); ?></p>
                <div class="vs-prod-footer">
                    <span class="vs-badge" id="preview-variante"><?php echo e($inventarioActual->Color ?? '—'); ?> · <?php echo e($inventarioActual->Talla ?? '—'); ?></span>
                    <span class="vs-badge" id="preview-stock" style="border-color:var(--border); color:var(--muted); background:none;">Stock: <?php echo e($inventarioActual->Stock ?? 0); ?></span>
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

    $('in-imagenes').addEventListener('change', e => {
        const archivos = Array.from(e.target.files);
        if (archivos.length === 0) return;

        const texto = $('dropzone-texto'); if (texto) texto.style.display = 'none';

        const contenedor = $('miniaturas-nuevas');
        contenedor.innerHTML = '';
        archivos.forEach(archivo => {
            const url = URL.createObjectURL(archivo);
            const img = document.createElement('img');
            img.src = url;
            img.style.cssText = 'width:60px; height:60px; object-fit:cover; border-radius:3px; border:1px solid var(--border);';
            contenedor.appendChild(img);
        });

        const primeraUrl = URL.createObjectURL(archivos[0]);
        $('preview-img').src = primeraUrl;
        $('preview-img').style.display = 'block';
        $('preview-img-placeholder').style.display = 'none';
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.appadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/Admin/productos/edit.blade.php ENDPATH**/ ?>