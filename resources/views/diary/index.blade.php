@extends('layout.page')

@section('title') Agenda @endsection

@section('content')




<div id="diaries">
   
    <div class="diary-table">
        <div class="diary-table-row-header">
            <div class="diary-table-cell-header" @click="plusRow">Hora</div>
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
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

    <script>
        Vue.component('d-table-row', {
            template: `
                <div>
                    <div v-for="(item, index) in data" class="diary-table-row-body" @click="plus(true)" >
                        <div class="diary-table-cell-body">08:00</div>
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
                plus: function(flag){
                    return this.showRow = flag;
                }
            },
            props:['data'],
            data: function() {
                return {
                    showRow: false
                }
            }
        });


        new Vue({
            el: '#diaries',
            data: {
                data: {!! json_encode($diaries) !!}
            },
            methods:{
                plusRow: function(){
                    this.data.push('mais um');
                    
                }   
            },
        });
    </script>
@endpush