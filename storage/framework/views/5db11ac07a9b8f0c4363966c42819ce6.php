

<?php $__env->startSection('titulo', '- Promociones'); ?>

<?php $__env->startSection('contenido'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="vs-page-title">Promociones</h1>
        <p class="vs-section-sub mb-0"><?php echo e($promociones->total()); ?> promoción(es) registrada(s)</p>
    </div>
    <a href="<?php echo e(route('admin.promociones.create')); ?>" class="btn-primary-vs" style="border:none;">+ Nueva promoción</a>
</div>

<?php if(session('exito')): ?>
    <div class="vs-alert-exito mb-3"><?php echo e(session('exito')); ?></div>
<?php endif; ?>

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
        <?php $__empty_1 = true; $__currentLoopData = $promociones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promocion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $estado = $promocion->estado();
                $badgeClase = match($estado) {
                    'vigente' => 'inf-badge-simple',
                    'futura'  => 'inf-badge-param',
                    default   => 'inf-badge-multi',
                };
            ?>
            <tr>
                <td><?php echo e($promocion->Descripcion ?: '—'); ?></td>
                <td><?php echo e($promocion->PorcentajeDescuento); ?>%</td>
                <td><?php echo e($promocion->FechaInicio->format('d/m/Y')); ?> → <?php echo e($promocion->FechaFin->format('d/m/Y')); ?></td>
                <td><?php echo e($promocion->productos_count); ?></td>
                <td><span class="inf-badge <?php echo e($badgeClase); ?>"><?php echo e($estado); ?></span></td>
                <td class="d-flex gap-1">
                    <a href="<?php echo e(route('admin.promociones.edit', $promocion)); ?>" class="vs-btn-editar">Editar</a>
                    <form method="POST" action="<?php echo e(route('admin.promociones.destroy', $promocion)); ?>" onsubmit="return confirm('¿Eliminar esta promoción?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="vs-btn-eliminar">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6" class="text-center vs-section-sub py-4">No hay promociones registradas todavía.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="mt-3">
    <?php echo e($promociones->links()); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.appadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/Admin/promociones/index.blade.php ENDPATH**/ ?>