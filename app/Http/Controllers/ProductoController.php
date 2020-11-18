<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProductoRequest;
use App\Models\FamiliaProducto;
use App\Models\Notificacion;
use App\Models\LineaProducto;
use App\Models\Producto;
use App\Models\Moneda;
use App\Models\TasaIva;
use App\Models\User;
use App\Models\Cart;
use App\Models\CartDetail;
use DB;



class ProductoController extends Controller
{    


	 public function __construct()
    {
        $this->middleware('auth');
    }




	public function index(Request $request)
	{
      if (!\Auth::user()->hasPermissionTo('add_users'))
          return \Redirect::to('/');

		$carbon = new \Carbon\Carbon();
		$date = $carbon->format('m');
		$contadorNoti = Notificacion::where('tipo',2)->count();
		$notificaciones = Notificacion::where('tipo',2)->paginate(5);
		

		$busqueda = $request->get('busqueda');
		$producto = Producto::BuscarPorCodigo($busqueda)->first();
		if ($producto !=null) {
			return Redirect::to('productos/' . $producto->busqueda);
		}else{
			$producto = Producto::BuscarPorCodigoDeBarras($busqueda)->first();
			if ($producto !=null) {
				return Redirect::to('productos/' . $producto->busqueda);
			}else{
				$productos = Producto::Filtrar($busqueda)->orderBy('nombre')->paginate(5);
				return view('admin.productos.index')->with(compact('productos','date','contadorNoti','notificaciones'));
			}
		}
	}

	public function buscar(Request $request){
		$texto = $request->texto;
		$productos = Producto::BuscarPorCodigo($texto)->with('iva')->get();
		if(count($productos) == 0){	        
			$productos = Producto::FiltrarPorCodigo($texto)
							->FiltrarPorNombre($texto)
							->with('iva')
							->get();
		}
		return Response()->json([
			'productos' => $productos
		]);
	}

	public function nuevo()
	{ 
	 if (!\Auth::user()->hasPermissionTo('add_users'))
            return \Redirect::to('/');

		$productos = Producto::orderBy('id', 'desc')->paginate(5);
		//dd($productos);
		$moneda = Moneda::find(config('app.monedaPreferida'));
		$familias_producto = FamiliaProducto::orderBy('nombre')->get();
		return view('admin.productos.nuevo')->with(compact('productos', 'familias_producto', 'moneda'));
	}

	public function guardar(ProductoRequest $request){  
		if (!\Auth::user()->hasPermissionTo('add_users'))
            return \Redirect::to('/');

	     
	     $producto = new Producto();
       
        //$fileNameToStore = $this->handleImageUpload($request);
        $this->setProducto($request ,$producto);
    
	
			$notification = array(
            'message' => '¡Producto creado satisfactoriamente!',
            'alert-type' => 'success'
        	);
			return Redirect::to('productos/nuevo/')->with($notification);			
		         
		
	}

	public function detalle($producto_codigo){
		if (!\Auth::user()->hasPermissionTo('add_users'))
            return \Redirect::to('/');

		$producto = Producto::BuscarPorCodigo($producto_codigo)->firstOrFail();
		$familias_producto = FamiliaProducto::orderBy('nombre')->get();
		$movimientos = $producto->LineasProducto()->orderBy('fecha', 'desc')->paginate(6);
		$precios_historico = $producto->preciosHistorico();
		$tasas_iva = TasaIva::all();

		return view('admin.productos.detalle')->with(compact('producto', 'movimientos', 'familias_producto', 'precios_historico', 'tasas_iva'));
	}

	public function editar(Request $request){
		if (!\Auth::user()->hasPermissionTo('add_users'))
            return \Redirect::to('/');

		$producto_id = $request->producto_id;

		//dd($request);
		$producto = Producto::BuscarPorId($producto_id)->first();        

		if(is_null($producto)){
			$notification = array(
            'message' => '¡El producto no existe!',
            'alert-type' => 'danger'
        );
			return Redirect::back()->with($notification);
		}else{
			if($producto->codigo != $request->codigo){
				$producto->codigo  = $request->codigo;
			}
			if($producto->nombre != $request->nombre){
				$producto->nombre  = $request->nombre;
			}
			$producto->codigo_de_barras  	= $request->codigo_de_barras;
			//$producto->cotizacion  			= $request->cotizacion;
			//$producto->preciocompra  		= $request->preciocompra;
			$producto->descripcion  		= nl2br($request->descripcion);
			$producto->familia_producto_id  	= $request->familia_producto;
			$producto->tasa_iva_id  		= $request->tasa_iva;

			if($request->precio!='' || $request->precio>0){
				if($request->precio != $producto->precio){
					$producto->precio  = floatval(str_replace(',', '.', str_replace('.', '', $request->precio)));
					$producto->registrarCambioPrecio();
				}
			}else{
				$producto->precio  = 0;
			}			
			
			$producto->save();            
			$notification = array(
            'message' => '¡El producto editado!',
            'alert-type' => 'danger'
        );
			return Redirect::to('productos/detalle/'.$producto->codigo)->with($notification);
		}
	}

