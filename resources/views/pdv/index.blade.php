@extends('layout.page')
@section('title') PDV @endsection

@section('content')
<div id="pdv" class="container" v-cloak>
    <modal-finish-pay></modal-finish-pay>
    <div class="pdv-content row">
        <div class="col-md-7 col-xs-12" style="">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Procurar Produto</label>
                        <vue-bootstrap-typeahead 
                            :key="reloadComponent"
                            v-model="query"
                            :data="showProductsForDropdown"
                            :serializer="item => item.name+' - '+item.barcode"
                            @hit="selectedProduct = $event"
                            placeholder="Procure o produto"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Quantidade</label>
                        <input type="number" name="" class="form-control" v-model="units">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Valor Unitario</label>
                        <input type="number" name="" class="form-control" readonly :value="unitaryValueProduct">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Valor Total do Produto</label>
                        <input type="number" name="" class="form-control" readonly :value="amountValueProduct">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="button" class="btn btn-dark btn-lg btn-block mb-3" @click="addProduct">Adicionar Item</button>
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
                            <td>@{{ convertToBrPattern(product.unitaryValue) }}</td>
                            <td>@{{ convertToBrPattern(product.amount) }}</td>
                        </tr>
                       
                    </tbody>
                </table>
                <div v-else class="alert alert-info pdv-content-alert" role="alert">
                    <h6>Nenhum produto/serviço no carrinho!</h6>
                </div>
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
                        <button type="button" class="btn btn-success btn-lg btn-block mt-2 mb-2" data-toggle="modal" data-target="#modal-finish-pay">Finalizar Venda</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@push('js-end')
<script>
    const API_URL = laroute.route('client.findByName');

    new Vue({
        el: '#pdv',
        data: {
            query: '',
            selectedProduct: null,
            units: 1,
            showProductsForDropdown: [],
            products:[],
            reloadComponent: '1'
        },
        methods:{
            hasProduct(){
                return this.products.length > 0;
            },
            addProduct(){
                this.products.push({
                    "units": this.units,
                    "description": this.selectedProduct.name,
                    "unitaryValue": this.unitaryValueProduct,
                    "amount": this.amountValueProduct,
                });

                this.query = '';
                this.selectedProduct = null;
                this.showProductsForDropdown = [];
                this.units = 1;
                this.reloadComponent = Math.floor(Math.random() * 101);
            },
            convertToBrPattern(value){
                return parseFloat(value).toLocaleString('pt-BR', {minimumFractionDigits:2});
            }
        },
        computed:{
            amountSale(){
                if(this.hasProduct()){
                    return this.products.reduce(function(accumulator, product){
                        return {
                            amount: parseFloat(accumulator.amount) + parseFloat(product.amount)
                        }
                    }).amount.toLocaleString('pt-BR', {minimumFractionDigits:2})
                }
            },
            unitaryValueProduct(){
                return parseFloat(this.selectedProduct ? this.selectedProduct.valueSales : 0).toFixed(2);
            },
            amountValueProduct(){
                return (this.unitaryValueProduct * this.units).toFixed(2);
            }
        },
        watch: {
            query(newQuery) {
                if(newQuery.length > 1){
                    axios.get(laroute.route('product.findByName', {
                        name: newQuery
                    }))
                    .then((res) => {
                        this.showProductsForDropdown = res.data;
                    });
                }else{
                    this.showProductsForDropdown = [];
                }
               
            }
        },
        filters: {
            stringify(value) {
                return JSON.stringify(value, null, 2)
            }
        },
        created(){
            try{
                this.products.push(JSON.parse('{!! $jsonPet !!}'));
            }catch(e){
            }

            try{
                this.products.push(JSON.parse('{!! $jsonVet !!}'));
            }catch(e){
            }

            try{
                this.products.push(JSON.parse('{!! $jsonDeliveryFee !!}'));
            }catch(e){
            }

            
        }

    });

</script>
@endpush