<div id='form'>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="name">Nome da loja</label>
                <input type="text" name="name" class="form-control" required value="{{old('name', $store->getName())}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="form-group">
                <label for="phone">Telefone</label>
                <input type="number" name="phone" class="form-control" value="{{old('phone', $store->getPhone())}}">
            </div>
        </div>
        <div class="col-8">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control" value="{{old('email', $store->getEmail())}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="address">Endereço</label>
                <input type="text" name="address" class="form-control" value="{{old('address', $store->getAddress())}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label for="inauguration_date">Data de Inauguração</label>
                <input type="date" name="inauguration_date" id="inauguration_date" class="form-control" v-model="inaugurationDate">
            </div>
        </div>
    </div>
</div> 



@push('js-end')
    <script>
        new Vue({
            el: '#form',
            data: {
                inaugurationDate: "{{$store->getInaugurationDate()}}" != "" ? moment("{{$store->getInaugurationDate()}}", "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD") : moment().format("YYYY-MM-DD"),
            },
        });
    </script>
@endpush