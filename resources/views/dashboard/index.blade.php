@extends('layout.page')
@section('title') Dashboard @endsection

@section('content')
<div id="dashboard" class="ml-3 mr-3" v-cloak>
    <modal-open-cashdesk @failed="alertError" @opened="opened" :value="value"></modal-open-cashdesk>
    <modal-close-cashdesk @failed="alertError" @closed="closed"></modal-close-cashdesk>
    <modal-extract-day :key="reloadComponent"></modal-extract-day>
    <alert-message :title="titleAlertMessage" text="" :type="typeAlertMessage" :active="showAlert" @active="showAlert=$event"></alert-message>

    <div class="row justify-content-between">
        <div class="col-md-3 col-xs-12">
            <div class="card mb-3 text-center">
                <div class="card-header text-white bg-primary">
                    <span >Valor em Caixa</span>
                </div>
                <div class="card-body">
                    <p class="card-text">R$ @{{value}}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xs-12">
            <div class="card mb-3 text-center" v-if="hasInconsistencyUnfinishedCashdesk">
                <div class="card-header text-white bg-primary">
                    <i class="fas fa-exclamation-triangle text-warning"></i> Inconsistencias
                </div>
                <div>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Data</th>
                                <th>Valor Inicial</th>
                                <th>Loja</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            <tr v-for="inconsistency in inconsistencyUnfinishedCashdesk" :key="inconsistency.id">
                                <td>@{{showDateBr(inconsistency.date_hour)}}</td>
                                <td>R$ @{{convertToBrPattern(inconsistency.value_start)}}</td>
                                <td>@{{inconsistency.store_id}}</td>
                            </tr>
                        </tbody>
                    </table>  
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-2">
        <div class="col-md-3 col-xs-12">
            <button class="btn btn-success btn-action-dashboard" data-toggle="modal" data-target="#modal-open-cashdesk" v-if="!isOpen">Abrir Caixa</button>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-3 col-xs-12">
            <button class="btn btn-danger btn-action-dashboard" data-toggle="modal" data-target="#modal-close-cashdesk" v-if="isOpen">Fechar Caixa</button>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-3 col-xs-12">
            <button class="btn btn-dark btn-action-dashboard" data-toggle="modal" data-target="#modal-extract-day" @click="reload">Resumo do Dia</button>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-3 col-xs-12">
            <button class="btn btn-dark btn-action-dashboard" data-toggle="modal" data-target="#modal-loading">teste</button>
        </div>
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
            reloadComponent: '1',
            showAlert: false,
            titleAlertMessage: "",
            typeAlertMessage: "",
        },
        methods:{
            opened(data){
                this.value = this.convertToBrPattern(data.value);
                this.isOpen = true;
                this.alertSucess('Caixa Aberto!');
            },
            alertSucess(title){
                this.typeAlertMessage = 'success';
                this.titleAlertMessage = title;
                this.showAlert = true;
            },
            alertError(message){
                console.log(message);
                this.typeAlertMessage = 'error';
                this.titleAlertMessage = 'Ocorreu um erro, tente novamente!';
                this.showAlert = true;
            },
            closed(data){
                this.value = this.convertToBrPattern(data.value);
                this.isOpen = false;
                this.alertSucess('Caixa Fechado!');
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
            },
            showDateBr(date){
                return moment(date, "YYYY-MM-DD HH:mm:ss").format('DD/MM/YYYY');
            },
        },
        computed: {
            hasInconsistencyUnfinishedCashdesk() {
                return this.inconsistencyUnfinishedCashdesk.length > 0;
            },
        },
        created(){
            this.checkStatus();
            this.getCashDrawer();
            this.getInconsistencyUnfinishedCashdesk();
        }

    });

</script>
@endpush