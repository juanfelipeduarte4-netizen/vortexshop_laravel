@extends('layouts.app')

@section('contenido')

@php
    $categoriasHome = \App\Models\Categoria::withCount('productos')->orderBy('Nombre')->limit(4)->get();
@endphp

<section class="vs-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 text-center">
                <p class="vs-hero-tag">Bienvenido</p>
                <h1 class="vs-hero-title">Bienvenido a <em>VortexShop</em></h1>
                <p class="vs-hero-sub">Explora nuestro catálogo y realiza tus compras de manera sencilla.</p>
                <div class="vs-hero-btns">
                    <a href="{{ route('catalogo.index') }}" class="btn-primary-vs">Ver catálogo</a>
                </div>
            </div>
        </div>
    </div>
</section>

@if($categoriasHome->isNotEmpty())
    <div class="vs-divisor"><span></span><p>Categorías</p><span></span></div>

    <section class="vs-section">
        <div class="container-fluid px-4">
            <h2 class="vs-section-title">Explorar <em>categorías</em></h2>
            <p class="vs-section-sub">Colección actual</p>
            <div class="row g-3">
                @foreach($categoriasHome as $categoria)
                    <div class="col-6 col-md-3">
                        <a href="{{ route('catalogo.index', ['categoria' => $categoria->IdCategoria]) }}" style="text-decoration:none;">
                            <div class="vs-cat-card">
                                <p class="vs-cat-name">{{ $categoria->Nombre }}</p>
                                <p class="vs-cat-count">{{ $categoria->productos_count }} productos</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

@endsection
