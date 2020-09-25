<template>
  <div id="modal-list-services-pet" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Serviços</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <table class="table" v-if="hasServices && !blockEdition">
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

          <div v-if="hasPackages()" class="">
            <div class="header-choose-days-package">
              Escolha os dias e horários dos banhos do pacote
            </div>
            <div class="row d-flex justify-content-center mt-2">
              <div class="col-md-1">
                <h3 class="font-weight-bold">#</h3>
              </div>

              <div class="col-md-7">
                <h3 class="font-weight-bold">Data\Hora</h3>
              </div>
            </div>
            
            <div class="row d-flex justify-content-center mt-2" v-for="item in packages" :key="item.id">
              <div class="col-md-1">
                <label>{{ item.id }}</label>
              </div>

              <div class="col-md-7">
                <datetime 
                  type="datetime" 
                  value-zone="America/Sao_Paulo"
                  :minute-step="30"
                  input-class="form-control" 
                  format="dd/MM/yyyy HH:mm" 
                  v-model="item.dateHour">
                </datetime>
              </div>
            </div>

            <div class="row d-flex justify-content-end mt-2">
              <div class="col-md-5">
                <button type="button" class="btn btn-success" data-dismiss="modal" @click="closeModal()">Confirmar</button>
              </div>
            </div>
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
      listServices: [],
      packages: [],
      serviceSelected: null,
      blockEdition: false,
    };
  },
  props: ["register", "date"],
  methods: {
    hasPackages: function() {
      return this.packages.length > 0;
    },
    removeService: function() {
      this.$emit("servicePetSelected", {});
      this.$forceUpdate();
    },
    selectService: function(service) {
      this.packages = [];
      this.serviceSelected = service;

      let dateMarked = moment(this.dateHour);
      
      if(service.package_type_id == window.packageType.PACKAGE_15_DAYS.id){
        this.package15Days(dateMarked);
      }else if(service.package_type_id == window.packageType.PACKAGE_30_DAYS.id){
        this.package30Days(dateMarked);
      }else {
        this.closeModal();
      }
      
    },
    closeModal: function() {
      this.$emit("servicePetSelected", this.serviceSelected);
      this.$emit("packageSelected", this.packages);
      this.$forceUpdate();
      $("#modal-list-services-pet").modal("hide");
    },
    package30Days: function(dateMarked) {
      this.packages = [
        { id: 1, dateHour: dateMarked.format() },
        { id: 2, dateHour: dateMarked.add(7, 'days').format() },
        { id: 3, dateHour: dateMarked.add(7, 'days').format() },
        { id: 4, dateHour: dateMarked.add(7, 'days').format() },
      ];
    },
    package15Days: function(dateMarked) {
      this.packages = [
        { id: 1, dateHour: dateMarked.format() },
        { id: 2, dateHour: dateMarked.add(14, 'days').format() },
      ];
    },
  },
  computed: {
    breedId: function() {
      return $.isEmptyObject(this.register) || this.register == undefined
        ? null
        : this.register.client.breed_id;
    },
    hasServices: function() {
      return this.listServices == null ? false : this.listServices.length > 0;
    },
    dateHour: function() {
      return this.date.slice(0,11)+this.register.hour;
    }
  },
  watch: {
    'register.date_other_package': function () {
      if(this.register.date_other_package){
        this.packages = this.register.date_other_package;
        this.blockEdition = true;
        this.serviceSelected = this.register.servicePet;
      }else{
        this.blockEdition = false;
        this.packages = [];
      }
    },
    breedId: function() {
      if (this.breedId > 0) {
        var that = this;
        $.get(laroute.route("service.findByBreed", { id: this.breedId })).done(
          function(data) {
            that.listServices = data;
          }
        );
      } else {
        this.listServices = [];
      }
    }
  }
};
</script>
