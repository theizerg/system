@extends('layouts.admin')
@section('title', 'productos')
@section('content')
<div class="container">      
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="title mt-3 ml-3">
					<h4>Alta de ruta</h4>
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
								Rutas &nbsp; &nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i>
							</a>
						</li>
						<li class="list-inline-item">
							<a href="/productos/nuevo" class="link_ruta">
								Nuevo
							</a>
						</li>
					</ul>
				
					<div class="row">
						
							<div class="col-md-4">
								<legend>Registro de rutas</legend>
								<form id="form_nuevo_producto" role="form" method="POST" action="/productos/nuevo" enctype="multipart/form-data">
									{{ csrf_field() }}
									<div class="form-group ml-0 mr-0">
				                     <input type="number" id="codigo" class="form-control" placeholder="Código" name="codigo" value="{{ old('codigo') }}">
				                     <span style="color: #F44336 !important;">{{$errors->first('codigo') }}</span>
				                         
										<p id="demo"></p>
				                    </div>

									<div class="form-group ml-0 mr-0">
				                     <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" placeholder="Nombre">
				                               
				                      <span style="color: #F44336 !important;">{{$errors->first('nombre') }}</span>
				                    </div>
									
									<div class="form-group ml-0 mr-0">
				                     <input type="number" class="form-control" name="codigo_de_barras" id="codigo_de_barras" value="{{ old('codigo_de_barras') }}"placeholder="Código de barras">
				                           <span style="color: #F44336 !important;">{{$errors->first('codigo_de_barras') }}</span>
				                    </div>
									
									<div class="form-group">
										<label for="txtNombre" class="control-label sr-only">
											Tipo de producto (Ruta)
											<a href="#formFamiliaProducto" class="btn-link" data-toggle="modal" data-target="#formFamiliaProducto" style="color:green">
												<small>
													<i class="fa fa-plus" aria-hidden="true">
														Agregar
													</i>
												</small>
											</a>
										</label>

										<div class="input-group pull-right">
											<select id="selectFamiliaProducto" class="form-control" name="familia_producto" required="true">
												<option value="" disabled selected hidden>Tipo de producto (Ruta)</option>
												@foreach( $familias_producto as $f)
													<option value="{{ $f->id}}">{{ $f->nombre }}</option>
												@endforeach
											</select>
											
											<div class="input-group-btn">
												<a href="#formFamiliaProducto" id="btnAgregarArticulo" class="btn btn-round btn-primary" data-toggle="modal" data-target="#formFamiliaProducto" style="color:white">
													<i class="fa fa-plus-square" aria-hidden="true"></i>
												</a>
											</div>
										</div>
									</div>
									<div class="form-group ml-0 mr-0">
				                     <input type="number" class="form-control" name="precio" value="{{ old('precio') }}"placeholder="Precio">
				                           
				                     <span style="color: #F44336 !important;">{{$errors->first('precio') }}</span>
				                    </div>

									
									<div class="form-group ml-0 mr-0">
				                     <input type="number" class="form-control" name="stock" value="{{ old('stock') }}" placeholder="Cantidad Inicial">
				       
				                          <span style="color: #F44336 !important;">{{$errors->first('stock') }}</span>
				                    </div>
									<div class="form-group" style="">
										
										<textarea class="form-control" id="txtDescripcion" rows="3" placeholder="Descripción" name="descripcion"></textarea>
										<span style="color: #F44336 !important;">{{$errors->first('descripcion') }}</span>
									</div>

									<div class="form-group ml-0 mr-0">
										<b>Imagen</b><br>
				                     <input type="file" class="form-control" name="photo" value="{{ old('photo') }}"placeholder="Precio">
				                           
				                     <span style="color: #F44336 !important;">{{$errors->first('photo') }}</span>
				                    </div>

									

									<div class="form-group text-center">
										<input type="submit" class="btn btn-primary btn-block" value="Guardar">
									</div>		                    		
								</form>   

							</div>
		
							<div class="col-md-8">
								<legend>Últimas rutas registradas</legend>
								<div class="table-responsive">
									<table width="97%" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th>Código</th>
												<th>Imagen</th>
												<th>Nombre</th>
												<th>Fecha</th>
												
											</tr>	                						
										</thead>
										<tbody>
											@foreach($productos as $p)
												<tr>
													<td><a href="/productos/detalle/{{ $p->codigo}}">{{ $p->codigo}}</a></td>
													<td><img height="40" src="{{asset('images/productos/'.$p->photo)}}"></td>
													<td>{{ $p->nombre }}</td>
													@if($p->created_at != null)
														<td>{{ date_format( $p->created_at, 'd/m/Y H:i:s' ) }}</td>
													@else
														<td></td>
													@endif
													
												</tr>
											@endforeach
										</tbody>

									</table>
									{{ $productos->links( "pagination::bootstrap-4") }}
								</div>
							</div>
							<div class="col-md-5 col-md-offset-2">                					
								
							</div>
							@include('partials.familia_producto_box')
						</div>
					</div>                        
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function () {

  $('#form_nuevo_producto').validate({
    rules: {
      codigo: {
        required: true,
         number: true,

        minlength: 2,
      },
      nombre: {
        required: true,
        minlength: 6
      },
      codigo_de_barras: {
        required: true,
         number: true,

      },
      precio: {
        required: true,

      },
      stock: {
        required: true,
         number: true,

      },
      descripcion: {
        required: true
      },
    },
    messages: {
      codigo: {
      	number:"Sólo números",
        required: "Introduce el código",
         minlength: "Debe tener un mínimo de 2 caracteres",

      },
      codigo_de_barras: {
        required: "Introduce el código de barras",
        minlength: "Debe tener un mínimo de 2 caracteres"
      },
      nombre: {
        required: "Introduce el nombre",
        minlength: "Debe tener un mínimo de 2 caracteres"
      },
       precio: {
        required: "Introduce precio",
        minlength: "Debe tener un mínimo de 2 caracteres",
      },
       stock: {
        required: "Introduce la cantidad principal",
        minlength: "Debe tener un mínimo de 2 caracteres",
      },
      descripcion: {
        required: "Introduce la descripción"

      },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });

});
</script>

<script type="text/javascript">	

	$("#formFamiliaProducto").on('submit', function(e){
		e.preventDefault();		
		var familiaProducto = $('#txtnombreFamiliaProducto').val();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: "POST",
			url: '/productos/familiaProductos/nueva',
			data: {nombreFamiliaProducto: familiaProducto},            
			success: function( response ) {				
				$('#selectFamiliaProducto').append($('<option>', {
					value: response,
					text: familiaProducto,
					selected: true
				}));
				$('#formFamiliaProducto').modal('toggle');
			}
		});
	});
</script>



@push('scripts')
<script>
    
$(document).ready(function (){
   
    //Define la cantidad de numeros aleatorios.
var cantidadNumeros = 5;
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
$('#codigo').val('000' + myArray.join(""));
  });
</script>
<script>
    
$(document).ready(function (){
   
    //Define la cantidad de numeros aleatorios.
var cantidadNumeros = 8;
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
$('#codigo_de_barras').val(myArray.join(""));
  });
</script>
@endpush
@endpush