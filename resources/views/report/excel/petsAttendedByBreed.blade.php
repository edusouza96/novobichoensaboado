
<table>
    <thead>
        <tr>
            <th scope="col">Raça</th>
            <th scope="col">Quantidade</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($report as $data)
            <tr>
                <td>{{ $data->name }}</td>
                <td>{{ $data->count }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Total atendidos</th>
            <th>{{ $report->sum('count') }}</th>
        </tr>
    </tfoot>
</table>

               