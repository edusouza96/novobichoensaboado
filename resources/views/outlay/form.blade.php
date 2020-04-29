<div id='form' v-cloak>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="description">Descrição</label>
                <input type="text" name="description" class="form-control" required value="{{old('name', $outlay->getDescription())}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label for="source">Valor</label>
                <input type="text" name="value" id="value" class="form-control" v-money="money" value="{{old('value', $outlay->getValue())}}">
            </div>
        </div>
        <div class="col-4">
            <select-sources v-model="sourceId" store="{{ auth()->user()->getStore()->getId() }}"></select-sources>
        </div>
        <div class="col-5">
            <div class="form-group">
                <label for="cost_center">Centro de Custo</label>
                <select name="cost_center" id="cost_center" class="form-control" required v-model="costCenterId">
                    <option value>Selecione</option>
                    <option v-for="cost in costCenters" :value="cost.id" :key="cost.id">@{{ cost.name }}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label for="date_pay">Data de Pagamento/Vencimento</label>
                <input type="date" name="date_pay" id="date_pay" class="form-control" v-model="datePay">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label for="store">Loja</label>
                <input type="text" value="{{ auth()->user()->getStore()->getName() }}" name="store" id="store" class="form-control" readonly>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="paid" name="paid" value="1" {{$outlay->statusPay()}}>
                    <label class="form-check-label" for="paid">Já esta pago</label>
                </div>
            </div>
        </div>
    </div>
</div> 

@push('js-end')
    <script>
        new Vue({
            el: '#form',
            data: {
                datePay: "{{old('date_pay', $outlay->getDatePay())}}" != "" ? moment("{{old('date_pay', $outlay->getDatePay())}}", "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD") : moment().format("YYYY-MM-DD"),
                money: {
                    decimal: ",",
                    thousands: "",
                    precision: 2
                },
                costCenters: [],
                costCenterId: "{{old('cost_center', $outlay->cost_center_id)}}",
                sourceId: "{{old('source', $outlay->source_id)}}",
            },
            methods:{
                getCostCenters(){
                    $.get(laroute.route("costCenter.allOptions"))
                    .done(function(data) {
                        this.costCenters = data;
                    }.bind(this));
                }
            },
            created(){
                this.getCostCenters();
            }
            
        });
    </script>
@endpush