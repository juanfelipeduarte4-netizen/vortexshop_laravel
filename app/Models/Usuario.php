<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'IdUsuario';

    protected $fillable = [
        'Correo',
        'Password',
        'Rol',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'IdUsuario', 'IdUsuario');
    }

    /**
     * La columna Rol ahora es ENUM('cliente','empleado','administrador') en
     * minúsculas estricto (ver migración) — esto elimina la necesidad de
     * strtolower() disperso por todo el código. Si en tu BD real el enum
     * tiene otros valores/casing, ajusta la migración, no este método.
     */
    public function esAdministrador(): bool
    {
        return $this->Rol === 'administrador';
    }
    public $timestamps = false;
}
