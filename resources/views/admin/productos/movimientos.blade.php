@extends('layouts.admin')
@section('title', 'movimiento de rutas')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="title ml-5 mt-3 mb-3">
                    <h4>Movimiento de rutas</h4>
                </div>

                <div class="card-body">
                    <span class="float-right">
                        <a class="btn btn-md btn-success" href="/productos/nuevo" class="btn btn-link">
                            <i class="fa fa-plus" aria-hidden="true"></i> Nueva ruta
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
                                Rutas &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i>
                            </a>
                        </li>
                       <li class="list-inline-item">
                            <a href="/productos/movimientos" class="link_ruta">
                                Movimientos
                            </a>
                        </li>
                    </ul><br>
				</div>
				<div class="card-body">
                    <div class="row">
                    	<div class="container">
	                        <div class="table-responsive">
								<table width="97%" class="table table-hover">
									<tr>
										<th width="70px">Fecha</th>
										<th width="70px">Hora</th>
										<th width="200px">Producto</th>
										<th width="40px">Cant.</th>
										<th>Descripción</th>
										<th width="120px">Comprador</th>
									
									</tr>

									@foreach($movimientos->sortByDesc('fecha') as $m)										
										<tr>
											<td>{{ date_format( date_create($m->fecha), 'd/m/Y' ) }}</td>		
											<td>{{ date_format( date_create($m->fecha), 'H:i:s' ) }}</td>		
											<td>
                                                <a href="/productos/detalle/{{ $m->producto->codigo }}">
                                                    @if(strlen($m->producto->nombre) > 24)
                                                        {{ substr($m->producto->nombre, 0, 24) . "..."}}
                                                    @else
                                                        {{ $m->producto->nombre }}
                                                    @endif                                                    
                                                </a>
                                            </td>
											<td align="center">{{ $m->cantidad}}</td>
											<td>{{ $m->descripcion}}</td>
											<td>{{$m->usuario->name}}</td>
									
										</tr>
									@endforeach							
								</table>
							</div><br>
							<div class="text-center">
								{{ $movimientos->links( "pagination::bootstrap-4") }}
							</div>
						</div>
                    </div>
                    @include('partials.movimiento_stock')
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection
