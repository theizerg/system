<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function details()
    {
    	return $this->hasMany(CartDetail::class);
    }

    public function getTotalAttribute()
    {
    	
    }

     public function getDisplayStatusAttribute()
    {
        return $this->status == 'Active' ? 'Activo' : 'Pendiente';
    }

    
}
