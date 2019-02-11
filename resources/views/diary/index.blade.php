@extends('layout.page')

@section('title') Agenda @endsection

@section('content')


<div id="diaries">
    
    <diary-table :data="data"></diary-table>

</div>

@endsection


@push('js-end')
    <script>
        Vue.component('modal-services', {
            template: `
            <div id="modal-list-services" class="modal modal-fixed-footer">
                <div class="modal-content">
                    <h4>Serviços</h4>
                    <table v-if="hasServices" class="highlight centered">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Preço</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="service in listServices" @click="selectService(service)" class="cursor-pointer">
                                <td>@{{service.name}}</td>
                                <td>@{{service.value}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-if="!hasServices">
                        <h6>Não foi encontrado serviços disponiveis para esta raça!</h6>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="modal-close waves-effect waves-green btn-flat red darken-2 white-text">Fechar</a>
                </div>
            </div>
            `,
            data: function(){
                return {
                    listServices : [],
                }
            },
            props:['register'],
            methods:{
                selectService: function(service){
                    this.$emit('serviceSelected', service);
                    this.$forceUpdate();
                    $('#modal-list-services').modal('close');
                },
            },
            computed: {
                breedId: function(){
                    return $.isEmptyObject(this.register) || this.register == undefined ? null : this.register.client.breed_id;
                },
                hasServices: function(){
                    return this.listServices == null ? false : this.listServices.length > 0;
                },
            },
            watch: {
                breedId: function(){
                    if(this.breedId > 0){
                        var that = this;
                        $.get(laroute.route('service.findByBreed', {id:this.breedId})).done(function(data) {
                            that.listServices = data;
                        });
                    }else{
                        this.listServices = [];
                    }
                }
            }
        });
        Vue.component('modal-clients', {
            template: `
            <div id="modal-list-clients" class="modal modal-fixed-footer">
                <div class="modal-content">
                    <h4>Clientes</h4>
                    <table v-if="hasClients" class="highlight centered">
                        <thead>
                            <tr>
                                <th>Pet</th>
                                <th>Dono</th>
                                <th>Raça</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="client in listClients" @click="selectClient(client)" class="cursor-pointer">
                                <td>@{{client.name}}</td>
                                <td>@{{client.owner_name}}</td>
                                <td>@{{client.breed_name}}</td>
                            </tr>
                        
                        </tbody>
                    </table>
                    <div v-if="!hasClients">
                        <h6>Não foi encontrado Pet com este nome!</h6>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="modal-close waves-effect waves-green btn-flat red darken-2 white-text">Fechar</a>
                </div>
            </div>
            `,
            props:['listClients'],
            computed:{   
                hasClients: function(){
                    return this.listClients == null ? false : this.listClients.length > 0;
                },
            },
            methods:{   
                selectClient: function(client){
                    this.$emit('clientSelected', client);
                    this.$forceUpdate();
                    $('#modal-list-clients').modal('close');
                },
            },
            
        });
        Vue.component('diary-table', {
            template: `
                <div class="table-responsive">
                    <modal-clients :listClients="listClients" @clientSelected="clientSelected"></modal-clients>
                    <modal-services :register="registerCurrent" @serviceSelected="serviceSelected"></modal-services>

                    <table class="highlight">
                        <thead>
                            <tr class="diary-table-header-row">
                                <th class="diary-table-header-cell">Hora</th>
                                <th class="diary-table-header-cell">Nome do Pet</th>
                                <th class="diary-table-header-cell">Raça</th>
                                <th class="diary-table-header-cell">Proprietário</th>
                                <th class="diary-table-header-cell">Busca</th>
                                <th class="diary-table-header-cell">Endereço</th>
                                <th class="diary-table-header-cell">Bairro</th>
                                <th class="diary-table-header-cell">Telefone</th>
                                <th class="diary-table-header-cell">Serviço Pet</th>
                                <th class="diary-table-header-cell">Valor Pet</th>
                                <th class="diary-table-header-cell">Serviço Vet</th>
                                <th class="diary-table-header-cell">Valor Vet</th>
                                <th class="diary-table-header-cell">Valor Busca</th>
                                <th class="diary-table-header-cell">Total</th>
                                <th class="diary-table-header-cell">Ações</th>
                            </tr>
                        </thead>

                        <tbody v-for="(register, index) in schedules">
                            <tr class="diary-table-body-row">
                                <td class="diary-table-body-cell cursor-pointer" @click="plus(register)" title="Clique para adicionar uma linha"> 
                                    @{{register.hour}}
                                </td>
                                
                                <td class="diary-table-body-cell">
                                    <input type="text" class="name" @blur="listAnimalName(register.client.name, index)" name="name" v-model="register.client.name" :readonly="register.id != null">
                                </td>
                                
                                <td class="diary-table-body-cell">
                                    <input type="text" name="breed" v-model="register.client.breed_name" readonly="reandonly">
                                </td>
                                
                                <td class="diary-table-body-cell">
                                    <input type="text" name="owner_name" v-model="register.client.owner_name" :readonly="register.id != null">
                                </td class="diary-table-body-cell">
                                
                                <td class="diary-table-body-cell">
                                    <span v-if="register.fetch == 1">
                                        <input type="checkbox" class="filled-in" :id="index" checked="checked" :disabled="register.id != null"/>
                                        <label :for="index"></label>
                                    </span>
                                    <span v-else>
                                        <input type="checkbox" class="filled-in" :id="index" :disabled="register.id != null"/>
                                        <label :for="index"></label>
                                    </span>                            
                                </td>
                                
                                <td class="diary-table-body-cell">
                                    <input type="text" name="address" v-model="register.client.address" readonly="reandonly">
                                </td>
                                
                                <td class="diary-table-body-cell">
                                    <input type="text" name="neighborhood" v-model="register.client.neighborhood" readonly="reandonly">
                                </td>
                                
                                <td class="diary-table-body-cell">
                                    <input type="text" name="phone" v-model="showPhones(register)" readonly="reandonly">
                                </td>
                                
                                <td class="diary-table-body-cell">
                                    <a href="#modal-list-services" @blur="refreshRegisterCurrent(register, index)" class="btn-floating waves-effect waves-light modal-trigger"><i class="material-icons">add</i></a>
                                    @{{register.service.name}}
                                </td>
                                
                                <td class="diary-table-body-cell">
                                    <input type="text" name="service_pet_value" v-model="register.value" readonly="reandonly">
                                </td>

                                <td class="diary-table-body-cell">
                                    <input type="text" name="service_vet" v-model="register.service.name" :readonly="register.id != null">
                                </td>
                                
                                <td class="diary-table-body-cell">
                                    <input type="text" name="service_vet_value" v-model="register.value" readonly="reandonly">
                                </td>
                                
                                <td class="diary-table-body-cell">
                                    <input type="text" name="delivery_fee" v-model="register.deliveryFee" readonly="reandonly">
                                </td>
                                
                                <td class="diary-table-body-cell">
                                    <input type="text" name="gross" v-model="register.gross" readonly="reandonly">
                                </td>
                                
                                <td class="diary-table-body-cell">
                                    <a @click="save()"><i class="fas fa-check"></i></a>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>

            `,
            
            props:['data'],
            data: function() {
                return {
                    listClients: null,
                    showRow: false,
                    defaultHours: [
                        {'id':null, 'hour':'08:00', 'client': {}, 'service': {} }, 
                        {'id':null, 'hour':'08:30', 'client': {}, 'service': {} },
                        {'id':null, 'hour':'09:00', 'client': {}, 'service': {} }, 
                        {'id':null, 'hour':'09:30', 'client': {}, 'service': {} }, 
                        {'id':null, 'hour':'10:00', 'client': {}, 'service': {} }, 
                        {'id':null, 'hour':'10:30', 'client': {}, 'service': {} }, 
                        {'id':null, 'hour':'11:00', 'client': {}, 'service': {} }, 
                        {'id':null, 'hour':'11:30', 'client': {}, 'service': {} }, 
                        {'id':null, 'hour':'12:00', 'client': {}, 'service': {} }, 
                        {'id':null, 'hour':'12:30', 'client': {}, 'service': {} },
                        {'id':null, 'hour':'13:00', 'client': {}, 'service': {} }, 
                        {'id':null, 'hour':'13:30', 'client': {}, 'service': {} },
                        {'id':null, 'hour':'14:00', 'client': {}, 'service': {} }, 
                        {'id':null, 'hour':'14:30', 'client': {}, 'service': {} }, 
                        {'id':null, 'hour':'15:00', 'client': {}, 'service': {} }, 
                        {'id':null, 'hour':'15:30', 'client': {}, 'service': {} }, 
                        {'id':null, 'hour':'16:00', 'client': {}, 'service': {} }, 
                        {'id':null, 'hour':'16:30', 'client': {}, 'service': {} }, 
                        {'id':null, 'hour':'17:00', 'client': {}, 'service': {} }, 
                        {'id':null, 'hour':'17:30', 'client': {}, 'service': {} },
                    ],
                    indexCurrent: null,
                    registerCurrent: {},
                }
            },
            methods:{   
                plus: function(hour){
                    this.data.push(hour);
                },
                showPhones: function(register){
                    var phone1 = register.client.phone1 == null ? '': register.client.phone1;
                    var phone2 = register.client.phone2 == null ? '': ' / '+register.client.phone2;
                    return phone1+phone2;
                },
                listAnimalName: function(name, index){
                    this.indexCurrent = index;
                    if(name){
                        var that = this;
                        $.get(laroute.route('client.findByName', { name:name})).done(function(data) {
                            that.listClients = data;
                        });
                        $('#modal-list-clients').modal();
                        $('#modal-list-clients').modal('open');
                    }
                },
                clientSelected: function(data){
                    this.schedules[this.indexCurrent].client = data;
                    
                },
                serviceSelected: function(data){
                    this.schedules[this.indexCurrent].service = data;
                },
                refreshRegisterCurrent: function(name, index){
                    this.indexCurrent = index;
                    this.registerCurrent = this.schedules[this.indexCurrent];
                }

            },
            computed:{
                removeDefaultHours: function(){
                    var that = this;
                    this.data.filter(function(obj){
                        var index = that.defaultHours.indexOf(obj);
                        if(index > -1)
                            that.defaultHours.splice(index, 1);

                        return true;
                    });
                },

                schedules: function(){
                    return this.data.concat(this.defaultHours).sort(function(current, previous){
                        if(current.hour > previous.hour) return 1
                        if(current.hour < previous.hour) return -1
                        return 0;
                    });
                },

            },
        });

        new Vue({
            el: '#diaries',
            data: {
                data: {!! json_encode($diaries) !!}
            },
            methods:{},

        });

       
    </script>
@endpush