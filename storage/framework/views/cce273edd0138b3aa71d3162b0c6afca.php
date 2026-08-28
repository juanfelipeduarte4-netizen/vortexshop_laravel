

<?php $__env->startSection('titulo', 'Buzón de sugerencias · VortexShop'); ?>

<?php $__env->startSection('contenido'); ?>
<section class="vs-section">
    <div class="container-fluid px-4">
        <h2 class="vs-section-title">Buzón de <em>sugerencias</em></h2>
        <p class="vs-section-sub">Cuéntanos qué podemos mejorar</p>

        <!-- Mensajes de Estado y Errores -->
        <div class="row mt-3">
            <div class="col-lg-12">
                <?php if(session('exito')): ?>
                    <div class="alert alert-success" style="background:#1d3528; border:1px solid #2e5940; color:#88e0a2; padding:12px; border-radius:4px; margin-bottom:20px;">
                        <?php echo e(session('exito')); ?>

                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-danger" style="background:#3b1e1e; border:1px solid #5a2a2a; color:#f88; padding:12px; border-radius:4px; margin-bottom:20px;">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger" style="background:#3b1e1e; border:1px solid #5a2a2a; color:#f88; padding:12px; border-radius:4px; margin-bottom:20px;">
                        <ul class="mb-0 ps-3">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row g-4 mt-1">
            <!-- Formulario de Envío -->
            <div class="col-lg-5">
                <div class="card-login" style="max-width:100%;">
                    <h2>Nueva <em>sugerencia</em></h2>

                    <form method="POST" action="<?php echo e(route('soporte.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="campo">
                            <label>Asunto</label>
                            <input type="text" name="Asunto" value="<?php echo e(old('Asunto')); ?>" required>
                        </div>
                        <div class="campo">
                            <label>Mensaje</label>
                            <textarea name="Mensaje" rows="4" required style="width:100%; background:var(--blue-bg); border:1px solid var(--border); border-radius:2px; padding:9px 12px; color:var(--cream); font-family:'DM Sans',sans-serif; font-size:14px;"><?php echo e(old('Mensaje')); ?></textarea>
                        </div>
                        <div class="campo">
                            <label>Calificación (opcional)</label>
                            <select name="Calificacion" style="width:100%; background:var(--blue-bg); border:1px solid var(--border); border-radius:2px; padding:9px 12px; color:var(--cream); font-size:14px;">
                                <option value="">Sin calificar</option>
                                <option value="5" <?php if(old('Calificacion') == '5'): echo 'selected'; endif; ?>>5 - Excelente</option>
                                <option value="4" <?php if(old('Calificacion') == '4'): echo 'selected'; endif; ?>>4 - Buena</option>
                                <option value="3" <?php if(old('Calificacion') == '3'): echo 'selected'; endif; ?>>3 - Regular</option>
                                <option value="2" <?php if(old('Calificacion') == '2'): echo 'selected'; endif; ?>>2 - Mala</option>
                                <option value="1" <?php if(old('Calificacion') == '1'): echo 'selected'; endif; ?>>1 - Muy mala</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-ingresar">Enviar</button>
                    </form>
                </div>
            </div>

            <!-- Listado de Sugerencias Anteriores -->
            <div class="col-lg-7">
                <h5 style="color:var(--cream); font-family:'Cormorant Garamond',serif; font-size:18px; margin-bottom:1rem;">Tus sugerencias anteriores</h5>

                <?php if($misSugerencias->isEmpty()): ?>
                    <p style="color:var(--muted); font-size:13px;">Aún no has enviado ninguna sugerencia.</p>
                <?php else: ?>
                    <?php $__currentLoopData = $misSugerencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="vs-panel mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p style="color:var(--cream); font-weight:500; margin-bottom:2px;"><?php echo e($s->Asunto); ?></p>
                                    <p style="color:var(--muted); font-size:12px;"><?php echo e(\Carbon\Carbon::parse($s->Fecha)->format('d/m/Y H:i')); ?></p>
                                </div>
                                <span class="<?php echo e($s->Estado === 'respondido' ? 'vs-badge-activo' : 'vs-badge-inactivo'); ?>">
                                    <?php echo e(str_replace('_', ' ', $s->Estado)); ?>

                                </span>
                            </div>
                            <p style="color:var(--muted); font-size:13px; margin-top:8px;"><?php echo e($s->Mensaje); ?></p>

                            <?php if($s->Respuesta): ?>
                                <div style="border-left:2px solid var(--blue); padding-left:12px; margin-top:10px;">
                                    <p style="color:var(--blue); font-size:11px; letter-spacing:1px; text-transform:uppercase;">Respuesta</p>
                                    <p style="color:var(--cream); font-size:13px;"><?php echo e($s->Respuesta); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/soporte.blade.php ENDPATH**/ ?>