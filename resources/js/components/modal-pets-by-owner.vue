<template>
  <div id="modal-list-pets-by-owner" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pets</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <table class="table" v-if="hasPets">
            <thead class="thead-primary">
              <tr>
                <th>Nome</th>
                <th>Raça</th>
              </tr>
            </thead>

            <tbody>
              <tr
                v-for="pet in listPets"
                :key="pet.id"
                @click="selectPet(pet)"
                class="cursor-pointer"
              >
                <td>{{pet.name}}</td>
                <td>{{pet.breed_name}}</td>
              </tr>
            </tbody>
          </table>
          <div v-if="!hasPets" class="alert alert-warning" role="alert">
            <h6>Não foi encontrado Pets!</h6>
          </div>
        </div>

        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-danger"
            data-dismiss="modal"
            @click="removePet()"
          >Remover</button>
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
      listPets: []
    };
  },
  props: ["register"],
  computed: {
    hasPets: function() {
      return this.listPets == null ? false : this.listPets.length > 0;
    }
  },
  methods: {
    searchMyPets() {
      if(!this.register.hasOwnProperty('client')) return false;
      let owner = this.register.client.owner_id;

      if (owner > 0) {
        $.get(laroute.route("owner.myPets", { id: owner })).done(
          function(data) {
            this.listPets = data;
          }.bind(this)
        );
      } else {
        this.listPets = [];
      }
    },
    removePet: function() {
      this.$emit("petSelected", {});
      this.$forceUpdate();
    },
    selectPet: function(pet) {
      this.$emit("petSelected", pet);
      this.$forceUpdate();
      $("#modal-list-pets-by-owner").modal("hide");
    }
  },
  created(){
    this.searchMyPets();
  }
};
</script>
