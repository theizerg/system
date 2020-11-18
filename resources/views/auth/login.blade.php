@extends('layouts.adminfront')
@section('title', 'Login')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group"><br>
                <div class="card p-4 mt-5">
                    <div class="card-body">
                        <h1>Iniciar Sesión</h1><!-- <p class="text-muted">ADMIN<br>
                            Email : admin@macbrame.com<br> Pass : macbrame</p> -->
                        <p class="text-muted">Ingresa tu cuenta</p>
                         <form id="main-form" class=""><br>
                          <input type="hidden" id="_url" value="{{ url('login') }}">
                          <input type="hidden" id="_redirect" value="{{ url('/') }}">
                          <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="input-group mb-3">
                                <span class="input-group-addon"><i class="fas-user"></i></span>
                                <input type="text" name="username" value="{{ old('username') }}" class="form-control" required
                                       autofocus placeholder="Ingrese el usuario">
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-addon"><i class="fas-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                       required>
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
                </div><br>
                <div class="card text-white bg-primary py-5 mt-5 d-md-down-none" style="width:44%">
                    <div class="card-body text-center">
                        <h2>{{ env('APP_NAME') }}</h2><br>
                        <div>
                            <p>Plantilla desarrollada para el inicio de proyectos a desarrollar en Laravel.</p><br>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                         <small>Copyright &copy; 2020 {{ env('APP_NAME') }}</small> All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/admin/auth/inicio.js') }}"></script>
@endpush