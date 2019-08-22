@extends('layout.page')
@section('title') Dashboard @endsection

@section('content')
<div id="dashboard" class="container" v-cloak>
    <modal-open-cashdesk></modal-open-cashdesk>
    <modal-close-cashdesk></modal-close-cashdesk>
    <modal-extract-day></modal-extract-day>

    <button class="btn btn-success" data-toggle="modal" data-target="#modal-open-cashdesk">Abrir Caixa</button>

    <button class="btn btn-danger" data-toggle="modal" data-target="#modal-close-cashdesk">Fechar Caixa</button>

    <button class="btn btn-primary" data-toggle="modal" data-target="#modal-extract-day">Extrato do Dia</button>
</div>
@endsection
@push('js-end')
<script>
    new Vue({
        el: '#dashboard',
        data: {
        },
        methods:{
        },

    });

</script>
@endpush