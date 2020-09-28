@extends('layout.page')
@section('title') Dashboard @endsection

@section('content')
<div class="alert alert-info text-center" role="alert">
    Loja: {{auth()->user()->getStore()->getName()}}
</div> 

<div id="dashboard" class="ml-3 mr-3" v-cloak>
    <modal-contribute :store="'{{auth()->user()->getStore()->getId()}}'" @failed="alertError" @contributed="contributed"></modal-contribute>
    <modal-bleed :store="'{{auth()->user()->getStore()->getId()}}'" @failed="alertError" @bleeded="bleeded"></modal-bleed>
    <modal-open-cashdesk @failed="alertError" @opened="opened" :value="value" :store="'{{auth()->user()->getStore()->getId()}}'" :is-admin="'{{auth()->user()->canSeeAdministrativePage()}}'"></modal-open-cashdesk>
    <modal-close-cashdesk @failed="alertError" @closed="closed" :closing-date="closingDate" :store="'{{auth()->user()->getStore()->getId()}}'"></modal-close-cashdesk>
    <modal-extract-day @closecashdesk="closeCashdesk" :_key="reloadComponent" :key="reloadComponent"></modal-extract-day>
    <modal-money-transfer :store="'{{auth()->user()->getStore()->getId()}}'" @finish="getCashDrawer"></modal-money-transfer>
    <alert-message :title="titleAlertMessage" text="" :type="typeAlertMessage" :active="showAlert" @active="showAlert=$event"></alert-message>

    <div class="row justify-content-between">
        <div class="col-md-3 col-xs-12">
            
            <div class="row">
                <div class="col-md-12">
                    <show-value-cashdesk :value="value"></show-value-cashdesk>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12">
                    <button class="btn btn-success btn-action-dashboard" data-toggle="modal" data-target="#modal-open-cashdesk" v-if="!isOpen">Abrir Caixa</button>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12">
                    <button class="btn btn-danger btn-action-dashboard" data-toggle="modal" data-target="#modal-extract-day" v-if="isOpen" @click="reload()">Fechar Caixa</button>
                </div>
            </div>
            
            @if(auth()->user()->canSeeAdministrativePage())
            <div class="row mt-2">
                <div class="col-md-12">
                    <button class="btn btn-dark btn-action-dashboard" data-toggle="modal" data-target="#modal-contribute" v-if="isOpen">Aporte</button>
                </div>
            </div>
            
            <div class="row mt-2">
                <div class="col-md-12">
                    <button class="btn btn-dark btn-action-dashboard" data-toggle="modal" data-target="#modal-bleed" v-if="isOpen">Sangria</button>
                </div>
            </div>
            
            <div class="row mt-2">
                <div class="col-md-12">
                    <button class="btn btn-dark btn-action-dashboard" data-toggle="modal" data-target="#modal-money-transfer">Transferência</button>
                </div>
            </div>
            @endif

            <div class="row mt-2">
                <div class="col-md-12">
                    <button class="btn btn-dark btn-action-dashboard" data-toggle="modal" data-target="#modal-extract-day" @click="reload">Extrato do Caixa</button>
                </div>
            </div>

        </div>

        <div class="col-md-4 col-xs-12">
            <inconsistency-unfinished-cashdesk @close="closingDate = $event" :key="reloadComponent"></inconsistency-unfinished-cashdesk>
        </div>
    </div>
 

    <div class="row justify-content-between mt-5">
        
        <div class="col-md-8 col-xs-12">
            <table-blacklist></table-blacklist>
        </div>

        <div class="col-md-4 col-xs-12">
            <div class="row">
                <div class="col-md-12">
                    <show-outlay-to-pay :store="'{{auth()->user()->getStore()->getId()}}'"></show-outlay-to-pay>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table-low-quantity></table-low-quantity>
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
            reloadComponent: '0',
            showAlert: false,
            titleAlertMessage: "",
            typeAlertMessage: "",
            closingDate:null,
        },
        methods:{
            setDateCurrent(){
                this.closingDate = moment().format("YYYY-MM-DD");
            },
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
            closeCashdesk(){
                this.setDateCurrent();
                $("#modal-close-cashdesk").modal();
            },
            closed(data){
                this.value = this.convertToBrPattern(data.value);
                if(data.ofDay) this.isOpen = false;
                this.alertSucess('Caixa Fechado!');
                this.reload();
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
            reload(){
                this.reloadComponent = Math.floor(Math.random() * 101);
            },
        },
        created(){
            this.checkStatus();
            this.getCashDrawer();
        }

    });

</script>
@endpush