@extends('layout.page') 
@section('title') Cadastrar @endsection
 
@section('form') 
<form method="POST" action="{{route('product.store')}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="card">
        <div class="card-header filter-header">Cadastrar</div>
            <div class="card-body">
                @include('product.form')
            </div>
        <div class="card-footer filter-footer">
            <a href="{{route('product.index')}}" class="btn btn-secondary">
                <i class="fa fa-reply"></i> Voltar
            </a>

            <button class="btn btn-primary" type="submit">
                <i class="fa fa-save"></i> Salvar
            </button>
        </div>
    </div>
</form>
@endsection