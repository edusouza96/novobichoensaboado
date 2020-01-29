<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Imprimir Código de Barras</title>
        <link rel="icon" type="image/png" href="{{ asset('img/logo.jpg') }}" />
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
        <script src="{{ asset('js/laroute.js') }}"></script>
    </head>

    <body>
       
        <div class="text-right mt-3 mr-5 noprint">
            <a href="{{route('product.index')}}" class="btn btn-secondary">
                <i class="fa fa-reply"></i> Voltar
            </a>
            <button class="btn btn-primary text-left" onclick="window.print();"> 
                <i class="fas fa-print"></i> Imprimir
            </button>
        </div>
        <div class="container">
            <div class="row">
                @for ($i = 0; $i < $count; $i++)
                    <div class="col-4 mt-5">
                        {!! DNS1D::getBarcodeSVG($product->getBarcode(), "C128", 2.5, 90, true) !!}
                    </div>
                @endfor
            </div>
        </div>  

        <script src="{{ asset('js/app.js') }}" charset="utf-8"></script>
    </body> 
</html>
