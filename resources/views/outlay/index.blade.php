@extends('layout.page') 
@section('title') Despesas @endsection
 
@section('content') 
    <div id="outlays" class="container">
        <modal-pay-outlay :id="id" :key="id"></modal-pay-outlay>
        <div class="text-right mb-3">
            <a href="{{route('outlay.create')}}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Cadastrar
            </a>
        </div>

        <div class="filter">
            <form method="GET">
                <div class="card">
                    <div class="card-header filter-header">Filtrar</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <div class="form-group">
                                    <label for="description">Descrição</label>
                                    <input type="text" name="description" class="form-control" value="{{ request()->input('description')}}">
                                </div>
                            </div>
                        </div>
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
                                    <label for="source">Fonte</label>
                                    <select name="source" id="source" class="form-control" v-model="source">
                                        <option value>Selecione</option>
                                        <option v-for="source in sources" :value="source.id" :key="source.id">@{{ source.display }}</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-7">
                                <div class="form-group">
                                    <label for="cost_center">Centro de Custo</label>
                                    <select name="cost_center" id="cost_center" class="form-control" v-model="cost_center">
                                        <option value>Selecione</option>
                                        <option v-for="cost in costCenters" :value="cost.id" :key="cost.id">@{{ cost.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer filter-footer">
                        <a href="{{route('outlay.index')}}" class="btn btn-secondary">
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
        @if($outlays->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-primary">
                        <tr>
                            <th scope="col">Descrição</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Data Pagamento</th>
                            <th scope="col">Fonte</th>
                            <th scope="col">Centro de Custo</th>
                            <th scope="col">Loja</th>
                            <th scope="col" colspan="3" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($outlays as $outlay)
                            <tr>
                                <td>{{ $outlay->getDescription() }}</td>
                                <td>R$ {{ number_format($outlay->getValue(), 2, ',', '.') }}</td>
                                <td>{{ $outlay->getDatePay()? $outlay->getDatePay()->format('d/m/Y'):'' }}</td>
                                <td>{{ $outlay->getSource() ? $outlay->getSource()->getDisplay() : "" }}</td>
                                <td>{{ $outlay->getCostCenter()->getName() }}</td>
                                <td>{{ $outlay->getStore()->getName() }}</td>
                                <td>
                                    @if(!$outlay->getPaid())
                                        <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#modal-pay-outlay" @click="id = {{ $outlay->getId()}}">
                                            <i class="fas fa-exclamation"></i>
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('outlay.edit', $outlay->getId())}}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                                <td>
                                    <a v-confirm="confirmDestroy" href="{{route('outlay.destroy', $outlay->getId())}}" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right mt-4 mr-5"><strong>Total de registros: {{$outlays->total()}}</strong></div>
                <div>{{$outlays->appends(request()->query())->links()}}</div>
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
            el: '#outlays',
            data: {
                id: null,
                sources: [],
                costCenters: [],
                source: "{{ request()->input('source') }}",
                cost_center: "{{ request()->input('cost_center') }}",
                confirmDestroy: {
                    message:{
                        title: 'Atenção',
                        body: 'Deseja realmente remover este registro do sistema?'
                    }
                },
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