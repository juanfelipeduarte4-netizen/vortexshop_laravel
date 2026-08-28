@extends('layouts.app')

@section('titulo', '- Crear cuenta')

@section('contenido')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card-login">
                <div class="logo">
                    <h1>Vortex<span>Shop</span></h1>
                    <p>Crea tu cuenta</p>
                </div>

                <h2>Crear <em>cuenta</em></h2>

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="campo">
                                <label>Nombre</label>
                                <input type="text" name="nombre" value="{{ old('nombre') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="campo">
                                <label>Apellido</label>
                                <input type="text" name="apellido" value="{{ old('apellido') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="campo">
                        <label>Correo electrónico</label>
                        <input type="email" name="correo" value="{{ old('correo') }}" placeholder="tucorreo@ejemplo.com" required>
                        @error('correo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="campo">
                                <label>Teléfono</label>
                                <input type="text" name="telefono" value="{{ old('telefono') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="campo">
                                <label>Ciudad</label>
                                <input type="text" name="ciudad" value="{{ old('ciudad') }}">
                            </div>
                        </div>
                    </div>

                    <div class="campo">
                        <label>Dirección</label>
                        <input type="text" name="direccion" value="{{ old('direccion') }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="campo">
                                <label>Contraseña</label>
                                <input type="password" name="password" required>
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
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

                    <a href="{{ route('login') }}" class="btn-registro">Ya tengo cuenta</a>
                </form>

                <p class="footer-card">Al registrarte aceptas nuestros <a href="#">términos y condiciones</a>.</p>
            </div>
        </div>
    </div>
</div>
@endsection