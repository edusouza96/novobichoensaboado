<table>
    <thead>
        <tr>
            <th scope="col">Data</th>
            <th scope="col">N° da nota</th>
            <th scope="col">Descrição</th>
            <th scope="col">Valor total</th>
            <th scope="col">Loja</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($report as $data)
            <tr>
                <td>{{ $data->getCreatedAt()->format('d/m/Y') }}</td>
                <td>{{ $data->getNumerInvoice() }}</td>
                <td>{!! $data->getDescription() !!}</td>
                <td>R$ {{ number_format($data->getCalcValueTotal(), 2, ',', '.') }}</td>
                <td>{{ $data->store->getName() }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3"></th>
            <th>Total das Vendas</th>
            <th>R$ {{ number_format($report->sum('total'), 2, ',', '.') }}</th>
        </tr>
    </tfoot>
</table>
     