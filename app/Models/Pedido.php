<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedidos';
    protected $primaryKey = 'idPedido';
    protected $fillable = [
        'idCliente',
        'lugarEntrega',
        'estado',
        'masInfo'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idCliente');
    }

    public function itemsPedido()
    {
        return $this->hasMany(ItemsPedido::class, 'idPedido');
    }

    public function factura()
    {
        return $this->hasOne(Factura::class, 'idPedido');
    }
}
