@extends('layout.page') 
@section('title') Funcionarios - Pagamento/Adiantamento @endsection
 
@section('content') 
    <div id="employeeSalary" class="container">
        <div class="text-right mb-3">
            <a href="{{route('employeeSalary.create')}}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Cadastrar
            </a>
        </div>

        <div class="filter">
            <form method="GET">
                <div class="card">
                    <div class="card-header filter-header">Filtrar</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="user_id">Funcionario</label>
                                    <select name="user_id" id="user_id" class="form-control" v-model="user_id">
                                        <option value>Selecione</option>
                                        <option v-for="user in users" :value="user.id" :key="user.id">@{{ user.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start">Data Inicial</label>
                                    <input type="date" name="start" id="start" class="form-control" value="{{ request()->input('start')}}">
                                </div>
                            </div>    
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end">Data Final</label>
                                    <input type="date" name="end" id="end" class="form-control" value="{{ request()->input('end')}}">
                                </div>
                            </div>    
                            
                        </div>
                    </div>
                    <div class="card-footer filter-footer">
                        <a href="{{route('employeeSalary.index')}}" class="btn btn-secondary">
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
        @if($employeeSalaries->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-primary">
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Data</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Tipo</th>
                            <th scope="col" width="5%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeSalaries as $employeeSalary)
                            <tr>
                                <td>{{ $employeeSalary->getUsers()->getName() }}</td>
                                <td>{{ $employeeSalary->getOutlays()->getDatePay()->format('d/m/Y') }}</td>
                                <td>R$ {{ number_format($employeeSalary->getOutlays()->getValue(), 2, ',', '.') }}</td>
                                <td>{{ $employeeSalary->getOutlays()->getDescription() }}</td>
                                <td>{{ $employeeSalary->isSalaryAdvance() ? "Adiantamento" : "Sálario" }}</td>
                                <td>
                                    <a href="{{route('employeeSalary.edit', $employeeSalary->getId())}}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right mt-4 mr-5"><strong>Total de registros: {{$employeeSalaries->total()}}</strong></div>
                <div>{{$employeeSalaries->appends(request()->query())->links()}}</div>
            </div>
        @else
            <div class="alert alert-info text-center" role="alert">
                <h6>Nenhum resultado encontrado.</h6>
            </div>
        @endif
    </div>
@endsection

@push('js-end')
    <script>
        new Vue({
            el: '#employeeSalary',
            data: {
                users: [],
                user_id: "{{ request()->input('user_id') }}",
            },
            methods:{
                getEmployeeUsers(){
                    $.get(laroute.route("user.allEmployeeUsers"))
                    .done(function(data) {
                        this.users = data;
                    }.bind(this));
                },
            },
            created(){
                this.getEmployeeUsers();
            }
           
        });
    </script>
@endpush