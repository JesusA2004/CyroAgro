<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('segmento')->nullable();
            $table->string('categoria')->nullable();
            $table->string('registro')->nullable();
            $table->text('contenido')->nullable();
            $table->text('uso_recomendado')->nullable();
            $table->text('dosis_sugerida')->nullable();
            $table->string('intervalo_aplicacion')->nullable();
            $table->text('controla')->nullable();
            $table->string('ficha_tecnica')->nullable();
            $table->string('hoja_seguridad')->nullable();
            $table->string('foto_producto')->nullable();
            $table->string('presentacion')->nullable();
            $table->string('creado_por')->nullable();
            $table->string('modificado_por')->nullable();
            $table->date('fecha_creacion')->nullable();
            $table->date('fecha_actualizacion')->nullable();
            $table->string('foto_catalogo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
