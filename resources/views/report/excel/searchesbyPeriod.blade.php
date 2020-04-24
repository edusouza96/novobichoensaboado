<table>
    <thead>
        <tr>
            <th scope="col">Data/Hora</th>
            <th scope="col">Nome Pet</th>
            <th scope="col">Proprietario</th>
            <th scope="col">Bairro</th>
            <th scope="col">Forma de Pagamento</th>
            <th scope="col">Valor</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($report as $data)
            <tr>
                <td>{{ $data->getDateHour()->format('d/m/Y H:i') }}</td>
                <td>{{ $data->getClient()->getName() }}</td>
                <td>{{ $data->getClient()->getOwnerName() }}</td>
                <td>{{ $data->getClient()->getNeighborhood()->getName() }}</td>
                <td>
                    {{ 
                        $data->getSales()->isEmpty() 
                            ? ''
                            : (
                                $data->getSales()->first()->getSalePaymentMethod()->first()
                                    ? $data->getSales()->first()->getSalePaymentMethod()->first()->getDescription()
                                    : ''
                            )
                    }}

                <td>R$ {{ number_format($data->getDeliveryFee(), 2, ',', '.') }}</td>
                
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4"></th>
            <th>Total das buscas</th>
            <th>R$ {{ number_format($report->sum('delivery_fee'), 2, ',', '.') }}</th>
        </tr>
    </tfoot>
</table>
     