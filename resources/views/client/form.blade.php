<div id='form'>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="name">Nome do Pet</label>
                <input type="text" name="name" class="form-control" required value="{{$client->getName()}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="phone1">Telefone 1</label>
                <input type="text" name="phone1" class="form-control" value="{{$client->getPhone1()}}">
            </div>
        </div>
        
        <div class="col-6">
            <div class="form-group">
                <label for="phone2">Telefone 2</label>
                <input type="text" name="phone2" class="form-control" value="{{$client->getPhone2()}}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control" value="{{$client->getEmail()}}">
            </div>
        </div>
    </div>
</div> 

@push('js-end')
    <script>
        new Vue({
            el: '#form',
            data: {
            },
        });
    </script>
@endpush