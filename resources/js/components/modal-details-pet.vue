<template>
    <div id="modal-details-pet" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informações do Pet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div v-if="pet!= null">

                        <div class="row">
                            <div class="col-12 mt-2 mb-2">
                                <strong>Nome:</strong>
                                <span>{{pet.name}}</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mt-2 mb-2">
                                <strong>Raça:</strong>
                                <span>{{pet.breed_name}}</span>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 mt-2 mb-2">
                                <strong>Bairro:</strong>
                                <span>{{pet.neighborhood}}</span>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 mt-2 mb-2">
                                <strong>Endereço:</strong>
                                <span>{{pet.address}}</span>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 mt-2 mb-2">
                                <strong>Telefone 1:</strong>
                                <span>{{pet.phone1}}</span>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 mt-2 mb-2">
                                <strong>Telefone 2:</strong>
                                <span>{{pet.phone2}}</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4 mt-3 mb-3">
                                <a :href="hrefViewHistoric()"  class="btn btn-dark text-white width90">
                                    <i class="fas fa-history"></i> Histórico do Pet
                                </a>
                            </div>
                            <div class="col-4 mt-3 mb-3">
                                <a :href="hrefEditPet()" class="btn btn-primary text-white width90">
                                    <i class="fas fa-pencil-alt"></i> Editar Pet
                                </a>
                            </div>
                            <div class="col-4 mt-3 mb-3">
                                <a v-confirm="confirmDestroy" :href="hrefDestroyPet()" class="btn btn-danger text-white width90">
                                    <i class="fas fa-trash-alt"></i> Excluir Pet
                                </a>
                            </div>
                        </div>
                    
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
    props: ['pet'],
    data: function() {
        return {
            confirmDestroy: {
                message:{
                    title: 'Atenção',
                    body: 'Deseja realmente remover este pet do sistema?'
                }
            },
        };
    },
    methods: {
        hrefDestroyPet(){
            return laroute.route('client.destroy', {id: this.pet.id});
        },
        hrefEditPet(){
            return laroute.route('client.edit', {id: this.pet.id});
        },
        hrefViewHistoric(){
            return laroute.route('client.historic', {client_id: this.pet.id});
        },
    },
};
</script>
