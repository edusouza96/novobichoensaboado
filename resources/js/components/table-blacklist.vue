<template>
    <div>
        <div class="card mb-3 text-center">
            <div class="card-header text-danger bg-dark">
                <span>Blacklist</span>
            </div>
            <div class="card-body">
                <table class="table" v-cloak v-show="hasBlacklist()">
                    <tbody>
                        <tr v-for="debitor in blacklist" :key="debitor.id">
                            <td>{{debitor.owner}} - {{debitor.pet}}</td>
                            <td>{{debitor.phone}}</td>
                            <td>R$ {{convertToBrPattern(debitor.value)}}</td>
                            <td>{{showDateBr(debitor.date)}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="btn-actions">
                                    <a :href="gotoDiary(debitor.date)" class="btn btn-primary btn-sm" target="_blank">Ver Agenda</a>
                                    <a :href="gotoPDV(debitor.id)" class="btn btn-dark btn-sm" target="_blank">Pagar</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>  

                <div v-show="!hasBlacklist()" class="alert alert-warning" role="alert">
                    <h6>Não possui devedores</h6>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  data: function() {
    return {
        blacklist: [],
    }
  },
  methods: {
    hasBlacklist(){
        return this.blacklist.length > 0;
    },
    convertToBrPattern(value){
        return parseFloat(value).toLocaleString('pt-BR', {minimumFractionDigits:2});
    },
    getBlacklist(){
        $.get(laroute.route('cashdesk.blacklist'))
        .done(function(data){
            this.blacklist = data;
        }.bind(this));
    },
    showDateBr(date){
        return moment(date, "YYYY-MM-DD HH:mm:ss").format('DD/MM/YYYY');
    },
    gotoPDV(id){
        return laroute.route('pdv.index', {id:id});
    },
    gotoDiary(date){
        return laroute.route('diary.index', {
            date: moment(date, "YYYY-MM-DD HH:mm:ss").format('YYYY-MM-DD')
        });
    }
  },
  created(){
    this.getBlacklist();
  }
};
</script>
