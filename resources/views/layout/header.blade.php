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

        @if(auth()->check())
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

                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Cadastros   <i class="fas fa-caret-down"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('neighborhood.index') }}">Bairros</a>
                            @if(auth()->user()->canSeeAdministrativePage())
                                <a class="dropdown-item" href="{{ route('costCenter.index') }}">Centro de Custo</a>
                            @endif
                            <a class="dropdown-item" href="{{ route('owner.index') }}">Clientes</a>
                            <a class="dropdown-item" href="{{ route('outlay.index') }}">Despesas</a>
                            @if(auth()->user()->canSeeAdministrativePage())
                                <a class="dropdown-item" href="{{ route('store.index') }}">Lojas</a>
                            @endif
                            <a class="dropdown-item" href="{{ route('product.index') }}">Produtos</a>
                            <a class="dropdown-item" href="{{ route('rebate.index') }}">Promoções</a>
                            <a class="dropdown-item" href="{{ route('breed.index') }}">Raças</a>
                            <a class="dropdown-item" href="{{ route('service.index') }}">Serviços</a>
                            @if(auth()->user()->canSeeAdministrativePage())
                                <a class="dropdown-item" href="{{ route('user.index') }}">Usuarios</a>
                            @endif
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Relatórios   <i class="fas fa-caret-down"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('report.searchesbyPeriod') }}">Buscas por período</a>
                            <a class="dropdown-item" href="{{ route('report.outlayByPeriod') }}">Despesas por periodo</a>
                            <a class="dropdown-item" href="{{ route('report.petsAttendedByNeighborhood') }}">Pets atendidos por período</a>
                            <a class="dropdown-item" href="{{ route('report.petsAttendedByBreed') }}">Pets atendidos por raça</a>
                            <a class="dropdown-item" href="{{ route('report.salesByPeriod') }}">Vendas por periodo</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.logout') }}">Sair</a>
                    </li>

                </ul>
            </div>
        @endif
    </nav>
