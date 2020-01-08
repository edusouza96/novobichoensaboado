@extends('layout.page') 
@section('title') Bairros @endsection
 
@section('content') 
    <div id="neighborhood" class="container">
        <div class="text-right mb-3">
            <a href="{{route('neighborhood.create')}}" class="btn btn-primary">
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
                                    <label for="name">Nome do Bairro</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer filter-footer">
                        <a href="{{route('neighborhood.index')}}" class="btn btn-secondary">
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
        @if($neighborhoods->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-primary">
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Valor</th>
                            <th scope="col" colspan="2" class="text-center" width="5%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($neighborhoods as $neighborhood)
                            <tr>
                                <td>{{ $neighborhood->getName() }}</td>
                                <td>R$ {{ number_format($neighborhood->getValue(), 2, ',', '.') }}</td>
                                <td>
                                    <a href="{{route('neighborhood.edit', $neighborhood->getId())}}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{route('neighborhood.destroy', $neighborhood->getId())}}" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right mt-4 mr-5"><strong>Total de registros: {{$neighborhoods->total()}}</strong></div>
                <div>{{$neighborhoods->links()}}</div>
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
            el: '#neighborhood',
            data: {
            },
            methods:{
            },
            created(){
            }
        });
    </script>
@endpush