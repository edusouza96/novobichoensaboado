@extends('layout.page')
@section('title') Ordem de Serviço @endsection

@section('content')
<div id="invoice" class="container">
    <div class="row text-center invoice-header">
        <div class="col-6 invoice-header-info-pet">
            <div class="invoice-header-info-pet-name">
                <h4>BICHO ENSABOADO</h4>
                <h5>Banho e Tosa</h5>
                <h5>PetShop</h5>
            </div>
            <div class="invoice-header-info-pet-phone">
                <p>Fone: (51) 3045-1898 / (51) 99575-1985</p>
            </div>
        </div>

        <div class="col-6 invoice-header-info-service">
            <div class="invoice-header-info-service-number">
                <p><strong>ORDEM DE SERVIÇO</strong> {{ $sale->getId() }}</p>
            </div>
            <div class="invoice-header-info-service-date">
                <p>Data {{ $sale->getDate() }}</p>
            </div>
        </div>
    </div>

    <div class="container invoice-identified">
        <div class="row invoice-owner">
            <div class="col-12 pt-4">
                <strong>Dono: </strong>
                {{ $sale->getOwnerName() }}
            </div>
        </div>
        <div class="row invoice-pet">
            <div class="col-12 pt-4">
                <strong>Pet: </strong>
                {!! $sale->getPetName() !!}
            </div>
        </div>
        <div class="row invoice-breed">
            <div class="col-12 pt-4">
                <strong>Raça: </strong>
                {!! $sale->getBreedName() !!}
            </div>
        </div>
    </div>

    <div class="invoice-description mt-2 table-responsive">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Unidades</th>
                    <th scope="col">Código</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Valor Unitario</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->getSaleItems() as $item)
                    <tr>
                        <th>{{ $item['units'] }}</th>
                        <td>{{ $item['barcode'] }}</td>
                        <td>{{ $item['description'] }}</td>
                        <td>{{ $item['unitaryValue_string'] }}</td>
                        <td>{{ $item['amountValue_string'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($sale->hasRebate())
        <div class="container invoice-payment">
            <div class="row">
                <div class="col-12 pt-4">
                    <strong>Desconto: </strong>
                    {!! $sale->getNameRebate() !!} - R$ {!! $sale->getValueRebate() !!}
                </div>
            </div>
        </div>
    @endif
    
    @for ($i = 0; $i < $sale->countPaymentMethods(); $i++)
        
        <div class="container invoice-payment">
            <div class="row">
                <div class="col-12 pt-4">
                    <strong>Método de Pagamento: </strong>
                    {!! $sale->getDescriptivePaymentMethod($i) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 pt-4">
                    <strong>Valor Recebido: </strong>
                    {{ $sale->getValueReceived($i) }}
                </div>
            </div>
            <div class="row">
                <div class="col-12 pt-4">
                    @if($sale->getLeftover($i) >= 0)
                        <strong>Troco: </strong>
                        {!! $sale->getLeftover($i) !!}
                    @else
                        <strong>Saldo devedor: </strong>
                        {!! $sale->getLeftover($i) !!}
                    @endif
                </div>
            </div>
        </div><br>
    @endfor

    <div class="row justify-content-end invoice-total">
        <div class="col-12 text-right"><strong>Total R$ {{ $sale->getTotal() }}</strong></div>
    </div>
</div>

<div class="container noprint">
    <div class="row float-right mt-3 mb-3">
        <div class="col-12">
            <a class="btn btn-primary ml-2" href="{{ route('dashboard.index') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a class="btn btn-primary ml-2" href="{{ route('diary.index') }}"><i class="far fa-calendar-alt"></i> Agenda</a>
            <button class="btn btn-success ml-2" type="button" onclick="window.print();"><i class="fas fa-print"></i> Imprimir</button>
        </div>
    </div>
</div>
@endsection
