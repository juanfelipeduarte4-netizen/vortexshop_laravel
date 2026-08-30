<?php $__env->startSection('titulo', '- ' . $producto->Nombre); ?>

<?php $__env->startSection('contenido'); ?>

<?php
    $imagen = $producto->imagenes->first();
    $stockTotal = $producto->inventario->sum('Stock');
?>

<div class="container-fluid px-4 py-4">
    <div class="row g-4">
        <div class="col-12 col-md-6">
            <div class="vs-prod-img" id="imagen-principal" style="height:420px; border-radius:4px; <?php echo e($imagen ? 'background-image:url('.asset('storage/'.$imagen->Ruta).'); background-size:cover; background-position:center;' : ''); ?>">
                <?php if (! ($imagen)): ?>
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <span style="color:var(--ghost); font-size:12px; letter-spacing:2px; text-transform:uppercase;">Sin imagen</span>
                    </div>
                <?php endif; ?>
            </div>

            <?php if($producto->imagenes->count() > 1): ?>
                <div class="d-flex gap-2 mt-2">
                    <?php $__currentLoopData = $producto->imagenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e(asset('storage/' . $img->Ruta)); ?>"
                             class="vs-thumb-selector <?php echo e($loop->first ? 'activa' : ''); ?>"
                             style="width:56px; height:56px; object-fit:cover; border-radius:3px; cursor:pointer; border:2px solid <?php echo e($loop->first ? 'var(--blue)' : 'var(--border)'); ?>;"
                             onclick="document.getElementById('imagen-principal').style.backgroundImage = 'url(<?php echo e(asset('storage/'.$img->Ruta)); ?>)';
                                      document.querySelectorAll('.vs-thumb-selector').forEach(t => t.style.borderColor = 'var(--border)');
                                      this.style.borderColor = 'var(--blue)';">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-12 col-md-6">
            <p class="vs-prod-cat"><?php echo e($producto->categoria->Nombre ?? 'Sin categoría'); ?></p>
            <h1 class="vs-hero-title" style="font-size:2.2rem; text-align:left;"><?php echo e($producto->Nombre); ?></h1>
            <p style="color:var(--muted); font-size:14px; line-height:1.7; margin:1rem 0;"><?php echo e($producto->Descripcion); ?></p>

            <?php if($producto->tieneDescuento()): ?>
                <p class="vs-prod-price" style="font-size:1.8rem;">
                    $<?php echo e(number_format($producto->precioFinal(), 0, ',', '.')); ?>

                    <s style="font-size:1.1rem;">$<?php echo e(number_format($producto->Precio, 0, ',', '.')); ?></s>
                    <span class="vs-badge" style="vertical-align:middle;">-<?php echo e(rtrim(rtrim(number_format($producto->promocionVigente()->PorcentajeDescuento, 2), '0'), '.')); ?>%</span>
                </p>
            <?php else: ?>
                <p class="vs-prod-price" style="font-size:1.8rem;">$<?php echo e(number_format($producto->Precio, 0, ',', '.')); ?></p>
            <?php endif; ?>

            <?php if($producto->inventario->isEmpty()): ?>
                <p class="vs-section-sub">No hay variantes disponibles para este producto.</p>
            <?php else: ?>
                <form action="<?php echo e(route('carrito.agregar', '__ID__')); ?>" method="POST" id="form-agregar-carrito">
                    <?php echo csrf_field(); ?>

                    <p class="vs-form-label" style="margin-top:1rem;">Color y talla</p>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <?php $__currentLoopData = $producto->inventario; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="vs-variante-opcion <?php echo e($variante->Stock < 1 ? 'agotada' : ''); ?>">
                                <input type="radio" name="id_inventario" value="<?php echo e($variante->IdInventario); ?>"
                                       data-stock="<?php echo e($variante->Stock); ?>"
                                       <?php echo e($loop->first && $variante->Stock > 0 ? 'checked' : ''); ?>

                                       <?php echo e($variante->Stock < 1 ? 'disabled' : ''); ?>>
                                <span><?php echo e($variante->Color); ?> · <?php echo e($variante->Talla); ?></span>
                                <small><?php echo e($variante->Stock > 0 ? $variante->Stock . ' disp.' : 'Agotado'); ?></small>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <p class="vs-section-sub" id="texto-stock" style="margin-bottom:1rem;"></p>

                    <div class="mb-3" style="max-width:150px;">
                        <input type="number" name="cantidad" id="input-cantidad" value="1" min="1" class="vs-form-control">
                    </div>

                    <button type="submit" class="btn-primary-vs" id="btn-agregar" style="border:none;">
                        Agregar al carrito
                    </button>
                </form>

                <script>
                    const radios = document.querySelectorAll('input[name="id_inventario"]');
                    const form = document.getElementById('form-agregar-carrito');
                    const inputCantidad = document.getElementById('input-cantidad');
                    const textoStock = document.getElementById('texto-stock');
                    const btnAgregar = document.getElementById('btn-agregar');

                    function actualizarSegunSeleccion() {
                        const seleccionado = document.querySelector('input[name="id_inventario"]:checked');

                        document.querySelectorAll('.vs-variante-opcion').forEach(op => {
                            op.style.borderColor = 'var(--border)';
                            op.style.background = 'var(--surface)';
                        });
                        if (seleccionado) {
                            const opcion = seleccionado.closest('.vs-variante-opcion');
                            opcion.style.borderColor = 'var(--blue)';
                            opcion.style.background = 'var(--blue-bg)';
                        }

                        if (!seleccionado) {
                            textoStock.textContent = 'Selecciona color y talla.';
                            btnAgregar.disabled = true;
                            return;
                        }
                        const stock = parseInt(seleccionado.dataset.stock, 10);
                        inputCantidad.max = stock;
                        if (parseInt(inputCantidad.value, 10) > stock) inputCantidad.value = stock;
                        textoStock.textContent = 'Stock disponible: ' + stock;
                        btnAgregar.disabled = stock < 1;
                        form.action = form.action.replace(/\/agregar\/[^/]+$/, '/agregar/' + seleccionado.value);
                    }

                    radios.forEach(r => r.addEventListener('change', actualizarSegunSeleccion));
                    actualizarSegunSeleccion();
                </script>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/producto-detalle.blade.php ENDPATH**/ ?>