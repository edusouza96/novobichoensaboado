<template>
  <div :id="modal_id" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pagar Despesa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <p><strong>Descrição: </strong>{{name}}</p>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="value">Valor</label>
                <input type="text" name="value" class="form-control" v-money="money" v-model="value" />
              </div>
            </div>

            <div class="col-md-12">
              <select-sources v-model="source" :store="store"></select-sources>
            </div>
            
            <div class="col-md-12">
              <div class="form-group">
                <label for="source">Data de Pagamento</label>
                <input type="date" name="date_pay" id="date_pay" class="form-control" v-model="datePay"/>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-success" data-dismiss="modal" @click="confirm()" :disabled="disabledConfirm">Confirmar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      name: null,
      value: null,
      source: "",
      money: {
        decimal: ",",
        thousands: "",
        precision: 2
      },
      datePay: moment().format("YYYY-MM-DD"),
    }
  },
  props: ['id', 'modal_id', 'store'],
  computed: {
    disabledConfirm() {
      return (this.source == "" || this.valueContribute == "0,00" || this.datePay == "");
    }
  },
  methods: {
    confirm() {
      $.post(laroute.route("outlay.pay"), {
        id: this.id,
        source: this.source,
        date_pay: this.datePay,
        value: this.convertToUsPattern(this.value),
      })
      .done(function(result) {
        location.reload(true);
      });
    },
    convertToUsPattern(value) {
      return value == undefined ? 0.0 : parseFloat(value.replace(",", "."));
    },
    getOutlay(){
      if(this.id){
        $.get(laroute.route("outlay.showJson", {id:this.id}))
        .done(function(outlay) {
          this.name = outlay.description;
          this.source = outlay.source_id;
          this.value = outlay.value;
          this.datePay = moment(outlay.date_pay, "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD");
        }.bind(this));
      }
    }
  },
  created(){
    this.getOutlay();
  }
};
</script>
