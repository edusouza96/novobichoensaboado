<div id='form'>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="owner_name">Nome do Proprietario</label>
                <input type="text" name="owner_name" class="form-control" readonly value="{{old('owner_name', $client->getOwner()->getName())}}">
                <input type="hidden" name="owner_id" value="{{old('owner_id', $client->getOwner()->getId())}}">
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
        <div class="col-12">
            <div class="form-group">
                <label for="observation">Observação do Pet</label>
                <textarea cols="30" rows="3" name="observation" class="form-control">{{ old('observation', $client->getObservation()) }}</textarea>
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
               
            },
            methods:{
                getBreeds(){
                    return $.get(laroute.route('breed.allOptions'))
                        .done(function(data){
                            this.breeds = data;
                        }.bind(this));
                },
            },
            created(){
                this.getBreeds();
            }
        });
    </script>
@endpush