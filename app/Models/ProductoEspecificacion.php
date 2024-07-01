<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoEspecificacion extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'producto_especificaciones';

    protected $fillable = [
        'idProducto',
        'idEspecificacion',
        'valorEspecificacion'
    ];
    public $timestamps = false;

    public static function rules($id = null)
    {
        return [
            'idProducto' => 'required',
            'idEspecificacion' => 'required',
            'valorEspecificacion' => 'required|string|max:200',
        ];
    }

    public static function findOrCreate($idProducto, $idEspecificacion)
    {
        return self::firstOrCreate([
            'idProducto' => $idProducto,
            'idEspecificacion' => $idEspecificacion,
        ]);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProducto', 'idProducto');
    }

    public function especificacion()
    {
        return $this->belongsTo(Especificacion::class,'idEspecificacion', 'idEspecificacion');
    }
}
