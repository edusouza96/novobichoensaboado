@include('layout.header')

<div class="main">
    @if(session('alertType'))
        <div class="alert alert-{{ session('alertType') }}" role="alert">
            {{ session('message') }}
        </div>
    @endif

    @yield('content')
</div>

@include('layout.footer')