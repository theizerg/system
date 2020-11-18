@extends('layouts.admin')

@section('title', 'Usuarios')
@section('page_title', 'Usuarios')
@section('page_subtitle', 'Datos')

@section('breadcrumb')
    @parent
    <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="{{ url('user') }}">usuarios</a></li>
    <li class="active">datos</li>
@endsection

@section('content')
<div class="card card-primary card-outline">
  <div class="col-xs-12">
    <div class=" card-primary card-outline card-header">
      <h2 class="card-title">
        <i class="fa fa-user"></i> Datos de usuario
        <small class="pull-right">{{ $user->display_name }}</small>
      </h2>
    </div>
  </div>
  <div class="car-body">
    <div class="row card-body  ">
      <div class="col-sm-2">
        <strong>Nombre</strong><br>
          {{ $user->full_name }}
      </div>
      <div class="col-sm-2">
          <strong>Correo electrónico</strong>
          <br>
          {{ $user->email }}
      </div>
       <div class="col-sm-2">
          <strong>Usuario</strong>
          <br>
          {{ $user->username }}
        </div>
        <div class="col-sm-2">
            <strong>Estatus</strong><br>
            <span class="badge {{ $user->status ? 'bg-green' : 'bg-red' }}">{{ $user->display_status }}</span>
          </div>
          <div class="col-sm-2">
              <strong>Tipo de usuario</strong><br>
              {{ Auth::user()->hasrole('Administrador') ? 'Administrador' : 'Usuario' }}
          </div>
      </div>
      <div class="row card-body  ">
        <div class="col-sm-3">
           <strong>Contraseña</strong><br>
              ********
            </div>
            <div class="col-sm-3">
              <strong>Creado</strong>
              <br>
                {{ $user->created_at }}
              </div>
              <div class="col-sm-3">
                <strong>Actualizado</strong><br>
                {{ $user->updated_at }}
              </div>
              <div class="col-sm-3">
                <strong>Logins</strong><br>
                <i class="fa fa-eye"></i> <a href="{{ url('logins', [$user->encode_id]) }}">logins</a>
              </div>
            </div>
            <div class="row card-body  ">
            <div class="col-sm-9">
                <strong>Permisos de usuario</strong><br>
                @foreach($user->getAllPermissions() as $permission)
                <span class="badge">{{  trans('permission.'.$permission->name) }}</span>&nbsp;&nbsp;
                @endforeach
              </div>
            </div>
            <br>
            <br>
            <div class="card-footer">
              <div class="col-md-6">
                <div class="btn-group">
                  @can('edit_users')
                  <a href="{{ url('user', [$user->encode_id, 'edit']) }}" class="btn btn-primary"><i class="fa fa-edit"></i> Editar</a>
                  @endcan
                </div>
              </div>
            </div>
    </div>
  </div>

@endsection