	public function borrar(Request $request){
		$producto = Producto::BuscarPorId($request->producto_id);
		if($producto != null){
			$producto->delete();
			
			return Redirect::to('/productos')->with(compact('mensaje', 'precios_historico'));
		}
	}

	public function configuracion(Request $request, $producto_codigo){
		if (!\Auth::user()->hasPermissionTo('add_users'))
            return \Redirect::to('/');

		$producto = Producto::BuscarPorCodigo($producto_codigo)->firstOrFail();
		if($producto != null){
			$stock_minimo = $request->stockMinimo;
			if($stock_minimo != null){
				if($stock_minimo >= 0){
					$producto->stock_minimo_valor = $stock_minimo;                    
				}else{
					$error = "ERROR: El valor ingresado como stock mínimo debe ser mayor o igual a 0.";
					return Redirect::back()->with(compact('error'));
				}
			}
			$producto->save();
			$mensaje = "Configuración del producto actualizada.";
			return Redirect::back()->with(compact('mensaje'));
		}
	}

	public function movimientoModificarStock(Request $request, $producto_codigo){  
	if (!\Auth::user()->hasPermissionTo('add_users'))
            return \Redirect::to('/');
      
		$producto = Producto::BuscarPorCodigo($producto_codigo)->firstOrFail();
		if($producto != null){

			$cantidad = $request->cantidad;

			if($request->accion == "sumar"){
				$producto->stock += $cantidad;
				$descripcion = "Ingreso de stock: " . $request->descripcion;
			}else if($request->accion == "restar"){
				$producto->stock -= $cantidad;
				$descripcion = "Retiro de stock: " . $request->descripcion;
			}else{
				$producto->stock = $cantidad;
				$descripcion = "Sustitución de stock: " . $request->descripcion;
			}
			// Si el stock final es válido, guardamos el producto e informamos del cambio.
			// TODO: Crear un trigger que lo haga automáticamente después del save.
			if($producto->stock >= 0){
				$producto->save();
				$producto->registrarCambioStock($cantidad, $descripcion);
				// Si el stock restante es menor al mínimo. Se envía una notificación de que quedan pocos.				
				if($producto->stock_minimo_notificar && $producto->stock <= $producto->stock_minimo_valor){
					$titulo = "Stock mínimo alcanzado";
					$texto = "Quedan " . $producto->stock . " unidad/es de " . $producto->nombre; 
					$link_texto = "Ir al producto";
					$link = "/productos/detalle/" . $producto->codigo;
					Notificacion::crearNotificacion($titulo, $texto, $link, $link_texto);
				}

				$mensaje = "Stock modificado correctamente.";
				return Redirect::back()->with(compact('mensaje'));
			}else{
				$error = "ERROR: El stock final debe ser mayor o igual a 0.";
				return Redirect::back()->with(compact('error'));
			}
		}
	}

	public function NotifStockMin(Request $request, $producto_codigo){
		$producto = Producto::BuscarPorCodigo($producto_codigo)->firstOrFail();
		if($producto != null){
			if($producto->stock_minimo_notificar == false){
				$producto->stock_minimo_notificar = true;
				$producto->save();
				$mensaje = "Notificación activada correctamente.";
				return Redirect::back()->with(compact('mensaje'));
			}else{
				$producto->stock_minimo_notificar = false;
				$producto->save();
				$mensaje = "Notificación desactivada correctamente.";
				return Redirect::back()->with(compact('mensaje'));
			}
		}        
	}

	public function nuevaFamiliaProducto(Request $request){	
	if (!\Auth::user()->hasPermissionTo('add_users'))
            return \Redirect::to('/');
	
		$familiaProducto = new FamiliaProducto();
		try {
			$familiaProducto->nombre = $request->nombreFamiliaProducto;
			$familiaProducto->save();
			return $familiaProducto->id;
			//$mensaje = "Familia de producto agregada correctamente.";
			//return Redirect::back()->with(compact('mensaje'));
		} catch ( \Illuminate\Database\QueryException $e) {
			if($e->errorInfo[0] == "23000"){
				$error = "Ya existe una familia de producto llamada '" . $request->nombreFamiliaProducto . "'.
				";
				return Redirect::back()->with(compact('error'));                
			}
			dd($error);
		}
	}

	public function movimientos(Request $request){
		$usuarios = User::where('id','>',1)->get();
		$fechaInicio = $request->fechaInicio;
		$fechaFin = $request->fechaFin;        

		if($fechaFin && $fechaInicio){            
			$fechaInicio = "$fechaInicio 00:00:00";
			$fechaFin = "$fechaFin 23:59:59";
			$movimientos = LineaProducto::where('fecha', '>=', $fechaInicio)
							->where('fecha', '<=', $fechaFin)
							->paginate(4);    
								        
		}else{
			$movimientos = LineaProducto::orderBy('fecha', 'desc')->paginate(4);
		}
		
		return view('admin.productos.movimientos')->with(compact('movimientos', 'usuarios'));
	}



