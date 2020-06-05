@extends('layout.page') 
@section('title') Promoções @endsection
 
@section('content') 
    <div id="rebate" class="container">
        <div class="text-right mb-3">
            <a href="{{route('rebate.create')}}" class="btn btn-primary">
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
                                    <label for="name">Nome da Promoção/Desconto</label>
                                    <input type="text" name="name" class="form-control" value="{{ request()->input('name')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer filter-footer">
                        <a href="{{route('rebate.index')}}" class="btn btn-secondary">
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
        @if($rebates->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-primary">
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Valor do desconto %</th>
                            <th scope="col">Se aplica em</th>
                            <th scope="col">Status</th>
                            <th scope="col" colspan="2" class="text-center" width="5%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rebates as $rebate)
                            <tr>
                                <td class="align-middle">{{ $rebate->getName() }}</td>
                                <td class="align-middle">{{ $rebate->getValue() }}%</td>
                                <td class="align-middle">
                                    <div>{!! $rebate->applyPet() ? '<i class="fas fa-dog"></i> Pet' : '' !!}</div>
                                    <div>{!! $rebate->applyVet() ? '<i class="fas fa-user-md"></i> Vet' : '' !!}</div>
                                    <div>{!! $rebate->applyProduct() ? '<i class="fas fa-shopping-bag"></i> Produtos' : '' !!}</div>
                                </td>
                                <td class="align-middle">{{ $rebate->isActive() ? 'Ativo' : 'Inativo' }}</td>
                                <td class="align-middle">
                                    <a href="{{route('rebate.edit', $rebate->getId())}}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                                <td class="align-middle">
                                    @if($rebate->isActive())
                                        <a v-confirm="confirmInactive" href="{{route('rebate.inactive', $rebate->getId())}}" class="btn btn-dark btn-sm" style="width:5em">
                                            Inativar
                                        </a>     
                                    @else
                                        <a v-confirm="confirmActive" href="{{route('rebate.active', $rebate->getId())}}" class="btn btn-dark btn-sm" style="width:5em">
                                            Ativar
                                        </a>  
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right mt-4 mr-5"><strong>Total de registros: {{$rebates->total()}}</strong></div>
                <div>{{$rebates->appends(request()->query())->links()}}</div>
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
            el: '#rebate',
            data: {
                confirmActive: {
                    message:{
                        title: 'Atenção',
                        body: 'Deseja realmente ativar esta promoção?'
                    }
                },
                confirmInactive: {
                    message:{
                        title: 'Atenção',
                        body: 'Deseja realmente inativar esta promoção?'
                    }
                }
            },
        });
    </script>
@endpush