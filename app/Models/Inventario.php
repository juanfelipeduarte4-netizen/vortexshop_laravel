<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';
    protected $primaryKey = 'IdInventario';

    protected $fillable = [
        'IdProducto',
        'Talla',
        'Color',
        'Stock',
        'Estado',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'IdProducto', 'IdProducto');
    }
    public $timestamps = false;
}
