@extends('layout.page')
@section('title') Dashboard @endsection

@section('content')
<div id="dashboard" class="container" v-cloak>
    <modal-open-cashdesk @opened="opened" :value="value"></modal-open-cashdesk>
    <modal-close-cashdesk @closed="closed"></modal-close-cashdesk>
    <modal-extract-day :key="reloadComponent"></modal-extract-day>

    <div class="row">
        <div class="card mb-3 text-center" style="max-width: 10rem;">
            <div class="card-header text-white bg-primary">Valor em Caixa</div>
            <div class="card-body">
            <p class="card-text">R$ @{{value}}</p>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="card mb-3 text-center" style="max-width: 10rem;">
            <div class="card-header text-white bg-primary">Inconsistencias</div>
            <div class="card-body">
            <p class="card-text" v-for="inconsistency in inconsistencyUnfinishedCashdesk">@{{inconsistency.date_hour}}</p>
            </div>
        </div>
    </div>
     
    <div class="row">
        <button class="btn btn-success btn-action-dashboard" data-toggle="modal" data-target="#modal-open-cashdesk" v-if="!isOpen">Abrir Caixa</button>
    </div>

    <div class="row">
        <button class="btn btn-danger btn-action-dashboard" data-toggle="modal" data-target="#modal-close-cashdesk" v-if="isOpen">Fechar Caixa</button>
    </div>

    <div class="row">
        <button class="btn btn-primary btn-action-dashboard" data-toggle="modal" data-target="#modal-extract-day" @click="reload">Resumo do Dia</button>
    </div>
    
</div>
@endsection
@push('js-end')
<script>
    new Vue({
        el: '#dashboard',
        data: {
            value:null,
            isOpen: false,
            inconsistencyUnfinishedCashdesk: [],
            reloadComponent: '1'
        },
        methods:{
            opened(data){
                this.value = this.convertToBrPattern(data.value);
                this.isOpen = true;
            },
            closed(data){
                this.value = this.convertToBrPattern(data.value);
                this.isOpen = false;
            },
            convertToBrPattern(value){
                return parseFloat(value).toLocaleString('pt-BR', {minimumFractionDigits:2});
            },
            checkStatus(){
                $.get(laroute.route('cashdesk.status')).done(function(data){
                    this.isOpen = data.hasOwnProperty('value_start');
                }.bind(this));
            },
            getCashDrawer(){
                $.get(laroute.route('cashdesk.getCashDrawer')).done(function(data){
                    this.value = this.convertToBrPattern(data.value);
                }.bind(this));
            },
            getInconsistencyUnfinishedCashdesk(){
                $.get(laroute.route('cashdesk.inconsistencyUnfinishedCashdesk'))
                .done(function(data){
                    this.inconsistencyUnfinishedCashdesk = data;
                }.bind(this));
            },
            reload(){
                this.reloadComponent = Math.floor(Math.random() * 101);
            }
        },
        created(){
            this.checkStatus();
            this.getCashDrawer();
            this.getInconsistencyUnfinishedCashdesk();
        }

    });

</script>
@endpush