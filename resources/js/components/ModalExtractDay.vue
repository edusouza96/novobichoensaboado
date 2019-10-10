<template>
	<div id="modal-extract-day" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Extrato do Dia</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<fieldset>
						<legend class="text-center">Entrada</legend>
						<div class="row" v-for="(entry, index) in sales" :key="index">
							<div class="col-md-8">{{entry.method}}</div><div class="col-md-4">R$ {{convertToBrPattern(entry.value)}}</div>
						</div>
						<div class="alert alert-info text-center" role="alert" v-if="sales.length == 0">
							Nenhuma venda no dia encontrada.
						</div>
					</fieldset>
					
					<fieldset class="mt-5 mb-5">
						<legend class="text-center">Saida</legend>
						<div class="row" v-for="(out, index) in outlays" :key="index">
							<div class="col-md-8">{{out.method}}</div><div class="col-md-4">R$ {{convertToBrPattern(out.value)}}</div>
						</div>
						<div class="alert alert-info text-center" role="alert" v-if="outlays.length == 0">
							Nenhuma despesa no dia encontrada.
						</div>
					</fieldset>
					
					<fieldset class="mt-5 mb-5">
						<legend class="text-center">Resumo</legend>
						<div class="row">
							<div class="col-md-8">Caixa Inicial</div><div class="col-md-4">R$ {{valueStart}}</div>
						</div>
						<div class="row">
							<div class="col-md-8">Caixa Final</div><div class="col-md-4">R${{valueEnd}}</div>
						</div>
						<div class="row">
							<div class="col-md-8">Aporte</div><div class="col-md-4">R$ {{contribute}}</div>
						</div>
						<div class="row">
							<div class="col-md-8">Sangria</div><div class="col-md-4">R$ 0,00</div>
						</div>
					</fieldset>
				</div>

				<div class="modal-footer">
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
			outlays: [],
			sales: [],
			valueStart: null,
			valueEnd: null,
			contribute: null,
		};
	},
	methods: {
		convertToBrPattern(value){
			if(value == null){ 
				value = 0; 
			}
			return parseFloat(value).toLocaleString('pt-BR', {minimumFractionDigits:2});
		},
		getExtractOfToday(){
			$.get(laroute.route("cashdesk.extractOfDay"), {'date': moment().format('YYYY-MM-DD')})
			.done(function(data) {
				this.outlays = data.outlays;
				this.sales = data.sales;
				this.valueStart = this.convertToBrPattern(data.value_start);
				this.valueEnd = this.convertToBrPattern(data.value_end);
				this.contribute = this.convertToBrPattern(data.contribute);
			}.bind(this));
		},
		
	},
	created: function(){
		this.getExtractOfToday();
	}
};
</script>