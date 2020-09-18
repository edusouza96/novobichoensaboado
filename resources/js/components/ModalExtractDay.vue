<template>
	<div id="modal-extract-day" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Extrato do Caixa</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<fieldset>
						<legend>Informações</legend>
						<div class="row">
							<div class="col-md-8">Aberto em: </div><div class="col-md-4">{{datetimeOpen}}</div>
						</div>
						<div class="row">
							<div class="col-md-8">Aberto por: </div><div class="col-md-4">{{openedBy}}</div>
						</div>
						<div class="row">
							<div class="col-md-8">Fechado em: </div><div class="col-md-4">{{datetimeClose}}</div>
						</div>
						<div class="row">
							<div class="col-md-8">Fechado por: </div><div class="col-md-4">{{closedBy}}</div>
						</div>
						<div class="row">
							<div class="col-md-8">Caixa Inicial</div><div class="col-md-4">R$ {{valueStart}}</div>
						</div>
					</fieldset>

					<fieldset class="mt-5 mb-5">
						<legend>Entradas</legend>
						<div class="row" v-if="contribute != '0,00'">
							<div class="col-md-8">Aporte</div><div class="col-md-4">R$ {{contribute}}</div>
						</div>

						<div class="row" v-for="(entry, index) in sales" :key="index">
							<div class="col-md-8">Vendas em {{entry.method}}</div><div class="col-md-4">R$ {{convertToBrPattern(entry.value)}}</div>
						</div>
						<div class="row" v-if="sales.length == 0">
							<div class="text-danger col-md-8">Nenhuma venda no dia encontrada.</div>
						</div>
					</fieldset>

					<fieldset class="mt-5 mb-5">
						<legend>Saidas</legend>

						<div class="row" v-if="bleed != '0,00'">
							<div class="col-md-8">Sangria</div><div class="col-md-4">R$ {{bleed}}</div>
						</div>
						
						<div class="row" v-if="salesDeliveryFee != '0,00'">
							<div class="col-md-8">Máquina das Buscas</div><div class="col-md-4">R$ {{salesDeliveryFee}}</div>
						</div>

						<div class="row" v-for="(out, index) in outlays" :key="index">
							<div class="col-md-8">{{out.method}}</div><div class="col-md-4">R$ {{convertToBrPattern(out.value)}}</div>
							<div class="col-md-12" v-for="(detail, i) in out.details" :key="i">
								<div class="row text-primary">
									<div class="col-md-8 pl-5">{{detail.description}}</div><div class="col-md-4">R$ {{convertToBrPattern(detail.value)}}</div>
								</div>
							</div>
						</div>
						<div class="row" v-if="outlays.length == 0">
							<div class="text-danger col-md-8">Nenhuma despesa no dia encontrada.</div>
						</div>
					</fieldset>

					<fieldset class="mt-5 mb-5">
						<legend>Saldo Final</legend>
						<div class="row">
							<div class="col-md-8">Somente Dinheiro</div><div class="col-md-4">R${{onlyCashDrawer}}</div>
						</div>
						<div class="row">
							<div class="col-md-8">Tudo</div><div class="col-md-4">R$ {{sum}}</div>
						</div>
					</fieldset>
				</div>

				<div class="modal-footer">
                    <button v-if="closedBy == ''" class="btn btn-danger" type="button" data-dismiss="modal" @click="openModalCloseCashdesk">Fechar Caixa</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: ["_key"],
	data: function() {
		return {
			outlays: [],
			sales: [],
			valueStart: null,
			valueEnd: null,
			contribute: null,
			bleed: null,
			datetimeOpen: null,
			openedBy: null,
			datetimeClose: null,
			closedBy: null,
			salesTotal: null,
			outlaysTotal: null,
			sum: null,
			onlyCashDrawer: null,
			salesDeliveryFee: null,
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
				if(typeof data == 'string') return false;
				
				this.outlays = data.outlays;
				this.sales = data.sales;
				this.valueStart = this.convertToBrPattern(data.value_start);
				this.valueEnd = this.convertToBrPattern(data.value_end);
				this.contribute = this.convertToBrPattern(data.contribute);
				this.bleed = this.convertToBrPattern(data.bleed);
				this.datetimeOpen = data.datetime_open;
				this.openedBy = data.opened_by;
				this.datetimeClose = data.datetime_close;
				this.closedBy = data.closed_by;
				this.salesTotal = this.convertToBrPattern(data.sales_total);
				this.salesDeliveryFee = this.convertToBrPattern(data.sales_delivery_fee);
				this.outlaysTotal = this.convertToBrPattern(data.outlays_total);
				this.onlyCashDrawer = this.convertToBrPattern(data.only_cash_drawer);
				this.sum = this.convertToBrPattern(
					(parseFloat(data.sales_total) + parseFloat(data.contribute) + parseFloat(data.value_start)) -
					(parseFloat(data.outlays_total) + parseFloat(data.bleed)) - 
					(parseFloat(data.sales_delivery_fee))
				);
			}.bind(this));
		},
		openModalCloseCashdesk(){
			this.$emit('closecashdesk');
		}
		
	},
	created: function(){
		if(this._key > 0){
			this.getExtractOfToday();
		}
	}
};
</script>