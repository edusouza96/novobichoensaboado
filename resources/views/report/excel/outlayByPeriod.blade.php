
<table>
    <thead>
        <tr>
            <th scope="col">Data Pagamento</th>
            <th scope="col">Descrição</th>
            <th scope="col">Fonte</th>
            <th scope="col">Centro de Custo</th>
            <th scope="col">Valor</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($report as $data)
            <tr>
                <td>{{ $data->getDatePay()->format('d/m/Y') }}</td>
                <td>{{ $data->getDescription() }}</td>
                <td>{{ $data->getSource()->getDisplay() }}</td>
                <td>{{ $data->getCostCenter()->getName() }}</td>
                <td>R$ {{ number_format($data->getValue(), 2, ',', '.') }}</td>
                
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3"></th>
            <th>Total das buscas</th>
            <th>R$ {{ number_format($report->sum('value'), 2, ',', '.') }}</th>
        </tr>
    </tfoot>
</table>

               