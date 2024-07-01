<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especificacion extends Model
{
    use HasFactory;
    protected $table = 'especificaciones';
    protected $primaryKey = 'idEspecificacion';
    protected $fillable = [
        'nombreEspecificacion',
        'idCategoria'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_especificaciones', 'idEspecificacion', 'idProducto')
                    ->withPivot('valorEspecificacion');
    }
}
