<header>
    <div class="logo" style="color:azure;text-shadow: 0px 0px 9px #508AD3; font-size: 20px">
        Tec Utopia Import <br>
        <span class="span1" style="font-size:8px">
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
            <li><a href="{{ route('catalogo.index') }}" style="color:azure;text-shadow: 0px 0px 9px #65ec59; font-weight:bold"><i class="fa-solid fa-house" style="color: #f6f7f9;"></i> Inicio</a></li>
            <li><a href="{{ route('catalogo.index', ['category' => 'celulares']) }}" style="color:azure;text-shadow: 0px 0px 9px #65ec59; font-weight:bold"><i class="fa-solid fa-mobile-screen-button"></i> Celulares</a></li>
            <li><a href="{{ route('catalogo.index', ['category' => 'computacion']) }}" style="color:azure;text-shadow: 0px 0px 9px #65ec59; font-weight:bold"><i class="fa-solid fa-computer"></i> Computación</a></li>
            <li><a href="{{ route('catalogo.index', ['category' => 'hogar']) }}" style="color:azure;text-shadow: 0px 0px 9px #65ec59; font-weight:bold"><i class="fa-solid fa-house-chimney-user"></i> Hogar</a></li>
            <li><a href="{{ route('catalogo.index', ['category' => 'novedades']) }}" target="_blank" style="color:azure;text-shadow: 0px 0px 9px #65ec59; font-weight:bold"><i class="fa-solid fa-lightbulb"></i> Novedades</a></li>
            @guest
                @if (Route::has('login'))
                    <li><a href="{{ route('login') }}" style="color:azure;text-shadow: 0px 0px 9px #65ec59; font-weight:bold"><i class="fa-solid fa-user" style="color: #f6f7f9;"></i> Acceder</a></li>
                @endif
                @if (Route::has('register'))
                    <li><a href="{{ route('register') }}" style="color:azure;text-shadow: 0px 0px 9px #65ec59; font-weight:bold"><i class="fa-solid fa-cart-shopping" style="color: #e5e7eb;"></i> ¡Comprar!</a></li>
                @endif
            @endguest
        </ul>
    </nav>
</header>
