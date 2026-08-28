<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Inventario;
use App\Models\Producto;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_productos'   => Producto::count(),
            'productos_activos' => Producto::activos()->count(),
            'total_categorias'  => Categoria::count(),
            'stock_bajo'        => Inventario::where('Stock', '>', 0)->where('Stock', '<=', 5)->count(),
            'agotados'          => Inventario::where('Stock', 0)->count(),
        ];

        $ultimosProductos = Producto::with('categoria')
            ->orderByDesc('IdProducto')
            ->limit(5)
            ->get();

        return view('Admin.dashboard', compact('stats', 'ultimosProductos'));
    }
}
