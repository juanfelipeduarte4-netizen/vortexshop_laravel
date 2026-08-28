<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * SUPUESTO: manejas variantes por talla/color (necesario para que el
     * filtro de CatalogoController funcione). Si NO es tu caso, borra este
     * método y usa el bloque comentado abajo (versión simple, sin variantes,
     * el stock vive directo en Productos.Stock).
     */
    public function up(): void
    {
        Schema::create('Inventarios', function (Blueprint $table) {
            $table->id('IdInventario');
            $table->foreignId('IdProducto')
                ->constrained('Productos', 'IdProducto')
                ->cascadeOnDelete();
            $table->string('Talla', 20)->nullable();
            $table->string('Color', 30)->nullable();
            $table->unsignedInteger('Stock')->default(0);
            $table->string('Ubicacion')->nullable();
            $table->timestamps();

            $table->index(['Talla', 'Color']);
        });

        /*
        | ---- VERSIÓN SIMPLE (sin variantes) ----
        | Si tu Producto.Stock ya es la única fuente de verdad, no necesitas
        | esta tabla para el catálogo. Consérvala solo si quieres trazabilidad
        | de ubicación física, y quita las columnas Talla/Color de aquí y del
        | CatalogoController.
        */
    }

    public function down(): void
    {
        Schema::dropIfExists('Inventarios');
    }
};
