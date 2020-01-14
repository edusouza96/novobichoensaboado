<div id='form'>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="name">Nome do Proprietario</label>
                <input type="text" name="name" class="form-control" required value="{{$owner->getName()}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-5">
            <div class="form-group">
                <label for="cpf">CPF</label>
                <input name="cpf" type="hidden" v-model="cpf">
                <the-mask mask="###.###.###-##" v-model="cpf" class="form-control" :masked="false" type="tel"/>
            </div>
        </div>
        
        <div class="col-7">
            <div class="form-group">
                <label for="cpf">Email</label>
                <input type="text" name="email" class="form-control" value="{{$owner->getEmail()}}">
            </div>
        </div>
    </div>
</div> 

@push('js-end')
    <script>
        new Vue({
            el: '#form',
            data: {
                cpf: '{!!$owner->getCpf()!!}',
            },
        });
    </script>
@endpush