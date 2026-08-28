<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = 'Carrito';
    protected $primaryKey = 'IdCarrito';
    public $timestamps = false;

    protected $fillable = [
        'IdCliente',
        'CodigoSesion',
        'FechaCreacion',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'IdCliente', 'IdCliente');
    }

    public function items()
    {
        return $this->hasMany(CarritoItem::class, 'IdCarrito', 'IdCarrito');
    }

    public function total(): float
    {
        return $this->items->sum(fn ($item) => $item->Cantidad * $item->inventario->producto->Precio);
    }

    public function cantidadTotal(): int
    {
        return $this->items->sum('Cantidad');
    }
}