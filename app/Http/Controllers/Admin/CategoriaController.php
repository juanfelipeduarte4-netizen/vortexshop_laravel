<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::withCount('productos')->orderBy('Nombre')->get();
        return view('Admin.categorias.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'Nombre'      => 'required|string|max:100|unique:categoria,Nombre',
            'Descripcion' => 'nullable|string',
        ]);

        Categoria::create($datos);
        return redirect()->back()->with('exito', 'Categoría creada con éxito.');
    }

    public function update(Request $request, Categoria $categoria)
    {
        $datos = $request->validate([
            'Nombre'      => 'required|string|max:100|unique:categoria,Nombre,' . $categoria->IdCategoria . ',IdCategoria',
            'Descripcion' => 'nullable|string',
        ]);

        $categoria->update($datos);
        return redirect()->back()->with('exito', 'Categoría actualizada.');
    }

    public function destroy(Categoria $categoria)
    {
        if ($categoria->productos()->exists()) {
            return redirect()->back()->with('error', 'No puedes eliminar una categoría con productos asociados.');
        }

        $categoria->delete();
        return redirect()->back()->with('exito', 'Categoría eliminada.');
    }
}
