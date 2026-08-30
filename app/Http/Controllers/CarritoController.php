<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Inventario;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session()->get('carrito', []);
        $total = 0;

        foreach ($carrito as $idInventario => $item) {
            $inventario = Inventario::find($idInventario);
            $producto = Producto::with('promociones')->find($item['id_producto']);

            $precioFinal = $producto ? $producto->precioFinal() : $item['precio'];
            $stockActual = $inventario->Stock ?? 0;

            $carrito[$idInventario]['precio_original'] = $item['precio'];
            $carrito[$idInventario]['precio_final'] = $precioFinal;
            $carrito[$idInventario]['tiene_descuento'] = $producto && $producto->tieneDescuento();
            $carrito[$idInventario]['stock_actual'] = $stockActual;
            $carrito[$idInventario]['insuficiente'] = $item['cantidad'] > $stockActual;

            $total += $precioFinal * $item['cantidad'];
        }

        return view('carrito.index', compact('carrito', 'total'));
    }

    public function agregar(Request $request, $idInventario)
    {
        $inventario = Inventario::with('producto.imagenes')->findOrFail($idInventario);
        $producto = $inventario->producto;
        abort_if(!$producto || $producto->Estado !== 'activo', 404);

        $carrito = session()->get('carrito', []);
        $cantidad = (int) $request->input('cantidad', 1);
        $cantidadActual = $carrito[$idInventario]['cantidad'] ?? 0;

        if (($cantidadActual + $cantidad) > $inventario->Stock) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible para esa variante.');
        }

        if (isset($carrito[$idInventario])) {
            $carrito[$idInventario]['cantidad'] += $cantidad;
        } else {
            $carrito[$idInventario] = [
                'id_producto'   => $producto->IdProducto,
                'id_inventario' => $inventario->IdInventario,
                'nombre'        => $producto->Nombre,
                'color'         => $inventario->Color,
                'talla'         => $inventario->Talla,
                'precio'        => $producto->Precio,
                'imagen'        => $producto->imagenes->first()->Ruta ?? null,
                'cantidad'      => $cantidad,
            ];
        }

        session()->put('carrito', $carrito);
        return redirect()->back()->with('exito', 'Producto agregado al carrito.');
    }

    public function actualizar(Request $request, $idInventario)
    {
        $request->validate(['cantidad' => ['required', 'integer', 'min:1']]);
        $carrito = session()->get('carrito', []);

        if (!isset($carrito[$idInventario])) {
            return redirect()->route('carrito.index')->with('error', 'El producto no existe en el carrito.');
        }

        $inventario = Inventario::findOrFail($idInventario);
        if ($request->cantidad > $inventario->Stock) {
            return redirect()->route('carrito.index')->with('error', 'No hay suficiente stock disponible para esa variante.');
        }

        $carrito[$idInventario]['cantidad'] = (int) $request->cantidad;
        session()->put('carrito', $carrito);
        return redirect()->route('carrito.index')->with('exito', 'Carrito actualizado.');
    }

    public function eliminar($idInventario)
    {
        $carrito = session()->get('carrito', []);
        if (isset($carrito[$idInventario])) {
            unset($carrito[$idInventario]);
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