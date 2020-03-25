<template>
  <div id="modal-money-transfer" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tranferência</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="value">Valor a Tranferir</label>
                  <input type="text" name="value" id="value" class="form-control" v-money="money" v-model="value" />
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label for="origin">Origem</label>
                  <select name="origin" id="origin" class="form-control" v-model="origin">
                    <option value>Selecione</option>
                    <option v-for="source in sources" :value="source.id" :key="source.id">{{ source.display }}</option>
                  </select>
                </div>
              </div>
              
              <div class="col-md-12">
                <div class="form-group">
                  <label for="destiny">Destino</label>
                  <select name="destiny" id="destiny" class="form-control" v-model="destiny">
                    <option value>Selecione</option>
                    <option v-for="source in sources" :value="source.id" :key="source.id">{{ source.display }}</option>
                  </select>
                </div>
              </div>
            </div>
              
            <div class="row text-center" v-if="message">
              <div class="col-md-12">
                <div class="alert" :class="classAlert" role="alert">{{message}}</div>
              </div>
            </div>
              
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-success" @click="confirm()" :disabled="disabledConfirm">Confirmar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      value: null,
      origin: "",
      destiny: "",
      money: {
        decimal: ",",
        thousands: "",
        precision: 2
      },
      sources: [],
      message: null,
      classAlert: null,

    }
  },
  computed: {
    disabledConfirm() {
      return (this.origin == "" || this.value == "0,00" || this.destiny == "");
    }
  },
  methods: {
    confirm() {
      $.post(laroute.route("cashdesk.moneyTransfer"), {
        origin: this.origin,
        destiny: this.destiny,
        value: this.convertToUsPattern(this.value),
      })
      .done(function(result) {
        this.message = 'Valor transferido!'
        this.classAlert = 'alert-success';
        
      }.bind(this))
      .fail(function(error) {
        this.message = error.responseJSON.message;
        this.classAlert = 'alert-danger';
      }.bind(this));
    },
    convertToUsPattern(value) {
      return value == undefined ? 0.0 : parseFloat(value.replace(",", "."));
    },
    getSources(){
      $.get(laroute.route("treasure.findByStore", {id:1}))
      .done(function(data) {
        this.sources = data;
      }.bind(this));
    }
  },
  created(){
    this.getSources();
  }
};
</script>
