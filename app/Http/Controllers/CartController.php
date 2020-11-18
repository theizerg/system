<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\LineaProducto;
use App\Models\Producto;
use App\Models\CartDetail;
use App\Models\Comprobante;
use App\Models\Notificacion;
use App\Models\User;

use App\Models\DetallePedidos;
use App\Mail\NewOrder;
use Mail;

class CartController extends Controller
{
    public function comprobante()
    {
      

        $comprobante=Comprobante::where('usuario_id', auth()->user()->id)->get();
        //dd($comprobante);

        return ( count($comprobante) > 0) ? true : false ;
    }
   

    public function update(Request $request)
    {
        //|dd($request);
           
         if (auth()->user()->cart->details->count() > 0) {
            $articulos = json_decode(auth()->user()->cart->details);
            //dd( count($articulos))
            for ($i=0; $i < count($articulos); $i++) {
                $producto = Producto::BuscarPorId($articulos[$i]->product_id)->first();
               
                $linea = $articulos[$i];
               
               //dd(($producto->stock >= $linea->quantity));                

                if($producto->stock >= $linea->quantity){
                    $lineaProducto = new LineaProducto();


                    $lineaProducto->producto()->associate($producto);
                    $lineaProducto->usuario()->associate(\Auth::user());

                    $lineaProducto->pedido_id = $linea->cart_id;
                    $lineaProducto->producto_id = $linea->product_id;
                    $lineaProducto->usuario_id = auth()->user()->id;

                    

                    $producto->stock -= $linea->quantity;
                    $lineaProducto->stock = $producto->stock;
                    
                    $lineaProducto->precioUnitario = $producto->precio;
                    $lineaProducto->cantidad = $linea->quantity;

                    //$lineaProducto->subTotal = $producto->precio * $linea->quantity;
                    $lineaProducto->subTotal = $producto->precio * $linea->quantity;
                    // Para los iva accede al tipo de iva que tenga el producto.
                    // Próxima versión debería poer modificarse si se quiere.
                    $lineaProducto->iva = $lineaProducto->subTotal * ($producto->iva->tasa / 100);
                   
                   
                    $lineaProducto->total = $lineaProducto->subTotal + $lineaProducto->iva;



                    $lineaProducto->fecha = date("Y-m-d H:i:s");
                    //dd($linea);
                    
                    $request->iva += $lineaProducto->iva;
                    $request->subTotal += $lineaProducto->subTotal;
                    //$moneda_simbolo = $comprobante->moneda->simbolo;

                    $lineaProducto->descripcion = "x $lineaProducto->cantidad  $producto->nombre  -  TOTAL  $lineaProducto->total";

 
                     $detallePedidos = new DetallePedidos();


                    $detallePedidos->producto()->associate($producto);
                    $detallePedidos->usuario()->associate(\Auth::user());

                    $detallePedidos->pedido_id = $linea->cart_id;
                    $detallePedidos->producto_id = $linea->product_id;
                    $detallePedidos->usuario_id = $lineaProducto->usuario_id;
                    
                    $detallePedidos->precioUnitario = $producto->precio;
                    $detallePedidos->cantidad = $linea->quantity;

                    //$detallePedidos->subTotal = $producto->precio * $linea->quantity;
                    $detallePedidos->subTotal = $producto->precio * $linea->quantity;
                    // Para los iva accede al tipo de iva que tenga el producto.
                    // Próxima versión debería poer modificarse si se quiere.
                    $detallePedidos->iva = 0;
                   $detallePedidos->orden_pedido = $request->orden_pedido;
                   
                    $detallePedidos->total = $detallePedidos->subTotal + $detallePedidos->iva;



                    $detallePedidos->fecha = date("Y-m-d H:i:s");

                    $detallePedidos->status = 'pendiente';
                    //dd($linea);
                    
                    $request->iva += $detallePedidos->iva;
                    $request->subTotal += $detallePedidos->subTotal;
                    //$moneda_simbolo = $comprobante->moneda->simbolo;

                    $detallePedidos->descripcion = "el usuario"." ".auth()->user()->name." ".auth()->user()->last_name." "."x $detallePedidos->cantidad  $producto->nombre  -  TOTAL  $detallePedidos->total";
                    //dd($detallePedidos->descripcion);
                    $detallePedidos->titulo = "Nuevo pedido";                
                    
                   
                //$detallePedidos->total = $request->iva + $request->subTotal;              
                //$comprobante->save();                               

                // Verificamos stock restante de producto para ver si notificar 
            
            \DB::table('cart_details')->delete();
               

            $client = auth()->user(); 

            $cart = $client->cart;
            
            $cart->status = 'Pendiente';
            $cart->order_date = Carbon::now();
            $cart->user_id = auth()->user()->id;
           
            

            $titulo = "Nuevo pedido";
            $texto = " el usuario" .auth()->user()->name .auth()->user()->last_name." x $lineaProducto->cantidad  $producto->nombre  -  TOTAL  $lineaProducto->total"; 
            $link_texto = "Ir al pedido";
            $link = "/pedido/detalle/" . $producto->codigo;
            $tipo = 1;
            Notificacion::crearNotificacion($titulo, $texto, $link,$link_texto, $tipo);
             
             $cart->save(); // UPDATE
             $detallePedidos->save(); 
             $lineaProducto->save();
             $producto->save();

                
               

            }

                // dd( $request->cantidad  >= $producto->stock  );         
                if( $request->cantidad  >= $producto->stock  ){
                    $titulo = "Stock mínimo alcanzado";
                    $texto = "Quedan " . $producto->stock . " unidad/es de " . $producto->nombre; 
                    $link_texto = "Ir al producto";
                    $link = "/productos/detalle/" . $producto->codigo;
                    $tipo = 1;
                   Notificacion::crearNotificacion($titulo, $texto, $link,$link_texto, $tipo);

                     $notification = array(
                    'message' => '¡No tenemos disponible la cantidad solicitada!',
                    'alert-type' => 'error'
                );
        
                 return back()->with($notification);  
                }




                 }
                  
                   $notification = array(
                    'message' => '¡Tu pedido se ha registrado correctamente. Te contactaremos pronto por las vias correspondientes!!',
                    'alert-type' => 'success'
                );
        
                 return back()->with($notification);   

              }   
  
               
               


      

    }

  
}