	 private function setProducto(Request $request , Producto $producto)
	 {
        

			$iva = TasaIva::find(3);
			//Acá se hace el alta
			
			$producto->codigo  = $request->codigo;
			$producto->codigo_de_barras  = $request->codigo_de_barras;
			$producto->nombre  = $request->nombre;
			$producto->descripcion  = $request->descripcion;
			$producto->familia_producto_id  = $request->familia_producto;
			$producto->precio  = $request->precio;

			

			if($request->stock!='' || $request->stock>0){
				$producto->stock  = $request->stock;
			}else{
				$producto->stock  = 0;
			}
			
			

					 //guardar imagen
		        $file = $request->file('photo');
		        $path = public_path() . '/images/productos';
		        $fileName = uniqid() . $file->getClientOriginalName();
		        $moved = $file->move($path, $fileName);

		        //dd($fileName);

		        //crear registro
		        $producto->photo = $fileName;

		        $producto->save();
	            $producto->registrarCambioPrecio();
        }

  
        
    


      /**
     *  Handle Image Upload
     */
    public function handleImageUpload(Request $request){
        if( $request->hasFile('photo') ){
            
            //get filename with extension
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            
            //get just filename
            $filename = pathInfo($filenameWithExt,PATHINFO_FILENAME);
            
            // get just extension
            $extension = $request->file('photo')->getClientOriginalExtension();
            
            /**
             * filename to store
             * 
             *  we are appending timestamp to the file name
             *  and prepending it to the file extensio n just to
             *  make the file name unique.
             */
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            
            //upload the image
            $path = $request->file('photo')->storeAs('images/productos' , $fileNameToStore);
        }
        /**
         *  return the file name so we can add it to database.
         */
        return $fileNameToStore;
    }



       public function imprimir($id)
    {
    
       $fecha = "04/07/2018";
        
        $pdf= app('Fpdf');

        $pdf->AddPage();
       
        $pdf->Ln(1);
        
         // dd();

        $producto = Producto::count();
              
         $pdf->Image('images/logo/logo.png',10,5,25,25,'PNG');
         $pdf->SetY(10);
         $pdf->SetFont('Arial','B',12);
         $pdf->SetXY(45,10);
         $pdf->Cell(80,5,utf8_decode("" ),0,1,'L');
         $pdf->Ln(10);
         $pdf->SetXY(47,14);
         $pdf->SetFont('Arial','B',8);
         $pdf->Cell(80,5,utf8_decode("" ),0,1,'L');
         $pdf->SetXY(150,10);
         $pdf->SetFont('Arial','B',12);
         $pdf->Cell(60,5,utf8_decode("Fecha: ".date("d/m/Y")),0,1,'L');
         $pdf->SetXY(150,15);
         $pdf->Cell(60,5,utf8_decode("Cantidad de Rutas: ").'00'.($producto),0,1,'L');

         $pdf->Ln(10);
         $pdf->SetFont('Arial','B',10);
         $pdf->Cell(180,10,utf8_decode("   Sisadmin"),0,1,'L');

         $productos = Producto::find($id);

         $pdf->Ln(10);
          $pdf->SetFont('Arial','B',16);
          $pdf->Cell(190,5,utf8_decode("Detalles de la ruta"),0,1,'C');


          $pdf->SetFont('Arial','B',10);
          $pdf->Ln(6);
          $pdf->SetX(10);
          $pdf->Cell(20,6,utf8_decode('Código'),1,0,'C');
          $pdf->Cell(50,6,"Nombre",1,0,'C');
          $pdf->Cell(30,6,utf8_decode("Categoría"),1,0,'C');
          $pdf->Cell(30,6,utf8_decode("Descripción"),1,0,'C');
          $pdf->Cell(30,6,"Precio",1,0,'C');
          $pdf->Cell(20,6,"Cantidad",1,0,'C');
           
          $pdf->Ln(6);
          $pdf->Cell(20,6,$productos->codigo,1,0,'C');
          $pdf->Cell(50,6,$productos->nombre,1,0,'C');
          $pdf->Cell(30,6,$productos->familia->nombre,1,0,'C');
          $pdf->Cell(30,6,$productos->descripcion,1,0,'C');
          $pdf->Cell(30,6,$productos->precio,1,0,'C');
          $pdf->Cell(20,6,$productos->stock,1,0,'C');
       

          

     
        
        //save file
        $headers=['Content-Type'=>'application/pdf'];
        return Response($pdf->Output(), 200, $headers);

   

	}

   public function detallada()
   {
   	 
      $producto = Producto::find(1);
      if ($producto <> true) {
 
            return \Redirect::to('/');

      }
      $productoJson = \DB::table('productos')->where('id',1)->get()->toJson();
      return view ('admin.productos.detallada',compact('producto','productoJson'));

   }
}