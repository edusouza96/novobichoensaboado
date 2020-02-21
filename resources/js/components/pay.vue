<template>
	<div id="idPay">
		<fieldset>
			<legend>Pagamento</legend>

			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<label for="valueReceived">Valor Recebido</label>
						<input
							type="text"
							name="valueReceived"
							class="form-control"
							v-model="valueReceived"
							v-money="money"
						/>
					</div>
				</div>

				<div class="col-4">
					<div class="form-group">
						<label for="leftover">Troco</label>
						<input
							type="text"
							name="leftover"
							class="form-control"
							:class="leftoverClass"
							v-model="leftover"
							disabled
						/>
					</div>
				</div>

				<div class="col-3" v-if="canAddPaymentMethod">
					<div class="form-group">
						<button type="button" class="btn btn-primary mt-2" @click="addPaymentMethod">
							<i class="fas fa-plus"></i>
							Adicionar outra forma de pagamento
						</button>
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
</template>

<script>
export default {
	props: ["idPay", "amountSale", "promotionValue", "canAddPaymentMethod"],
	data: function() {
		return {
			leftoverClass: "",
			valueReceived: "",
			money: {
				decimal: ",",
				thousands: "",
				precision: 2
			}
		};
	},
	methods: {
		getValueReceived() {
			return this.valueReceived == "" ? "0,00" : this.valueReceived;
		},
		
		convertToBrPattern(value) {
			return parseFloat(value).toLocaleString("pt-BR", {
				minimumFractionDigits: 2,
				maximumFractionDigits: 2
			});
		},
		convertToUsPattern(value) {
			return value == undefined
				? 0.0
				: parseFloat(value.replace(",", "."));
		},
		isOwing() {
			return this.convertToUsPattern(this.leftover) < 0;
		},
		addPaymentMethod(){
			this.$emit('showSecondMethod', true);
		}
	},
	watch: {
		leftover() {
			this.leftoverClass = this.isOwing() ? "text-red" : "";
			this.$emit('leftover', this.leftover);
		},
		valueReceived(){
			this.$emit('valueReceived', this.valueReceived);
		}, 
	},
	computed: {
		totalPayable() {
			return this.convertToBrPattern(
				this.convertToUsPattern(this.amountSale) -
					this.convertToUsPattern(this.promotionValue)
			);
		},
		leftover() {
			return this.convertToBrPattern(
				this.convertToUsPattern(this.getValueReceived()) -
					(this.convertToUsPattern(this.amountSale) -
						this.convertToUsPattern(this.promotionValue))
			);
		}
	},
	
};
</script>

<style>
.text-red {
	color: #ff0000;
}
</style>
