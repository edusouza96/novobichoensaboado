<template>
  <div id="modal-close-cashdesk" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Fechar Caixa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">

            <div class="col-md-12">
              <div class="form-group">
                <label for="value_withdraw">Valor a Retirar</label>
                <input type="text" name="value_withdraw" id="value_withdraw" class="form-control" v-money="money" v-model="valueWithdraw">
              </div>
            </div>
            
            <div class="col-md-12">
              <div class="form-group">
                <label for="closing_date">Data do Fechamento</label>
                <input type="date" name="closing_date" id="closing_date" class="form-control" v-model="closingDate">
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label for="source">Fonte</label>
                <select name="source" id="source" class="form-control" v-model="source">
                    <option value="">Selecione</option>
                    <option value="1">Cofre</option>
                </select>
              </div>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-success" data-dismiss="modal">Confirmar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
        valueWithdraw:null, 
        source:'', 
        closingDate: moment().format('YYYY-MM-DD'),
        money:{
            decimal: ',',
            thousands: '',
            precision: 2,
        }
    };
  },
  methods: {
    confirm(){
        // $.post(laroute.route("pdv.registerPayment"),{
        //     source: this.source,
        //     closingDate: this.closingDate,
        //     valueWithdraw: this.convertToUsPattern(this.valueWithdraw),
        // }).done((result)=> {
        //     console.log('done');

        // });
    },
    convertToUsPattern(value){
      return value == undefined ? 0.00 : parseFloat(value.replace(",", "."));
    },
  },
};
</script>
