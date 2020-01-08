<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.jpg') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <script src="{{ asset('js/laroute.js') }}"></script>
    @stack('css-begin') @stack('js-begin')
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-primary fixed-top">
        <a class="navbar-brand font-weight-bolder" href="#">{{ env('APP_NAME') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault" aria-controls="navbarsDefault"
            aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        <div class="collapse navbar-collapse" id="navbarsDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('diary.index') }}">Agenda</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pdv.index') }}">PDV</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sales.ofDay') }}">Vendas do dia</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
               
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('outlay.index') }}">Despesas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('neighborhood.index') }}">Bairros</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Sair</a>
                </li>

            </ul>

        </div>
    </nav>