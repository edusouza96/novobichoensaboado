@extends('layout.page') 
@section('title') Editar @endsection
@php
    $edit = true;
@endphp
@section('form') 
<form method="POST" action="{{route('employeeSalary.update', $employeeSalary->getId())}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="card">
        <div class="card-header filter-header">Editar</div>
            <div class="card-body">
                @include('employeeSalary.form')
            </div>
        <div class="card-footer filter-footer">
            <a href="{{route('employeeSalary.index')}}" class="btn btn-secondary">
                <i class="fa fa-reply"></i> Voltar
            </a>

            <button class="btn btn-primary" type="submit">
                <i class="fa fa-save"></i> Salvar
            </button>
        </div>
    </div>
</form>
@endsection