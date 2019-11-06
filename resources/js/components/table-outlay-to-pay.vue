<template>
  <div>
    <modal-pay-outlay :id="id" :key="id"></modal-pay-outlay>
    <table class="table">
      <thead>
          <tr :class="classBgColor">
              <th colspan="3" class="text-center">{{title}}</th>
          </tr>
          <tr class="thead-dark">
              <th>Descrição</th>
              <th>Valor</th>
              <th></th>
          </tr>
      </thead>

      <tbody>
          <tr v-for="outlay in list" :key="outlay.id">
              <td>{{outlay.description}}</td>
              <td>R$ {{convertToBrPattern(outlay.value)}}</td>
              <td>
                <button class="btn btn-dark btn-sm" type="button" data-toggle="modal" data-target="#modal-pay-outlay" @click="id = outlay.id">
                  Pagar
                </button>
              </td>
          </tr>
      </tbody>
    </table>  
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      list:[],
      title:"",
      classBgColor:"",
      id: null,
    }
  },
  props: ["type"],
  methods: {
    get() {
      $.get(laroute.route("outlay.listDashboard", {type:this.type}))
      .done(function(result) {
        this.list = result;
      }.bind(this))
    },
    linkPay(id){
      return laroute.route("outlay.pay", {id:id});
    },
    convertToBrPattern(value){
			if(value == null){ 
				value = 0; 
			}
			return parseFloat(value).toLocaleString('pt-BR', {minimumFractionDigits:2});
		},
   
  },
  created(){
    this.get();
    if(this.type == 'today'){
      this.title = 'Vence Hoje';
      this.classBgColor = 'bg-warning';
    }else if(this.type == 'tomorrow'){
      this.title = 'Vence Amanhã';
      this.classBgColor = 'bg-warning';
    }else{
      this.title = 'Já Venceu';
      this.classBgColor = 'bg-danger';
    }
  }
};
</script>
