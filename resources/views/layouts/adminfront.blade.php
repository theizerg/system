<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ env('APP_NAME') }} - @yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    @stack('styles')
  </head>

  <body class="hold-transition login-page" id="login">
    <!--Page Content Here --><br>
    @yield('content')

    <!-- REQUIRED JS SCRIPTS -->
    <script src="{{ asset('js/inicio.js') }}"></script>
    @stack('scripts')

      <style>
    
    #login{

        background-image: url("{{asset('/images/fondo/fondo_pagina.png') }}");    
        background-repeat: repeat;
        background-position: 30px;
            
    }
    
    </style>
  </body>
</html>
