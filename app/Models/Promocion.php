<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    protected $table = 'Promocion';
    protected $primaryKey = 'IdPromocion';
    public $timestamps = false;

    protected $fillable = [
        'Descripcion',
        'PorcentajeDescuento',
        'FechaInicio',
        'FechaFin',
    ];

    protected $casts = [
        'FechaInicio' => 'date',
        'FechaFin'    => 'date',
    ];

    public function productos()
    {
        return $this->belongsToMany(
            Producto::class,
            'Producto_Promocion',
            'IdPromocion',
            'IdProducto'
        );
    }

    public function estaVigente(): bool
    {
        $hoy = now()->toDateString();

        return $this->FechaInicio->toDateString() <= $hoy && $this->FechaFin->toDateString() >= $hoy;
    }

    public function estado(): string
    {
        $hoy = now()->toDateString();

        if ($this->FechaFin->toDateString() < $hoy) {
            return 'vencida';
        }

        if ($this->FechaInicio->toDateString() > $hoy) {
            return 'futura';
        }

        return 'vigente';
    }
}