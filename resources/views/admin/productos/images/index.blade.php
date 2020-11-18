@extends('layouts.dashboard')

@section('title', 'Imágenes de productos')

@section('content')


<div class="container-fluid">
    <div class="col-sm-12">
        <a href="{{ url('/admin/products') }}" class="btn btn-redondo red darken-4 mb-3 mt-3"><i class="material-icons mt-1">home</i></a>
        <div class="card">
            <div class="card-header text-center">
                <h4 class="title">Imágenes del producto "{{ $product->nombre }}"</h4>
            </div>
            <div class="card-body">
              <form method="post" action="" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-12">
                       <div class="md-form ml-0 mr-0">
                       <input type="file" name="photo" required><br><br><br>  
                        <input type="hidden" name="producto_id" value="{{ $product->id }}"> 
                <button type="submit" class="btn btn-primary btn-round">Subir nueva imagen</button>
                
                    </div> 
                        
                    </div>
                    <div class="col-sm-6">
                       <div class="md-form ml-0 mr-0">
                         <div class="row">
            @foreach ($images as $image)
                <div class="col-md-12">
                    <div class="card">
                      <div class="card-body">
                        <img src="{{ $image->url }}" width="250">
                        <form method="post" action="">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="image_id" value="{{ $image->id }}"><br><br>
                            <button type="submit" class="btn btn-redondo red darken-2"><i class="material-icons mt-1">delete</i></button>
                            @if ($image->featured)
                                <button type="button" class="btn btn-redondo blue darken-4" rel="tooltip" title="Imagen destacada actualmente">
                                    <i class="material-icons mt-1">favorite</i>
                                </button>
                            @else
                                <a href="{{ url('/admin/products/'.$product->id.'/images/select/'.$image->id) }}" class="btn btn-redondo blue darken-4">
                                    <i class="material-icons mt-1">favorite</i>
                                </a>
                            @endif
                        </form>
                      </div>
                    </div>
                </div>
            @endforeach
            </div>
                    </div> 
                        
                    </div>
                   
                   
                </div> 
            </div>

@endsection
