@extends('layout.page')
@section('title') Dashboard @endsection

@section('content')
<div id="dashboard" class="container" v-cloak>
    <modal-open-cashdesk @opened="opened"></modal-open-cashdesk>
    <modal-close-cashdesk></modal-close-cashdesk>
    <modal-extract-day></modal-extract-day>

    <button class="btn btn-success" data-toggle="modal" data-target="#modal-open-cashdesk" v-if="!isOpen">Abrir Caixa</button>

    <button class="btn btn-danger" data-toggle="modal" data-target="#modal-close-cashdesk" v-if="isOpen">Fechar Caixa</button>

    <button class="btn btn-primary" data-toggle="modal" data-target="#modal-extract-day">Extrato do Dia</button>
    @{{value}}
</div>
@endsection
@push('js-end')
<script>
    new Vue({
        el: '#dashboard',
        data: {
            value:null,
            isOpen: false,
        },
        methods:{
            opened(data){
                this.value = this.convertToBrPattern(data.value);
                this.isOpen = true;
            },
            convertToBrPattern(value){
                return parseFloat(value).toLocaleString('pt-BR', {minimumFractionDigits:2});
            },
        },
        created(){
            $.get(laroute.route('cashdesk.status')).done(function(data){
                this.isOpen = data.hasOwnProperty('value_start');
                this.value = this.convertToBrPattern(data.value_start);
            }.bind(this));
        }

    });

</script>
@endpush