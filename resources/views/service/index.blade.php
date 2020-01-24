@extends('layout.page') 
@section('title') Serviços @endsection
 
@section('content') 
    <div id="service" class="container">
        <div class="text-right mb-3">
            <a href="{{--route('service.create')--}}" class="btn btn-primary">
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
                                    <label for="name">Serviço</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="breed">Raça</label>
                                    <select name="breed" id="breed" class="form-control">
                                        <option value>Todas</option>
                                        <option v-for="breed in breeds" :value="breed.id" :key="breed.id">@{{ breed.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="package_type">Pacote</label>
                                    <select name="package_type" id="package_type" class="form-control">
                                        <option value>Selecione</option>
                                        <option value="2">15 Dias</option>
                                        <option value="3">30 Dias</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="pet" name="pet" value="1">
                                        <label class="form-check-label" for="pet">Pet-shop</label>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="vet" name="vet" value="1">
                                        <label class="form-check-label" for="vet">Veterinário</label>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer filter-footer">
                        <a href="{{route('service.index')}}" class="btn btn-secondary">
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
        @if($services->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-primary">
                        <tr>
                            <th scope="col">Raça</th>
                            <th scope="col">Serviço</th>
                            <th scope="col">Pet</th>
                            <th scope="col">Vet</th>
                            <th scope="col">Detalhes</th>
                            <th scope="col">Valor</th>
                            <th scope="col" colspan="2" class="text-center" width="5%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                            <tr>
                                <td>{{ $service->getBreed() ? $service->getBreed()->getName() : 'Todas' }}</td>
                                <td>{{ $service->getName() }}</td>
                                <td>{{ $service->isPet() ? 'Sim' : 'Não' }}</td>
                                <td>{{ $service->isVet() ? 'Sim' : 'Não' }}</td>
                                <td>{{ $service->details() }}</td>
                                <td>R$ {{ number_format($service->getValue(), 2, ',', '.') }}</td>
                                <td>
                                    <a href="{{--route('service.edit', $service->getId())--}}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                                <td>
                                    <a v-confirm="confirmDestroy" href="{{route('service.destroy', $service->getId())}}" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right mt-4 mr-5"><strong>Total de registros: {{$services->total()}}</strong></div>
                <div>{{$services->links()}}</div>
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
            el: '#service',
            data: {
                confirmDestroy: {
                    message:{
                        title: 'Atenção',
                        body: 'Deseja realmente remover este serviço do sistema?'
                    }
                },
                breeds:[]
            },
            methods:{
                getBreeds(){
                    $.get(laroute.route("breed.allOptions"))
                    .done(function(data) {
                        this.breeds = data;
                    }.bind(this));
                },
            },
            created(){
                this.getBreeds();
            }
            
        });
    </script>
@endpush