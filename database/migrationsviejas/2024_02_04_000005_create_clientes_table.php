<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Clientes', function (Blueprint $table) {
            $table->id('IdCliente');
            $table->foreignId('IdUsuario')
                ->constrained('Usuarios', 'IdUsuario')
                ->cascadeOnDelete();
            $table->string('Nombre', 100);
            $table->string('Apellido', 100);
            $table->string('Direccion')->nullable();
            $table->string('Telefono', 20)->nullable();
            $table->string('Ciudad', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Clientes');
    }
};
