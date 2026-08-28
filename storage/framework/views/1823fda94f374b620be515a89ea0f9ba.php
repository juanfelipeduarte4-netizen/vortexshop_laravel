<?php $__env->startSection('titulo', '- Crear cuenta'); ?>

<?php $__env->startSection('contenido'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card-login">
                <div class="logo">
                    <h1>Vortex<span>Shop</span></h1>
                    <p>Crea tu cuenta</p>
                </div>

                <h2>Crear <em>cuenta</em></h2>

                <form action="<?php echo e(route('register')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="campo">
                                <label>Nombre</label>
                                <input type="text" name="nombre" value="<?php echo e(old('nombre')); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="campo">
                                <label>Apellido</label>
                                <input type="text" name="apellido" value="<?php echo e(old('apellido')); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="campo">
                        <label>Correo electrónico</label>
                        <input type="email" name="correo" value="<?php echo e(old('correo')); ?>" placeholder="tucorreo@ejemplo.com" required>
                        <?php $__errorArgs = ['correo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="campo">
                                <label>Teléfono</label>
                                <input type="text" name="telefono" value="<?php echo e(old('telefono')); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="campo">
                                <label>Ciudad</label>
                                <input type="text" name="ciudad" value="<?php echo e(old('ciudad')); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="campo">
                        <label>Dirección</label>
                        <input type="text" name="direccion" value="<?php echo e(old('direccion')); ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="campo">
                                <label>Contraseña</label>
                                <input type="password" name="password" required>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="campo">
                                <label>Confirmar contraseña</label>
                                <input type="password" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-ingresar mt-2">Registrarse</button>

                    <div class="divisor"><span></span><p>o</p><span></span></div>

                    <a href="<?php echo e(route('login')); ?>" class="btn-registro">Ya tengo cuenta</a>
                </form>

                <p class="footer-card">Al registrarte aceptas nuestros <a href="#">términos y condiciones</a>.</p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Laravel_VortexShopcorregido\resources\views/auth/register.blade.php ENDPATH**/ ?>