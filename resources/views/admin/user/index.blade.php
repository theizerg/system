    @extends('layouts.admin')

    @section('title', 'Usuarios')
    @section('page_title', 'Usuarios')
    @section('page_subtitle', 'Listado')

    @section('breadcrumb')
        @parent
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="{{ url('user') }}">usuarios</a></li>
        <li class="active">Listado</li>
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
                <h3 class="card-title">Listado de usuario</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                    <th>#</th>
                    <th>Nombre completo</th>
                    <th>Usuario</th>
                    <th>Tipo</th>
                    <th>Correo electrónico</th>
                    <th>Acceso</th>
                    <th>Opciones</th> 
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                    <tr class="row{{ $user->id }}">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->display_name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->hasrole('Administrador') ? 'Administrador' : 'Usuario'  }}</td>
                    <td>{{ $user->email  }}</td>
                    <td><span class="badge {{ $user->status ? 'bg-green' : 'bg-red' }}">{{ $user->display_status }}</span></td>
                    <td>
                       <a class="btn btn-round blue darken-4 elevation-3" href="{{  url('user', [$user->encode_id]) }}"><i class="material-icons" style="color: white;">person</i> </a>
                       <a class="btn btn-round red darken-4 elevation-3" href="{{ url('user', [$user->encode_id, 'edit']) }}"><i class="material-icons" style="color: white;">edit</i> </a>
                         @if(auth()->user()->can('delete_users') && Auth::user()->encode_id != $user->encode_id)
                         {{ Form::open(array('url' => 'user/' . $user->encode_id, 'class' => '')) }}
                         {{ Form::hidden('_method', 'DELETE') }}
                         {{ Form::submit('Borrar', array('class' => 'btn btn-outline-danger btn-sm btn-block' )) }}
 <!--                    {{ Form::button('<i class="fa fa-trash  fa-2x"></i>', ['type' => 'submit', 'class' => ''] )  }}-->
                         {{ Form::close() }} 
                    @endif
                    </td>
                    </tr>
                    @endforeach
                    </tr>
                    </tbody>                
                </table>
                </div>
                <!-- /.card-body -->
            </div>
        
        </div>




    @endsection