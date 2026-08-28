<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Productos', function (Blueprint $table) {
            $table->id('IdProducto');
            $table->foreignId('IdCategoria')
                ->constrained('Categorias', 'IdCategoria')
                ->restrictOnDelete(); // evita borrar categorías con productos SIN control en la app
            $table->string('Nombre', 150);
            $table->text('Descripcion')->nullable();
            $table->decimal('Precio', 10, 2);
            $table->unsignedInteger('Stock')->default(0);
            $table->string('Imagen')->nullable();
            $table->enum('Estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();

            $table->index('Estado');
            $table->index('Nombre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Productos');
    }
};
