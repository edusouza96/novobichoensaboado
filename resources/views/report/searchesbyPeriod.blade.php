@extends('layout.page') 
@section('title') Relatório - Buscar por Período @endsection
 
@section('content') 
    <div id="report" class="container">
        <div class="filter">
            <form method="GET">
                <div class="card">
                    <div class="card-header filter-header">Filtrar</div>
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start">Periodo Inicial</label>
                                    <input type="date" name="start" id="start" class="form-control" value="{{ request()->input('start')}}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end">Periodo Final</label>
                                    <input type="date" name="end" id="end" class="form-control" value="{{ request()->input('end')}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer filter-footer">
                        <a href="{{route('report.searchesbyPeriod')}}" class="btn btn-secondary">
                            <i class="fa fa-eraser"></i> Limpar
                        </a>

                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <br><br>
        @if($report->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-primary">
                        <tr>
                            <th scope="col">Data/Hora</th>
                            <th scope="col">Nome Pet</th>
                            <th scope="col">Proprietario</th>
                            <th scope="col">Bairro</th>
                            <th scope="col">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($report as $data)
                            <tr>
                                <td>{{ $data->getDateHour()->format('d/m/Y H:i') }}</td>
                                <td>{{ $data->getClient()->getName() }}</td>
                                <td>{{ $data->getClient()->getOwnerName() }}</td>
                                <td>{{ $data->getClient()->getNeighborhood()->getName() }}</td>
                                <td>R$ {{ number_format($data->getDeliveryFee(), 2, ',', '.') }}</td>
                               
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="thead-dark">
                        <tr>
                            <th colspan="3"></th>
                            <th>Total das buscas</th>
                            <th>R$ {{ number_format($sumDeliveryFee, 2, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>

                <div class="text-right mt-4 mr-5"><strong>Total de registros: {{$report->total()}}</strong></div>

                <div class="text-right mt-4 mr-5">
                    <form method="GET" action="{{route('report.searchesbyPeriodExcel')}}">
                        <input type="hidden" name="start" value="{{ request()->input('start')}}">
                        <input type="hidden" name="end" value="{{ request()->input('end')}}">
        
                        <button class="btn btn-success" type="submit">
                            <i class="fas fa-file-excel"></i> Gerar Planilha
                        </button>
                    </form>  
                </div>

                <div>{{$report->appends(request()->query())->links()}}</div>
            </div>
        @else
            <div class="alert alert-info text-center" role="alert">
                <h6>Nenhum resultado encontrado.</h6>
            </div>
        @endif
    </div>
@endsection

@push('js-end')
    <script>
        new Vue({
            el: '#report',
        });
    </script>
@endpush