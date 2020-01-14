@extends('layout.page') 
@section('title') Clientes @endsection
 
@section('content') 
    <div id="client" class="container">
        <div class="text-right mb-3">
            <a href="{{route('owner.create')}}" class="btn btn-primary">
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
                                    <label for="owner_name">Nome do Proprietario</label>
                                    <input type="text" name="owner_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cpf">CPF</label>
                                    <input name="cpf" type="hidden" v-model="cpf">
                                    <the-mask mask="###.###.###-##" v-model="cpf" class="form-control" :masked="false" type="tel"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer filter-footer">
                        <a href="{{route('owner.index')}}" class="btn btn-secondary">
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
        @if($owners->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-primary">
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">CPF</th>
                            <th scope="col">Email</th>
                            <th scope="col" colspan="2" class="text-center" width="5%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($owners as $owner)
                            <tr>
                                <td>{{ $owner->getName() }}</td>
                                <td>{{ $owner->getCpf() }}</td>
                                <td>{{ $owner->getEmail() }}</td>
                                <td>
                                    <a href="{{route('owner.edit', $owner->getId())}}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                                <td>
                                    <a v-confirm="confirmDestroyOwner" href="{{route('owner.destroy', $owner->getId())}}" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right mt-4 mr-5"><strong>Total de registros: {{$owners->total()}}</strong></div>
                <div>{{$owners->links()}}</div>
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
            el: '#client',
            data: {
                cpf: '{!!request()->cpf!!}',
                confirmDestroyOwner: {
                    message:{
                        title: 'Atenção',
                        body: 'Deseja realmente remover este cliente e seus pets do sistema?'
                    }
                }
            },
        });
    </script>
@endpush