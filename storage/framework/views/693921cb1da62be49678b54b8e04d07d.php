

<?php $__env->startSection('contenido'); ?>
<div style="max-width: 800px; margin: 0 auto; text-align: center;">
    <h2 class="vs-page-title">Gestionar Sección <em>"Nosotros"</em></h2>
    <div class="vs-divisor" style="margin-bottom:1.6rem;"><span></span><span></span></div>

    <?php if(session('success')): ?>
        <div class="vs-alert-exito mb-3"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="inf-card" style="max-width:800px; margin: 0 auto; text-align: left;">
        <form action="<?php echo e(route('admin.nosotros.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="mb-3">
                <label for="Nombre" class="vs-form-label">Nombre de la empresa</label>
                <input type="text" name="Nombre" id="Nombre" class="vs-form-control" value="<?php echo e(old('Nombre', $info->Nombre ?? '')); ?>">
            </div>

            <div class="mb-3">
                <label for="Mision" class="vs-form-label">Misión</label>
                <textarea name="Mision" id="Mision" class="vs-form-control" rows="3"><?php echo e(old('Mision', $info->Mision ?? '')); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="Vision" class="vs-form-label">Visión</label>
                <textarea name="Vision" id="Vision" class="vs-form-control" rows="3"><?php echo e(old('Vision', $info->Vision ?? '')); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="Valores" class="vs-form-label">Valores</label>
                <textarea name="Valores" id="Valores" class="vs-form-control" rows="3"><?php echo e(old('Valores', $info->Valores ?? '')); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="Historia" class="vs-form-label">Historia</label>
                <textarea name="Historia" id="Historia" class="vs-form-control" rows="4"><?php echo e(old('Historia', $info->Historia ?? '')); ?></textarea>
            </div>

            <button type="submit" class="btn-primary-vs" style="border:none;">Guardar cambios</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.appadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/admin/nosotros/edit.blade.php ENDPATH**/ ?>