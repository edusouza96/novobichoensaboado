<div id='form'>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="name">Nome do Serviço</label>
                <input type="text" name="name" class="form-control" required value="{{$service->getName()}}">
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label for="breed_id">Raça</label>
                <select name="breed_id" id="breed_id" class="form-control" v-model="breed_id">
                    <option value="0">Todas</option>
                    <option v-for="breed in breeds" :value="breed.id" :key="breed.id">@{{ breed.name }}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label for="value">Valor</label>
                <input type="text" name="value" id="value" class="form-control" v-money="money" value="{{$service->getValue()}}">
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label for="package_type_id">Pacote</label>
                <select name="package_type_id" id="package_type_id" class="form-control" v-model="package_type_id">
                    <option v-for="package_type in package_types" :value="package_type.id" :key="package_type.id">@{{ package_type.name }}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-2">
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="pet" name="pet" value="1" {{$service->isPet() ? 'checked': ''}}>
                    <label class="form-check-label" for="pet">Pet-shop</label>
                </div>
               
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="vet" name="vet" value="1" {{$service->isVet() ? 'checked': ''}}>
                    <label class="form-check-label" for="vet">Veterinário</label>
                </div>
               
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
                package_types:[{id:1, name:'Selecione'}, {id:2, name:'15 Dias'}, {id:3, name:'30 Dias'}],
                package_type_id: "{{$service->package_type_id}}",
                breeds:[],
                breed_id: "{{$service->breed_id}}",
            },
            methods:{
                getBreeds(){
                    $.get(laroute.route("breed.allOptions"))
                    .done(function(data) {
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