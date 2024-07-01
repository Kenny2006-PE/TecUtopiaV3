<!-- resources/views/partials/navbar.blade.php -->
<div class="sidebar" id="sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="toggleSidebar()">x</a>
    <a href="{{ route('admin.index') }}">
        <i class="fas fa-tachometer-alt"></i> Admin Panel
    </a>
    <a href="{{ route('categorias.index') }}">
        <i class="fas fa-list"></i> Categorías
    </a>
    <a href="{{ route('especificaciones.index') }}">
        <i class="fas fa-cogs"></i> Especificaciones
    </a>
    <a href="{{ route('productos.index') }}">
        <i class="fas fa-box"></i> Productos
    </a>
    <a href="{{ route('admin.usuarios') }}">
        <i class="fas fa-users"></i> Usuarios
    </a>
    <a href="{{ route('admin.pedidos') }}">
        <i class="fas fa-clipboard-list"></i> Pedidos
    </a>
    @auth
    <div class="dropdown">
        <a href="#" class="dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user"></i> {{ Auth::user()->nombres }}
        </a>
        <ul class="dropdown-menu" aria-labelledby="userDropdown">
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Cerrar Sesión') }}
                </a>
            </li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
    @endauth
</div>

<div id="main">
    <span class="toggle-btn" onclick="toggleSidebar()">&#9776;</span>
</div>
<script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("collapsed");
        document.getElementById("main").classList.toggle("collapsed");
    }
</script>
