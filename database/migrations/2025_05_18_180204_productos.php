<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('segmento', 255)->nullable();
            $table->string('categoria', 255)->nullable();
            $table->string('registro', 255)->nullable();
            $table->text('contenido')->nullable();
            $table->text('usoRecomendado')->nullable();
            $table->text('dosisSugerida')->nullable();
            $table->string('intervaloAplicacion', 255)->nullable();
            $table->text('controla')->nullable();
            $table->string('fichaTecnica', 255)->nullable();
            $table->string('hojaSeguridad', 255)->nullable();
            $table->string('fotoProducto', 255)->nullable();
            $table->string('presentacion', 255)->nullable();
            $table->string('creadoPor', 255)->nullable();
            $table->string('modificadoPor', 255)->nullable();
            $table->date('fechaCreacion')->nullable();
            $table->date('fechaActualizacion')->nullable();
            $table->string('FotoCatalogo', 255)->nullable();

            $table->timestamps(); // crea created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
