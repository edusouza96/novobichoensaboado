<template>
  <div id="modal-list-clients" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Clientes</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label for="name">Nome do Pet</label>
              <input type="text" class="name form-control" name="name" v-model="name">
            </div>
          </div>

          <table class="table" v-if="hasClients">
            <thead class="thead-primary">
              <tr>
                <th>Pet</th>
                <th>Dono</th>
                <th>Raça</th>
              </tr>
            </thead>

            <tbody>
              <tr
                v-for="client in listClients"
                :key="client.id"
                @click="selectClient(client)"
                class="cursor-pointer"
              >
                <td>{{client.name}}</td>
                <td>{{client.owner_name}}</td>
                <td>{{client.breed_name}}</td>
              </tr>
            </tbody>
          </table>
          <div v-if="!hasClients" class="alert alert-warning" role="alert">
            <h6>Não foi encontrado Pet com este nome!</h6>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal" @click="removeClient()">Remover</button>
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
      name: null,
      listClients: []
    };
  },
  computed: {
    hasClients: function() {
      return this.listClients == null ? false : this.listClients.length > 0;
    }
  },
   watch: {
    name: function() {
      if (this.name.length > 2) {
        $.get(laroute.route("client.findByName", { name: this.name }))
          .done(function(data) {
            this.listClients = data;
          }.bind(this));
      }
    }
  },
  methods: {
    removeClient: function() {
      this.$emit("clientSelected", {});
      this.$forceUpdate();
    },
    selectClient: function(client) {
      this.$emit("clientSelected", client);
      this.$forceUpdate();
      $("#modal-list-clients").modal("hide");
    }
  }
};
</script>
