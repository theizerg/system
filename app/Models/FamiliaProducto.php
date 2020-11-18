<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class FamiliaProducto extends Model
{
    #Tabla asociada
    protected $table = 'familia_productos';

    protected $fillable = [
        'nombre'
    ];

    public function productos(){
        return $this->hasMany(Producto::class);
    }
}
