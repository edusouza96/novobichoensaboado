@include('layout.header')

<div class="main">
    @if(session('alertType'))
        <div class="alert alert-{{ session('alertType') }} text-center" role="alert">
            {{ session('message') }}
        </div>
    @endif

    @yield('content')
    <div class="container">
        @yield('form')
    </div>
</div>

@include('layout.footer')