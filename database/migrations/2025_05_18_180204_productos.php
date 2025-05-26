<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('nombre', 150);
            $table->string('segmento', 50); // Ej: "Orgánicos"
            $table->string('categoria', 100); // Ej: "Fertilizantes"
            $table->string('registro', 100)->nullable(); // Ej: "RSCO-286/X/08"
            $table->text('contenido')->nullable(); // Descripción de lo que contiene
            $table->string('presentaciones')->nullable(); // Ej: "1 lt., 20 lt."
            $table->string('intervalo_aplicacion')->nullable(); // Texto libre
            $table->string('incompatibilidad')->nullable();
            $table->string('certificacion')->nullable();
            $table->text('controla')->nullable(); // Qué controla el producto
            $table->string('ficha_tecnica')->nullable(); // Ruta o nombre del archivo
            $table->string('hoja_seguridad')->nullable(); // Ruta o nombre del archivo
            $table->decimal('precio', 10, 2)->default(0.00);
            $table->unsignedInteger('cantidad_inventario')->default(0);
            $table->string('urlFoto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
