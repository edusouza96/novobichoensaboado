<div id='form'>
    <div class="row">
        <div class="col-8">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" required value="{{old('name', $product->getName())}}">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="barcode">Código de Barras</label>
                <input type="text" name="barcode" class="form-control" readonly value="{{old('barcode', $product->getBarcode())}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-5">
            <div class="form-group">
                <label for="value_buy">Valor de Compra</label>
                <input type="text" name="value_buy" id="value_buy" class="form-control" v-money="money" v-model="valueBuy">
            </div>
        </div>
        <div class="col-5">
            <div class="form-group">
                <label for="value_sales">Valor de Venda</label>
                <input type="text" name="value_sales" id="value_sales" class="form-control" v-money="money" value="{{old('value_sales', $product->getValueSales())}}">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label for="quantity">Quantidade</label>
                <input type="number" name="quantity" class="form-control" required v-model="quantity">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="has_outlay" name="has_outlay" v-model="hasOutlay">
                    <label class="form-check-label" for="has_outlay"> Lançar despesa ?</label>
                </div>  
            </div>  
        </div>  
    </div>

    <fieldset v-if="hasOutlay">
        <legend>Lançar despesa</legend>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="value_outlay">Valor da despesa</label>
                    <input type="text" name="value_outlay" id="value_outlay" class="form-control" v-model="totalOutlay" v-money="money">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="source">Fonte</label>
                    <select name="source" id="source" class="form-control">
                        <option value>Selecione</option>
                        <option v-for="source in sources" :value="source.id" :key="source.id">@{{ source.display }}</option>
                    </select>
                </div>
            </div>
            <div class="col-5">
                <div class="form-group">
                    <label for="cost_center">Centro de Custo</label>
                    <select name="cost_center" id="cost_center" class="form-control">
                        <option value>Selecione</option>
                        <option v-for="cost in costCenters" :value="cost.id" :key="cost.id">@{{ cost.name }}</option>
                    </select>
                </div>
            </div>
        </div>
    </fieldset>
    
</div> 

@push('js-end')
    <script>
        new Vue({
            el: '#form',
            data: {
                money: {
                    decimal: ",",
                    thousands: "",
                    precision: 2
                },
                sources: [],
                costCenters: [],
                quantity: "{{ old('quantity', $product->getQuantity()) }}",
                valueBuy: "{{ old('value_buy', $product->getValueBuy()) }}",
                totalOutlay: 0,
                hasOutlay: false,
            },
            methods:{
                getSources(){
                    $.get(laroute.route("treasure.findByStore", {id:1}))
                    .done(function(data) {
                        this.sources = data;
                    }.bind(this));
                },
                getCostCenters(){
                    $.get(laroute.route("costCenter.allOptions"))
                    .done(function(data) {
                        this.costCenters = data;
                    }.bind(this));
                },
                convertToBrPattern(value) {

                    return parseFloat(value).toLocaleString("pt-BR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                },
                convertToUsPattern(value) {
                    return value == undefined
                        ? 0.0
                        : parseFloat(value.replace(",", "."));
                },
                getTotalOutlay(){
                    let total = this.convertToUsPattern(this.quantity) * this.convertToUsPattern(this.valueBuy);
                    return isNaN(total) ? '0,00' : this.convertToBrPattern(total);
                }
            },
            created(){
                this.getSources();
                this.getCostCenters();
            },
            watch:{
                quantity(){
                    this.totalOutlay = this.getTotalOutlay();
                },
                valueBuy(){
                    this.totalOutlay = this.getTotalOutlay();
                }
            }
        });
    </script>
@endpush