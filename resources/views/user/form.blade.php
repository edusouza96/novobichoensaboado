<div id='form' v-cloak>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="name">Nome completo</label>
                <input type="text" name="name" class="form-control" required value="{{old('name', $user->getName())}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="nickname">Nome de usuário</label>
                <input type="text" name="nickname" class="form-control" required value="{{old('name', $user->getNickname())}}">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" name="password" class="form-control" value="{{old('password', $user->getPassword())}}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="role_id">Perfil</label>
                <select name="role_id" class="form-control" v-model="role_id">
                    <option value=''>Selecione</option>
                    <option v-for="role in roles" :value="role.id" :key="role.id">@{{ role.display_name }}</option>
                </select>
            </div>
        </div>
    </div>

    <fieldset>
        <legend>Vincular Lojas</legend>

        <div class="row" v-for="store in stores">
            <div class="col-3">
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" :id="'store'+store.id" name="store[]" :value="store.id" :checked="canCheckStore(store.id)">
                        <label class="form-check-label" :for="'store'+store.id">@{{ store.name }}</label>
                    </div>
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
                stores:[],
                saved_stores: JSON.parse(`{{ $user->getStoresIds() }}`),
                roles:[],
                role_id: "{{ old('role_id', $user->getRole() ? $user->getRole()->getId() : '') }}",
            },
            methods:{
                getRoles(){
                    $.get(laroute.route("role.allOptions"))
                    .done(function(data) {
                        this.roles = data;
                    }.bind(this));
                },
                getStores(){
                    $.get(laroute.route("store.allOptions"))
                    .done(function(data) {
                        this.stores = data;
                    }.bind(this));
                },
                canCheckStore(id){
                    let checking = this.saved_stores.filter(function(store){
                        return store == id;
                    });

                    return checking.length > 0;
                    
                }
            },
            created(){
                this.getRoles();
                this.getStores();
            }
        });
    </script>
@endpush