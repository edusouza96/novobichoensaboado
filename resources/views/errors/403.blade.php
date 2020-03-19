@extends('layout.page')


@section('content')
<div class="flex-center position-ref full-height">
    <div class="code">
        <img class="" src="{{ asset('img/403.jpg') }}" style="width: 10em;">
    </div>

    <div class="message" style="padding: 10px;">
       Você não possui permissão para esta página.
    </div>
</div>
@endsection

<style>
    html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 100;
        height: 100vh;
        margin: 0;
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .code {
        border-right: 2px solid;
        font-size: 26px;
        padding: 0 15px 0 15px;
        text-align: center;
    }

    .message {
        font-size: 18px;
        text-align: center;
    }
</style>