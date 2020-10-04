<div id='form'>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="name">Nome do Proprietario</label>
                <input type="text" name="name" class="form-control" required value="{{old('name', $owner->getName())}}">
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
                <input type="text" name="email" class="form-control" value="{{old('email', $owner->getEmail())}}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="form-group">
                <label for="neighborhood_id">Bairro</label>
                <select name="neighborhood_id" class="form-control" v-model="neighborhood_id" required>
                    <option value="">Selecione</option>
                    <option v-for="neighborhood in neighborhoods" :value="neighborhood.id">@{{neighborhood.name}}</option>
                </select>
            </div>
        </div>
        
        <div class="col-8">
            <div class="form-group">
                <label for="address">Endereço</label>
                <input type="text" name="address" class="form-control" value="{{old('address',$owner->getAddress())}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="phone1">Telefone 1</label>
                <input type="number" name="phone1" class="form-control" required value="{{old('phone1', $owner->getPhone1())}}">
            </div>
        </div>
        
        <div class="col-6">
            <div class="form-group">
                <label for="phone2">Telefone 2</label>
                <the-mask mask="###########" :masked="false" type="tel" name="phone2" class="form-control" value="{{old('phone2', $owner->getPhone2())}}">

            </div>
        </div>
    </div>
</div> 

@push('js-end')
    <script>
        new Vue({
            el: '#form',
            data: {
                cpf: '{!!old("cpf", $owner->getCpf())!!}',
                neighborhoods:[],
                neighborhood_id: "{{old('breed_id',$owner->neighborhood_id)}}",
            },
            methods:{
                getNeighborhoods(){
                    return $.get(laroute.route('neighborhood.allOptions'))
                        .done(function(data){
                            this.neighborhoods = data;
                        }.bind(this));
                },
            },
            created(){
                this.getNeighborhoods();
            }
        });
    </script>
@endpush
