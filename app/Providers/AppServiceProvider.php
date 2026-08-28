<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Comparte $cantidadCarrito con TODAS las vistas que incluyan
        // partials.menu — antes no existía ningún mecanismo para esto,
        // causaba "Undefined variable $cantidadCarrito" en cualquier
        // página que cargara el menú.
        View::composer('partials.menu', function ($view) {
            $carrito = session()->get('carrito', []);
            $cantidad = array_sum(array_column($carrito, 'cantidad'));
            $view->with('cantidadCarrito', $cantidad);
        });
    }
}
