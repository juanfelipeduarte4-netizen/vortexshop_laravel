<?php $__env->startSection('titulo', '- Catálogo'); ?>

<?php $__env->startSection('contenido'); ?>
<div class="container-fluid px-4 py-4">
    <div class="row g-4">

        
        <div class="col-12 col-lg-3">
            <h5 class="vs-section-title" style="font-size:1.3rem;">Filtros</h5>
            <div class="inf-card">
                <form method="GET" action="<?php echo e(route('catalogo.index')); ?>">
                    <div class="mb-3">
                        <label class="vs-form-label">Buscar</label>
                        <input type="text" name="q" class="vs-form-control" value="<?php echo e(request('q')); ?>" placeholder="Nombre o descripción...">
                    </div>

                    <div class="mb-3">
                        <label class="vs-form-label">Categoría</label>
                        <select name="categoria" class="vs-form-control">
                            <option value="">Todas</option>
                            <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($categoria->IdCategoria); ?>" <?php echo e(request('categoria') == $categoria->IdCategoria ? 'selected' : ''); ?>>
                                    <?php echo e($categoria->Nombre); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <?php if($tallas->count()): ?>
                    <div class="mb-3">
                        <label class="vs-form-label">Talla</label>
                        <select name="talla" class="vs-form-control">
                            <option value="">Todas</option>
                            <?php $__currentLoopData = $tallas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $talla): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($talla); ?>" <?php echo e(request('talla') == $talla ? 'selected' : ''); ?>><?php echo e($talla); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <?php if($colores->count()): ?>
                    <div class="mb-3">
                        <label class="vs-form-label">Color</label>
                        <select name="color" class="vs-form-control">
                            <option value="">Todos</option>
                            <?php $__currentLoopData = $colores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($color); ?>" <?php echo e(request('color') == $color ? 'selected' : ''); ?>><?php echo e($color); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="vs-form-label">Precio mín.</label>
                            <input type="number" name="precio_min" class="vs-form-control" value="<?php echo e(request('precio_min')); ?>">
                        </div>
                        <div class="col-6">
                            <label class="vs-form-label">Precio máx.</label>
                            <input type="number" name="precio_max" class="vs-form-control" value="<?php echo e(request('precio_max')); ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-vs w-100" style="border:none;">Filtrar</button>
                    <a href="<?php echo e(route('catalogo.index')); ?>" class="btn-secondary-vs w-100 mt-2 text-center d-block">Limpiar</a>
                </form>
            </div>
        </div>

        
        <div class="col-12 col-lg-9">
            <p class="vs-section-sub"><?php echo e($productos->total()); ?> producto(s) encontrado(s)</p>

            <div class="row g-3">
                <?php $__empty_1 = true; $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php $img = $producto->imagenes->first() ?? null; ?>
                    <div class="col-6 col-md-4">
                        <div class="vs-prod-card h-100 d-flex flex-column">
                            <div class="vs-prod-img" style="<?php echo e($img ? 'background-image:url(' . asset('storage/'.$img->Ruta) . '); background-size:cover; background-position:center;' : ''); ?>"></div>
                            <div class="vs-prod-body flex-grow-1 d-flex flex-column">
                                <p class="vs-prod-cat"><?php echo e($producto->categoria->Nombre ?? 'Sin categoría'); ?></p>
                                <p class="vs-prod-name"><?php echo e($producto->Nombre); ?></p>
                                <?php if($producto->tieneDescuento()): ?>
                                    <p class="vs-prod-price">
                                        $<?php echo e(number_format($producto->precioFinal(), 0, ',', '.')); ?>

                                        <s>$<?php echo e(number_format($producto->Precio, 0, ',', '.')); ?></s>
                                    </p>
                                <?php else: ?>
                                    <p class="vs-prod-price">$<?php echo e(number_format($producto->Precio, 0, ',', '.')); ?></p>
                                <?php endif; ?>
                                <div class="vs-prod-footer mt-auto">
                                    <a href="<?php echo e(route('catalogo.show', $producto->IdProducto)); ?>" class="btn-secondary-vs" style="padding:6px 14px; font-size:11px;">Ver detalle</a>
                                    <?php if($producto->tieneDescuento()): ?>
                                        <span class="vs-badge">-<?php echo e(rtrim(rtrim(number_format($producto->promocionVigente()->PorcentajeDescuento, 2), '0'), '.')); ?>%</span>
                                    <?php endif; ?>
                                    <form action="<?php echo e(route('carrito.agregar', $producto->IdProducto)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="cantidad" value="1">
                                        <button type="submit" class="vs-btn-carrito">+ Carrito</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12">
                        <p class="vs-section-sub" style="text-align:center; padding:3rem 0;">No se encontraron productos con esos filtros.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mt-4">
                <?php echo e($productos->links()); ?>

            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/catalogo.blade.php ENDPATH**/ ?>