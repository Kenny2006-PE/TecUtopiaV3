<header>
    <div class="logo">
        Tec Utopia Import <br>
        <span class="span1">
            Importador de productos tecnológicos para celulares, cómputo y más!
        </span>
    </div>
    <div class="bars">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
    <nav class="nav-bar">
        <ul>
            <li><a href="{{ route('catalogo.index') }}"><i class="fa-solid fa-house"></i> Inicio</a></li>
            <li><a href="{{ route('catalogo.index', ['category' => 'celulares']) }}"><i class="fa-solid fa-mobile-screen-button"></i> Celulares</a></li>
            <li><a href="{{ route('catalogo.index', ['category' => 'computacion']) }}"><i class="fa-solid fa-computer"></i> Computación</a></li>
            <li><a href="{{ route('catalogo.index', ['category' => 'hogar']) }}"><i class="fa-solid fa-house-chimney-user"></i> Hogar</a></li>
            <li><a href="{{ route('catalogo.index', ['category' => 'novedades']) }}" target="_blank"><i class="fa-solid fa-lightbulb"></i> Novedades</a></li>
        </ul>
    </nav>
    <div class="user-menu">
    <div class="dropdown">
        <button onclick="toggleDropdown('userDropdown')" class="dropbtn">
            <i class="fa-solid fa-user"></i> {{ Auth::user()->nombres }}
        </button>
        <div id="userDropdown" class="dropdown-content">
            <a href="{{ route('cliente.index') }}">Cuenta</a>
            <a href="{{ route('cliente.pedido') }}">Pedidos</a>
            <a href="{{ route('cliente.factura') }}">Facturas</a>
            @if(Auth::user()->cliente)
                <a>Crédito: {{ Auth::user()->cliente->credito }}</a>
            @endif
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>
    <div class="cart">
        <button onclick="toggleSidebar()" class="dropbtn">
            <i class="fa-solid fa-shopping-cart"></i>
            <span class="cart-count">{{ count(session('carrito', [])) }}</span>
        </button>
    </div>
</header>
<div id="cartSidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="toggleSidebar()">&times;</a>
    <h2>Carrito de Compras</h2>
    @if(count(session('carrito', [])) > 0)
        @foreach(session('carrito') as $item)
        <div class="cart-item" style="cursor: pointer;" onclick="window.location='{{ route('catalogo.producto', $item['idProducto']) }}'">
                <img src="{{ $item['imagen'] }}" alt="{{ $item['nombre'] }}" class="cart-item-image">
                <p>{{ $item['nombre'] }} - {{ $item['cantidad'] }} x S/.{{ $item['precio'] }}</p>
            </div>
        @endforeach
        <a href="{{ route('carrito.index') }}" class="btn btn-primary mt-2">Ver Carrito</a>
    @else
        <p>No hay productos en el carrito</p>
    @endif
</div>


<script>
    function toggleDropdown(dropdownId) {
        document.getElementById(dropdownId).classList.toggle("show");
    }

    window.onclick = function(event) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (!event.target.matches('.dropbtn') && openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }

        var sidebar = document.getElementById("cartSidebar");
        if (!event.target.matches('.dropbtn') && !event.target.closest('#cartSidebar') && sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
        }
    }

    function toggleSidebar() {
        document.getElementById("cartSidebar").classList.toggle("active");
    }
</script>