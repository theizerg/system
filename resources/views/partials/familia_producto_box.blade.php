<!-- Modal alerts -->
	<div class="modal fade" id="formFamiliaProducto" tabindex="-1" role="dialog" aria-labelledby="formFamiliaProductoLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<center><h4>Tipo de ruta</h4></center>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form class="form" method="post" action="/productos/familiaProductos/nueva">
			{{ csrf_field() }}
			<meta name="csrf-token" content="{{ csrf_token() }}">			
				<div class="modal-body list-group">
					<div class="row">
						<div class="col-md-12 col-md-offset-2">
							<fieldset>
								<div class="form-group text-center">
									
									<input id="txtnombreFamiliaProducto" type="text" class="form-control" name="nombreFamiliaProducto" placeholder="Ingresa el tipo de ruta" oninvalid="this.setCustomValidity('Debe ingresar un valor válido')" required oninput="setCustomValidity('')">
								</div>
							</fieldset>
							<div class="form-group">
								<input class="btn btn-success btn-block" type="submit" name="" value="Guardar">
							</div>
						</div>
					</div>
				</div>				
			</form>
		</div>
	</div>
</div>