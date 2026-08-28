@extends('layouts.app')

@section('titulo', '- Nosotros')

@section('contenido')

<section class="vs-hero" style="padding:3.5rem 0 2rem;">
    <div class="container text-center">
        <p class="vs-hero-tag">Nosotros</p>
        <h1 class="vs-hero-title" style="font-size:2.6rem;">Sobre <em>{{ $info->Nombre ?? 'Nosotros' }}</em></h1>
    </div>
</section>

<div class="container-fluid px-4" style="max-width:1000px; margin:0 auto;">

    @if($info->Historia ?? false)
        <div class="inf-card mb-4">
            <h5 class="inf-section-title" style="font-size:.9rem;">Nuestra historia</h5>
            <p style="color:var(--muted); font-size:14px; line-height:1.8; margin:0;">{{ $info->Historia }}</p>
        </div>
    @endif

    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="inf-card h-100">
                <h5 class="inf-section-title" style="font-size:.85rem;">Misión</h5>
                <p style="color:var(--muted); font-size:13px; line-height:1.7; margin:0;">{{ $info->Mision }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="inf-card h-100">
                <h5 class="inf-section-title" style="font-size:.85rem;">Visión</h5>
                <p style="color:var(--muted); font-size:13px; line-height:1.7; margin:0;">{{ $info->Vision }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="inf-card h-100">
                <h5 class="inf-section-title" style="font-size:.85rem;">Valores</h5>
                <p style="color:var(--muted); font-size:13px; line-height:1.7; margin:0;">{{ $info->Valores }}</p>
            </div>
        </div>
    </div>

</div>
@endsection