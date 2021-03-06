@extends('layout.page') 
@section('title') Editar @endsection
 
@section('form') 
<form method="POST" action="{{route('user.update', $user->getId())}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="card">
        <div class="card-header filter-header">Editar</div>
            <div class="card-body">
                @include('user.form')
            </div>
        <div class="card-footer filter-footer">
            <a href="{{route('user.index')}}" class="btn btn-secondary">
                <i class="fa fa-reply"></i> Voltar
            </a>

            <button class="btn btn-primary" type="submit">
                <i class="fa fa-save"></i> Salvar
            </button>
        </div>
    </div>
</form>
@endsection