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
            $table->id('idProducto');
            $table->string('nombre', 100);
            $table->text('descripcion');
            $table->decimal('precioUnitario', 10, 2)->check('precioUnitario >= 0');
            $table->integer('stock')->default(0)->check('stock >= 0');
            $table->foreignId('idCategoria')->constrained('categorias', 'idCategoria');
            $table->integer('popularidad')->default(1)->check('popularidad >= 0');
            $table->string('imagen_url')->nullable();
            $table->string('codigoProducto', 25)->unique();
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
