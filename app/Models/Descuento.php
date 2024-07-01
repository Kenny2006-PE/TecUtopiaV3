<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    use HasFactory;
    protected $table = 'descuentos';
    protected $primaryKey = 'idDescuento';
    protected $fillable = [
        'idProducto',
        'unidadDesc',
        'valorDesc'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProducto');
    }
}
