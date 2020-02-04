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
                  <select name="promotion" class="form-control promotion" v-model="rebate">
                    <option value>Selecione</option>
                    <option v-for="reb in rebates" :key="reb.id" :value="reb.id">{{ reb.name }}</option>
                  </select>
                </div>
              </div>

              <div class="col-4">
                <div class="form-group">
                  <label for="promotionValue">Valor do Desconto</label>
                  <input type="text" name="promotionValue" v-model="promotionValue" class="form-control promotion-value" disabled>
                </div>
              </div>
            </div>
          </fieldset>

          <fieldset>
            <legend>Opções de Pagamento</legend>
            <div class="row">
              <div class="col-7">
                <div class="form-group">
                  <label for="paymentMethod">Forma de Pagamento</label>
                  <select name="paymentMethod" class="form-control" v-model="paymentMethod">
                    <option v-for="method in paymentMethods" :value="method.id" :key="method.id">{{ method.label }}</option>
                  </select>
                </div>
              </div>

              <div class="col-2" v-show="showFieldPlots">
                <div class="form-group">
                  <label for="plots">Parcelas</label>
                  <input type="number" name="plots" class="form-control" v-model="plots">
                </div>
              </div>

              <div class="col-3" v-show="showFieldCardMachine">
                <div class="form-group">
                  <label for="cardMachine">Maquina</label>
                  <select name="cardMachine" class="form-control" v-model="cardMachine">
                    <option value>Selecione</option>
                    <option v-for="card in cardMachines" :value="card.id" :key="card.id">{{ card.display }}</option>
                  </select>
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
                  <input type="text" name="valueReceived" class="form-control" v-model="valueReceived" v-money="money" :disabled="showFieldCardMachine">
                  
                </div>
              </div>

              <div class="col-4">
                <div class="form-group">
                  <label for="leftover">Troco</label>
                  <input type="text" name="leftover" class="form-control" :class="leftoverClass" v-model="leftover" disabled>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <button type="button" class="btn-info btn-lg btn-block" disabled>Total R$ {{ totalPayable }}</button>
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
            :disabled="isOwing() || !isSelectedPaymentMethod()"
          >Confirmar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['products', 'amountSale', 'diariesId'],
  data: function() {
    return {
      rebates: [],
      rebate: '',
      promotionValue: '0,00',
      paymentMethods: window.paymentMethodsType,
      paymentMethod: 1,
      cardMachines: window.cardMachinesType,
      cardMachine: 3,
      valueReceived: '',
      plots: 1,
      leftoverClass: '',
      money: {
        decimal: ',',
        thousands: '',
        precision: 2,
      }
    };
  },
  methods: {
    getValueReceived(){
      return this.valueReceived == '' ? '0,00' : this.valueReceived;
    },
    confirm() {
      $.post(laroute.route("pdv.registerPayment"),{
        products: this.products,
        paymentMethod: this.paymentMethod,
        plots: this.plots,
        rebate: this.rebate,
        promotionValue: this.convertToUsPattern(this.promotionValue),
        valueReceived: this.convertToUsPattern(this.valueReceived),
        leftover: this.convertToUsPattern(this.leftover),
        amountSale: this.convertToUsPattern(this.amountSale),
        diariesId: this.diariesId,
        cardMachine: this.cardMachine,
      }).done((result)=> {
        window.location.href = laroute.route("pdv.invoice", result);
      });
    },
    convertToBrPattern(value){
      return parseFloat(value).toLocaleString('pt-BR', {minimumFractionDigits:2, maximumFractionDigits:2});
    },
    convertToUsPattern(value){
      return value == undefined ? 0.00 : parseFloat(value.replace(",", "."));
    },
    getRebate(id){
      return this.rebates.find((rebate)=> {
        if(rebate.id == id){
          return rebate;
        }
      })
    },
    isOwing(){
      return this.convertToUsPattern(this.leftover) < 0;
    },
    isSelectedPaymentMethod(){
      return this.paymentMethod > 0;
    },
    getOptionsCardMachine(){
      $.get(laroute.route("treasure.findOptionsCardMachineByStore", {id:1}))
        .done(function(data) {
          this.cardMachines = data;
        }.bind(this));
    },
    getRebates(){
      $.get(laroute.route("rebate.findActive"))
      .done(function(data) {
        this.rebates = data;
      }.bind(this));
    },
    setValueReceived(){
      if(this.paymentMethod != this.paymentMethods.CASH.id){
        this.valueReceived = this.totalPayable;
      }
    }
  },
  watch: {
    rebate(){
      let rebate = this.getRebate(this.rebate);
      this.promotionValue = 0;

      if(this.rebate > 0){
        this.promotionValue += rebate.pet ? ((rebate.value / 100) * this.totalServicePet) : 0;
        this.promotionValue += rebate.vet ? ((rebate.value / 100) * this.totalServiceVet) : 0;
        this.promotionValue += rebate.product ? ((rebate.value / 100) * this.totalProduct) : 0;
      }
      
      this.promotionValue = this.convertToBrPattern(this.promotionValue);

      this.setValueReceived();
    },
    leftover(){
      this.leftoverClass = this.isOwing() ? 'text-red' : '';
    },
    paymentMethod(){
      this.setValueReceived();
    }
  },
  computed:{
    totalServicePet(){   
      
      let productsPet = this.products.filter((product)=>{
        if(product.type == window.servicesType.PET){
          return product;
        }
      });
  
      if(productsPet.length > 0){
        return productsPet.reduce((accumulator, product) => {
          return {
            amount: parseFloat(accumulator.amount) + parseFloat(product.amount)
          }
        }).amount;
      }else{
        return 0.00;
      }
    },
    totalServiceVet(){   
      let productsVet = this.products.filter((product)=>{
        if(product.type == window.servicesType.VET){
          return product;
        }
      });
  
      if(productsVet.length > 0){
        return productsVet.reduce((accumulator, product) => {
          return {
            amount: parseFloat(accumulator.amount) + parseFloat(product.amount)
          }
        }).amount;
      }else{
        return 0.00;
      }
    },
    totalProduct(){   
      let products = this.products.filter((product)=>{
        if(product.type == window.servicesType.PRODUCTS){
          return product;
        }
      });
  
      if(products.length > 0){
        return products.reduce((accumulator, product) => {
          return {
            amount: parseFloat(accumulator.amount) + parseFloat(product.amount)
          }
        }).amount;
      }else{
        return 0.00;
      }
    },
    showFieldPlots(){
      return this.paymentMethod == this.paymentMethods.CREDIT_CARD.id;
    },
    showFieldCardMachine(){
      return this.paymentMethod != this.paymentMethods.CASH.id;
    },
    totalPayable(){
      return this.convertToBrPattern(this.convertToUsPattern(this.amountSale) - this.convertToUsPattern(this.promotionValue));
    },
    leftover(){
      return this.convertToBrPattern(this.convertToUsPattern(this.getValueReceived()) - (this.convertToUsPattern(this.amountSale) - this.convertToUsPattern(this.promotionValue)));
    },
  },
  created: function(){
    this.getRebates();
    this.getOptionsCardMachine();
  },
};
</script>

<style>
  .text-red{
    color: #ff0000; 
  }
</style>
