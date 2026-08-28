<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Inventario;
use App\Models\Producto;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    /**
     * RF002 + RF004: catálogo público filtrable por categoría, talla, color
     * y rango de precio, combinable con búsqueda libre por nombre/descripción.
     * Solo muestra productos con Estado='activo' (RF014: la baja lógica los oculta aquí).
     */
    public function index(Request $request)
    {
        $query = Producto::with(['categoria', 'inventario', 'imagenes', 'promociones'])
            ->where('Estado', 'activo');

        if ($request->filled('q')) {
            $texto = $request->q;
            $query->where(function ($sub) use ($texto) {
                $sub->where('Nombre', 'like', "%{$texto}%")
                    ->orWhere('Descripcion', 'like', "%{$texto}%");
            });
        }

        if ($request->filled('categoria')) {
            $query->where('IdCategoria', $request->categoria);
        }

        if ($request->filled('precio_min')) {
            $query->where('Precio', '>=', $request->precio_min);
        }

        if ($request->filled('precio_max')) {
            $query->where('Precio', '<=', $request->precio_max);
        }

        if ($request->filled('talla') || $request->filled('color')) {
            $query->whereHas('inventario', function ($inv) use ($request) {
                if ($request->filled('talla')) {
                    $inv->where('Talla', $request->talla);
                }
                if ($request->filled('color')) {
                    $inv->where('Color', $request->color);
                }
                $inv->where('Stock', '>', 0);
            });
        }

        $productos = $query->orderBy('Nombre')->paginate(12)->withQueryString();

        $categorias = Categoria::orderBy('Nombre')->get();
        $tallas = Inventario::select('Talla')->distinct()->orderBy('Talla')->pluck('Talla');
        $colores = Inventario::select('Color')->distinct()->orderBy('Color')->pluck('Color');

        return view('catalogo', compact('productos', 'categorias', 'tallas', 'colores'));
    }

    public function show(Producto $producto)
    {
        abort_if($producto->Estado !== 'activo', 404);

        $producto->load(['categoria', 'inventario', 'imagenes', 'promociones']);

        return view('producto-detalle', compact('producto'));
    }
}