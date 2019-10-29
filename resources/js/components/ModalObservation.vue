<template>
  <div id="modal-observation" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Observação</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="observation">Observação</label>
                <textarea name="observation" id="observation" class="form-control" cols="30" rows="5" v-model="observation" :disabled="!editable"></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-success" data-dismiss="modal" @click="define()" v-show="editable">Ok</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['default', 'editable'],
  data: function() {
    return {
      observation: ""
    };
  },
  methods: {
    define: function () {
      this.$emit('setObservation', this.observation);
    }
  },
  watch: {
    default: function(){
     this.observation = this.default;
    }
  }
};
</script>
