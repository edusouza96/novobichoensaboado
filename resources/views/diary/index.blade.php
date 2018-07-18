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
                    <div v-for="(item, index) in schedules" class="diary-table-row-body">
                        <div class="diary-table-cell-body" @click="plus(item)" > @{{item}} </div>
                        <div class="diary-table-cell-body"><input placeholder="Placeholder" type="text" name="name"></div>
                        <div class="diary-table-cell-body"><input type="text" name="breed"></div>
                        <div class="diary-table-cell-body"><input type="text" name="owner"></div>
                        <div class="diary-table-cell-body"><input type="text" name="fetch"></div>
                        <div class="diary-table-cell-body"><input type="text" name="address"></div>
                        <div class="diary-table-cell-body"><input type="text" name="neighborhood"></div>
                        <div class="diary-table-cell-body"><input type="text" name="phone1"></div>
                        <div class="diary-table-cell-body"><input type="text" name="phone2"></div>
                        <div class="diary-table-cell-body"><input type="text" name="service"></div>
                        <div class="diary-table-cell-body"><input type="text" name="value"></div>
                        <div class="diary-table-cell-body"><input type="text" name="delivery_fee"></div>
                        <div class="diary-table-cell-body"><input type="text" name="gross"></div>
                        <div class="diary-table-cell-body"><button>Agendar</button></div>
                    
                    </div>
                </div>

            `,
            
            methods:{
                plus: function(hour){
                    this.data.push(hour);
                }, 
                
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
                    return this.data.concat(this.defaultHours).sort();
                }
            },
            props:['data'],
            data: function() {
                return {
                    showRow: false,
                    defaultHours: [
                        '08:00', '08:30','09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30',
                        '13:00', '13:30','14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30',
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