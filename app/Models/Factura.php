<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    protected $table = 'facturas';
    protected $primaryKey = 'idFactura';
    protected $fillable = [
        'idCliente',
        'idPedido',
        'montoTotal',
        'fechaFactura'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idCliente');
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'idPedido');
    }
}
