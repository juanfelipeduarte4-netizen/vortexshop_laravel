<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soporte extends Model
{
    protected $table = 'soporte';
    protected $primaryKey = 'IdSoporte';
    public $timestamps = false;

    protected $fillable = [
        'IdCliente',
        'Asunto',
        'Mensaje',
        'Fecha',
        'Calificacion',
        'Estado',
        'Respuesta',
        'FechaRespuesta',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'IdCliente', 'IdCliente');
    }
}