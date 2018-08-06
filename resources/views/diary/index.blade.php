@extends('layout.page')

@section('title') Agenda @endsection

@section('content')




<div id="diaries">

    <div class="diary-table">
        <div class="diary-table-row-header">
            <div class="diary-table-cell-header">Hora</div>
            <div class="diary-table-cell-header">Nome do Pet</div>
            <div class="diary-table-cell-header">Raça</div>
            <div class="diary-table-cell-header">Proprietário</div>
            <div class="diary-table-cell-header">Busca</div>
            <div class="diary-table-cell-header">Endereço</div>
            <div class="diary-table-cell-header">Bairro</div>
            <div class="diary-table-cell-header">Telefone 1</div>
            <div class="diary-table-cell-header">Telefone 2</div>
            <div class="diary-table-cell-header">Serviço</div>
            <div class="diary-table-cell-header">Valor</div>
            <div class="diary-table-cell-header">Taxa de Entrega</div>
            <div class="diary-table-cell-header">Total</div>
            <div class="diary-table-cell-header">Ações</div>
        </div>
    </div>
    <d-table-row :data="data"></d-table-row>

</div>

@endsection


@push('js-end')
    <script>
        Vue.component('d-table-row', {
            template: `
                <div>
                    <div v-for="(register, index) in schedules" class="diary-table-row-body">
                        <div class="diary-table-cell-body cursor-pointer" @click="plus(register)" title="Clique para adicionar uma linha"> 
                            @{{register.hour}}
                        </div>
                       
                        <div class="diary-table-cell-body">
                            <input type="text" name="name" v-model="register.client.name">
                        </div>
                        
                        <div class="diary-table-cell-body">
                            <input type="text" name="breed" v-model="register.client.breed">
                        </div>
                        
                        <div class="diary-table-cell-body">
                            <input type="text" name="owner" v-model="register.client.owner">
                        </div>
                        
                        <div class="diary-table-cell-body">
                            <span v-if="register.fetch == 1">
                                <input type="checkbox" class="filled-in" :id="index" checked="checked"/>
                                <label :for="index"></label>
                            </span>
                            <span v-else>
                                <input type="checkbox" class="filled-in" :id="index"/>
                                <label :for="index"></label>
                            </span>                            
                        </div>
                        
                        <div class="diary-table-cell-body">
                            <input type="text" name="address" v-model="register.client.address">
                        </div>
                        
                        <div class="diary-table-cell-body">
                            <input type="text" name="neighborhood" v-model="register.client.neighborhood">
                        </div>
                        
                        <div class="diary-table-cell-body">
                            <input type="text" name="phone1" v-model="register.client.phone1">
                        </div>
                        
                        <div class="diary-table-cell-body">
                            <input type="text" name="phone2" v-model="register.client.phone2">
                        </div>
                        
                        <div class="diary-table-cell-body">
                            <input type="text" name="service" v-model="register.service.name">
                        </div>
                        
                        <div class="diary-table-cell-body">
                            <input type="text" name="value" v-model="register.value">
                        </div>
                        
                        <div class="diary-table-cell-body">
                            <input type="text" name="delivery_fee" v-model="register.deliveryFee">
                        </div>
                        
                        <div class="diary-table-cell-body">
                            <input type="text" name="gross" v-model="register.gross">
                        </div>
                        
                        <div class="diary-table-cell-body">
                            <a @click="save()"><i class="fas fa-check"></i></a>
                        </div>
                    
                    </div>
                </div>

            `,
            
            methods:{
                plus: function(hour){
                    this.data.push(hour);
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
                }
            },
            props:['data'],
            data: function() {
                return {
                    showRow: false,
                    defaultHours: [
                        {'hour':'08:00', 'client': {}, 'service': {} }, 
                        {'hour':'08:30', 'client': {}, 'service': {} },
                        {'hour':'09:00', 'client': {}, 'service': {} }, 
                        {'hour':'09:30', 'client': {}, 'service': {} }, 
                        {'hour':'10:00', 'client': {}, 'service': {} }, 
                        {'hour':'10:30', 'client': {}, 'service': {} }, 
                        {'hour':'11:00', 'client': {}, 'service': {} }, 
                        {'hour':'11:30', 'client': {}, 'service': {} }, 
                        {'hour':'12:00', 'client': {}, 'service': {} }, 
                        {'hour':'12:30', 'client': {}, 'service': {} },
                        {'hour':'13:00', 'client': {}, 'service': {} }, 
                        {'hour':'13:30', 'client': {}, 'service': {} },
                        {'hour':'14:00', 'client': {}, 'service': {} }, 
                        {'hour':'14:30', 'client': {}, 'service': {} }, 
                        {'hour':'15:00', 'client': {}, 'service': {} }, 
                        {'hour':'15:30', 'client': {}, 'service': {} }, 
                        {'hour':'16:00', 'client': {}, 'service': {} }, 
                        {'hour':'16:30', 'client': {}, 'service': {} }, 
                        {'hour':'17:00', 'client': {}, 'service': {} }, 
                        {'hour':'17:30', 'client': {}, 'service': {} },
                    ],
                }
            }
        });

        new Vue({
            el: '#diaries',
            data: {
                data: {!! json_encode($diaries) !!}
            },
            
        });
    </script>
@endpush