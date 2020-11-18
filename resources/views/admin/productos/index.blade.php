@extends('layouts.admin')
@section('title', 'Rutas')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="title mt-3 ml-3">
					<h4>Vista general de rutas</h4>
				</div>

			 <div class="card-body">
			 	<ul class="list-inline">
						<li class="list-inline-item">
							<a href="/home" class="link_ruta">
								Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i>
							</a>
						</li>
						<li class="list-inline-item">
							<a href="/productos" class="link_ruta">
								Productos &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i>
							</a>
						</li>
						
					</ul><br>
				<div class="row mb-3">	
					<div class="col-sm-4">
					<span class="float-left">
						 
						 <button class=" btn btn-md blue accent-4 clearfix d-none d-sm-inline-block" data-toggle="modal" data-target="#modalAbandonedCart">
						 	<span class="badge red z-depth-1 mr-1"> {{ $contadorNoti }}  </span>
						 	  <span class="text-white">Noficaciones</span>
                          </button>
					</span>	
					</div>
				
					
					<div class="col-sm-4">
					
						 
						<span class="text-center">
						<a class="btn btn-md blue accent-4 white-text ml-5" href="/productos/movimientos" class="btn btn-link" data-toggle="tooltip" data-placement="top"
                                         title="Movimiento de productos " >
							<i class="fa fa-plus" aria-hidden="true"></i> Movimiento 
						</a>
					</span>	
					
					</div>
					
					<div class="col-sm-4">
					
						 
						 <span class="text-center">
						<a class="btn btn-md blue accent-4 white-text ml-5" href="/productos/nuevo" class="btn btn-link" data-toggle="tooltip" data-placement="top"
                                         title="Agregar nuevo producto " >
							<i class="fa fa-plus" aria-hidden="true"></i> Nuevo producto 
						</a>
					</span>	
					
					
					</div>
				</div>	
					
					<ul class="list-inline">
						 <li class="list-inline-item">
							<a href="/home" class="link_ruta">
								Inicio &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i>
							</a>
						</li>
						 <li class="list-inline-item">
							<a href="/productos" class="link_ruta">
								Productos
							</a>
						</li>
					</ul>
				
					<div class="row">
						<div class="container">
							<div class="table-responsive ">
								<table id="example"  class="table">
									<thead>
									<tr>
										<th class="text-center" width="100px">Código</th>
										<th class="text-center" width="80px">Nombre</th>
										<th class="text-center" width="140px">Categoría</th>
										<th class="text-center">Descripción</th>
										<th class="text-center" width="70px">Precio</th>
										<th class="text-center" width="5%">Stock</th> <th class="text-center">Opciones</th>                                     
									</tr>
									</thead>

									@foreach($productos as $producto)
										
									<tbody>
<tr>
											<td class="text-center"><a href="/productos/detalle/{{ $producto->codigo}}">{{ $producto->codigo}}</a></td>
											<td class="text-center" title="{{$producto->nombre}}">
												@if(strlen($producto->nombre) > 24)
													{{ substr($producto->nombre, 0, 24) . "..."}}
												@else
													{{ $producto->nombre }}
												@endif
											</td>
											<td class="text-center">{{ $producto->familia->nombre}}</td>
											<!--<td class="text-center">{{ $producto->descripcion}}</td>-->
											<td class="text-center">
												{{ str_limit(str_replace('<br />','', $producto->descripcion), 80) }}

												@if(strlen($producto->descripcion) > 80)
												<span class="float-right">
													<a class="btn-sm btn-link" data-toggle="modal" data-target="#myModal{{ $producto->codigo }}">
														más...
													</a>
												</span>
													<div id="myModal{{ $producto->codigo }}" class="modal fade" role="dialog">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title">{{ $producto->nombre }}</h4>
																</div>
																<div class="modal-body">
																	{!! $producto->descripcion !!}
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
																</div>
															</div>
														</div>
													</div>
												@endif
											</td>
											<td>
												&nbsp;
												
												<span class="float-right">
													Bs.{{ $producto->precio}}
												</span>
											</td>
											<td class="text-center">{{ $producto->stock}}</td>
											<td class="text-center">
												<a class="btn btn-round blue darken-4 text-white" href="#formStock" id="{{$producto->codigo}}" data-toggle="modal" data-target="#formStock" onclick='$("#form_stock").attr("action", "/productos/{{$producto->codigo}}/ModificarStock");'>
													<i class="material-icons" aria-hidden="true">
														track_changes
													</i>
												</a>
												<a href="{{ ('productos/imprimir/'.$producto->id) }}" class="btn btn-round blue darken-1 text-white">
													<i class="material-icons" aria-hidden="true">
														print
													</i>
												</a>
											</td>
											
										</tr>
										</tbody>
									@endforeach 
									<tfoot>
							            <tr>
							                <th>Código</th>
							                <th>Nombre</th>
							                <th>Categoría</th>
							                <th>Descripción</th>
							                <th>Precio</th>
							                <th>Stock</th>
							                <th>Opciones</th>
							            </tr>
							        </tfoot>                        
								</table>
							</div>
							<div class="text-center">
								{{ $productos->links( "pagination::bootstrap-4") }}
							</div>
						</div>
					</div>
					@include('partials.movimiento_stock')
				</div>                
			</div>
		</div>
	</div>
</div>
<div class="modal fade center" id="modalAbandonedCart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
     
      	
    
    <div class="modal-dialog" role="document">
      <div class="modal-dialog modal-center modal-notify modal-info" role="document">
        <!--Content-->
        <div class="modal-content">

          <!--Header-->
          <div class="modal-header">
            <p class="heading"> <i class="fas fa-shopping-cart fa-2x"></i>
              Notificaciones
            </p>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="white-text">&times;</span>
            </button>
          </div>
          

          <!--Body-->
          <div class="modal-body">
            <div class="row">
                <div class="col sm-6">
                  <div class="table-responsive">	
					<table class="table table-hover">	
					 <thead>
					   <tr>
						<th class="text-center">Mensaje</th>
						<th>Opciones</th>                                     
						</tr>
					 </thead>
					  <?php foreach ($notificaciones as $key => $notificacion): ?>
					 <tbody>
					 	<tr class="text-center">
					 		<td> {{$notificacion->texto}}  </td>
					 		<td> <a href=" {{$notificacion->link}} " class="btn btn-redondo blue darken-4"  data-toggle="tooltip" data-placement="top"
                                         title="Link del producto"> <span class="text-white"><i class="material-icons mt-1">person</i>  </span></a></td>
					 	</tr>

					 </tbody>	
					  <?php endforeach ?>
				    </table>
                  </div>
            </div>
               
             </div>
             <div class="text-center">
								{{ $notificaciones->links( "pagination::bootstrap-4") }}
							</div>
	
            <!--Footer-->
            <div class="modal-footer">
                
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