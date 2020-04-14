@extends('layout.page') 
@section('title') Relatório - Vendas por Período @endsection
 
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
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="product_name">Nome Produto</label>
                                    <input type="text" name="product_name" id="product_name" class="form-control" value="{{ request()->input('product_name')}}">
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
                        <a href="{{route('report.salesByPeriod')}}" class="btn btn-secondary">
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
                            <th scope="col">Data</th>
                            <th scope="col">N° da nota</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Valor total</th>
                            <th scope="col">Loja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($report as $data)
                            <tr>
                                <td>{{ $data->getCreatedAt()->format('d/m/Y') }}</td>
                                <td>{{ $data->getNumerInvoice() }}</td>
                                <td>{!! $data->getDescription() !!}</td>
                                <td>R$ {{ number_format($data->getTotal(), 2, ',', '.') }}</td>
                                <td>{{ $data->store->getName() }}</td>
                               
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="thead-dark">
                        <tr>
                            <th colspan="3"></th>
                            <th>Total das Vendas</th>
                            <th>R$ {{ number_format($sum, 2, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>

                <div class="text-right mt-4 mr-5"><strong>Total de registros: {{$report->total()}}</strong></div>

                <div class="container">
                    <div class="mt-4 row justify-content-end">
                        <div class="col-2 text-right">
                            <a href="{{route('report.salesByPeriodExcel', request()->input())}}" class="btn btn-success" type="submit">
                                <i class="fas fa-file-excel"></i> Gerar Planilha
                            </a>
                        </div>
                        
                        <div class="col-2 text-right">
                            <modal-chart-bar title="Vendas por periodo" route="report.salesByPeriodChart" :param="param" :label="label"></modal-chart-bar>
                            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal-chart-bar">
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
                label: ['Vendas no Periodo R$'],
                param: @json(request()->input()),
                stores:[],
                store_id: "{{ request()->input('store_id') }}",
            },
            methods:{
                getStores(){
                    $.get(laroute.route("store.allOptions"))
                    .done(function(data) {
                        this.stores = data;
                    }.bind(this));
                },
            },
            created(){
                this.getStores();
            }
        });
    </script>
@endpush
