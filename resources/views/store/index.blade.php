@extends('layout.page') 
@section('title') Lojas @endsection
 
@section('content') 
    <div id="store" class="container">
        <div class="text-right mb-3">
            <a href="{{route('store.create')}}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Cadastrar
            </a>
        </div>

        <div class="filter">
            <form method="GET">
                <div class="card">
                    <div class="card-header filter-header">Filtrar</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Loja</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer filter-footer">
                        <a href="{{route('store.index')}}" class="btn btn-secondary">
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
        @if($stores->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-primary">
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Endereço</th>
                            <th scope="col">Data de Inauguração</th>
                            <th scope="col" colspan="2" class="text-center" width="5%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stores as $store)
                            <tr>
                                <td>{{ $store->getName() }}</td>
                                <td>{{ $store->getPhone() }}</td>
                                <td>{{ $store->getEmail() }}</td>
                                <td>{{ $store->getAddress() }}</td>
                                <td>{{ $store->getInaugurationDate() ? $store->getInaugurationDate()->format('d/m/Y') : '' }}</td>
                                <td>
                                    <a href="{{route('store.edit', $store->getId())}}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                                <td>
                                    <a v-confirm="confirmDestroy" href="{{route('store.destroy', $store->getId())}}" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right mt-4 mr-5"><strong>Total de registros: {{$stores->total()}}</strong></div>
                <div>{{$stores->links()}}</div>
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
            el: '#store',
            data: {
                confirmDestroy: {
                    message:{
                        title: 'Atenção',
                        body: 'Deseja realmente remover esta Loja do sistema?'
                    }
                }
            },
           
        });
    </script>
@endpush