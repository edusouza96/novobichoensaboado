<div id='form'>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="name">Nome do Bairro</label>
                <input type="text" name="name" class="form-control" required value="{{$neighborhood->getName()}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label for="value">Valor Busca</label>
                <input type="text" name="value" id="value" class="form-control" v-money="money" value="{{$neighborhood->getValue()}}">
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