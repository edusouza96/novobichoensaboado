<div id='form'>
    <div class="row">
        <div class="col-8">
            <div class="form-group">
                <label for="user_id">Funcionario</label>
                <select name="user_id" id="user_id" class="form-control" v-model="user_id" required>
                    <option value>Selecione</option>
                    <option v-for="user in users" :value="user.id" :key="user.id">@{{ user.name }}</option>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="date_pay">Data do Pagamento</label>
                <input type="date" name="date_pay" id="date_pay" class="form-control" value="{{ request()->input('date_pay')}}" required>
            </div>
        </div> 
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="description">Descrição</label>
                <input type="text" name="description" class="form-control" required value="{{old('description', null)}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label for="source">Valor</label>
                <input type="text" name="value" id="value" class="form-control" v-money="money" value="{{old('value', null)}}">
            </div>
        </div>
        <div class="col-4">
            <select-sources v-model="sourceId" store="{{ auth()->user()->getStore()->getId() }}"></select-sources>
        </div>
    </div>
</div> 

<div class="row">
    <div class="col-3">
        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="salary_advance" name="salary_advance" value="1" {{$employeeSalary->isSalaryAdvance()}}>
                <label class="form-check-label" for="salary_advance">Adiantamento ?</label>
            </div>
        </div>
    </div>
</div>
{{-- "{{old('date_pay', $outlay->getDatePay())}}" != "" ? moment("{{old('date_pay', $outlay->getDatePay())}}", "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD") : moment().format("YYYY-MM-DD"), --}}
{{-- {{old('source', $outlay->source_id)}} --}}
@push('js-end')
    <script>
        new Vue({
            el: '#form',
            data: {
                users: [],
                user_id: "{{ request()->input('user_id') }}",
                money: {
                    decimal: ",",
                    thousands: "",
                    precision: 2
                },
                datePay: "",
                sourceId: "",
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