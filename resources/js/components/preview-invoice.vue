<template>
    <div id="modal-preview-invoice" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Itens da Compra</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <table class="table">
                            <thead>
                                <tr class="thead-primary">
                                    <th>Quantidade</th>
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="item in saleItems">
                                    <td>{{item.quantity}}</td>
                                    <td>{{item.name}}</td>
                                    <td>{{item.value_br}}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" @click="chargeback(item)">
                                            <i class="fas fa-hand-holding-usd"></i> Estorno
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>  
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['id'],
    data: function() {
        return {
            saleItems: []
        };
    },
    methods: {
        getItemsSale(){
            $.get(laroute.route('sales.itemsBySale', {id: this.id})).done(function(data){
               this.saleItems = data;
            }.bind(this));
        },
        chargeback(item){
            $.get(laroute.route('sales.chargeback', {item_id: item.id, type: item.type})).done(function(data){
                location.reload();                    
            }.bind(this));
        }
    },
    watch:{
        id(){
            this.getItemsSale();
        }
    }
};
</script>
