<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('microempresas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Nombre de la microempresa
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con el usuario (microempresa_P)
            $table->foreignId('plan_id')->constrained()->onDelete('cascade'); // Relación con el plan
            $table->string('direccion');
            $table->string('telefono');
            $table->string('nit');
            $table->enum('estado', ['activa', 'inactiva'])->default('activa');
            $table->string('logo')->nullable(); // Logo de la microempresa
            $table->text('horario_atencion')->nullable(); // Horario de atención de la microempresa
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('microempresas');
    }
};
