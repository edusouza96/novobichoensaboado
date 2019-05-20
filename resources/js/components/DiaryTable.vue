<template>
  <div class="table-responsive">
    <notifications group="alert-status" position="top center" />
    <modal-clients @clientSelected="clientSelected"></modal-clients>
    <modal-services-pet :date="date" :register="registerCurrent" @servicePetSelected="servicePetSelected" @packageSelected="packageSelected"></modal-services-pet>
    <modal-services-vet :register="registerCurrent" @serviceVetSelected="serviceVetSelected"></modal-services-vet>
    <modal-observation :default="observationCurrent" :editable="editableCurrent" @setObservation="setObservation"></modal-observation>
    <modal-pets-by-owner :register="registerCurrent" @petSelected="petSelected"></modal-pets-by-owner>

    <table class="table">
      <thead class="thead-primary">
        <tr>
          <th scope="col">Hora</th>
          <th scope="col">Nome do Pet</th>
          <th scope="col">Raça</th>
          <th scope="col">Proprietário</th>
          <th scope="col">Busca</th>
          <th scope="col">Endereço</th>
          <th scope="col">Bairro</th>
          <th scope="col">Telefone</th>
          <th scope="col">Serviço Pet</th>
          <th scope="col">Valor Pet</th>
          <th scope="col">Serviço Vet</th>
          <th scope="col">Valor Vet</th>
          <th scope="col">Obs</th>
          <th scope="col">Valor Busca</th>
          <th scope="col">Total</th>
          <th scope="col">Ações</th>
        </tr>
      </thead>

      <tbody v-for="(register, index) in schedules" :key="register.id">
        <tr :class="register.cssRowBackground">
          <th
            scope="row"
            @click="plus(register)"
            data-toggle="tooltip" data-placement="bottom" 
            title="Clique para adicionar uma linha"
            class="cursor-pointer"
          >{{register.hour}}</th>

          <td>
            <div id="name">{{ register.client.name }}</div>
            <a
              v-if="register.editable"
              data-toggle="modal"
              href="#modal-list-clients"
              @blur="refreshRegisterCurrent(index)"
            >
              <i class="fas fa-plus-circle" data-toggle="tooltip" data-placement="bottom" title="Selecionar Pet"></i>
            </a>
          </td>

          <td>
            <div id="breed">{{ register.client.breed_name }}</div>
          </td>

          <td>
            <div id="owner_name">{{ register.client.owner_name }}</div>
          </td>

          <td>
            <input
              type="checkbox"
              class="filled-in form-control"
              v-model="register.fetch"
              :checked="register.fetch"
              :disabled="!register.editable"
            >
          </td>

          <td>
            <div id="address" v-show="register.fetch">{{ register.client.address }}</div>
          </td>

          <td>
            <div id="neighborhood" v-show="register.fetch">{{ register.client.neighborhood }}</div>
          </td>

          <td>
            <div id="phones" v-html="register.client.phones"></div>
          </td>

          <td class="text-center">
            <div id="service_pet">{{ register.servicePet ? register.servicePet.name : "" }}</div>
            <a
              v-if="register.editable"
              data-toggle="modal"
              href="#modal-list-services-pet"
              @blur="refreshRegisterCurrent(index)"
            >
              <i class="fas fa-plus-circle" data-toggle="tooltip" data-placement="bottom" title="Incluir Serviço Pet"></i>
            </a>
          </td>

          <td>
            <div id="service_pet_value" >{{ register.petValue }}</div>
          </td>

          <td class="text-center">
            <div id="service_vet">{{ register.serviceVet ? register.serviceVet.name : "" }}</div>
            <a
              v-if="register.editable"
              data-toggle="modal"
              href="#modal-list-services-vet"
              @blur="refreshRegisterCurrent(index)"
            >
              <i class="fas fa-plus-circle" data-toggle="tooltip" data-placement="bottom" title="Incluir Serviço Vet"></i>
            </a>
          </td>

          <td>
            <div id="service_vet_value">{{ register.vetValue }}</div>
          </td>

          <td>
            <div id="observation">
              <a
                data-toggle="modal"
                href="#modal-observation"
                @blur="refreshRegisterCurrent(index)"
              >
                <i class="fas fa-plus-circle" data-toggle="tooltip" data-placement="bottom" title="Adicionar Observação" v-if="register.editable"></i>
                <i class="fas fa-eye" data-toggle="tooltip" data-placement="bottom" title="Ver Observação" v-else></i>
              </a>
            </div>
          </td>
          
          <td>
            <div id="delivery_fee">{{ register.fetch && register.id == null ? register.client.deliveryFee : register.deliveryFee }}</div>
          </td>

          <td>
            <div id="gross">{{ register.gross }}</div>
          </td>

          <td>
            <div class="btn-group" role="group" aria-label="Actions">

              <button @click="save(register)" class="btn btn-info btn-sm" v-if="register.status == null">
                <i class="fas fa-save"></i> Agendar
              </button>

              <button @click="refreshRegisterCurrent(index)" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-list-pets-by-owner" v-if="register.status == statusType.scheduled">
                <i class="fas fa-paw"></i><small>Irmão</small>
              </button>
            
              <button @click="checkin(register)" class="btn btn-info btn-sm" v-if="register.status == statusType.scheduled">
                <i class="far fa-clock"></i> <small>CheckIn</small>
              </button>

              <a :href="url(register.id)" class="btn btn-info btn-sm" v-if="register.status == statusType.scheduled || register.status == statusType.present">
                <i class="fas fa-shopping-cart"></i> Pagar
              </a>

              <button @click="edit(register);refreshRegisterCurrent(index)" class="btn btn-info btn-sm" v-if="register.status == statusType.scheduled || register.status == statusType.present">
                <i class="fas fa-edit"></i> Editar
              </button>

              <button @click="cancel(register)" class="btn btn-info btn-sm" v-if="register.status == statusType.scheduled || register.status == statusType.present">
                <i class="fas fa-ban"></i> Excluir
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: ["data", "date"],
  data: function() {
    return {
      statusType: {
        scheduled : 1,
        present : 2,
        finished : 3,
        canceled : 4,
      },
      listClients: null,
      showRow: false,
      defaultHours: [
        { id:null, hour:"08:00", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"08:30", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"09:00", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"09:30", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"10:00", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"10:30", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"11:00", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"11:30", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"12:00", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"12:30", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"13:00", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"13:30", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"14:00", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"14:30", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"15:00", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"15:30", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"16:00", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"16:30", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"17:00", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" },
        { id:null, hour:"17:30", client:{}, servicePet:{}, petValue: 0, serviceVet:{}, vetValue: 0, gross:"", status: null, cssRowBackground: "table-row-background-status-empty", editable: true, observation:"" }
      ],
      indexCurrent: null,
      registerCurrent: {}
    };
  },
  methods: {
    url: function(id) {
      return laroute.route('pdv.index', {id: id});
    },
    plus: function(hour) {
      var register = Object.assign({}, hour);
      register.id = null;
      register.client = {};
      register.servicePet = {};
      register.petValue = 0;
      register.serviceVet = {};
      register.vetValue = 0;
      register.gross = "";
      register.status = null;
      register.fetch = false;
      register.cssRowBackground = "table-row-background-status-empty";
      register.editable = true;
      register.observation = "";
      register.deliveryFee = 0;
      this.data.push(register);
    },
    clientSelected: function(data) {
      this.schedules[this.indexCurrent].client = data;
    },
    petSelected: function(pet) {
      var register = Object.assign({}, this.registerCurrent);
      register.id = null;
      register.client = pet;
      register.servicePet = {};
      register.petValue = 0;
      register.serviceVet = {};
      register.vetValue = 0;
      register.gross = "";
      register.status = null;
      register.fetch = false;
      register.cssRowBackground = "table-row-background-status-empty";
      register.editable = true;
      register.observation = "";
      register.deliveryFee = 0;
      this.data.push(register);
    },
    packageSelected: function(data) {
      this.schedules[this.indexCurrent].package = data;
    },
    servicePetSelected: function(data) {
      this.schedules[this.indexCurrent].servicePet = data;
      console.log(data);
      this.schedules[this.indexCurrent].petValue = data.hasOwnProperty('value') ? data.value : 0;
    },
    serviceVetSelected: function(data) {
      this.schedules[this.indexCurrent].serviceVet = data;
      this.schedules[this.indexCurrent].vetValue = data.hasOwnProperty('value') ? data.value : 0;
    },
    setObservation: function(observation) {
      this.schedules[this.indexCurrent].observation = observation;
    },
    refreshRegisterCurrent: function(index) {
      this.indexCurrent = index;
      this.registerCurrent = this.schedules[this.indexCurrent];
    },
    calcGross: function() {
      let registerCurrent = this.schedules[this.indexCurrent];
      
      if (registerCurrent) {
        let vetValue = registerCurrent.vetValue;
        let petValue = registerCurrent.petValue;
        let deliveryFee = registerCurrent.fetch
          ? registerCurrent.client.deliveryFee
          : 0;
        registerCurrent.gross = parseFloat(petValue) + parseFloat(vetValue) + parseFloat(deliveryFee);
      }
    },
    save: function(register) {
      if(register.client.id == undefined){
        alert('Selecione um cliente');
        return false;
      }
      if((register.servicePet == null || register.servicePet.id == undefined) && (register.serviceVet == null || register.serviceVet.id == undefined)){
        alert('Selecione um serviço');
        return false;
      }
      $.post(laroute.route("diary.store"), this.buildData(register))
        .done(function(data) {
          register.id = data.id;
          register.status = data.status;
          register.cssRowBackground = data.cssRowBackground;
          register.editable = false;
          
          let group = 'alert-status';
          let title = 'Horário Agendado!';
          let text = '';
          let type = 'success';

          this.$notify({ group, title, text, type });
          
        }.bind(this))
        .fail(function() {
          console.log('Erro');
        });
        
    },
    checkin: function(register) {
      $.post(laroute.route("diary.checkin"), {id : register.id})
        .done(function(data) {
          register.status = data.status;
          register.cssRowBackground = data.cssRowBackground;
          
          let group = 'alert-status';
          let title = 'Check-in Realizado!';
          let text = '';
          let type = 'success';

          this.$notify({ group, title, text, type });
          
        }.bind(this))
        .fail(function() {
          console.log('Erro');
        });
    },
    cancel: function(register) {
      $.post(laroute.route("diary.destroy"), {id : register.id})
        .done(function(response) {
          let scheduleCanceled = this.data.filter(function(schedule){
            return schedule.id == register.id;
          });
                      
          this.data.splice(this.data.indexOf(scheduleCanceled[0]), 1);

          let group = 'alert-status';
          let title = 'Agendamento cancelado!';
          let text = '';
          let type = 'success';

          this.$notify({ group, title, text, type });
          
        }.bind(this))
        .fail(function() {
          console.log('Erro');
        });
    },
    edit: function(register) {
      register.editable = true;
      register.status = null;
    },
    buildData: function(register) {
      return {
        id: register.id,
        date: this.date,
        hour: register.hour,
        client: register.client.id,
        servicePet: register.servicePet ? register.servicePet.id : null,
        serviceVet: register.serviceVet ? register.serviceVet.id : null,
        package : register.package,
        observation: register.observation,
        gross: register.gross,
        fetch: register.fetch,
      };
    }
  },
  computed: {
    removeDefaultHours: function() {
      var that = this;
      this.data.filter(function(obj) {
        var index = that.defaultHours.indexOf(obj);
        if (index > -1) that.defaultHours.splice(index, 1);

        return true;
      });
    },
    schedules: function() {
      return this.data
        .concat(this.defaultHours)
        .sort(function(current, previous) {
          if (current.hour > previous.hour) return 1;
          if (current.hour < previous.hour) return -1;
          return 0;
        });
    },
    observationCurrent:function() {
      if(this.indexCurrent != null){
        return this.schedules[this.indexCurrent].observation;
      }
      return "";
    },
    editableCurrent:function() {
      if(this.indexCurrent != null){
        return this.schedules[this.indexCurrent].editable;
      }
      return true;
    }
  },
  watch: {
    schedules: {
      handler: function() {
        this.calcGross();
      },
      deep: true
    }
  }
};
</script>
