<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Categorias', function (Blueprint $table) {
            $table->id('IdCategoria');
            $table->string('Nombre', 100)->unique();
            $table->text('Descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Categorias');
    }
};
