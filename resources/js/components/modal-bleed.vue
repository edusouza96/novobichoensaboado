<template>
	<div id="modal-bleed" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Sangria</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="value_withdraw">Valor a Retirar</label>
								<input
									type="text"
									name="value_withdraw"
									id="value_withdraw"
									class="form-control"
									v-money="money"
									v-model="valueWithdraw"
								/>
							</div>
						</div>

						<div class="col-md-12">
							<select-sources v-model="source" :store="store"></select-sources>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="observation">Observação</label>
								<textarea
									name="observation"
									id="observation"
									class="form-control"
									cols="30"
									rows="3"
									v-model="observation"
								></textarea>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					<button
						type="button"
						class="btn btn-success"
						data-dismiss="modal"
						@click="confirm()"
						:disabled="disabledConfirm"
					>Confirmar</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data: function() {
		return {
			valueWithdraw: null,
			source: "",
			observation: "",
			money: {
				decimal: ",",
				thousands: "",
				precision: 2
			},
		};
	},
	computed: {
		disabledConfirm() {
			return (
				this.source == "" ||
				this.valueWithdraw == "0,00" ||
				this.observation == ""
			);
		}
	},
	props: ['store'],
	methods: {
		confirm() {
			$.post(laroute.route("cashdesk.bleed"), {
				source: this.source,
				observation: this.observation,
				valueWithdraw: this.convertToUsPattern(this.valueWithdraw)
			})
				.done(
					function(result) {
						this.$emit("bleeded", result);
					}.bind(this)
				)
				.fail(
					function(error) {
						this.$emit("failed", error);
					}.bind(this)
				);
		},
		convertToUsPattern(value) {
			return value == undefined
				? 0.0
				: parseFloat(value.replace(",", "."));
		},
	},
};
</script>
