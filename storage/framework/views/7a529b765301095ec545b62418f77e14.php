<?php $__env->startSection('titulo', '- ' . $producto->Nombre); ?>

<?php $__env->startSection('contenido'); ?>

<?php
    $stockTotal = $producto->inventario->sum('Stock');
    $imagen = $producto->imagenes->first();
?>

<div class="container-fluid px-4 py-4">
    <div class="row g-4">
        <div class="col-12 col-md-6">
            <div class="vs-prod-img" style="height:420px; border-radius:4px; <?php echo e($imagen ? 'background-image:url('.asset('storage/'.$imagen->Ruta).'); background-size:cover; background-position:center;' : ''); ?>">
                <?php if (! ($imagen)): ?>
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <span style="color:var(--ghost); font-size:12px; letter-spacing:2px; text-transform:uppercase;">Sin imagen</span>
                    </div>
                <?php endif; ?>
            </div>
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
            <p class="vs-section-sub" style="margin-bottom:1.2rem;">Stock disponible: <?php echo e($stockTotal); ?></p>

            <form action="<?php echo e(route('carrito.agregar', $producto->IdProducto)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3" style="max-width:150px;">
                    <input type="number" name="cantidad" value="1" min="1" max="<?php echo e($stockTotal); ?>" class="vs-form-control">
                </div>
                <button type="submit" class="btn-primary-vs" style="border:none;" <?php echo e($stockTotal < 1 ? 'disabled' : ''); ?>>
                    <?php echo e($stockTotal < 1 ? 'Sin stock' : 'Agregar al carrito'); ?>

                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/producto-detalle.blade.php ENDPATH**/ ?>