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
        // Tabla de usuarios
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            // 101 porque así lo definiste; único
            $table->string('email', 101)->unique();

            $table->timestamp('email_verified_at')->nullable();

            // Usar casts 'hashed' en el modelo para que se guarde con bcrypt
            $table->string('password');

            // Rol permitido
            $table->enum('role', ['empleado', 'cliente', 'administrador'])->default('cliente')->index();

            $table->rememberToken();

            // Timestamps con valores por defecto para evitar NULLs en inserts manuales
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // Tokens de reseteo de contraseña (estándar de Laravel)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Sesiones si usas el driver "database"
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index(); // sin FK dura para no acoplar fuerte
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar en orden inverso por posibles dependencias
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
