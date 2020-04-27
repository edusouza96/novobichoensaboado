@extends('layout.page') 
@section('title') Relatório - Despesas por Período @endsection
 
@section('content') 
    <div id="report" class="container">
        <div class="filter">
            <form method="GET">
                <div class="card">
                    <div class="card-header filter-header">Filtrar</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="store_id">Loja</label>
                                    <select name="store_id" id="store_id" class="form-control" v-model="store_id">
                                        <option value>Selecione</option>
                                        <option v-for="store in stores" :value="store.id" :key="store.id">@{{ store.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="source_id">Fonte</label>
                                    <select name="source_id" id="source_id" class="form-control" v-model="source">
                                        <option value>Selecione</option>
                                        <option v-for="source in sources" :value="source.id" :key="source.id">@{{ source.display }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="cost_center_id">Centro de Custo</label>
                                    <select name="cost_center_id" id="cost_center_id" class="form-control" v-model="cost_center">
                                        <option value>Selecione</option>
                                        <option v-for="cost in costCenters" :value="cost.id" :key="cost.id">@{{ cost.name }}</option>
                                    </select>
                                </div>
                            </div>
                           
                        </div>
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
                        <a href="{{route('report.outlayByPeriod')}}" class="btn btn-secondary">
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
                            <th scope="col">Data Pagamento</th>
                            <th scope="col">Loja</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Fonte</th>
                            <th scope="col">Centro de Custo</th>
                            <th scope="col">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($report as $data)
                            <tr>
                                <td>{{ $data->getDatePay()->format('d/m/Y') }}</td>
                                <td>{{ $data->getStore()->getName() }}</td>
                                <td>{{ $data->getDescription() }}</td>
                                <td>{{ $data->getSource()->getDisplay() }}</td>
                                <td>{{ $data->getCostCenter()->getName() }}</td>
                                <td>R$ {{ number_format($data->getValue(), 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="thead-dark">
                        <tr>
                            <th colspan="4"></th>
                            <th>Total das buscas</th>
                            <th>R$ {{ number_format($sum, 2, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>

                <div class="text-right mt-4 mr-5"><strong>Total de registros: {{$report->total()}}</strong></div>

                <div class="container">
                    <div class="mt-4 row justify-content-end">
                        <div class="col-2 text-right">
                            <a href="{{route('report.outlayByPeriodExcel', request()->input())}}" class="btn btn-success" type="submit">
                                <i class="fas fa-file-excel"></i> Gerar Planilha
                            </a>
                        </div>
                        
                        <div class="col-2 text-right">
                            <modal-chart-bar title="Despesas por periodo" route="report.outlayByPeriodChart" :param="param" :label="label"></modal-chart-bar>
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
                label: ['Custo no Periodo R$'],
                param: @json(request()->input()),
                sources: [],
                costCenters: [],
                source: "{{ request()->input('source_id') }}",
                cost_center: "{{ request()->input('cost_center_id') }}",
                stores:[],
                store_id: "{{ request()->input('store_id') }}",
            },
            methods:{
                getSources(){
                    if(this.store_id){
                        $.get(laroute.route("treasure.findByStore", { id: this.store_id }))
                        .done(function(data) {
                            this.sources = data;
                        }.bind(this));
                    }
                },
                getCostCenters(){
                    $.get(laroute.route("costCenter.allOptions"))
                    .done(function(data) {
                        this.costCenters = data;
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
                this.getStores();
                this.getCostCenters();
                this.getSources();
            },
            watch: {
                store_id(){
                    this.getSources();
                }
            }
        });
    </script>
@endpush
