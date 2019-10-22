<template>
  <div id="modal-open-cashdesk" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Abrir Caixa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="">Abrir caixa, sem novo aporte ?</label>
                <div class="checkbox">
                  <label><input type="checkbox" value="1" v-model="openWithoutNewContribute"> Sim</label>
                </div>
              </div>
            </div>
          </div>
          <fieldset :disabled="openWithoutNewContribute">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="value_start">Valor do Aporte do Caixa Inicial</label>
                  <input
                    type="text"
                    name="value_start"
                    id="value_start"
                    class="form-control"
                    v-money="money"
                    v-model="valueStart"
                  />
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label for="source">Fonte</label>
                  <select name="source" id="source" class="form-control" v-model="source">
                    <option value>Selecione</option>
                    <option v-for="sourceOrigin in sources" :value="sourceOrigin.id" :key="sourceOrigin.id">{{ sourceOrigin.display }}</option>
                  </select>
                </div>
              </div>
            </div>
          </fieldset>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button
            type="button"
            class="btn btn-success"
            data-dismiss="modal"
            @click="confirm()"
			      :disabled="disabledConfirm"
          >Confirmar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      valueStart: null,
      source: "",
      openWithoutNewContribute: false,
      money: {
        decimal: ",",
        thousands: "",
        precision: 2
      },
      sources: [],
    };
  },
  computed: {
    disabledConfirm() {
      return (this.source == "" || this.valueStart == "0,00") && !this.openWithoutNewContribute;
    }
  },
  props: ['value'],
  methods: {
    confirm() {
      $.post(laroute.route("cashdesk.open"), {
        source: this.source,
        valueStart: this.convertToUsPattern(this.valueStart),
        openWithoutNewContribute: this.openWithoutNewContribute,
      })
      .done(function(result) {
        this.$emit("opened", result);
      }.bind(this))
      .fail(function(error) {
        this.$emit("failed", error);
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
