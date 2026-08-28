<?php $__env->startSection('titulo', '- Mi carrito'); ?>

<?php $__env->startSection('contenido'); ?>
<section class="vs-section">
    <div class="container-fluid px-4">
        <h2 class="vs-section-title" style="font-size:1.8rem;">Mi <em>carrito</em></h2>
        <p class="vs-section-sub"><?php echo e(count($carrito)); ?> artículo(s)</p>

        <?php if(session('error')): ?>
            <div class="alert-vs-error mb-3" style="max-width:700px;"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <?php if(count($carrito) === 0): ?>
            <p style="color:var(--muted);">Tu carrito está vacío. <a href="<?php echo e(route('catalogo.index')); ?>" class="vs-nav-link">Ver catálogo →</a></p>
        <?php else: ?>
            <div class="vs-panel">
                <table class="vs-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $carrito; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php if($item['imagen'] ?? null): ?>
                                        <img src="<?php echo e(asset('storage/' . $item['imagen'])); ?>" alt="<?php echo e($item['nombre']); ?>" class="vs-thumb">
                                    <?php else: ?>
                                        <div class="vs-thumb" style="background:var(--blue-bg);"></div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($item['nombre']); ?></td>
                                <td>
                                    <?php if($item['tiene_descuento']): ?>
                                        $<?php echo e(number_format($item['precio_final'], 0, ',', '.')); ?>

                                        <s style="color:var(--dim); font-size:12px;">$<?php echo e(number_format($item['precio_original'], 0, ',', '.')); ?></s>
                                    <?php else: ?>
                                        $<?php echo e(number_format($item['precio_original'], 0, ',', '.')); ?>

                                    <?php endif; ?>
                                </td>
                                <td style="max-width:120px;">
                                    <form method="POST" action="<?php echo e(route('carrito.actualizar', $id)); ?>" class="d-flex gap-2">
                                        <?php echo csrf_field(); ?>
                                        <input type="number" name="cantidad" value="<?php echo e($item['cantidad']); ?>" min="1"
                                               class="vs-form-control" style="padding:6px 8px; font-size:13px;">
                                        <button type="submit" class="vs-btn-sm">↻</button>
                                    </form>
                                </td>
                                <td>$<?php echo e(number_format($item['precio_final'] * $item['cantidad'], 0, ',', '.')); ?></td>
                                <td>
                                    <form method="POST" action="<?php echo e(route('carrito.eliminar', $id)); ?>" onsubmit="return confirm('¿Quitar este producto del carrito?');">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="vs-btn-sm vs-btn-sm-danger">Quitar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <form method="POST" action="<?php echo e(route('carrito.vaciar')); ?>" onsubmit="return confirm('¿Vaciar todo el carrito?');">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-secondary-vs" style="border-color:#e57373; color:#e57373;">Vaciar carrito</button>
                    </form>

                    <div class="text-end">
                        <p class="vs-form-label" style="margin-bottom:4px;">Total</p>
                        <p style="color:var(--cream); font-size:24px; font-family:'Cormorant Garamond',serif; margin-bottom:.6rem;">
                            $<?php echo e(number_format($total, 0, ',', '.')); ?>

                        </p>
                        <button class="btn-ingresar" style="width:auto; padding:10px 28px;" disabled title="Proceso de pago: próximamente">
                            Finalizar compra
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/carrito/index.blade.php ENDPATH**/ ?>