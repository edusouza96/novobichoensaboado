@extends('layout.page') 
@section('title') Relatório - Balanço Financeiro @endsection
 
@section('content') 
    <div id="report" class="container">
        <div class="filter">
            <form method="GET">
                <div class="card">
                    <div class="card-header filter-header">Filtrar</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start">Periodo Inicial</label>
                                    <input type="date" name="start" id="start" class="form-control" value="{{ request()->input('start')}}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end">Periodo Final</label>
                                    <input type="date" name="end" id="end" class="form-control" value="{{ request()->input('end')}}">
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group">
                                    <label for="store_id">Loja</label>
                                    <select name="store_id" id="store_id" class="form-control" v-model="store_id">
                                        <option value>Selecione</option>
                                        <option v-for="store in stores" :value="store.id" :key="store.id">@{{ store.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer filter-footer">
                        <a href="{{route('report.financialStatement')}}" class="btn btn-secondary">
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
        <ul role="navigation" class="pagination">
            @foreach ($report->keys() as $date)
                <li @click="setDateFilter({{$date}})" :class="setClassMarked({{$date}})"> 
                    <a class="page-link">{{$date}}</a> 
                </li>
            @endforeach
        </ul>
          
        @if($report->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-sm table-striped" v-cloak>
                    <thead class="thead-primary">
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
                            <th scope="col">Máquina da Busca</th>
                            <th scope="col">Total de Saida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="data in reportByYear">
                            <th>@{{ data['period'] }}</th>
                            <td>R$ @{{ convertToBrPattern(data['sales_cash']) }}</td>
                            <td>R$ @{{ convertToBrPattern(data['sales_debit_card']) }}</td>
                            <td>R$ @{{ convertToBrPattern(data['sales_credit_card_1x']+data['sales_credit_card_2x']+data['sales_credit_card_3x']) }}</td>
                            <td class="bg-success text-light">R$ @{{ convertToBrPattern(data['sales_total']) }}</td>
                            <td>R$ @{{ convertToBrPattern(data['outlay_cash_drawer']) }}</td>
                            <td>R$ @{{ convertToBrPattern(data['outlay_safe_box']) }}</td>
                            <td>R$ @{{ convertToBrPattern(data['outlay_pagseguro']) }}</td>
                            <td>R$ @{{ convertToBrPattern(data['outlay_bank']) }}</td>
                            <td>R$ @{{ convertToBrPattern(data['delivery_fee']) }}</td>
                            <td class="bg-danger text-light">R$ @{{ convertToBrPattern(data['outlay_total']) }}</td>
                            
                        </tr>
                    </tbody>
                    <tfoot class="thead-dark">
                        <tr>
                            <th>Total</th>
                            <th>R$ @{{ convertToBrPattern(sumSalesCash) }}</th>
                            <th>R$ @{{ convertToBrPattern(sumSalesDebitCard) }}</th>
                            <th>R$ @{{ convertToBrPattern(sumSalesCreditCard) }}</th>
                            <th class="bg-success text-light">R$ @{{ convertToBrPattern(sumSalesTotal) }}</th>
                            <th>R$ @{{ convertToBrPattern(sumOutlayCashDrawer) }}</th>
                            <th>R$ @{{ convertToBrPattern(sumOutlaySafeBox) }}</th>
                            <th>R$ @{{ convertToBrPattern(sumOutlayPagseguro) }}</th>
                            <th>R$ @{{ convertToBrPattern(sumOutlayBank) }}</th>
                            <th>R$ @{{ convertToBrPattern(sumDeliveryFee) }}</th>
                            <th class="bg-danger text-light">R$ @{{ convertToBrPattern(sumOutlayTotal) }}</th>
                        </tr>
                    </tfoot>
                </table>

                <div class="container">
                    <div class="mt-4 row justify-content-end">
                        <div class="col-2 text-right">
                            <a href="{{route('report.financialStatementExcel', request()->input())}}" class="btn btn-success" type="submit">
                                <i class="fas fa-file-excel"></i> Gerar Planilha
                            </a>
                        </div>
                        
                        <div class="col-2 text-right">
                            <modal-chart-financial-statement title="Balanço financeiro" route="report.financialStatementChart" :param="param"></modal-chart-financial-statement>
                            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal-chart-bar">
                                <i class="fas fa-chart-pie"></i> Gerar Gráfico
                            </button>
                        </div>
                    </div>
                </div>

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
            el: '#report',
            data:{
                param: @json(request()->input()),
                stores:[],
                store_id: "{{ request()->input('store_id') }}",
                report: @json($report),
                dateFilter: "{{ $report->keys()->first() }}",
                sumSalesCash: 0.00,
                sumSalesDebitCard: 0.00,
                sumSalesCreditCard: 0.00,
                sumSalesTotal: 0.00,
                sumOutlayCashDrawer: 0.00,
                sumOutlaySafeBox: 0.00,
                sumOutlayPagseguro: 0.00,
                sumDeliveryFee: 0.00,
                sumOutlayBank: 0.00,
                sumOutlayTotal: 0.00,

            },
            methods:{
                getStores(){
                    $.get(laroute.route("store.allOptions"))
                    .done(function(data) {
                        this.stores = data;
                    }.bind(this));
                },
                setDateFilter(date){
                    this.dateFilter = date;
                },
                setClassMarked(date){
                    return (this.dateFilter == date) 
                        ? 'page-item active' 
                        : 'page-item';
                },
                convertToBrPattern(value) {
                    return parseFloat(value).toLocaleString("pt-BR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                },
                calcSumOfYear() {
                    this.sumSalesCash = 0.00;
                    this.sumSalesDebitCard = 0.00;
                    this.sumSalesCreditCard = 0.00;
                    this.sumSalesTotal = 0.00;
                    this.sumOutlayCashDrawer = 0.00;
                    this.sumOutlaySafeBox = 0.00;
                    this.sumOutlayPagseguro = 0.00;
                    this.sumDeliveryFee = 0.00;
                    this.sumOutlayBank = 0.00;
                    this.sumOutlayTotal = 0.00;

                    this.reportByYear.forEach(data => {
                        this.sumSalesCash += data.sales_cash;
                        this.sumSalesDebitCard += data.sales_debit_card;
                        this.sumSalesCreditCard += data.sales_credit_card_1x + data.sales_credit_card_2x + data.sales_credit_card_3x;
                        this.sumSalesTotal += data.sales_total;
                        this.sumOutlayCashDrawer += data.outlay_cash_drawer;
                        this.sumOutlaySafeBox += data.outlay_safe_box;
                        this.sumOutlayPagseguro += data.outlay_pagseguro;
                        this.sumDeliveryFee += data.delivery_fee;
                        this.sumOutlayBank += data.outlay_bank;
                        this.sumOutlayTotal += data.outlay_total;
                    });
                }
            },
            computed: {
                reportByYear(){
                    return this.report[this.dateFilter];
                }
            },
            watch:{
                reportByYear(){
                    this.calcSumOfYear();
                }
            },
            created(){
                this.getStores();
            },
            mounted(){
                this.calcSumOfYear();
            }
        });
    </script>
@endpush
