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
            $table->string('descripcion');  
            $table->string('unidad');  
            $table->integer('stock');  
            $table->integer('cantidad_minima');  
            $table->decimal('precio', 10, 2);  
            $table->foreignId('user_id')  
                ->constrained('users')  
                ->onDelete('cascade');  
            $table->timestamps();  
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
