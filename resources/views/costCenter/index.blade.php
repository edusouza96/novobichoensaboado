@extends('layout.page') 
@section('title') Centro de Custo @endsection
 
@section('content') 
    <div id="costCenter" class="container">
        <div class="text-right mb-3">
            <a href="{{route('costCenter.create')}}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Cadastrar
            </a>
        </div>

        <div class="filter">
            <form method="GET">
                <div class="card">
                    <div class="card-header filter-header">Filtrar</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cost_center_category_id">Categoria</label>
                                    <select name="cost_center_category_id" id="cost_center_category_id" class="form-control">
                                        <option value>Selecione</option>
                                        <option v-for="category in categories" :value="category.id" :key="category.id">@{{ category.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer filter-footer">
                        <a href="{{route('costCenter.index')}}" class="btn btn-secondary">
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
        @if($costCenters->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-primary">
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Categoria</th>
                            <th scope="col" colspan="2" class="text-center" width="5%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($costCenters as $costCenter)
                            <tr>
                                <td>{{ $costCenter->getName() }}</td>
                                <td>{{ $costCenter->getCategory()->getName() }}</td>
                                <td>
                                    <a href="{{route('costCenter.edit', $costCenter->getId())}}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                                <td>
                                    <a v-confirm="confirmDestroy" href="{{route('costCenter.destroy', $costCenter->getId())}}" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right mt-4 mr-5"><strong>Total de registros: {{$costCenters->total()}}</strong></div>
                <div>{{$costCenters->links()}}</div>
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
            el: '#costCenter',
            data: {
                categories: [],
                confirmDestroy: {
                    message:{
                        title: 'Atenção',
                        body: 'Deseja realmente remover este registro do sistema?'
                    }
                }
            },
            methods:{
                getCategories(){
                    $.get(laroute.route("costCenter.category.allOptions", {id:1}))
                    .done(function(data) {
                        this.categories = data;
                    }.bind(this));
                },
            },
            created(){
                this.getCategories();
            }
        });
    </script>
@endpush