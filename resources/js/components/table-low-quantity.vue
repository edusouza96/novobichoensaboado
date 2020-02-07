<template>
  <div v-show="list.length > 0">
    <table class="table">
      <thead>
         <tr class="thead-dark">
              <th>Nome</th>
              <th>Quantidade</th>
              <th></th>
          </tr>
      </thead>

      <tbody>
          <tr v-for="product in list" :key="product.id">
              <td>{{product.name}}</td>
              <td>{{product.quantity}}</td>
              <td>
                <a :href="gotoProduct(product.id)" class="btn btn-dark btn-sm">
                  Atualizar
                </a>
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
    }
  },
  methods: {
    get() {
      $.get(laroute.route("product.lowQuantity"))
      .done(function(result) {
        this.list = result;
      }.bind(this))
    },
    gotoProduct(id){
      return laroute.route('product.edit', {id:id});
    }
  },
  created(){
    this.get();
  }
};
</script>
