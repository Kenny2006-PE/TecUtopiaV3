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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id('idFactura');
            $table->foreignId('idCliente')->constrained('clientes', 'idCliente');
            $table->foreignId('idPedido')->constrained('pedidos', 'idPedido');
            $table->decimal('montoTotal', 10, 2)->check('montoTotal >= 0');
            $table->date('fechaFactura');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
