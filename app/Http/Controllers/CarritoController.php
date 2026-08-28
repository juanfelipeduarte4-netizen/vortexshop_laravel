<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session()->get('carrito', []);
        $total = 0;

        foreach ($carrito as $id => $item) {
            $producto = Producto::with('promociones')->find($id);
            $precioFinal = $producto ? $producto->precioFinal() : $item['precio'];

            $carrito[$id]['precio_original'] = $item['precio'];
            $carrito[$id]['precio_final'] = $precioFinal;
            $carrito[$id]['tiene_descuento'] = $producto && $producto->tieneDescuento();

            $total += $precioFinal * $item['cantidad'];
        }

        return view('carrito.index', compact('carrito', 'total'));
    }

    public function agregar(Request $request, $id)
    {
        $producto = Producto::activos()->with(['inventario', 'imagenes'])->findOrFail($id);
        $carrito = session()->get('carrito', []);
        $cantidad = (int) $request->input('cantidad', 1);

        $stockDisponible = $producto->inventario->sum('Stock');
        $cantidadActual = $carrito[$id]['cantidad'] ?? 0;

        if (($cantidadActual + $cantidad) > $stockDisponible) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible.');
        }

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] += $cantidad;
        } else {
            $carrito[$id] = [
                'id'       => $producto->IdProducto,
                'nombre'   => $producto->Nombre,
                'precio'   => $producto->Precio,
                'imagen'   => $producto->imagenes->first()->Ruta ?? null,
                'cantidad' => $cantidad,
            ];
        }

        session()->put('carrito', $carrito);
        return redirect()->back()->with('exito', 'Producto agregado al carrito.');
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate(['cantidad' => ['required', 'integer', 'min:1']]);
        $carrito = session()->get('carrito', []);

        if (!isset($carrito[$id])) {
            return redirect()->route('carrito.index')->with('error', 'El producto no existe en el carrito.');
        }

        $producto = Producto::with('inventario')->findOrFail($id);
        if ($request->cantidad > $producto->inventario->sum('Stock')) {
            return redirect()->route('carrito.index')->with('error', 'No hay suficiente stock disponible.');
        }

        $carrito[$id]['cantidad'] = (int) $request->cantidad;
        session()->put('carrito', $carrito);
        return redirect()->route('carrito.index')->with('exito', 'Carrito actualizado.');
    }

    public function eliminar($id)
    {
        $carrito = session()->get('carrito', []);
        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }
        return redirect()->route('carrito.index')->with('exito', 'Producto eliminado.');
    }

    public function vaciar()
    {
        session()->forget('carrito');
        return redirect()->route('carrito.index')->with('exito', 'Carrito vaciado.');
    }
}