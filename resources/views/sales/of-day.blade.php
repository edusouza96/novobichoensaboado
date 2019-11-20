@extends('layout.page') 
@section('title') Vendas do dia @endsection
 
@section('content') 
    <div id="sales_of_day" class="container">
        <div class="filter">
            <form method="GET">
                <div class="card">
                    <div class="card-header filter-header">Filtrar</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name_pet">Nome Pet</label>
                                    <input type="text" name="name_pet" id="name_pet" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name_product">Nome Produto</label>
                                    <input type="text" name="name_product" id="name_product" class="form-control">
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="created_at">Data</label>
                                    <input type="date" name="created_at" id="created_at" class="form-control">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="store">Loja</label>
                                    <select name="store" id="store" class="form-control">
                                        <option value>Selecione</option>
                                        <option value="1">Loja 1</option>
                                        <option value="2">Loja 2</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-footer filter-footer">
                        <a href="{{route('sales.ofDay')}}" class="btn btn-secondary">
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
        @if($sales->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-primary">
                        <tr>
                            <th scope="col">Descrição</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Data</th>
                            <th scope="col">Loja</th>
                            <th scope="col" colspan="3" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                            <tr>
                                <td>{!! $sale->getDescription() !!}</td>
                                <td>R$ {{ number_format($sale->getTotal(), 2, ',', '.') }}</td>
                                <td>{{ $sale->getCreatedAt()->format('d/m/Y') }}</td>
                                <td>{{ $sale->getStore() }}</td>
                                <td class="text-center">
                                    <button class="btn btn-danger">
                                        <i class="fas fa-hand-holding-usd"></i> Estorno
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <td>Total Débito</td>
                            <td colspan="4">R$ {{ number_format($debitCard, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Total Crédiro</td>
                            <td colspan="4">R$ {{ number_format($creditCard, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Total Dinheiro</td>
                            <td colspan="4">R$ {{ number_format($cash, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td colspan="4">R$ {{ number_format($total, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="text-right mt-4 mr-5"><strong>Total de registros: {{$sales->total()}}</strong></div>
                <div>{{$sales->links()}}</div>
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
            el: '#sales_of_day',
            data: {
            },
            methods:{
            },
        });
    </script>
@endpush