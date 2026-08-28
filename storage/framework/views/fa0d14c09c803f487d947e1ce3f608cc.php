<?php $__env->startSection('titulo', '- Iniciar Sesión'); ?>

<?php $__env->startSection('contenido'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card-login">
                <div class="logo">
                    <h1>Vortex<span>Shop</span></h1>
                    <p>Panel de acceso</p>
                </div>

                <h2>Iniciar <em>sesión</em></h2>

                <form action="<?php echo e(route('login')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="campo">
                        <label>Correo electrónico</label>
                        <input type="email" name="correo" value="<?php echo e(old('correo')); ?>" placeholder="tucorreo@ejemplo.com" required autofocus>
                        <?php $__errorArgs = ['correo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="campo">
                        <label>Contraseña</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>

                    <div class="fila-opciones">
                        <label class="recordarme">
                            <input type="checkbox" name="recordarme">
                            Recordarme
                        </label>
                    </div>

                    <button type="submit" class="btn-ingresar">Ingresar</button>

                    <div class="divisor"><span></span><p>o</p><span></span></div>

                    <a href="<?php echo e(route('register')); ?>" class="btn-registro">Crear una cuenta</a>
                </form>

                <p class="footer-card">¿Olvidaste tu contraseña? <a href="#">Recupérala aquí</a></p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/auth/login.blade.php ENDPATH**/ ?>