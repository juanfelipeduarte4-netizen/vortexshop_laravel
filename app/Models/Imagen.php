<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 'imagen';
    protected $primaryKey = 'IdImagen';
    public $timestamps = false;

    protected $fillable = [
        'IdProducto',
        'Formato',
        'Tamano',
        'Ruta',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'IdProducto', 'IdProducto');
    }
}