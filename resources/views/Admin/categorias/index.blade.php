@extends('layouts.appadmin')

@section('contenido')
<h2 class="vs-page-title">Gestión de <em>Categorías</em></h2>
<div class="vs-divisor"><span></span><span></span></div>

<div class="row">
    <div class="col-md-4">
        <div class="inf-card">
            <h5>Nueva categoría</h5>
            <form action="{{ route('admin.categorias.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="vs-form-label">Nombre</label>
                    <input type="text" name="Nombre" class="vs-form-control" required>
                </div>
                <div class="mb-3">
                    <label class="vs-form-label">Descripción</label>
                    <textarea name="Descripcion" class="vs-form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn-primary-vs w-100" style="border:none;">Guardar</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <h5 class="inf-section-title" style="border:none; margin-bottom:.6rem;">Listado de categorías</h5>

        @foreach($categorias as $categoria)
            <form id="editar-cat-{{ $categoria->IdCategoria }}"
                  action="{{ route('admin.categorias.update', $categoria->IdCategoria) }}"
                  method="POST">
                @csrf
                @method('PUT')
            </form>
            <form id="eliminar-cat-{{ $categoria->IdCategoria }}"
                  action="{{ route('admin.categorias.destroy', $categoria->IdCategoria) }}"
                  method="POST">
                @csrf
                @method('DELETE')
            </form>
        @endforeach

        <table class="vs-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th># Productos</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categorias as $categoria)
                    <tr>
                        <td>
                            <input type="text" name="Nombre" value="{{ $categoria->Nombre }}"
                                   form="editar-cat-{{ $categoria->IdCategoria }}"
                                   class="vs-form-control" style="padding:6px 10px;" required>
                        </td>
                        <td>{{ $categoria->productos_count }}</td>
                        <td>
                            <input type="text" name="Descripcion" value="{{ $categoria->Descripcion }}"
                                   form="editar-cat-{{ $categoria->IdCategoria }}"
                                   class="vs-form-control" style="padding:6px 10px;">
                        </td>
                        <td class="d-flex gap-1">
                            <button type="submit" form="editar-cat-{{ $categoria->IdCategoria }}"
                                    class="vs-btn-editar">Guardar</button>

                            <button type="submit" form="eliminar-cat-{{ $categoria->IdCategoria }}"
                                    class="vs-btn-eliminar"
                                    onclick="return confirm('¿Eliminar esta categoría?')"
                                    @if($categoria->productos_count > 0) disabled title="Tiene productos asociados" @endif>
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center vs-section-sub py-4">No hay categorías registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection