@extends('layout.page') 
@section('title') Usuarios @endsection
 
@section('content') 
    <div id="user" class="container">
        <div class="text-right mb-3">
            <a href="{{route('user.create')}}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Cadastrar
            </a>
        </div>

        <div class="filter">
            <form method="GET">
                <div class="card">
                    <div class="card-header filter-header">Filtrar</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" name="name" class="form-control" value="{{ request()->input('name')}}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="role_id">Perfil</label>
                                    <select name="role_id" class="form-control" v-model="role_id">
                                        <option value=''>Selecione</option>
                                        <option v-for="role in roles" :value="role.id" :key="role.id">@{{ role.display_name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer filter-footer">
                        <a href="{{route('user.index')}}" class="btn btn-secondary">
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
        @if($users->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-primary">
                        <tr>
                            <th scope="col">Nome completo</th>
                            <th scope="col">Usuário</th>
                            <th scope="col">Perfil</th>
                            <th scope="col" colspan="2" class="text-center" width="5%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->getName() }}</td>
                                <td>{{ $user->getNickname() }}</td>
                                <td>{{ $user->getRole()->getDisplayName() }}</td>
                                <td>
                                    <a href="{{route('user.edit', $user->getId())}}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                                <td>
                                    <a v-confirm="confirmDestroy" href="{{route('user.destroy', $user->getId())}}" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right mt-4 mr-5"><strong>Total de registros: {{$users->total()}}</strong></div>
                <div>{{$users->appends(request()->query())->links()}}</div>
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
            el: '#user',
            data: {
                roles:[],
                role_id: '{!!request()->role_id!!}',
                confirmDestroy: {
                    message:{
                        title: 'Atenção',
                        body: 'Deseja realmente remover este usuário do sistema?'
                    }
                }
            },
            methods:{
                getRoles(){
                    $.get(laroute.route("role.allOptions"))
                    .done(function(data) {
                        this.roles = data;
                    }.bind(this));
                },
            },
            created(){
                this.getRoles();
            }
        });
    </script>
@endpush