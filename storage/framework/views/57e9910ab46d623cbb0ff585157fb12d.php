

<?php $__env->startSection('titulo', '- Nueva promoción'); ?>

<?php $__env->startSection('contenido'); ?>
<div style="max-width: 800px; margin: 0 auto; text-align: center;">
    <h2 class="vs-page-title">Nueva <em>promoción</em></h2>
    <a href="<?php echo e(route('admin.promociones.index')); ?>" class="vs-nav-link" style="display:inline-block; margin-bottom:1rem;">← Volver al listado</a>

    <?php if($errors->any()): ?>
        <div class="alert-vs-error mb-3" style="text-align: left;">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div><?php echo e($error); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <div class="inf-card" style="max-width:800px; margin: 0 auto; text-align: left;">
        <form method="POST" action="<?php echo e(route('admin.promociones.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="mb-3">
                <label class="vs-form-label">Descripción</label>
                <textarea name="Descripcion" rows="2" class="vs-form-control" placeholder="Ej: Descuento de temporada en camisetas"><?php echo e(old('Descripcion')); ?></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="vs-form-label">Descuento (%)</label>
                    <input type="number" step="0.01" min="1" max="100" name="PorcentajeDescuento" value="<?php echo e(old('PorcentajeDescuento')); ?>" class="vs-form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="vs-form-label">Fecha de inicio</label>
                    <input type="date" name="FechaInicio" value="<?php echo e(old('FechaInicio')); ?>" class="vs-form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="vs-form-label">Fecha de fin</label>
                    <input type="date" name="FechaFin" value="<?php echo e(old('FechaFin')); ?>" class="vs-form-control" required>
                </div>
            </div>

            <div class="mb-0">
                <label class="vs-form-label">Productos incluidos</label>

                <?php if($productos->isEmpty()): ?>
                    <p class="vs-section-sub">No hay productos activos disponibles. Crea un producto primero.</p>
                <?php else: ?>
                    <div class="vs-checklist">
                        <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="productos[]"
                                    id="producto-<?php echo e($producto->IdProducto); ?>"
                                    value="<?php echo e($producto->IdProducto); ?>"
                                    <?php if(collect(old('productos'))->contains($producto->IdProducto)): echo 'checked'; endif; ?>
                                >
                                <label class="form-check-label" for="producto-<?php echo e($producto->IdProducto); ?>">
                                    <?php echo e($producto->Nombre); ?> — $<?php echo e(number_format($producto->Precio, 0, ',', '.')); ?>

                                </label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn-primary-vs mt-4" style="border:none;">Crear promoción</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.appadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/Admin/promociones/create.blade.php ENDPATH**/ ?>