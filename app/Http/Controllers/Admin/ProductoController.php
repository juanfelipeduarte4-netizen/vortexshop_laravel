<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Inventario;
use App\Models\Imagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['categoria', 'inventario', 'imagenes'])
            ->orderByDesc('IdProducto')
            ->paginate(15);

        return view('Admin.productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('Nombre')->get();
        return view('Admin.productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'IdCategoria' => 'required|exists:categoria,IdCategoria',
            'Nombre'      => 'required|string|max:150',
            'Descripcion' => 'nullable|string',
            'Precio'      => 'required|numeric|min:0',
            'Vigencia'    => 'nullable|boolean',
            'Color'       => 'required|string|max:50',
            'Talla'       => 'required|string|max:20',
            'Stock'       => 'required|integer|min:0',
            'Imagen'      => 'nullable|image|max:2048',
        ]);

        $producto = Producto::create([
            'IdCategoria' => $datos['IdCategoria'],
            'Nombre'      => $datos['Nombre'],
            'Descripcion' => $datos['Descripcion'] ?? null,
            'Precio'      => $datos['Precio'],
            'Vigencia'    => $datos['Vigencia'] ?? 1,
            'Estado'      => 'activo',
        ]);

        Inventario::create([
            'IdProducto' => $producto->IdProducto,
            'Color'      => $datos['Color'],
            'Talla'      => $datos['Talla'],
            'Stock'      => $datos['Stock'],
            'Estado'     => $datos['Stock'] > 0 ? 'disponible' : 'agotado',
        ]);

        if ($request->hasFile('Imagen')) {
            $archivo = $request->file('Imagen');
            $ruta = $archivo->store('productos', 'public');

            Imagen::create([
                'IdProducto' => $producto->IdProducto,
                'Formato'    => $archivo->getClientOriginalExtension(),
                'Tamano'     => $archivo->getSize(),
                'Ruta'       => $ruta,
            ]);
        }

        return redirect()->route('admin.productos.index')->with('exito', 'Producto creado.');
    }

    public function edit($id)
    {
        $producto = Producto::with(['inventario', 'imagenes'])->findOrFail($id);
        $categorias = Categoria::orderBy('Nombre')->get();
        return view('Admin.productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $datos = $request->validate([
            'IdCategoria' => 'required|exists:categoria,IdCategoria',
            'Nombre'      => 'required|string|max:150',
            'Descripcion' => 'nullable|string',
            'Precio'      => 'required|numeric|min:0',
            'Vigencia'    => 'nullable|boolean',
            'Color'       => 'required|string|max:50',
            'Talla'       => 'required|string|max:20',
            'Stock'       => 'required|integer|min:0',
            'Imagen'      => 'nullable|image|max:2048',
        ]);

        $producto->update([
            'IdCategoria' => $datos['IdCategoria'],
            'Nombre'      => $datos['Nombre'],
            'Descripcion' => $datos['Descripcion'] ?? null,
            'Precio'      => $datos['Precio'],
            'Vigencia'    => $datos['Vigencia'] ?? 1,
        ]);

        // Actualiza el primer registro de inventario asociado (asume 1 variante por ahora)
        $inventario = Inventario::where('IdProducto', $producto->IdProducto)->first();
        if ($inventario) {
            $inventario->update([
                'Color'  => $datos['Color'],
                'Talla'  => $datos['Talla'],
                'Stock'  => $datos['Stock'],
                'Estado' => $datos['Stock'] > 0 ? 'disponible' : 'agotado',
            ]);
        } else {
            Inventario::create([
                'IdProducto' => $producto->IdProducto,
                'Color'      => $datos['Color'],
                'Talla'      => $datos['Talla'],
                'Stock'      => $datos['Stock'],
                'Estado'     => $datos['Stock'] > 0 ? 'disponible' : 'agotado',
            ]);
        }

        if ($request->hasFile('Imagen')) {
            $archivo = $request->file('Imagen');
            $ruta = $archivo->store('productos', 'public');

            // Borra la imagen física anterior (opcional, evita basura en disco)
            $anterior = Imagen::where('IdProducto', $producto->IdProducto)->first();
            if ($anterior && Storage::disk('public')->exists($anterior->Ruta)) {
                Storage::disk('public')->delete($anterior->Ruta);
            }

            Imagen::updateOrCreate(
                ['IdProducto' => $producto->IdProducto],
                [
                    'Formato' => $archivo->getClientOriginalExtension(),
                    'Tamano'  => $archivo->getSize(),
                    'Ruta'    => $ruta,
                ]
            );
        }

        return redirect()->route('admin.productos.index')->with('exito', 'Producto actualizado.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        $imagen = Imagen::where('IdProducto', $producto->IdProducto)->first();
        if ($imagen && Storage::disk('public')->exists($imagen->Ruta)) {
            Storage::disk('public')->delete($imagen->Ruta);
        }
        Imagen::where('IdProducto', $producto->IdProducto)->delete();
        Inventario::where('IdProducto', $producto->IdProducto)->delete();
        $producto->delete();

        return redirect()->route('admin.productos.index')->with('exito', 'Producto eliminado.');
    }
}