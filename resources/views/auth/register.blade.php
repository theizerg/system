@extends('layouts.adminfront')
@section('title', 'Registrarse  ')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <div class="card">
                <div class="h5 mt-2 mb-2 text-center">
                    Ingrese los datos para el registro
                </div>
                <div class="card-body">
                    <div class="text-center">
                      <img src="{{ asset('images/logo/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                      style="opacity: .8" width="50">
                     </div><br>
                       <form id="main-form" class=""><br>
                          <input type="hidden" id="_url" value="{{ url('register') }}">
                          <input type="hidden" id="_redirect" value="{{ url('/') }}">
                          <input type="hidden" id="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-4">
                                        <div class="form-group">
                                            <input id="name" type="text" class="form-control" name="name" placeholder="Nombres" value="{{ old('name') }}"   autofocus>

                                    @if ($errors->has('name'))
                                    <span class="text-red">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                            
                                        </div>
                                     </div>
                                     <div class="col-lg-4 col-sm-4">
                                        <div class="form-group">
                                            <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Apellidos"   autofocus>

                                    @if ($errors->has('last_name'))
                                    <span class="text-red">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                            
                                        </div>
                                     </div>
                                     <div class="col-lg-4 col-sm-4">
                                        <div class="form-group">
                                            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Usuario"   autofocus>

                                    @if ($errors->has('username'))
                                    <span class="text-red">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                            
                                        </div>
                                     </div>
                                     <div class="col-lg-4 col-sm-4">
                                        <div class="form-group">
                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Correo electrónico"   autofocus>

                                    @if ($errors->has('email'))
                                    <span class="text-red">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                            
                                        </div>
                                     </div>
                                     <div class="col-lg-4 col-sm-4">
                                        <div class="form-group">
                                            <input id="telefono" type="number" class="form-control" name="telefono" value="{{ old('telefono') }}" placeholder="Teléfono"   autofocus>

                                    @if ($errors->has('telefono'))
                                    <span class="text-red">
                                        <strong>{{ $errors->first('telefono') }}</strong>
                                    </span>
                                    @endif
                                            
                                        </div>
                                     </div>
                                     <div class="col-lg-4 col-sm-4">
                                        <div class="form-group">
                                            <input id="direccion" type="text" class="form-control" name="direccion" value="{{ old('direccion') }}" placeholder="Dirección"   autofocus>

                                    @if ($errors->has('direccion'))
                                    <span class="text-red">
                                        <strong>{{ $errors->first('direccion') }}</strong>
                                    </span>
                                    @endif
                                            
                                        </div>
                                     </div>
                                      <div class="col-lg-4 col-sm-4">
                                        <div class="form-group">
                                            <input id="fecha_nacimiento" type="date" class="form-control" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" placeholder="Dirección"   autofocus>

                                    @if ($errors->has('fecha_nacimiento'))
                                    <span class="text-red">
                                        <strong>{{ $errors->first('fecha_nacimiento') }}</strong>
                                    </span>
                                    @endif
                                            
                                        </div>
                                     </div>
                                     <div class="col-lg-4 col-sm-4">
                                        <div class="form-group">
                                           <select class="form-control" name="nacionalidad_id" required="true">
                                         <option value="" disabled selected hidden>Nacionalidad</option>
                                            @foreach( $nacionalidades as $f)
                                              <option value="{{ $f->id}}">{{ $f->nb_nacionalidad }}</option>
                                        @endforeach
                                     </select>
                                    

                                        @if ($errors->has('nacionalidad_id'))
                                        <span class="text-red">
                                            <strong>{{ $errors->first('nacionalidad_id') }}</strong>
                                        </span>
                                        @endif
            
                                        </div>
                                     </div>
                                     <div class="col-lg-4 col-sm-4">
                                        <div class="form-group">
                                           <select class="form-control" name="genero_id" required="true">
                                         <option value="" disabled selected hidden>Género</option>
                                            @foreach( $generos as $f)
                                              <option value="{{ $f->id}}">{{ $f->nb_genero}}</option>
                                        @endforeach
                                     </select>
                                    

                                        @if ($errors->has('genero_id'))
                                        <span class="text-red">
                                            <strong>{{ $errors->first('genero_id') }}</strong>
                                        </span>
                                        @endif
            
                                        </div>
                                     </div>
                                     
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Contraseña"   autofocus>

                                    @if ($errors->has('password'))
                                    <span class="text-red">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                            
                                        </div>
                                     </div>
                                     <div class="col-lg-6 col-sm-6">
                                        <div class="form-group">
                                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Confirmación de contraseña"   autofocus>

                                    @if ($errors->has('password_confirmation'))
                                    <span class="text-red">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                                
                                    </div>
                                 </div>
                              </div>
                               <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary form-control" id="boton">
                                        <i class="fas fa-sign-in-alt text-white" id="ajax-icon"></i> <span class="text-white ml-3">{{ __('Iniciar Sesión') }}</span>
                                    </button>                           
                                </div>   
                                <div class="col-12 text-center">
                                    <a href="{{ url('/register ')}}" class="btn btn-link px-0 mt-1">
                                        Regístrate
                                    </a>
                                </div>
                            </div>
                           </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/admin/register/create.js') }}"></script>
@endpush