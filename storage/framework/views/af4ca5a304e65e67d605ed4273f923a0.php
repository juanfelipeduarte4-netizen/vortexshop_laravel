<?php $__env->startSection('contenido'); ?>

<?php
    $categoriasHome = \App\Models\Categoria::withCount('productos')->orderBy('Nombre')->limit(4)->get();
?>

<section class="vs-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 text-center">
                <p class="vs-hero-tag">Bienvenido</p>
                <h1 class="vs-hero-title">Bienvenido a <em>VortexShop</em></h1>
                <p class="vs-hero-sub">Explora nuestro catálogo y realiza tus compras de manera sencilla.</p>
                <div class="vs-hero-btns">
                    <a href="<?php echo e(route('catalogo.index')); ?>" class="btn-primary-vs">Ver catálogo</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if($categoriasHome->isNotEmpty()): ?>
    <div class="vs-divisor"><span></span><p>Categorías</p><span></span></div>

    <section class="vs-section">
        <div class="container-fluid px-4">
            <h2 class="vs-section-title">Explorar <em>categorías</em></h2>
            <p class="vs-section-sub">Colección actual</p>
            <div class="row g-3">
                <?php $__currentLoopData = $categoriasHome; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-6 col-md-3">
                        <a href="<?php echo e(route('catalogo.index', ['categoria' => $categoria->IdCategoria])); ?>" style="text-decoration:none;">
                            <div class="vs-cat-card">
                                <p class="vs-cat-name"><?php echo e($categoria->Nombre); ?></p>
                                <p class="vs-cat-count"><?php echo e($categoria->productos_count); ?> productos</p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/index.blade.php ENDPATH**/ ?>