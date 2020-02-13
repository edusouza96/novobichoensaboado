@extends('layout.page')
@section('title') Dashboard @endsection

@section('content')
<div id="dashboard" class="ml-3 mr-3" v-cloak>
    <modal-contribute @failed="alertError" @contributed="contributed"></modal-contribute>
    <modal-bleed @failed="alertError" @bleeded="bleeded"></modal-bleed>
    <modal-open-cashdesk @failed="alertError" @opened="opened" :value="value"></modal-open-cashdesk>
    <modal-close-cashdesk @failed="alertError" @closed="closed"></modal-close-cashdesk>
    <modal-extract-day :key="reloadComponent"></modal-extract-day>
    <modal-money-transfer></modal-money-transfer>
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
                    <i class="fas fa-exclamation-triangle text-warning"></i> Caixas não fechado
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
            <button class="btn btn-dark btn-action-dashboard" data-toggle="modal" data-target="#modal-contribute" v-if="isOpen">Aporte</button>
        </div>
    </div>
    
    <div class="row mt-2">
        <div class="col-md-3 col-xs-12">
            <button class="btn btn-dark btn-action-dashboard" data-toggle="modal" data-target="#modal-bleed" v-if="isOpen">Sangria</button>
        </div>
    </div>
    
    <div class="row mt-2">
        <div class="col-md-3 col-xs-12">
            <button class="btn btn-dark btn-action-dashboard" data-toggle="modal" data-target="#modal-extract-day" @click="reload">Resumo do Dia</button>
        </div>
    </div>
    
    <div class="row mt-2">
        <div class="col-md-3 col-xs-12">
            <button class="btn btn-dark btn-action-dashboard" data-toggle="modal" data-target="#modal-money-transfer">Transferência</button>
        </div>
    </div>

    <div class="row mt-2 d-flex flex-row-reverse">
        <div class="col-md-4 col-xs-12">
            <div class="card mb-3">
                <div class="card-header text-center text-white bg-primary">
                    <i class="fas fa-dollar-sign text-warning"></i> Contas a Pagar
                </div>
                <div>
                    <table-outlay-to-pay type="last"></table-outlay-to-pay>
                    <table-outlay-to-pay type="today"></table-outlay-to-pay>
                    <table-outlay-to-pay type="tomorrow"></table-outlay-to-pay>
                   
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header text-center text-white bg-primary">
                    Poucos Produtos
                </div>
                <div>
                    <table-low-quantity></table-low-quantity>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-xs-12">
            <div class="card mb-3 text-center">
                <div class="card-header text-danger bg-dark">
                    <span>Blacklist</span>
                </div>
                <div class="card-body">
                    <table class="table" v-cloak>
                        <tbody>
                            <tr v-for="debitor in blacklist" :key="debitor.id">
                                <td>@{{debitor.owner}} - @{{debitor.pet}}</td>
                                <td>@{{debitor.phone}}</td>
                                <td>R$ @{{convertToBrPattern(debitor.value)}}</td>
                                <td>@{{showDateBr(debitor.date)}}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="btn-actions">
                                        <a :href="gotoDiary(debitor.date)" class="btn btn-primary btn-sm" target="_blank">Ver Agenda</a>
                                        <a :href="gotoPDV(debitor.id)" class="btn btn-dark btn-sm" target="_blank">Pagar</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>  
                </div>
            </div>
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
            blacklist: [],
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
            contributed(data){
                this.value = this.convertToBrPattern(data.value);
                this.alertSucess('Aporte Realizado!');
            },
            bleeded(data){
                this.value = this.convertToBrPattern(data.value);
                this.alertSucess('Sangria Realizada!');
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
            getBlacklist(){
                $.get(laroute.route('cashdesk.blacklist'))
                .done(function(data){
                    this.blacklist = data;
                }.bind(this));
            },
            reload(){
                this.reloadComponent = Math.floor(Math.random() * 101);
            },
            showDateBr(date){
                return moment(date, "YYYY-MM-DD HH:mm:ss").format('DD/MM/YYYY');
            },
            gotoPDV(id){
                return laroute.route('pdv.index', {id:id});
            },
            gotoDiary(date){
                return laroute.route('diary.index', {
                    date: moment(date, "YYYY-MM-DD HH:mm:ss").format('YYYY-MM-DD')
                });
            }
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
            this.getBlacklist();
        }

    });

</script>
@endpush