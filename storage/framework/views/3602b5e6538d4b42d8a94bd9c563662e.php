<?php $__env->startSection('contenido'); ?>
<h2 class="vs-page-title">Panel de <em>Control</em></h2>
<div class="vs-divisor" style="margin-bottom:1.6rem;"><span></span><span></span></div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="vs-stat-card vs-stat-accent-blue">
            <p class="vs-stat-label">Productos activos</p>
            <p class="vs-stat-value"><?php echo e($stats['productos_activos']); ?></p>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="vs-stat-card vs-stat-accent-cream">
            <p class="vs-stat-label">Total productos</p>
            <p class="vs-stat-value"><?php echo e($stats['total_productos']); ?></p>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="vs-stat-card vs-stat-accent-blue">
            <p class="vs-stat-label">Categorías</p>
            <p class="vs-stat-value"><?php echo e($stats['total_categorias']); ?></p>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="vs-stat-card vs-stat-accent-amber">
            <p class="vs-stat-label">Stock bajo / agotado</p>
            <p class="vs-stat-value"><?php echo e($stats['stock_bajo']); ?> / <?php echo e($stats['agotados']); ?></p>
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
        <?php $__empty_1 = true; $__currentLoopData = $ultimosProductos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($p->Nombre); ?></td>
                <td><?php echo e($p->categoria->Nombre ?? 'N/A'); ?></td>
                <td>$<?php echo e(number_format($p->Precio, 2, ',', '.')); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="3" class="text-center vs-section-sub py-4">Aún no hay productos creados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.appadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/Admin/dashboard.blade.php ENDPATH**/ ?>