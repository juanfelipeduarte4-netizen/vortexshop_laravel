<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'IdCategoria';

    protected $fillable = [
        'Nombre',
        'Descripcion',
        'Genero',
        'ImagenReferencial'
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'IdCategoria', 'IdCategoria');
    }
    public $timestamps = false;
}
