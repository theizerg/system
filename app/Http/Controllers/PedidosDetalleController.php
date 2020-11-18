<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetallePedidos;
class PedidosDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function index()
    {
        $pedidos = DetallePedidos::has('producto')
        ->where('status','pendiente')->get();

        //dd($pedidos);
        return view ('admin.pedidos.detalle', compact('pedidos'));

    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pedidos = DetallePedidos::has('producto')
        ->where('status','pendiente')->find($id);
        //dd($pedidos);
        return view ('admin.pedidos.editar', compact('pedidos'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = DetallePedidos::find($id);
        $user->update($request->all());

      

        $notification = array(
            'message' => '¡El pedido ha sido editado!',
            'alert-type' => 'success'
        );
           return \Redirect::to('pedidos/detalle')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

      public function entregados()
    {
        $pedidos = DetallePedidos::has('producto')
        ->where('status','Entregado')->get();

        //dd($pedidos);
        return view ('admin.pedidos.entregados', compact('pedidos'));

    }


     public function print ($id)
    {
       

        $fecha = "04/07/2018";
        
        $pdf= app('Fpdf');

        $pdf->AddPage();
       
        $pdf->Ln(1);

        $pedidos = DetallePedidos::find($id);

       

        
        
         $pdf->Image('assets/img/logo-imagen.png',10,5,40,35,'PNG');
        
          //dd($pedidos);
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
         $pdf->Cell(60,5,utf8_decode("N° de Orden: ").($pedidos->orden_pedido),0,1,'L');

         $pdf->Ln(10);
         $pdf->SetFont('Arial','B',10);

         $pdf->SetFont('Arial','B',10);
        //$pdf->Ln(1);
         $pdf->Cell(190,5,utf8_decode(""),0,1,'L');
        //$pdf->Ln(1);
         $pdf->Cell(190,5,utf8_decode(""),0,1,'L');
         //$pdf->Ln(1);
       

         $pdf->Ln(10);
         $pdf->SetFont('Arial','B',12);
         $pdf->Cell(190,5,utf8_decode("Nombre: ".$pedidos->usuario->name." ".$pedidos->usuario->last_name),0,1,'L');
         $pdf->Cell(190,5,utf8_decode("Dirección: ".$pedidos->usuario->tx_direccion),0,1,'L');
         $pdf->Cell(190,5,utf8_decode("Teléfono: ".$pedidos->usuario->nu_telefono),0,1,'L');
        
        

          $pdf->Ln(10);
          $pdf->SetFont('Arial','B',16);
          $pdf->Cell(190,5,utf8_decode("Comprobante de la compra"),0,1,'C');
        
         
          $pdf->SetFont('Arial','B',10);
          $pdf->Ln(6);
          $pdf->SetX(10);
          $pdf->Cell(20,6,"Cantidad",1,0,'C');
          $pdf->Cell(70,6,"Producto",1,0,'C');
          $pdf->Cell(45,6,"Precio Unitario",1,0,'C');

         
                
          $pdf->Ln(6);
          $pdf->Cell(20,6,$pedidos->cantidad,1,0,'C');
          $pdf->Cell(70,6,$pedidos->producto->nombre,1,0,'C');
          $pdf->Cell(45,6,$pedidos->producto->precio,1,0,'C');

        

           $pdf->Ln(6);
           $pdf->Cell(105,6,"SubTotal:",1,0,'C');
           $pdf->Cell(30,6,number_format($pedidos->subTotal,2,",","."),1,0,'C');

           $pdf->Ln(6);
           $pdf->Cell(105,6,"IVA:",1,0,'C');
           $pdf->Cell(30,6,number_format($pedidos->iva,2,",","."),1,0,'C');


           $pdf->Ln(6);
           $pdf->Cell(105,6,"Total:",1,0,'C');
           $pdf->Cell(30,6,number_format($pedidos->total,2,",","."),1,0,'C');
          

          
          
 

        
        

        
       

          

     
        
        //save file
        $headers=['Content-Type'=>'application/pdf'];
        return Response($pdf->Output(), 200, $headers);


        
    

    }
}
