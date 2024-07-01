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
        Schema::create('itemspedido', function (Blueprint $table) {
            $table->id('idItemPedido');
            $table->foreignId('idPedido')->constrained('pedidos', 'idPedido')->onDelete('cascade');
            $table->foreignId('idProducto')->constrained('productos', 'idProducto');
            $table->integer('cantidad')->check('cantidad >= 0');
            $table->decimal('subtotal', 10, 2)->check('subtotal >= 0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itemspedido');
    }
};
