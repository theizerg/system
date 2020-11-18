@extends('layouts.admin')
@section('title', 'productos')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="title ml-5 mt-3 mb-3">
					<h4>Detalle de la ruta</h4>
				</div>
				<div class="card-body">
					<span class="float-right">
						<a class="btn btn-md btn-success" href="/productos/nuevo" class="btn btn-link">
							<i class="fas fa-plus" aria-hidden="true"></i> Nueva ruta
						</a>
					</span><br>
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
						 <li class="list-inline-item">
							<a href="/productos/detalle/{{$producto->codigo}}" class="link_ruta">
								{{ $producto->nombre }}
							</a>
						</li>
					</ul><br>
					
					<div class="row">
							<div class="col-md-4">
								<legend>
									Detalle de la ruta
									<span class="float-right">
										<a class="btn blue darken-1 btn-sm" id="editCodigo" data-toggle="modal" data-target="#modalEditarProducto">
											<i class="fas fa-edit fa-lg" aria-hidden="true"></i>
										</a>
									</span>
								</legend>								
								<div class="form-group">
									<table class="table table-condensed table-striped table-bordered" width="100%">
										<tr>
											<th class="text-center th-b" colspan="2">Información general</th>
										</tr>
										<tr>
											<td width="30%">Código</td>
											<td width="70%">
												{{ $producto->codigo }}
											</td>
										</tr>
										<tr>
											<td>Nombre</td>
											<td> 
												{{ $producto->nombre }}
											</td>
										</tr>
										<tr>
											<td>Cod. barras</td>
											<td> 
												{{ $producto->codigo_de_barras }}
											</td>												
										</tr>
										<tr>
											<td>Familia</td>
											<td> 
												{{ $producto->familia->nombre }}
											</td>
										</tr>
										<tr>
											<td>Descripción</td>
											<td> 													
												{{ str_limit(str_replace('<br />','', $producto->descripcion), 40) }}
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
												@else
													</label>
												@endif
												
											</td>
											
										</tr>
										<tr>
											<td>Precio venta</td>
											<td>
												<!-- Se obtiene moneda predeterinada --> 
												BS.
												{{ $producto->precio }}
												<span class="float-right">
													<a href="#formStock" class="btn btn-sm" id="{{$producto->codigo}}" data-toggle="modal" data-target="#modalHistoricoPrecios" onclick='$("#form_stock").attr("action", "/productos/{{$producto->codigo}}/ModificarStock");'  title="Histórico de precios de venta para este producto">
														<i class="fa fa-book" aria-hidden="true"></i>
													</a>
												</span>
											</td>												
										</tr>
										<tr>
											<td>Tasa de IVA</td>
											<td>
												{{ $producto->iva->nombre }}
												<span class="float-right">
													 ( {{$producto->iva->tasa}} % )

												</span>
											</td>												
										</tr>
										<tr>
											<td>Stock</td>
											<td> 
												{{ $producto->stock }}
												<span class="float-right">
													<a href="#formStock" class="btn btn-sm" id="{{$producto->codigo}}" data-toggle="modal" data-target="#formStock" onclick='$("#form_stock").attr("action", "/productos/{{$producto->codigo}}/ModificarStock");' title="Realizar un movimiento de stock">
														<i class="fas fa-exchange-alt" aria-hidden="true"></i>
													</a>
												</span>
											</td>
										</tr>
									</table>
								</div>								
								@include('partials.movimiento_stock')
							</div>


							<div class="col-md-8">
								<legend>Últimos movimientos</legend>
								<div class="col-md-12">
									<div class="table-responsive ">
										<table class="table table-condensed table-striped table-bordered">
											<thead>
												<tr>
													<th class="text-center" width="70px">Fecha</th>
													<th class="text-center" width="70px">Hora</th>
													<th class="text-center" width="40px">Cant.</th>
													<th class="text-center">Descripción</th>
													<th class="text-center">Pedido</th>
													<th class="text-center" width="75px">Usuario</th>
												</tr>
											</thead>
											<tbody>
												@foreach($movimientos->sortByDesc('fecha') as $m)
													<tr>
														<td>{{ date_format( date_create($m->fecha), 'd/m/Y' ) }}</td>
														<td>{{ date_format( date_create($m->fecha), 'H:i:s' ) }}</td>
														<td align="center">{{ $m->cantidad}}</td>
														<td title="{{$m->descripcion}}">
															@if(strlen($m->descripcion) > 36)
																{{ substr($m->descripcion, 0, 36) . "..."}}
															@else
																{{ $m->descripcion }}
															@endif
														</td>
														<td class="text-center">
															@if($m->pedido_id)
																<a href="/pedido/detalle/{{$m->pedido_id}}">
																	{{ $m->pedido_id }}
																</a>
															@else
																-
															@endif
														</td>
														<td class="text-center">{{$m->usuario->name}}</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
								<div class="text-center">
									{{ $movimientos->links() }}
								</div>
							</div>
						</div>
					</div>
					<div class="container">
						<div class="col-md-12">
							<legend>Configuración del producto <i class="fa fa-cogs" aria-hidden="true"></i></legend>
							<div class="col-md-8">
								<form class="form-horizontal" role="form" method="POST" action="/productos/{{$producto->codigo}}/configuracion">
								{{ csrf_field() }}
									<div class="form-group">
										<h4>Notificaciones</h4>
										<div class="table-responsive">
											<table width="100%" class=" table">
												<tr>
													<th width="120px">
														Stock mínimo
													</th>
													<th width="80px">
														<input class="input-sm form-control" type="number" name="stockMinimo" value="{{ $producto->stock_minimo_valor }}" id="txtStockMinimo">
													</th>
													<td>
														Recibe una notificación cuando el stock del producto sea menor o igual al especificado.
													</td>
													@push('scripts')
													<td  class="float-right">
														
															
															<script type="text/javascript">
																$("#txtStockMinimo").prop('disabled', false);
															</script>
															<span class="label label-success">Activado</span>
															<a href="/productos/{{$producto->codigo}}/NotifStockMin">Desactivar</a>
														
															<script type="text/javascript">
																$("#txtStockMinimo").prop('disabled', true);
															</script>
															<span class="label label-warning">Desactivado</span>
															<a href="/productos/{{$producto->codigo}}/NotifStockMin">Activar</a>
														
														@endpush
													</td>
												</tr>												
											</table>
										</div>
									</div>
									<div class="form-group">
										<input class="btn btn-primary" type="submit" value="Guardar configuración">
									</div>
								</form>
							</div>
							<div class="col-md-3 col-md-offset-1">
								<div class="form-group">
									<form id="form-borrar" class="form-horizontal" role="form" method="POST" action="/productos/borrar">
										{{ csrf_field() }}
										<input type="hidden" name="producto_id" value="{{$producto->id}}">
										<h4>Eliminar producto</h4>
										<p><small>El producto no se mostrará más luego de ser borrado. Pero se mantendrá su registro histórico.</small></p>
										<input class="btn btn-danger" type="submit" name="" value="Borrar producto">
									</form><br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>    
