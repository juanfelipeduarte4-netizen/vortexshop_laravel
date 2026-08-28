<?php $__env->startSection('contenido'); ?>
<h2 class="vs-page-title">Gestión de <em>Categorías</em></h2>
<div class="vs-divisor"><span></span><span></span></div>

<div class="row">
    <div class="col-md-4">
        <div class="inf-card">
            <h5>Nueva categoría</h5>
            <form action="<?php echo e(route('admin.categorias.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label class="vs-form-label">Nombre</label>
                    <input type="text" name="Nombre" class="vs-form-control" required>
                </div>
                <div class="mb-3">
                    <label class="vs-form-label">Descripción</label>
                    <textarea name="Descripcion" class="vs-form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn-primary-vs w-100" style="border:none;">Guardar</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <h5 class="inf-section-title" style="border:none; margin-bottom:.6rem;">Listado de categorías</h5>

        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <form id="editar-cat-<?php echo e($categoria->IdCategoria); ?>"
                  action="<?php echo e(route('admin.categorias.update', $categoria->IdCategoria)); ?>"
                  method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
            </form>
            <form id="eliminar-cat-<?php echo e($categoria->IdCategoria); ?>"
                  action="<?php echo e(route('admin.categorias.destroy', $categoria->IdCategoria)); ?>"
                  method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
            </form>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <table class="vs-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th># Productos</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <input type="text" name="Nombre" value="<?php echo e($categoria->Nombre); ?>"
                                   form="editar-cat-<?php echo e($categoria->IdCategoria); ?>"
                                   class="vs-form-control" style="padding:6px 10px;" required>
                        </td>
                        <td><?php echo e($categoria->productos_count); ?></td>
                        <td>
                            <input type="text" name="Descripcion" value="<?php echo e($categoria->Descripcion); ?>"
                                   form="editar-cat-<?php echo e($categoria->IdCategoria); ?>"
                                   class="vs-form-control" style="padding:6px 10px;">
                        </td>
                        <td class="d-flex gap-1">
                            <button type="submit" form="editar-cat-<?php echo e($categoria->IdCategoria); ?>"
                                    class="vs-btn-editar">Guardar</button>

                            <button type="submit" form="eliminar-cat-<?php echo e($categoria->IdCategoria); ?>"
                                    class="vs-btn-eliminar"
                                    onclick="return confirm('¿Eliminar esta categoría?')"
                                    <?php if($categoria->productos_count > 0): ?> disabled title="Tiene productos asociados" <?php endif; ?>>
                                Eliminar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" class="text-center vs-section-sub py-4">No hay categorías registradas.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.appadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/Admin/categorias/index.blade.php ENDPATH**/ ?>