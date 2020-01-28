<div id='form'>
    <div class="row">
        <div class="col-8">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" required value="{{$product->getName()}}">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="barcode">Código de Barras</label>
                <input type="text" name="barcode" class="form-control" readonly value="{{$product->getBarcode()}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-5">
            <div class="form-group">
                <label for="value_buy">Valor de Compra</label>
                <input type="text" name="value_buy" id="value_buy" class="form-control" v-money="money" value="{{$product->getValueBuy()}}">
            </div>
        </div>
        <div class="col-5">
            <div class="form-group">
                <label for="value_sales">Valor de Venda</label>
                <input type="text" name="value_sales" id="value_sales" class="form-control" v-money="money" value="{{$product->getValueSales()}}">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label for="quantity">Quantidade</label>
                <input type="number" name="quantity" class="form-control" required value="{{$product->getQuantity()}}">
            </div>
        </div>
    </div>
    
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
            },
        });
    </script>
@endpush