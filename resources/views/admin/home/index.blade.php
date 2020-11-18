@extends('layouts.admin')

@section('title', 'Inicio')
@section('page_title', 'Inicio')
@section('page_subtitle', 'Principal')

@push('styles')
    <style>
    	.fa-5x
    	{
          font-size:5em
    	}
    	.fa-3x
    	{
    		font-size:3em;
    	}
    </style>
@endpush

@section('content')

<div class="container">
	<div class="row"><br><br><br><br>
		<div class="col-sm-12">
		 <div class="card">
		 	<div class="h3 mt-2 mb-2 text-center">
		 		Datos del sistema <i class="material-icons float-right text-blue mr-3 fa-3x">
		 			dashboard
		 		</i>
		 	</div>
		 	  <div class="card-body">
		 	  	 @if (Auth::guest())
		         @else
		         @hasrole('Administrador')
		 		<div class="row">
		 		   <div class="col-12 col-sm-6 col-md-4">
			        <div class="info-box elevation-2 blue">
			          <span class="info-box-icon blue darken-4 elevation-3"><i class=" text-white fas fa-user"></i></span>

			          <div class="info-box-content">
			            <span class="info-box-text text-white ml-5" style="font-size: 18px;">Usuarios</span>
			            <span class="info-box-number text-white ml-5">
			              {{ App\Models\User::count() }}
			            </span>
			          </div>
			          <!-- /.info-box-content -->
			        </div>
			        <!-- /.info-box -->
			      </div>
			      <div class="col-12 col-sm-6 col-md-4">
			        <div class="info-box elevation-2 blue">
			          <span class="info-box-icon blue darken-4 elevation-3"><i class=" text-white fas fa-lock"></i></span>
			          <div class="info-box-content">
			            <span class="info-box-text text-white ml-5" style="font-size: 18px;">Permisos</span>
			            <span class="info-box-number text-white ml-5">
			              {{ Spatie\Permission\Models\Permission::count() }}
			            </span>
			          </div>
			          <!-- /.info-box-content -->
			        </div>
			        <!-- /.info-box -->
			      </div>
			      <div class="col-12 col-sm-6 col-md-4">
			        <div class="info-box elevation-2 blue">
			          <span class="info-box-icon blue darken-4 elevation-3"><i class=" text-white fas fa-sign-in-alt"></i></span>
			          <div class="info-box-content">
			            <span class="info-box-text text-white ml-5" style="font-size: 18px;">Inicios de sesión</span>
			            <span class="info-box-number text-white ml-5">
			              {{ App\Models\Login::count() }}
			            </span>
			          </div>
			          <!-- /.info-box-content -->
			        </div>
			        <!-- /.info-box -->
			      </div>
		 		</div>	
		 		 @endhasrole
                @endif
                <div class="row">
                  <div class="col-12 col-sm-6 col-md-4">
			        <div class="info-box elevation-2 blue">
			          <span class="info-box-icon blue darken-4 elevation-3"><i class=" text-white fas fa-store"></i></span>

			          <div class="info-box-content">
			            <span class="info-box-text text-white ml-5" style="font-size: 18px;">Rutas</span>
			            <span class="info-box-number text-white ml-5">
			              {{ App\Models\Producto::count() }}
			            </span>
			          </div>
			          <!-- /.info-box-content -->
			        </div>
			        <!-- /.info-box -->
			      </div>
			      <div class="col-12 col-sm-6 col-md-4">
			        <div class="info-box elevation-2 blue">
			          <span class="info-box-icon blue darken-4 elevation-3"><i class=" text-white fas fa-store"></i></span>

			          <div class="info-box-content">
			            <span class="info-box-text text-white ml-5" style="font-size: 18px;">Rutas adquiridas</span>
			            <span class="info-box-number text-white ml-5">
			              {{ auth()->user()->cart->details->count() }}
			            </span>
			          </div>
			          <!-- /.info-box-content -->
			        </div>
			        <!-- /.info-box -->
			      </div>
			      <div class="col-12 col-sm-6 col-md-4">
			        <div class="info-box elevation-2 blue">
			          <span class="info-box-icon blue darken-4 elevation-3"><i class=" text-white material-icons">attach_money</i></span>

			          <div class="info-box-content">
			            <span class="info-box-text text-white ml-5" style="font-size: 18px;">Rutas canceladas</span>
			            <span class="info-box-number text-white ml-5">
			              {{ auth()->user()->payments->count() }}
			            </span>
			          </div>
			          <!-- /.info-box-content -->
			        </div>
			        <!-- /.info-box -->
			      </div>
                </div>
		 	  </div>
		  </div>
		</div>
	</div>
</div>

@endsection
