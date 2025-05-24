<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('detalles', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad');
            $table->decimal('precio_unit', 10, 2);
            $table->decimal('subtotal', 12, 2)->storedAs('cantidad * precio_unit');

            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->foreign('producto_id')->references('id')->on('productos');
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalles');
    }
    
};
