

<?php $__env->startSection('titulo', '- Buzón de sugerencias'); ?>

<?php $__env->startSection('contenido'); ?>
<h2 class="vs-page-title">Buzón de <em>sugerencias</em></h2>
<p class="vs-section-sub" style="margin-bottom:1.4rem;"><?php echo e($tickets->total()); ?> mensaje(s) en total</p>

<?php if(session('exito')): ?>
    <div class="vs-alert-exito mb-3"><?php echo e(session('exito')); ?></div>
<?php endif; ?>

<form method="GET" class="mb-4">
    <div class="row g-2 align-items-end" style="max-width:420px;">
        <div class="col-8">
            <label class="vs-form-label">Filtrar por estado</label>
            <select name="estado" class="vs-form-control">
                <option value="">Todos</option>
                <option value="pendiente" <?php if(request('estado') === 'pendiente'): echo 'selected'; endif; ?>>Pendiente</option>
                <option value="en_revision" <?php if(request('estado') === 'en_revision'): echo 'selected'; endif; ?>>En revisión</option>
                <option value="respondido" <?php if(request('estado') === 'respondido'): echo 'selected'; endif; ?>>Respondido</option>
            </select>
        </div>
        <div class="col-4">
            <button type="submit" class="btn-secondary-vs w-100">Filtrar</button>
        </div>
    </div>
</form>

<?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $badgeClase = match($ticket->Estado) {
            'respondido'  => 'inf-badge-simple',
            'en_revision' => 'inf-badge-param',
            default       => 'inf-badge-multi',
        };
    ?>
    <div class="inf-card mb-3">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h5 style="margin-bottom:2px;"><?php echo e($ticket->Asunto); ?></h5>
                <p style="color:var(--dim); font-size:11px; margin-bottom:0;">
                    <?php echo e($ticket->cliente->Nombre ?? 'Cliente'); ?> <?php echo e($ticket->cliente->Apellido ?? ''); ?>

                    · <?php echo e(\Carbon\Carbon::parse($ticket->Fecha)->format('d/m/Y H:i')); ?>

                    <?php if($ticket->Calificacion): ?> · Calificación: <?php echo e($ticket->Calificacion); ?>/5 <?php endif; ?>
                </p>
            </div>
            <span class="inf-badge <?php echo e($badgeClase); ?>"><?php echo e(str_replace('_', ' ', $ticket->Estado)); ?></span>
        </div>

        <p style="color:var(--cream); font-size:13px; margin:.8rem 0;"><?php echo e($ticket->Mensaje); ?></p>

        <?php if($ticket->Respuesta): ?>
            <div style="border-left:2px solid var(--blue); padding-left:12px; margin-top:.6rem;">
                <p style="color:var(--blue); font-size:11px; font-weight:500; letter-spacing:1px; text-transform:uppercase; margin-bottom:4px;">
                    Tu respuesta (<?php echo e(\Carbon\Carbon::parse($ticket->FechaRespuesta)->format('d/m/Y H:i')); ?>)
                </p>
                <p style="color:var(--muted); font-size:13px; margin:0;"><?php echo e($ticket->Respuesta); ?></p>
            </div>
        <?php else: ?>
            <form method="POST" action="<?php echo e(route('admin.soporte.responder', $ticket)); ?>" class="mt-2">
                <?php echo csrf_field(); ?>
                <textarea name="Respuesta" rows="2" class="vs-form-control mb-2" placeholder="Escribe tu respuesta..." required></textarea>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-primary-vs" style="border:none; padding:8px 18px; font-size:11px;">Responder</button>
                    <?php if($ticket->Estado === 'pendiente'): ?>
                        <button type="submit" formaction="<?php echo e(route('admin.soporte.enRevision', $ticket)); ?>" formnovalidate
                                class="btn-secondary-vs" style="padding:8px 18px; font-size:11px;">
                            Marcar en revisión
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        <?php endif; ?>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="vs-section-sub" style="text-align:center; padding:3rem 0;">No hay mensajes de soporte todavía.</p>
<?php endif; ?>

<div class="mt-3">
    <?php echo e($tickets->links()); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.appadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/Admin/soport/index.blade.php ENDPATH**/ ?>