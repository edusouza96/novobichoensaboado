@extends('layout.page') 
@section('title') Clientes @endsection
 
@section('content') 
    <div id="client" class="container">
        <modal-details-pet :pet="pet"></modal-details-pet>
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
                                    <input type="text" name="owner_name" class="form-control" value="{{ request()->input('owner_name')}}">
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
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="pet_name">Nome do Pet</label>
                                    <input type="text" name="pet_name" class="form-control" value="{{ request()->input('pet_name')}}">
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="breed_name">Raça</label>
                                    <input type="text" name="breed_name" class="form-control" value="{{ request()->input('breed_name')}}">
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
                            <th scope="col">Pet</th>
                            <th scope="col">Proprietario</th>
                            <th scope="col">CPF</th>
                            <th scope="col">Email</th>
                            <th scope="col" colspan="3" class="text-center" width="8%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($owners as $owner)
                            <tr>
                                <td class="align-middle">
                                    @foreach ($owner->getMyPets() as $pet)
                                        <div><a data-toggle="modal" href="#modal-details-pet" @click="setPet({{$pet}})">{{$pet->getName()}}</a></div>
                                    @endforeach     
                                </td>
                                <td class="align-middle">{{ $owner->getName() }}</td>
                                <td class="align-middle">{{ $owner->getCpf() }}</td>
                                <td class="align-middle">{{ $owner->getEmail() }}</td>
                                <td class="align-middle">
                                    <a href="{{route('client.create', $owner->getId())}}" class="btn btn-success btn-sm" v-tooltip.top-center="'Adicionar Pet'">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </td>
                                <td class="align-middle">
                                    <a href="{{route('owner.edit', $owner->getId())}}" class="btn btn-primary btn-sm" v-tooltip.top-center="'Editar Proprietario'">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                                <td class="align-middle">
                                    <a v-confirm="confirmDestroyOwner" href="{{route('owner.destroy', $owner->getId())}}" class="btn btn-danger btn-sm" v-tooltip.top-center="'Excluir Proprietario'">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                           
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right mt-4 mr-5"><strong>Total de registros: {{$owners->total()}}</strong></div>
                <div>{{$owners->appends(request()->query())->links()}}</div>
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
                },
                pet: null,
            },
            methods:{
                setPet(pet){
                    this.pet = pet;
                }
            }
        });
    </script>
@endpush