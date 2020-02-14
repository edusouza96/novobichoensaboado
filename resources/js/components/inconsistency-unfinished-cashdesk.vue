<template>
	<div>
		<div class="card mb-3 text-center" v-if="hasInconsistencyUnfinishedCashdesk">
			<div class="card-header text-white bg-primary">
				<i class="fas fa-exclamation-triangle text-warning"></i> Caixas não fechado
			</div>
			<div>
				<table class="table">
					<thead class="thead-dark">
						<tr>
							<th>Data</th>
							<th>Valor Inicial</th>
							<th>Loja</th>
							<th></th>
						</tr>
					</thead>

					<tbody>
						<tr v-for="inconsistency in inconsistencyUnfinishedCashdesk" :key="inconsistency.id">
							<td>{{showDateBr(inconsistency.date_hour)}}</td>
							<td>R$ {{convertToBrPattern(inconsistency.value_start)}}</td>
							<td>{{inconsistency.store_id}}</td>
							<td>
								<button
									class="btn btn-dark btn-sm"
									type="button"
									data-toggle="modal"
									data-target="#modal-close-cashdesk"
									@click="close(inconsistency.date_hour)"
								>Fechar Caixa</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data: function() {
		return {
			inconsistencyUnfinishedCashdesk: []
		};
	},
	methods: {
		showDateBr(date) {
			return moment(date, "YYYY-MM-DD HH:mm:ss").format("DD/MM/YYYY");
		},
		convertToBrPattern(value) {
			return parseFloat(value).toLocaleString("pt-BR", {
				minimumFractionDigits: 2
			});
		},
		getInconsistencyUnfinishedCashdesk() {
			$.get(
				laroute.route("cashdesk.inconsistencyUnfinishedCashdesk")
			).done(
				function(data) {
					this.inconsistencyUnfinishedCashdesk = data;
				}.bind(this)
			);
		},
		close(date){
			this.$emit('close',  moment(date, "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD"));
		} 
	},
	computed: {
		hasInconsistencyUnfinishedCashdesk() {
			return this.inconsistencyUnfinishedCashdesk.length > 0;
		}
	},
	created() {
		this.getInconsistencyUnfinishedCashdesk();
	}
};
</script>
