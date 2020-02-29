@include('layout.header')

<div class="main">
    @if(session('alertType'))
        <div class="alert alert-{{ session('alertType') }} text-center" role="alert">
            {{ session('message') }}
        </div>
    @endif

        
    @yield('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <p>Preencha corretamente os campos</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('form')
    </div>
</div>

@include('layout.footer')