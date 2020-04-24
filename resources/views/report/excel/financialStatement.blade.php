<table>
    <thead>
        <tr>
            <th scope="col">Periodo</th>
            <th scope="col">Dinheiro</th>
            <th scope="col">Cartão de Débito</th>
            <th scope="col">Cartão de Crédito</th>
            <th scope="col">Total de Entrada</th>
            <th scope="col">Gaveta</th>
            <th scope="col">Cofre</th>
            <th scope="col">PagSeguro</th>
            <th scope="col">Banco</th>
            <th scope="col">Total de Saida</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($report as $data)
            <tr>
                <td>{{ $data['period'] }}</td>
                <td>R$ {{ number_format($data['sales_cash'], 2, ',', '.') }}</td>
                <td>R$ {{ number_format($data['sales_debit_card'], 2, ',', '.') }}</td>
                <td>R$ {{ number_format(
                    ($data['sales_credit_card_1x']+$data['sales_credit_card_2x']+$data['sales_credit_card_3x'])
                    , 2, ',', '.') }}</td>
                <td>R$ {{ number_format($data['sales_total'], 2, ',', '.') }}</td>
                <td>R$ {{ number_format($data['outlay_cash_drawer'], 2, ',', '.') }}</td>
                <td>R$ {{ number_format($data['outlay_safe_box'], 2, ',', '.') }}</td>
                <td>R$ {{ number_format($data['outlay_pagseguro'], 2, ',', '.') }}</td>
                <td>R$ {{ number_format($data['outlay_bank'], 2, ',', '.') }}</td>
                <td>R$ {{ number_format($data['outlay_total'], 2, ',', '.') }}</td>
                
            </tr>
        @endforeach
    </tbody>
</table>
     