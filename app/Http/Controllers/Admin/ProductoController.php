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
            'Imagenes'    => 'nullable|array',
            'Imagenes.*'  => 'image|max:2048',
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

        if ($request->hasFile('Imagenes')) {
            foreach ($request->file('Imagenes') as $archivo) {
                $ruta = $archivo->store('productos', 'public');

                Imagen::create([
                    'IdProducto' => $producto->IdProducto,
                    'Formato'    => $archivo->getClientOriginalExtension(),
                    'Tamano'     => $archivo->getSize(),
                    'Ruta'       => $ruta,
                ]);
            }
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
            'Imagenes'    => 'nullable|array',
            'Imagenes.*'  => 'image|max:2048',
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

        // Eliminar las imágenes que el usuario marcó para quitar
        if ($request->filled('eliminar_imagenes')) {
            $imagenesABorrar = Imagen::where('IdProducto', $producto->IdProducto)
                ->whereIn('IdImagen', $request->input('eliminar_imagenes'))
                ->get();

            foreach ($imagenesABorrar as $img) {
                if (Storage::disk('public')->exists($img->Ruta)) {
                    Storage::disk('public')->delete($img->Ruta);
                }
                $img->delete();
            }
        }

        // Agregar las imágenes nuevas que se hayan subido, sin tocar las que ya quedaron
        if ($request->hasFile('Imagenes')) {
            foreach ($request->file('Imagenes') as $archivo) {
                $ruta = $archivo->store('productos', 'public');

                Imagen::create([
                    'IdProducto' => $producto->IdProducto,
                    'Formato'    => $archivo->getClientOriginalExtension(),
                    'Tamano'     => $archivo->getSize(),
                    'Ruta'       => $ruta,
                ]);
            }
        }

        return redirect()->route('admin.productos.index')->with('exito', 'Producto actualizado.');
    }

    public function destroy($id)
    {
        // Baja lógica: la vista index ofrece "Reactivar" después, así que
        // nunca se borra el producto ni sus imágenes/inventario físicamente.
        $producto = Producto::findOrFail($id);
        $producto->update(['Estado' => 'inactivo']);

        return redirect()->route('admin.productos.index')->with('exito', 'Producto dado de baja.');
    }

    public function reactivar($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->update(['Estado' => 'activo']);

        return redirect()->route('admin.productos.index')->with('exito', 'Producto reactivado.');
    }
}