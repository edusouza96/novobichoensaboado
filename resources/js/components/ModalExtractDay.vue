<template>
  <div id="modal-extract-day" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Extrato do Dia</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <fieldset>
            <legend class="text-center">Vendas</legend>
            <div class="row">
              <div class="col-md-6">Banhos</div>
              <div class="col-md-6">R$ 0,00</div>
            </div>
          </fieldset>

          <fieldset class="mt-5 mb-5">
            <legend class="text-center">Despesas</legend>
            <div class="row">
              <div class="col-md-6">Funcionarios</div>
              <div class="col-md-6">R$ 0,00</div>
            </div>
          </fieldset>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
    };
  },
  methods: {
  },
};
</script>
