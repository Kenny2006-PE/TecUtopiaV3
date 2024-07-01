<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Registration Form')</title>
    @vite(['resources/css/auth.css', 'resources/js/app.js','resources/sass/app.scss'])
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @yield('styles')

</head>
<body>
    @include('partials.header-auth')
    
    <div class="container mt-3">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>
