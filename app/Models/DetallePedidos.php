<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\Cart;
use App\Models\User;

class DetallePedidos extends Model
{
    
    protected $table = 'detalle_pedidos';

    protected $fillable = [
        
    
            'titulo',
             // Producto asociado
            'producto_id',
           
            // Usuario asociado
            'usuario_id',
           
            // Cinoribante asociado : NULLABLE
            'pedido_id',
            
            'descripcion',            
            'fecha',
            // Tasa de IVA
            'tasa_iva_id',
            'precioUnitario',
            'cantidad',

            'subTotal',
            'iva',
            'total',
            'status'
             ];




     public function producto(){
    	return $this->belongsTo(Producto::class, 'producto_id')->withTrashed();
    }

    public function usuario(){
    	return $this->belongsTo(User::class, 'usuario_id');
    }

    public function pedido(){
        return $this->belongsTo(Cart::class, 'pedido_id');
    }

    public function iva(){
        return $this->belongsTo(App\Models\TasaIva::class, 'tasa_iva_id');
    }
}
