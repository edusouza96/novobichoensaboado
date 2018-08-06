<html>
    <head>
        <title> @yield('title') </title>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="icon" type="image/png" href="{{ asset('img/logo.jpg') }}" />
        <link rel="stylesheet" href="{{ asset('css/materialize.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @stack('css-begin')
        @stack('js-begin')
    </head>
    <body>
         <nav style="background:#007fbf;">
            <div class="nav-wrapper">
                <a href="#!" class="brand-logo">Bicho Ensaboado</a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="{{route('diary.index')}}">Agenda</a></li>

                    <li><a href="{{route('logout')}}"><i class="material-icons" title="Sair">exit_to_app</i></a></li>
                </ul>
                <ul class="side-nav" id="mobile-demo">
                    <li><a href="{{route('diary.index')}}">Agenda</a></li>

                    <li><a href="{{route('logout')}}">Sair</a></li>
                </ul>
            </div>
        </nav>
