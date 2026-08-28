@extends('layouts.app')

@section('titulo', '- Iniciar Sesión')

@section('contenido')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card-login">
                <div class="logo">
                    <h1>Vortex<span>Shop</span></h1>
                    <p>Panel de acceso</p>
                </div>

                <h2>Iniciar <em>sesión</em></h2>

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="campo">
                        <label>Correo electrónico</label>
                        <input type="email" name="correo" value="{{ old('correo') }}" placeholder="tucorreo@ejemplo.com" required autofocus>
                        @error('correo') <small class="text-danger">{{ $message }}</small> @enderror
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

                    <a href="{{ route('register') }}" class="btn-registro">Crear una cuenta</a>
                </form>

                <p class="footer-card">¿Olvidaste tu contraseña? <a href="#">Recupérala aquí</a></p>
            </div>
        </div>
    </div>
</div>
@endsection