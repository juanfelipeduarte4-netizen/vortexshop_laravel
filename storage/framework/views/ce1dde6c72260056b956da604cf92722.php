<?php $__env->startSection('contenido'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="vs-page-title">Listado de <em>Productos</em></h2>
    <a href="<?php echo e(route('admin.productos.create')); ?>" class="btn-primary-vs" style="border:none;">Nuevo producto</a>
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
        <?php $__empty_1 = true; $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr style="<?php echo e($producto->Estado === 'inactivo' ? 'opacity:.5;' : ''); ?>">
                <td>
                    <?php if($producto->imagenes->isNotEmpty()): ?>
                        <img src="<?php echo e(asset('storage/' . $producto->imagenes->first()->Ruta)); ?>"
                             alt="<?php echo e($producto->Nombre); ?>" class="vs-thumb">
                    <?php else: ?>
                        <div class="vs-thumb" style="background:var(--blue-bg);"></div>
                    <?php endif; ?>
                </td>
                <td><?php echo e($producto->Nombre); ?></td>
                <td><?php echo e($producto->categoria->Nombre ?? 'N/A'); ?></td>
                <td>$<?php echo e(number_format($producto->Precio, 2, ',', '.')); ?></td>
                <td><?php echo e($producto->inventario->sum('Stock')); ?></td>
                <td>
                    <span class="vs-badge" style="<?php echo e($producto->Estado !== 'activo' ? 'color:var(--muted); border-color:var(--border); background:none;' : ''); ?>">
                        <?php echo e(ucfirst($producto->Estado)); ?>

                    </span>
                </td>
                <td>
                    <a href="<?php echo e(route('admin.productos.edit', $producto->IdProducto)); ?>" class="vs-btn-editar">Editar</a>

                    <?php if($producto->Estado === 'activo'): ?>
                        <form action="<?php echo e(route('admin.productos.destroy', $producto->IdProducto)); ?>" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Dar de baja este producto?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="vs-btn-eliminar">Dar de baja</button>
                        </form>
                    <?php else: ?>
                        <form action="<?php echo e(route('admin.productos.reactivar', $producto->IdProducto)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="vs-btn-editar">Reactivar</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="7" class="text-center vs-section-sub py-4">No hay productos registrados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="mt-3">
    <?php echo e($productos->links()); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.appadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/Admin/productos/index.blade.php ENDPATH**/ ?>