</div>
<div class="modal fade" id="modalEditarProducto" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4>
					Editar datos del producto
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</h4>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<form id="form_editar_producto" class="form-horizontal" role="form" method="POST" action="/productos/editar">
						{{ csrf_field() }}
							<input type="hidden" name="producto_id" value="{{$producto->id}}">
							<div class="form-group">
								<table class="table table-condensed table-striped table-bordered" width="100%">
									<tr>
										<th width="30%">Código</th>
										<td width="70%">									
											<input id="txtCodigo" type="text" class="form-control input-sm" name="codigo" placeholder="Código del producto" value="{{$producto->codigo}}" hidden="true" required>
										</td>										
									</tr>
									<tr>
										<th>Nombre</th>
										<td>
											<input id="txtNombre" type="text" class="form-control input-sm" name="nombre" placeholder="Nombre del producto" value="{{$producto->nombre}}" required>
										</td>
										
									</tr>
									<tr>
										<th>Código de barras</th>
										<td>
											<input id="txtCodigoDeBarras" type="text" class="form-control input-sm" name="codigo_de_barras" placeholder="Codigo de barras del producto" value="{{$producto->codigo_de_barras}}" >
										</td>
										
									</tr>
									<tr>
										<th>Familia</th>
										<td>
											<select id="selectFamilia" class="form-control input-sm" name="familia_producto">
												@foreach( $familias_producto as $f)
													@if($f->id == $producto->familia->id)
														<option value="{{ $f->id}}" selected="true">{{ $f->nombre }}</option>
													@else
														<option value="{{ $f->id}}">{{ $f->nombre }}</option>
													@endif
												@endforeach
											</select>
										</td>
										
									</tr>
									<tr>
										<th>Descripción</th>
										<td>
											<textarea class="form-control input-sm" id="txtDescripcion" rows="3" placeholder="Descripción del producto" name="descripcion">{{str_replace('<br />','', $producto->descripcion)}}</textarea>
										</td>
										
									</tr>
									<tr>
										<th>
											Precio de venta $ (Sin IVA)
										</th>
										<td>
											<!-- Se obtiene moneda predeterinada -->
											<input id="txtPrecio" class="form-control input-sm" name="precio" placeholder="Precio" value="{{$producto->precio}}">
										</td>										
									</tr>
									<tr>
										<th>Tipo de iva</th>
										<td>
											<select name="tasa_iva" class='form-control'>
												@foreach($tasas_iva as $tasa_iva)
													
														<option value='{{$tasa_iva->id}}'>{{$tasa_iva->nombre}} ({{$tasa_iva->tasa}})</opition>
													
												@endforeach
											</select>
										</td>
									</tr>
								</table>
								<input type="submit" name="" value="Guardar cambios" class="btn btn-primary btn-block">
							</div>					
						</form>
					</div>
				</div>
			</div>

			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalHistoricoPrecios" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h4>
					Histórico de precios de venta
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</h4>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-condensed table-striped table-bordered">
						<thead>
							<tr>
								<th>Fecha</th>
								<th>Precio ({{App\Models\Moneda::find(1)->first()->simbolo}})</th>
								<th>Usuario</th>
							</tr>
						</thead>
						<tbody>
							@foreach($precios_historico as $p)
							<tr>
								<td>
									{{ date_format( date_create($p->fecha), 'd/m/Y' ) }}								
								</td>
								<td>{{App\Models\Moneda::find(1)->first()->simbolo}} {{ $p->precio }}</td>
								<td>{{ App\Models\User::where('id', $p->usuario_id)->first()->name }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>					
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">	
	$(document).ready(function(){
		$('#form-borrar').on('submit', function(e) {			
			if(! confirm("¿Está seguro de que desea eliminar el producto?")){
				e.preventDefault();
			}
		});
	});

	$("#form_editar_producto").on('submit', function(e){    	
		var precio = $("#txtPrecio").val();
		precio = precio.replace(",", ".");      
		if(isNaN(precio)) {         
			e.preventDefault();
			alert("El precio ingresado no es válido.");
		}
	});
</script>
@endpush