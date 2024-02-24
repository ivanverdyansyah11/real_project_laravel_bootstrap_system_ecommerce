<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} | Adigoeroe Ecommerce</title>
    
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.css') }}">
</head>
<body>
    @if (Route::is('login') || Route::is('register'))
        <div class="container-fluid content-auth">
            <div class="row justify-content-center align-items-center" style="height: 100vh !important; min-height: fit-content !important;">
                @yield('content-auth')
            </div>
        </div>
    @else
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-xl-2">
                    @include('components.sidebar')
                </div>
                <div class="col-12 col-lg-9 col-xl-10 pb-5">
                    @include('components.topbar')
                    @yield('content-dashboard')
                </div>
            </div>
        </div>
    @endif

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    @stack('js')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>