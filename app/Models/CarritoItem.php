<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarritoItem extends Model
{
    protected $table = 'CarritoItem';
    protected $primaryKey = 'IdCarritoItem';
    public $timestamps = false;

    protected $fillable = [
        'IdCarrito',
        'IdProducto',
        'IdInventario',
        'Cantidad',
    ];

    public function carrito()
    {
        return $this->belongsTo(Carrito::class, 'IdCarrito', 'IdCarrito');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'IdProducto', 'IdProducto');
    }

    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'IdInventario', 'IdInventario');
    }

    public function subtotal(): float
    {
        return $this->Cantidad * $this->producto->Precio;
    }
}