<?php $__env->startSection('titulo', '- Nosotros'); ?>

<?php $__env->startSection('contenido'); ?>

<section class="vs-hero" style="padding:3.5rem 0 2rem;">
    <div class="container text-center">
        <p class="vs-hero-tag">Nosotros</p>
        <h1 class="vs-hero-title" style="font-size:2.6rem;">Sobre <em><?php echo e($info->Nombre ?? 'Nosotros'); ?></em></h1>
    </div>
</section>

<div class="container-fluid px-4" style="max-width:1000px; margin:0 auto;">

    <?php if($info->Historia ?? false): ?>
        <div class="inf-card mb-4">
            <h5 class="inf-section-title" style="font-size:.9rem;">Nuestra historia</h5>
            <p style="color:var(--muted); font-size:14px; line-height:1.8; margin:0;"><?php echo e($info->Historia); ?></p>
        </div>
    <?php endif; ?>

    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="inf-card h-100">
                <h5 class="inf-section-title" style="font-size:.85rem;">Misión</h5>
                <p style="color:var(--muted); font-size:13px; line-height:1.7; margin:0;"><?php echo e($info->Mision); ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="inf-card h-100">
                <h5 class="inf-section-title" style="font-size:.85rem;">Visión</h5>
                <p style="color:var(--muted); font-size:13px; line-height:1.7; margin:0;"><?php echo e($info->Vision); ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="inf-card h-100">
                <h5 class="inf-section-title" style="font-size:.85rem;">Valores</h5>
                <p style="color:var(--muted); font-size:13px; line-height:1.7; margin:0;"><?php echo e($info->Valores); ?></p>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/nosotros.blade.php ENDPATH**/ ?>