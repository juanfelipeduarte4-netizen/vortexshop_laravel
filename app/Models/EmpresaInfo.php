<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaInfo extends Model
{
    use HasFactory;

    protected $table = 'empresa_info';

    // Define la clave primaria correspondiente (o si no usas ID para el UPDATE)
    protected $primaryKey = 'Nombre'; 
    public $incrementing = false;
    protected $keyType = 'string';

    // Desactiva los campos created_at y updated_at
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Mision',
        'Vision',
        'Valores',
        'Historia',
    ];
}