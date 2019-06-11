<template>
  <div id="modal-finish-pay" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pagamento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <fieldset>
            <legend>Desconto</legend>
            <div class="row">
              <div class="col-8">
                <div class="form-group">
                  <label for="promotion">Promoção</label>
                  <select name="promotion" class="form-control promotion">
                    <option value>Selecione</option>
                    <option v-for="rebate in rebates" :key="rebate.id" :value="rebate.id">{{ rebate.name }}</option>
                  </select>
                </div>
              </div>

              <div class="col-4">
                <div class="form-group">
                  <label for="promotionValue">valor</label>
                  <input type="text" name="promotionValue" class="form-control promotion-value" disabled>
                </div>
              </div>
            </div>
          </fieldset>

          <fieldset>
            <legend>Opções de Pagamento</legend>
            <div class="row">
              <div class="col-8">
                <div class="form-group">
                  <label for="methodPay">Forma de Pagamento</label>
                  <select name="methodPay" class="form-control">
                    <option value>Selecione</option>
                  </select>
                </div>
              </div>

              <div class="col-4">
                <div class="form-group">
                  <label for="plots">Parcelas</label>
                  <input type="number" name="plots" class="form-control">
                </div>
              </div>
            </div>
          </fieldset>

          <fieldset>
            <legend>Pagamento</legend>
            
            <div class="row">
              <div class="col-4">
                <div class="form-group">
                  <label for="valueReceived">Valor Recebido</label>
                  <input type="text" name="valueReceived" class="form-control">
                </div>
              </div>

              <div class="col-4">
                <div class="form-group">
                  <label for="change">troco</label>
                  <input type="text" name="change" class="form-control" disabled>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <button type="button" class="btn-info btn-lg btn-block" disabled>Total R$ 0,00</button>
              </div>
            </div>
          </fieldset>
        </div>

        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-success"
            data-dismiss="modal"
            @click="confirm()"
          >Confirmar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: [],
  data: function() {
    return {
      rebates: []
    };
  },
  methods: {
    confirm() {
      alert("Paguei");
    }
  },
  watch: {},
  created: function(){
    $.get(laroute.route("rebate.findAll"))
      .done(function(data) {
        this.rebates = data;
      }.bind(this));
  },
};
</script>
