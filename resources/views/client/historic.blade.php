@extends('layout.page') 
@section('title') Historico @endsection
 

@section('content') 
    <div class="container">
        <div class="filter">
            <form method="GET">
                <div class="card">
                    <div class="card-header filter-header">Filtrar</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="start">Inicio</label>
                                    <input type="date" name="start" id="start" class="form-control" value="{{ request()->input('start')}}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="end">Fim</label>
                                    <input type="date" name="end" id="end" class="form-control" value="{{ request()->input('end')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer filter-footer">
                        <a href="{{route('client.historic', $client_id)}}" class="btn btn-secondary">
                            <i class="fa fa-eraser"></i> Limpar
                        </a>

                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <br><br>
        @if($historic->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-primary">
                        <tr>
                            <th scope="col">Data/Hora</th>
                            <th scope="col">Serviço PET</th>
                            <th scope="col">Serviço VET</th>
                            <th scope="col">Checkin</th>
                            <th scope="col">Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($historic as $diary)
                            <tr>
                                <td>{{ $diary->getDateHour()->format('d/m/Y H:i') }}</td>
                                <td>{{ $diary->getServicePet()? $diary->getServicePet()->getName() : '' }}</td>
                                <td>{{ $diary->getServiceVet()? $diary->getServiceVet()->getName() : '' }}</td>
                                <td>{{ $diary->getCheckinHour() }}</td>
                                <td>{{ $diary->getObservation() }}</td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right mt-4 mr-5"><strong>Total de registros: {{$historic->total()}}</strong></div>
                <div>{{$historic->appends(request()->query())->links()}}</div>
            </div>
        @else
            <div class="alert alert-info text-center" role="alert">
                <h6>Nenhum resultado encontrado.</h6>
            </div>
        @endif
    </div>
@endsection
