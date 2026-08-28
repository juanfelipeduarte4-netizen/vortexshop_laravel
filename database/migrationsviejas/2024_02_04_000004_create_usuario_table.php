<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Usuarios', function (Blueprint $table) {
            $table->id('IdUsuario');
            $table->string('Correo', 150)->unique();
            $table->string('Password');
            $table->enum('Rol', ['cliente', 'empleado', 'administrador'])->default('cliente');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Usuarios');
    }
};
