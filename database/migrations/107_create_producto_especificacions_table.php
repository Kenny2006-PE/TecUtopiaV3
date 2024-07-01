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
        Schema::create('producto_especificaciones', function (Blueprint $table) {
            $table->foreignId('idProducto')->constrained('productos', 'idProducto')->onDelete('cascade');
            $table->foreignId('idEspecificacion')->constrained('especificaciones', 'idEspecificacion');
            $table->string('valorEspecificacion', 200)->nullable();
            $table->primary(['idProducto', 'idEspecificacion']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_especificaciones');
    }
};
