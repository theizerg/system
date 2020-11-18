@extends('layouts.admin')

@section('title', 'Logins')
@section('page_title', 'Logins')
@section('page_subtitle', 'Registros')

@section('breadcrumb')
    @parent
    <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="{{ url('user') }}">usuarios</a></li>
    <li><a href="{{ url('login') }}">logins</a></li>
    <li class="active">Registros</li>
@endsection

@section('content')

          <div class="container">
            <div class="row">
            <div class="col-md-6">
                <div class="btn-group">
               
                <a href="{{ url('user/create') }}" class="btn btn btn-primary"><i class="fa fa-plus-square"></i> Ingresar</a>
                
                
                </div>
            </div>
            </div>
        <br>
        <div class="card card-primary card-outline">
                <div class=" card-header">
                <h3 class="card-title">Listado de inicio de sesión</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                    <th>Usuario</th>
                    <th>Inicio</th>
                    <th>Cierre</th>
                    <th>IP</th>
                    <th>Cliente</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach ($logins as $login)
                <tr>
                  <td>{{ $login->user->full_name }}</td>
                  <td>{{ $login->login_at  }}</td>
                  <td>{{ $login->logout_at }}</td>
                  <td>{{ $login->ip_address }}</td>
                  <td>{{ $login->user_agent }}</td>
                </tr>
                @endforeach
                    </tbody>                
                </table>
                </div>
                <!-- /.card-body -->
            </div>
        
        </div>


@endsection

@push('scripts')
  <script src="{{ asset('js/admin/login/index.js') }}"></script>
@endpush
 