<template>
  <div id="modal-list-services-vet" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Serviços Veterinário</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <table class="table" v-if="hasServices">
            <thead class="thead-primary">
              <tr>
                <th>Descrição</th>
                <th>Preço</th>
              </tr>
            </thead>

            <tbody>
              <tr
                v-for="service in listServices"
                :key="service.id"
                @click="selectService(service)"
                class="cursor-pointer"
              >
                <td>{{service.name}}</td>
                <td>{{service.value}}</td>
              </tr>
            </tbody>
          </table>
          <div v-if="!hasServices" class="alert alert-warning" role="alert">
            <h6>Não foi encontrado serviços disponiveis para esta raça!</h6>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal" @click="removeService()">Remover</button>
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
      listServices: []
    };
  },
  methods: {
    removeService: function() {
      this.$emit("serviceVetSelected", {});
      this.$forceUpdate();
    },
    selectService: function(service) {
      this.$emit("serviceVetSelected", service);
      this.$forceUpdate();
      $("#modal-list-services-vet").modal("hide");
    },
    findServicesVet: function() {
      var that = this;
      $.get(laroute.route("service.allVet")).done(function(data) {
        that.listServices = data;
      });
    }
  },
  computed: {
    hasServices: function() {
      return this.listServices == null ? false : this.listServices.length > 0;
    }
  },
  created: function() {
    this.findServicesVet();
  }
};
</script>
