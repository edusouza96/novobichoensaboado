<template>
	<div id="modal-finish-pay" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Pagamento</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<fieldset>
						<legend>Desconto</legend>
						<div class="row">
							<div class="col-8">
								<div class="form-group">
									<label for="promotion">Promoção</label>
									<select name="promotion" class="form-control promotion" v-model="rebate">
										<option value>Selecione</option>
										<option v-for="reb in rebates" :key="reb.id" :value="reb.id">{{ reb.name }}</option>
									</select>
								</div>
							</div>

							<div class="col-4">
								<div class="form-group">
									<label for="promotionValue">Valor do Desconto</label>
									<input
										type="text"
										name="promotionValue"
										v-model="promotionValue"
										class="form-control promotion-value"
										disabled
									/>
								</div>
							</div>
						</div>
					</fieldset>
					<div id="first-method">
						<payment-method
							idPaymentMethod="payment-method-1"
							@method="paymentMethod = $event"
							@plots="plots = $event"
							@cardMachine="cardMachine = $event"
						></payment-method>

						<pay
							idPay="pay-1"
							:amountSale="amountSale"
							:promotionValue="promotionValue"
							:canAddPaymentMethod="canAddPaymentMethod"
							@valueReceived="valueReceived = $event"
							@leftover="leftover = $event"
							@showSecondMethod="showSecondMethod = $event; canAddPaymentMethod = false"
						></pay>
					</div>

					<div id="second-method" class="mt-5" v-if="showSecondMethod">
						<payment-method
							idPaymentMethod="payment-method-2"
							@method="paymentMethod2 = $event"
							@plots="plots2 = $event"
							@cardMachine="cardMachine2 = $event"
						></payment-method>

						<pay
							idPay="pay-2"
							:amountSale="convertToBrPattern(convertToUsPattern(leftover)*-1)"
							promotionValue="0"
							:canAddPaymentMethod="false"
							@valueReceived="valueReceived2 = $event"
							@leftover="leftover2 = $event"
						></pay>
					</div>

				</div>

				<div class="modal-footer">
					<button
						type="button"
						class="btn btn-success"
						data-dismiss="modal"
						@click="confirm()"
						:disabled="isOwing()"
					>Confirmar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: ["products", "amountSale", "diariesId"],
	data: function() {
		return {
			rebates: [],
			rebate: "",
			promotionValue: "0,00",
			paymentMethod: 1,
			cardMachine: 3,
			valueReceived: "",
			plots: 1,
			leftover: "0,00",
			canAddPaymentMethod:true,
			showSecondMethod:false,
			paymentMethod2: 1,
			plots2: 1,
			cardMachine2: 3,
			valueReceived2: "",
			leftover2: '0,00',
		};
	},
	methods: {
		confirm() {
			$.post(laroute.route("pdv.registerPayment"), {
				products: this.products,
				paymentMethod: this.paymentMethod,
				paymentMethod2: this.paymentMethod2,
				plots: this.plots,
				plots2: this.plots2,
				rebate: this.rebate,
				promotionValue: this.convertToUsPattern(this.promotionValue),
				valueReceived: this.convertToUsPattern(this.valueReceived),
				valueReceived2: this.convertToUsPattern(this.valueReceived2),
				leftover: this.convertToUsPattern(this.leftover),
				leftover2: this.convertToUsPattern(this.leftover2),
				amountSale: this.convertToUsPattern(this.amountSale),
				diariesId: this.diariesId,
				cardMachine: this.cardMachine,
				cardMachine2: this.cardMachine2,
				hasSecondMethod: this.hasSecondMethod,
			}).done(result => {
				window.location.href = laroute.route("pdv.invoice", result);
			});
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
		getRebate(id) {
			return this.rebates.find(rebate => {
				if (rebate.id == id) {
					return rebate;
				}
			});
		},
		isOwing() {
			return this.convertToUsPattern(this.leftover2) < 0;
		},
		getRebates() {
			$.get(laroute.route("rebate.findActive")).done(
				function(data) {
					this.rebates = data;
				}.bind(this)
			);
		}
	},
	watch: {
		rebate() {
			let rebate = this.getRebate(this.rebate);
			this.promotionValue = 0;

			if (this.rebate > 0) {
				this.promotionValue += rebate.pet
					? (rebate.value / 100) * this.totalServicePet
					: 0;
				this.promotionValue += rebate.vet
					? (rebate.value / 100) * this.totalServiceVet
					: 0;
				this.promotionValue += rebate.product
					? (rebate.value / 100) * this.totalProduct
					: 0;
			}

			this.promotionValue = this.convertToBrPattern(this.promotionValue);
		},
	},
	computed: {
		hasSecondMethod(){
			return this.convertToUsPattern(this.valueReceived2) > 0;
		},
		totalServicePet() {
			let productsPet = this.products.filter(product => {
				if (product.type == window.servicesType.PET) {
					return product;
				}
			});

			if (productsPet.length > 0) {
				return productsPet.reduce((accumulator, product) => {
					return {
						amount:
							parseFloat(accumulator.amount) +
							parseFloat(product.amount)
					};
				}).amount;
			} else {
				return 0.0;
			}
		},
		totalServiceVet() {
			let productsVet = this.products.filter(product => {
				if (product.type == window.servicesType.VET) {
					return product;
				}
			});

			if (productsVet.length > 0) {
				return productsVet.reduce((accumulator, product) => {
					return {
						amount:
							parseFloat(accumulator.amount) +
							parseFloat(product.amount)
					};
				}).amount;
			} else {
				return 0.0;
			}
		},
		totalProduct() {
			let products = this.products.filter(product => {
				if (product.type == window.servicesType.PRODUCTS) {
					return product;
				}
			});

			if (products.length > 0) {
				return products.reduce((accumulator, product) => {
					return {
						amount:
							parseFloat(accumulator.amount) +
							parseFloat(product.amount)
					};
				}).amount;
			} else {
				return 0.0;
			}
		},
	},
	created: function() {
		this.getRebates();
	}
};
</script>
