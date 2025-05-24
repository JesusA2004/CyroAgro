<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->dateTime('fecha')->useCurrent();
            $table->unsignedBigInteger('empleado_id');
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->decimal('total', 12, 2);
            $table->timestamps();

            $table->foreign('empleado_id')->references('id')->on('users');
            $table->foreign('cliente_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
    
};
