@include('layout.header')

@if(session('alertType'))
    <div class="card-panel padding-5 {{ session('alertType') }}">
        <center>        
            {{ session('message') }}
        </center>
    </div>
@endif

@yield('content')

@include('layout.footer')
