<template>
	<div :id="idPaymentMethod">
		<fieldset>
			<legend>Opções de Pagamento</legend>
			<div class="row">
				<div class="col-7">
					<div class="form-group">
						<label for="paymentMethod">Forma de Pagamento</label>
						<select name="paymentMethod" class="form-control" v-model="paymentMethod">
							<option
								v-for="method in paymentMethods"
								:value="method.id"
								:key="method.id"
							>{{ method.label }}</option>
						</select>
					</div>
				</div>

				<div class="col-2" v-show="showFieldPlots">
					<div class="form-group">
						<label for="plots">Parcelas</label>
						<input type="number" name="plots" class="form-control" v-model="plots" />
					</div>
				</div>

				<div class="col-3" v-show="showFieldCardMachine">
					<div class="form-group">
						<label for="cardMachine">Maquina</label>
						<select name="cardMachine" class="form-control" v-model="cardMachine">
							<option value>Selecione</option>
							<option v-for="card in cardMachines" :value="card.source_id" :key="card.id">{{ card.display }}</option>
						</select>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
</template>

<script>
export default {
	props: ["idPaymentMethod"],
	data: function() {
		return {
			paymentMethods: window.paymentMethodsType,
			paymentMethod: 1,
			plots: 1,
			cardMachines: window.cardMachinesType,
			cardMachine: 3,
		};
	},
	methods: {
		getOptionsCardMachine() {
			$.get(
				laroute.route("treasure.findOptionsCardMachineByStore", {
					id: 1
				})
			).done(
				function(data) {
					this.cardMachines = data;
				}.bind(this)
			);
		},
	},
	watch: {
		paymentMethod(){
			this.$emit('method', this.paymentMethod);
		},
		plots(){
			this.$emit('plots', this.plots);
		},
		cardMachine(){
			this.$emit('cardMachine', this.cardMachine);
		},
	},
	computed: {
		showFieldPlots() {
			return this.paymentMethod == this.paymentMethods.CREDIT_CARD.id;
		},
		showFieldCardMachine() {
			return this.paymentMethod != this.paymentMethods.CASH.id;
		},
	},
	created: function() {
		this.getOptionsCardMachine();
	}
};
</script>
