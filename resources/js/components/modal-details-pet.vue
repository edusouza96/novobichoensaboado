<template>
    <div id="modal-details-pet" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pets</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <table class="table">
                            <thead>
                                <tr class="thead-primary">
                                    <th>Nome</th>
                                    <th>Raça</th>
                                    <th>Bairro</th>
                                    <th>Endereço</th>
                                    <th>Telefone</th>
                                    <th colspan="3" class="text-center" width="5%">Ações</th>
                                </tr>
                            </thead>
                            <tbody v-if="pet!= null">
                                <tr>
                                    <td>{{pet.name}}</td>
                                    <td>{{pet.breed_name}}</td>
                                    <td>{{pet.neighborhood}}</td>
                                    <td>{{pet.address}}</td>
                                    <td>
                                        <div>{{pet.phone1}}</div>
                                        <div>{{pet.phone2}}</div>
                                    </td>
                                    <td>
                                        <a href="" class="btn btn-dark btn-sm" v-tooltip.top-center="'Histórico do Pet'">
                                            <i class="fas fa-history"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="" class="btn btn-primary btn-sm" v-tooltip.top-center="'Editar Pet'">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a v-confirm="confirmDestroy" href="" class="btn btn-danger btn-sm" v-tooltip.top-center="'Excluir Pet'">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
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
   
    },
};
</script>
