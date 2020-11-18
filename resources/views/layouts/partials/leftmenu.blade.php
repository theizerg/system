   <!-- Brand Logo -->
    <a href="i{{ ('/') }}" class="brand-link">
      <img src="{{ asset('images/logo/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>
     <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('images/user/user1-128x128.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info ml-2">
          <a href="{{ url('/') }}" class="d-block text-center">{{ auth()->user()->full_name }}</a>
          <small class="text-center text-white ml-5">
            {{ Auth::user()->hasrole('Administrador') ? 'Administrador' : 'Usuario' }}
          </small><br>
          <small class="text-center text-white">
            Miembro desde el año {{ Auth::user()->created_at->format('Y') }}</small>
        </div>
      </div>

    <!-- Sidebar Menu -->
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
    
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
        <li class="nav-header">OPCIONES</li><br>
        @if (Auth::guest())
         @else
         @hasrole('Administrador')
        <li class="nav-item has-treeview menu-open">
        <a href="#" class="nav-link active">
          <i class="nav-icon fas fa-cogs"></i>
          <p>
            Administración
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        
         
          <ul class="nav nav-treeview">
          <li class="nav-item">
          <a href="{{url('user')}}" class="nav-link">
              <i class="far fa-user nav-icon"></i>
              <p>Usuarios</p>
            </a>
          </li>   
          <li class="nav-item">
            <a href="{{url('permission')}}" class="nav-link">
              <i class="far fa-file-archive nav-icon"></i>
              <p>Permisos</p>
            </a>
          </li>
           <li class="nav-item">
            <a href="{{url('logins')}}" class="nav-link">
              <i class="material-icons nav-icon">attach_file</i>
              <p>Logins</p>
            </a>
          </li>
         
          
        </ul>
      </li>
    @endhasrole
    @endif
    <li class="nav-item has-treeview menu-open">
      <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-store"></i>
          <p>
            Productos
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>

      <ul class="nav nav-treeview">
        <li class="nav-item">
           @can('add_users')
          <a href="/productos/nuevo" class="nav-link">
            <i class="far fa-plus-square nav-icon"></i>
            <p>Agregar ruta</p>
          </a>
          @endcan
        </li>
         <li class="nav-item">
           @can('add_users')
          <a href="/productos" class="nav-link">
            <i class="fas fa-clipboard-list nav-icon"></i>
            <p>Vista general</p>
          </a>
          @endcan
        </li>
         <li class="nav-item">
          <a href="/productos/detalles" class="nav-link">
            <i class="fas fa-clipboard-list nav-icon"></i>
            <p>Vista detallada</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/pedidos" class="nav-link">
            <i class="fas fa-clipboard-list nav-icon"></i>
            <p>Compra detallada</p>
          </a>
        </li>
       </ul>
      </li>
    </ul>
  </nav>
</div>
