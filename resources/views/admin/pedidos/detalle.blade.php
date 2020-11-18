 @extends('layouts.admin')

@section('title', 'Administración')

@section('content')
<div class="container-fluid">
	<div class="col-sm-12">
		<div class="card">
			<div class="title mt-3 ml-3">
				<h4>Pedidos Generados</h4>
			</div>
			<div class="card-body">
			<ul class="list-inline">
					 <li class="list-inline-item">
						<a href="/home" class="link_ruta">
							Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i>
						</a>
					</li>
					 <li class="list-inline-item">
						<a href="/mostrar" class="link_ruta">
							Pedidos
						</a>
					</li>
				</ul><br>
				<div class="row">
					<div class="container">
						<div class="table-responsive">
						 	   <table id="example" cellspacing="0" width="100%" class="table">
							<thead>
							<tr>
								<th class="text-center">#</th>
                                <th class="text-center">Producto</th>
                                <th  class="text-center">Número de Orden</th>
								<th  class="text-center">Cantidad</th>
								<th  class="text-center">Total a pagar</th>
								<th  class="text-center">Estado</th>
								<th  class="text-center">Descripción</th>
								<th class="text-center">Opciones</th>
								
							</tr>
							</thead>
							<tbody>
							 @foreach ($pedidos as $detail)
							<tr class="text-center">
								<td> <img src="{{asset('images/productos/'.$detail->producto->photo)}}" height="50"></td>	
                                 <td> {{$detail->producto->nombre}}  </td>
                                <td>{{$detail->orden_pedido}}</td>
                                <td>$ {{$detail->subTotal}}</td>
                                <td>$ {{$detail->total}}</td>
                                <td><span class="badge green z-depth-1 mr-1 {{$detail->status}} ?  : 'badge red z-depth-1 mr-1 ' }}">{{$detail->status}}</td>
                                <td>{{$detail->descripcion}}</td>
                                <td class="text-center">

                                        <a data-toggle="tooltip" data-placement="top"
                                         title="editar pedido " class="btn lue darken-4 btn-fab btn-round" href="{{ url('/pedidos/detalle/'.$detail->id.'/edit') }}" style=" background-color: #0d47a1 !important;">
                                            <i class="material-icons" style="color: white;"  data-toggle="modal" data-target="#modalAbandonedCart">edit</i>
                                        </a>
                                         
                                                                     
                                </td>
							</tr>
							      @endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')

<script>
  // Tooltips Initialization
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>


@endpush