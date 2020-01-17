<div id='form'>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="owner_name">Nome do Proprietario</label>
                <input type="text" name="owner_name" class="form-control" readonly value="{{$client->getOwner()->getName()}}">
                <input type="hidden" name="owner_id" value="{{$client->getOwner()->getId()}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <div class="form-group">
                <label for="name">Nome do Pet</label>
                <input type="text" name="name" class="form-control" required value="{{old('name', $client->getName())}}">
            </div>
        </div>
       
        <div class="col-4">
            <div class="form-group">
                <label for="breed_id">Raça</label>
                <select name="breed_id" class="form-control" v-model="breed_id" required>
                    <option value="">Selecione</option>
                    <option v-for="breed in breeds" :value="breed.id">@{{breed.name}}</option>
                </select>
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
                <input type="text" name="address" class="form-control" value="{{old('address',$client->getAddress())}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="phone1">Telefone 1</label>
                <input type="number" name="phone1" class="form-control" required value="{{old('phone1', $client->getPhone1())}}">
            </div>
        </div>
        
        <div class="col-6">
            <div class="form-group">
                <label for="phone2">Telefone 2</label>
                <input type="number" name="phone2" class="form-control" value="{{old('phone2', $client->getPhone2())}}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control" value="{{old('email', $client->getEmail())}}">
            </div>
        </div>
    </div>
</div> 

@push('js-end')
    <script>
        new Vue({
            el: '#form',
            data: {
                breeds:[],
                breed_id: "{{old('breed_id',$client->breed_id)}}",
                neighborhoods:[],
                neighborhood_id: "{{old('breed_id',$client->neighborhood_id)}}",
            },
            methods:{
                getBreeds(){
                    return $.get(laroute.route('breed.allOptions'))
                        .done(function(data){
                            this.breeds = data;
                        }.bind(this));
                },
                getNeighborhoods(){
                    return $.get(laroute.route('neighborhood.allOptions'))
                        .done(function(data){
                            this.neighborhoods = data;
                        }.bind(this));
                },
            },
            created(){
                this.getBreeds();
                this.getNeighborhoods();
            }
        });
    </script>
@endpush