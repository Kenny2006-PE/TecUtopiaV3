<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $primaryKey = 'idCliente';
    protected $fillable = [
        'credito',
        'RUC',
        'idUsuario',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'idCliente');
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'idCliente');
    }
}
