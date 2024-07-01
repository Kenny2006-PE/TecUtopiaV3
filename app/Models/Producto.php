<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $primaryKey = 'idProducto';
    protected $fillable = [
        'nombre',
        'descripcion',
        'precioUnitario',
        'stock',
        'idCategoria',
        'popularidad',
        'imagen_url',
        'codigoProducto'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->codigoProducto)) {
                $categoria = Categoria::find($model->idCategoria);
                if ($categoria) {
                    $prefix = strtoupper(substr($categoria->nombreCategoria, 0, 4));
                    $model->codigoProducto = $prefix.'-'.Str::random(5).str_pad(mt_rand(1, 99999),5, '0',STR_PAD_LEFT);
                }
            }
        });
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria');
    }

    public function especificaciones()
    {
        return $this->belongsToMany(Especificacion::class, 'producto_especificaciones', 'idProducto', 'idEspecificacion')
                    ->withPivot('valorEspecificacion');
    }

    public function itemsPedido()
    {
        return $this->hasMany(ItemsPedido::class, 'idProducto');
    }

    public function descuentos()
    {
        return $this->hasMany(Descuento::class, 'idProducto');
    }
}
