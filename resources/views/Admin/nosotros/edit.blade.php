@extends('layouts.appadmin')

@section('contenido')
<div style="max-width: 800px; margin: 0 auto; text-align: center;">
    <h2 class="vs-page-title">Gestionar Sección <em>"Nosotros"</em></h2>
    <div class="vs-divisor" style="margin-bottom:1.6rem;"><span></span><span></span></div>

    @if(session('success'))
        <div class="vs-alert-exito mb-3">{{ session('success') }}</div>
    @endif

    <div class="inf-card" style="max-width:800px; margin: 0 auto; text-align: left;">
        <form action="{{ route('admin.nosotros.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="Nombre" class="vs-form-label">Nombre de la empresa</label>
                <input type="text" name="Nombre" id="Nombre" class="vs-form-control" value="{{ old('Nombre', $info->Nombre ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="Mision" class="vs-form-label">Misión</label>
                <textarea name="Mision" id="Mision" class="vs-form-control" rows="3">{{ old('Mision', $info->Mision ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="Vision" class="vs-form-label">Visión</label>
                <textarea name="Vision" id="Vision" class="vs-form-control" rows="3">{{ old('Vision', $info->Vision ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="Valores" class="vs-form-label">Valores</label>
                <textarea name="Valores" id="Valores" class="vs-form-control" rows="3">{{ old('Valores', $info->Valores ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="Historia" class="vs-form-label">Historia</label>
                <textarea name="Historia" id="Historia" class="vs-form-control" rows="4">{{ old('Historia', $info->Historia ?? '') }}</textarea>
            </div>

            <button type="submit" class="btn-primary-vs" style="border:none;">Guardar cambios</button>
        </form>
    </div>
</div>
@endsection