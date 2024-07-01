@if(Auth::check())
    @include('partials.header-cliente')
@else
    @include('partials.header-invitado')
@endif
