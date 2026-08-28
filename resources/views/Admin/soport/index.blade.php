@extends('layouts.appadmin')

@section('titulo', '- Buzón de sugerencias')

@section('contenido')
<h2 class="vs-page-title">Buzón de <em>sugerencias</em></h2>
<p class="vs-section-sub" style="margin-bottom:1.4rem;">{{ $tickets->total() }} mensaje(s) en total</p>

@if (session('exito'))
    <div class="vs-alert-exito mb-3">{{ session('exito') }}</div>
@endif

<form method="GET" class="mb-4">
    <div class="row g-2 align-items-end" style="max-width:420px;">
        <div class="col-8">
            <label class="vs-form-label">Filtrar por estado</label>
            <select name="estado" class="vs-form-control">
                <option value="">Todos</option>
                <option value="pendiente" @selected(request('estado') === 'pendiente')>Pendiente</option>
                <option value="en_revision" @selected(request('estado') === 'en_revision')>En revisión</option>
                <option value="respondido" @selected(request('estado') === 'respondido')>Respondido</option>
            </select>
        </div>
        <div class="col-4">
            <button type="submit" class="btn-secondary-vs w-100">Filtrar</button>
        </div>
    </div>
</form>

@forelse ($tickets as $ticket)
    @php
        $badgeClase = match($ticket->Estado) {
            'respondido'  => 'inf-badge-simple',
            'en_revision' => 'inf-badge-param',
            default       => 'inf-badge-multi',
        };
    @endphp
    <div class="inf-card mb-3">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h5 style="margin-bottom:2px;">{{ $ticket->Asunto }}</h5>
                <p style="color:var(--dim); font-size:11px; margin-bottom:0;">
                    {{ $ticket->cliente->Nombre ?? 'Cliente' }} {{ $ticket->cliente->Apellido ?? '' }}
                    · {{ \Carbon\Carbon::parse($ticket->Fecha)->format('d/m/Y H:i') }}
                    @if ($ticket->Calificacion) · Calificación: {{ $ticket->Calificacion }}/5 @endif
                </p>
            </div>
            <span class="inf-badge {{ $badgeClase }}">{{ str_replace('_', ' ', $ticket->Estado) }}</span>
        </div>

        <p style="color:var(--cream); font-size:13px; margin:.8rem 0;">{{ $ticket->Mensaje }}</p>

        @if ($ticket->Respuesta)
            <div style="border-left:2px solid var(--blue); padding-left:12px; margin-top:.6rem;">
                <p style="color:var(--blue); font-size:11px; font-weight:500; letter-spacing:1px; text-transform:uppercase; margin-bottom:4px;">
                    Tu respuesta ({{ \Carbon\Carbon::parse($ticket->FechaRespuesta)->format('d/m/Y H:i') }})
                </p>
                <p style="color:var(--muted); font-size:13px; margin:0;">{{ $ticket->Respuesta }}</p>
            </div>
        @else
            <form method="POST" action="{{ route('admin.soporte.responder', $ticket) }}" class="mt-2">
                @csrf
                <textarea name="Respuesta" rows="2" class="vs-form-control mb-2" placeholder="Escribe tu respuesta..." required></textarea>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-primary-vs" style="border:none; padding:8px 18px; font-size:11px;">Responder</button>
                    @if ($ticket->Estado === 'pendiente')
                        <button type="submit" formaction="{{ route('admin.soporte.enRevision', $ticket) }}" formnovalidate
                                class="btn-secondary-vs" style="padding:8px 18px; font-size:11px;">
                            Marcar en revisión
                        </button>
                    @endif
                </div>
            </form>
        @endif
    </div>
@empty
    <p class="vs-section-sub" style="text-align:center; padding:3rem 0;">No hay mensajes de soporte todavía.</p>
@endforelse

<div class="mt-3">
    {{ $tickets->links() }}
</div>
@endsection