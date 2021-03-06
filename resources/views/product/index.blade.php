@extends('layout.page') 
@section('title') Produtos @endsection
 
@section('content') 
    <div id="product" class="container">
        <div class="text-right mb-3">
            <a href="{{route('product.create')}}" class="btn btn-primary">
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
                                    <label for="name">Produtos</label>
                                    <input type="text" name="name" class="form-control" value="{{ request()->input('name')}}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="barcode">Código de Barras</label>
                                    <input type="text" name="barcode" class="form-control" value="{{ request()->input('barcode')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer filter-footer">
                        <a href="{{route('product.index')}}" class="btn btn-secondary">
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
        @if($products->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-primary">
                        <tr>
                            <th scope="col">Código de Barras</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Valor de Compra</th>
                            <th scope="col">Valor de venda</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col" colspan="3" class="text-center" width="5%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->getBarcode() }}</td>
                                <td>{{ $product->getName() }}</td>
                                <td>R$ {{ number_format($product->getValueBuy(), 2, ',', '.') }}</td>
                                <td>R$ {{ number_format($product->getValueSales(), 2, ',', '.') }}</td>
                                <td>{{ $product->getQuantity() }}</td>
                                <td>
                                    <button class="btn btn-dark btn-sm text-white" @click="printBarcode({{$product->getId()}})">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </td>
                                <td>
                                    <a href="{{route('product.edit', $product->getId())}}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                                <td>
                                    <a v-confirm="confirmDestroy" href="{{route('product.destroy', $product->getId())}}" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right mt-4 mr-5"><strong>Total de registros: {{$products->total()}}</strong></div>
                <div>{{$products->appends(request()->query())->links()}}</div>
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
            el: '#product',
            data: {
                confirmDestroy: {
                    message:{
                        title: 'Atenção',
                        body: 'Deseja realmente remover este produo do sistema?'
                    }
                }
            },
            methods:{
                printBarcode(id){
                    this.$dialog
                        .prompt({
                            title: "Gerar tela de impressão do código de barras",
                        },{
                            promptHelp: "Quantos códigos deseja imprimir ?",
                            okText: 'Imprimir',
                            cancelText: 'Cancelar',
                        })
                        .then(dialog => {
                            let count = parseInt(dialog.data);
                            if(!Number.isInteger(count)){
                                count = 1;
                            }
                            let url = laroute.route('product.barcode', {id: id, count: count});
                            location.href = url;
                        })
                        .catch(() => {
                            console.log('Contate ao Dev, ou tente novamente');
                        });
                }
            }
        });
    </script>
@endpush