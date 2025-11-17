<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mercado Libre')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    @stack('styles')
    <style>
        body {
            background-color: #292929;
            color: #ebe4e4;
        }
    </style>
    @livewireStyles
</head>
<body class="">
    @include('components.navbar')

    <main class="container mx-auto py-4">
        @yield('content')
        @isset($slot)
            {{ $slot }}
        @endisset
    </main>

    @include('components.footer')

    @livewireScripts
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
    @stack('scripts')
    {{-- livewireScriptConfig --}}
</body>
</html>
