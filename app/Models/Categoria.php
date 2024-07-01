<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categorias';
    protected $primaryKey = 'idCategoria';
    protected $fillable = ['nombreCategoria'];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'idCategoria');
    }

    public function especificaciones()
    {
        return $this->hasMany(Especificacion::class, 'idCategoria');
    }
}
