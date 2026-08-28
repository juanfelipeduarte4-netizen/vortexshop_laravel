<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public $timestamps = false;
    protected $table = 'cliente';
    protected $primaryKey = 'IdCliente';

    protected $fillable = [
        'IdUsuario',
        'Nombre',
        'Apellido',
        'Direccion',
        'Telefono',
        'Ciudad',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'IdUsuario', 'IdUsuario');
    }
}
