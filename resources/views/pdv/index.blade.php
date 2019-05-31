@extends('layout.page')
@section('title') PDV @endsection

@section('content')
<div id="pdv" class="container" v-cloak>

    <div class="pdv-content row">
        <div class="col-md-7 col-xs-12" style="">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Procurar Produto</label>
                        <vue-bootstrap-typeahead 
  v-model="query"
  :data="['Canada', 'USA', 'Mexico']"
/>
                        <select name="" class="form-control">
                            <option value="">Selecione</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Quantidade</label>
                        <input type="number" name="" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Valor Unitario</label>
                        <input type="number" name="" class="form-control" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Valor Total do Produto</label>
                        <input type="number" name="" class="form-control" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="button" class="btn btn-dark btn-lg btn-block mb-3">Adicionar Item</button>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-xs-12">

            <div class="table-responsive" style="height: 27em;">
                <table class="table table-sm table-striped" v-if="hasProduct()">
                    <thead class="thead-primary">
                        <tr>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Valor Unitário</th>
                            <th scope="col">Valor Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products">
                            <td>@{{ product.units }}</td>
                            <td>@{{ product.description }}</td>
                            <td>@{{ product.unitaryValue }}</td>
                            <td>@{{ product.amount }}</td>
                        </tr>
                       
                    </tbody>
                </table>
            </div>

            <div class="pdv-content-bottom">
                <div class="row">
                    <div class="col-12">
                        <h4 class="text-center">Total da Venda</h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn-dark btn-lg btn-block" disabled>R$ @{{ amountSale }}</button>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn btn-success btn-lg btn-block mt-2 mb-2">Finalizar Venda</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@push('js-end')
<script>
    new Vue({
        el: '#pdv',
        data: {
            query: null,
            products:[{"units":2,"description":"banho","amount":20,"unitaryValue":10}, {"units":2,"description":"banho","amount":20,"unitaryValue":10}]
        },
        methods:{
            hasProduct(){
                return this.products.length > 0;
            }
        },
        computed:{
            amountSale(){
                return this.products.reduce(function(accumulator, product){
                    return {
                        amount: accumulator.amount + product.amount
                    }
                }).amount.toLocaleString('pt-BR', {minimumFractionDigits:2})
            }
        }

    });

</script>
@endpush