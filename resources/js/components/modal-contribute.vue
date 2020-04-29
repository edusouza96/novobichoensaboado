<template>
	<div id="modal-contribute" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Aporte</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="value_contribute">Valor do Aporte</label>
								<input
									type="text"
									name="value_contribute"
									id="value_contribute"
									class="form-control"
									v-money="money"
									v-model="valueContribute"
								/>
							</div>
						</div>

						<div class="col-md-12">
							<select-sources v-model="source" :store="store"></select-sources>
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
			valueContribute: null,
			source: "",
			money: {
				decimal: ",",
				thousands: "",
				precision: 2
			},
		};
	},
	computed: {
		disabledConfirm() {
			return this.source == "" || this.valueContribute == "0,00";
		}
	},
	props: ['store'],
	methods: {
		confirm() {
			$.post(laroute.route("cashdesk.contribute"), {
				source: this.source,
				valueContribute: this.convertToUsPattern(this.valueContribute)
			})
				.done(
					function(result) {
						this.$emit("contributed", result);
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
