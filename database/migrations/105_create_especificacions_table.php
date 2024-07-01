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
        Schema::create('especificaciones', function (Blueprint $table) {
            $table->id('idEspecificacion');
            $table->string('nombreEspecificacion', 50);
            $table->foreignId('idCategoria')->constrained('categorias', 'idCategoria');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('especificaciones');
    }
};
