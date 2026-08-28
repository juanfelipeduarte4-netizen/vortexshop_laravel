<header class="vs-navbar">
    <div class="container-fluid px-4">
        <div class="row align-items-center py-3">

            <div class="col-auto">
                <a href="<?php echo e(route('inicio')); ?>" class="vs-logo" style="text-decoration:none;">Vortex<span>Shop</span></a>
            </div>

            <div class="col d-flex justify-content-center gap-4">
                <a href="<?php echo e(route('inicio')); ?>" class="vs-nav-link">Inicio</a>
                <a href="<?php echo e(route('catalogo.index')); ?>" class="vs-nav-link">Catálogo</a>
                <a href="<?php echo e(route('nosotros.index')); ?>" class="vs-nav-link">Nosotros</a>
                <a href="<?php echo e(route('soporte.create')); ?>" class="vs-nav-link">Buzon de Sugerencias</a>
            </div>

            <div class="col-auto d-flex align-items-center gap-3">
                <a href="<?php echo e(route('carrito.index')); ?>" class="vs-nav-link position-relative" title="Mi carrito" style="font-size:16px;">
                    🛒
                    <?php if($cantidadCarrito > 0): ?>
                        <span class="badge bg-primary rounded-pill position-absolute top-0 start-100 translate-middle" style="font-size:9px;">
                            <?php echo e($cantidadCarrito); ?>

                        </span>
                    <?php endif; ?>
                </a>

                <?php if(auth()->guard()->check()): ?>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-ingresar-nav" style="border:none;">Cerrar Sesión</button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="vs-nav-link">Iniciar Sesión</a>
                    <a href="<?php echo e(route('register')); ?>" class="btn-ingresar-nav">Registrarse</a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</header>
<?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/partials/menu.blade.php ENDPATH**/ ?>