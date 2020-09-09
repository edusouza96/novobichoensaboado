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
                        <a class="nav-link" href="{{ route('dashboard.index') }}">Dashboard</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('diary.index') }}">Agenda</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pdv.index') }}">PDV</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sales.ofDay') }}">Vendas do dia</a>
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
                                <a class="dropdown-item" href="{{ route('employeeSalary.index') }}">Pagamento de Funcionários</a>
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
                            <a class="dropdown-item" href="{{ route('report.financialStatement') }}">Balanço financeiro</a>
                            <a class="dropdown-item" href="{{ route('report.searchesbyPeriod') }}">Buscas por período</a>
                            <a class="dropdown-item" href="{{ route('report.outlayByPeriod') }}">Despesas por periodo</a>
                            <a class="dropdown-item" href="{{ route('report.petsAttendedByNeighborhood') }}">Pets atendidos por bairro</a>
                            <a class="dropdown-item" href="{{ route('report.petsAttendedByBreed') }}">Pets atendidos por raça</a>
                            <a class="dropdown-item" href="{{ route('report.salesByPeriod') }}">Vendas por periodo</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth-definition.selectCurrenteStore') }}">Trocar de loja</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Manuais   <i class="fas fa-caret-down"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ URL::to('manual/acesso.pdf') }}" target="_blank">Como Acessar</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/agenda.pdf') }}" target="_blank">Menu Agenda</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/dashboard.pdf') }}" target="_blank">Menu Dashboard</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/pdv.pdf') }}" target="_blank">Menu PDV</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/vendas_do_dia.pdf') }}" target="_blank">Menu Vendas do dia</a>
                            
                            <a class="dropdown-item" href="{{ URL::to('manual/cadastros/bairro.pdf') }}" target="_blank">Menu Cadastro de bairro</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/cadastros/centro_custo.pdf') }}" target="_blank">Menu Cadastro de centro de custo</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/cadastros/clientes.pdf') }}" target="_blank">Menu Cadastro de clientes</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/cadastros/despesas.pdf') }}" target="_blank">Menu Cadastro de despesas</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/cadastros/lojas.pdf') }}" target="_blank">Menu Cadastro de lojas</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/cadastros/pagamento_funcionarios.pdf') }}" target="_blank">Menu Cadastro de pagamento de funcionarios</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/cadastros/produtos.pdf') }}" target="_blank">Menu Cadastro de produtos</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/cadastros/promocoes.pdf') }}" target="_blank">Menu Cadastro de promoções</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/cadastros/raças.pdf') }}" target="_blank">Menu Cadastro de raças</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/cadastros/serviços.pdf') }}" target="_blank">Menu Cadastro de serviços</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/cadastros/usuarios.pdf') }}" target="_blank">Menu Cadastro de usuarios</a>
                            
                            <a class="dropdown-item" href="{{ URL::to('manual/relatorios/balanço_financeiro.pdf') }}" target="_blank">Menu Relatório de balanço financeiro</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/relatorios/buscas_por_periodo.pdf') }}" target="_blank">Menu Relatório de buscas por periodo</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/relatorios/despesas_por_periodo.pdf') }}" target="_blank">Menu Relatório de despesas por periodo</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/relatorios/vendas_por_periodo.pdf') }}" target="_blank">Menu Relatório de vendas por periodo</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/relatorios/pets_atendidos_por_raça.pdf') }}" target="_blank">Menu Relatório de pets atendidos por raça</a>
                            <a class="dropdown-item" href="{{ URL::to('manual/relatorios/pets_atendidos_por_bairro.pdf') }}" target="_blank">Menu Relatório de pets atendidos por bairro</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.logout') }}">Sair</a>
                    </li>

                </ul>
            </div>
        @endif
    </nav>
