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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="neighborhood_id">Bairro</label>
                                    <select name="neighborhood_id" class="form-control" v-model="neighborhood_id">
                                        <option value="">Selecione</option>
                                        <option v-for="neighborhood in neighborhoods" :value="neighborhood.id">@{{neighborhood.name}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group">
                                    <label for="store_id">Loja</label>
                                    <select name="store_id" id="store_id" class="form-control" v-model="store_id">
                                        <option value>Selecione</option>
                                        <option v-for="store in stores" :value="store.id" :key="store.id">@{{ store.name }}</option>
                                    </select>
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
                            <th scope="col">Loja</th>
                            <th scope="col">Forma de Pagamento</th>
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
                                <td>{{ $data->getStore()->getName() }}</td>
                                <td>
                                    {{ 
                                        $data->getSales()->isEmpty() 
                                            ? ''
                                            : (
                                                $data->getSales()->first()->getSalePaymentMethod()->first()
                                                    ? $data->getSales()->first()->getSalePaymentMethod()->first()->getDescription()
                                                    : ''
                                            )
                                    }}

                                </td>
                                <td>R$ {{ number_format($data->getDeliveryFee(), 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="thead-dark">
                        <tr>
                            <th colspan="5"></th>
                            <th>Total das buscas</th>
                            <th>R$ {{ number_format($sumDeliveryFee, 2, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>

                <div class="text-right mt-4 mr-5"><strong>Total de registros: {{$report->total()}}</strong></div>

                <div class="container">
                    <div class="mt-4 row justify-content-end">
                        <div class="col-2 text-right">
                            <a href="{{route('report.searchesbyPeriodExcel', request()->input())}}" class="btn btn-success" type="submit">
                                <i class="fas fa-file-excel"></i> Gerar Planilha
                            </a>
                        </div>
                        
                        <div class="col-2 text-right">
                            <modal-chart-pie title="Buscas por periodo" route="report.searchesbyPeriodChart" :param="param"></modal-chart-pie>
                            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal-chart-pie">
                                <i class="fas fa-chart-pie"></i> Gerar Gráfico
                            </button>
                        </div>
                    </div>
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
            data:{
                param: @json(request()->input()),
                neighborhoods:[],
                neighborhood_id: "{{ request()->input('neighborhood_id') }}",
                stores:[],
                store_id: "{{ request()->input('store_id') }}",
            },
            methods:{
                getNeighborhoods(){
                    return $.get(laroute.route('neighborhood.allOptions'))
                        .done(function(data){
                            this.neighborhoods = data;
                        }.bind(this));  
                },
                getStores(){
                    $.get(laroute.route("store.allOptions"))
                    .done(function(data) {
                        this.stores = data;
                    }.bind(this));
                },
            },
            created(){
                this.getNeighborhoods();
                this.getStores();
            }
        });
    </script>
@endpush
