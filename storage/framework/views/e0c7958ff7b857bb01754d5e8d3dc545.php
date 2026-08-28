<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración - VortexShop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo e(asset('css/copiadisenos.css')); ?>">
</head>
<body>
    <?php echo $__env->make('partials.menuadministrador', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="container-fluid px-4 py-4">
        <?php if(session('exito')): ?>
            <div class="vs-alert-exito mb-3"><?php echo e(session('exito')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert-vs-error mb-3"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('contenido'); ?>
    </main>
</body>
</html>
<?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/layouts/appadmin.blade.php ENDPATH**/ ?>