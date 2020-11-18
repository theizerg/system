@extends('layouts.admin')

@section('title', 'Pedidos')

@section('content')

        <div class="section">
            <div class="container">
                <div class="row">
                     <div class="col-lg-6 col-sm-6">
                        <div class="card" >
                            <div class="card-header card-header-primary">
                                <h4 class="text-center">
                                       <h3>Productos en la Cesta <b class="badge badge-danger z-depth-1 mr-1"> {{ auth()->user()->cart->details->count() }}</b></h3>
    
                                </h4>
                            </div>
                            <div class="card-body text-center">
                                    <div class="table-responsive">
                        <table id="example" cellspacing="0" width="100%" class="table">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Código</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Precio</th>
                                <th  class="text-center">Cantidad</th>
                                <th  class="text-center">Total</th>
                                <th  class="text-center">Opciones</th>
                            </tr>
                            </thead>
                            <tbody>
                             @foreach (auth()->user()->cart->details as $detail)
                            <tr class="text-center">
                                <td> <img src="{{asset('images/productos/'.$detail->productos->photo)}}" height="50"></td>
                                <td> {{$detail->productos->codigo}}  </td>  
                                 <td> {{$detail->productos->nombre}}  </td>     
                                <td> Bs.{{$detail->productos->precio}}</td>
                                <td>{{$detail->quantity}}</td>
                                <td> Bs.{{$detail->productos->precio * $detail->quantity}}</td>
                                <td class="text-center">
                                    <form method="post" action="{{ url('/cart/'.$detail->id) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                
                                         <button type="submit" class="btn btn-danger btn-fab btn-round" data-toggle="tooltip" data-placement="top"
                                         title="Eliminar pedido "class="btn btn-danger btn-redondo btn-xs">
                                           <i class="material-icons" style="color: white;">delete</i>
                                        </button>
                                    </form>                                    
                                </td>
                                
                            </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                            </div>
                </div>
            </div> 
                <div class="col-sm-6 col-lg-6">
                    <form method="post" id="formNuevoComprobante" action="{{ url('/order') }}">
                                {{ csrf_field() }}
                      <div class="card">
                           <div class="title text-center">
                            <h3>Número de Orden <br>
                            </h3>
                            <input type="text" id="codigo" value="" name="orden_pedido" class="form-control" disabled style="text-align: center; font-size: 2em;">
                            <input type="hidden" name="orden_pedido" id="pedido">
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-sm btn-primary " data-toggle="tooltip" data-placement="top"
                                title="Realizar pedido" id="formNuevoComprobante" >
                               Procesar compra

                            </button>
                            <a href="{{url('/')}} " class="btn btn-link btn-success">Seguir comprando</a>
                        </div>
                        
                      </div>        
                        <div class="form-group">
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
   </div>
</div>


@endsection
@push('scripts')
<script>
    
$(document).ready(function (){
   
    //Define la cantidad de numeros aleatorios.
var cantidadNumeros = 7;
var myArray = []
while(myArray.length < cantidadNumeros ){
  var numeroAleatorio = Math.ceil(Math.random()*cantidadNumeros);
  var existe = false;
  for(var i=0;i<myArray.length;i++){
    if(myArray [i] == numeroAleatorio){
        existe = true;
        break;
    }
  }
  if(!existe){
    myArray[myArray.length] = numeroAleatorio;
  }

}
$('#codigo').val(myArray.join(""));
$('#pedido').val(myArray.join(""));
  });
</script>


@endpush



