<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{

	// CartDetail N               1 Product
    public function productos()
    {
    	return $this->belongsTo(Producto::class,'product_id');
    }


     public function cart()
    {
    	return $this->belongsTo(Cart::class);
    }

       
}
