<nav class="vs-admin-nav">
    <div class="container-fluid px-4">
        <div class="row align-items-center py-3">
            <div class="col-auto">
                <a class="vs-admin-brand" href="<?php echo e(route('admin.dashboard')); ?>">Vortex<span>Shop</span> Admin</a>
            </div>
            <div class="col d-flex gap-4 flex-wrap">
                <a class="vs-admin-link <?php echo e(request()->routeIs('admin.dashboard') ? 'activo' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
                <a class="vs-admin-link <?php echo e(request()->routeIs('admin.categorias.*') ? 'activo' : ''); ?>" href="<?php echo e(route('admin.categorias.index')); ?>">Categorías</a>
                <a class="vs-admin-link <?php echo e(request()->routeIs('admin.productos.*') ? 'activo' : ''); ?>" href="<?php echo e(route('admin.productos.index')); ?>">Productos</a>
                <a class="vs-admin-link <?php echo e(request()->routeIs('admin.promociones.*') ? 'activo' : ''); ?>" href="<?php echo e(route('admin.promociones.index')); ?>">Promociones</a>
                <a class="vs-admin-link <?php echo e(request()->routeIs('admin.soporte.*') ? 'activo' : ''); ?>" href="<?php echo e(route('admin.soporte.index')); ?>">Buzón de Sugerencias</a>
                <a class="vs-admin-link <?php echo e(request()->routeIs('admin.nosotros') ? 'activo' : ''); ?>" href="<?php echo e(route('admin.nosotros')); ?>">Nosotros</a>
                <a class="vs-admin-link" href="<?php echo e(route('inicio')); ?>" target="_blank">Ver tienda</a>
            </div>
            <div class="col-auto">
                <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="vs-admin-logout">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</nav><?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/partials/menuadministrador.blade.php ENDPATH**/ ?>