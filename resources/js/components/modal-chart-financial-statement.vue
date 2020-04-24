<template>
	<div id="modal-chart-bar" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">{{title}}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<div class="row">
						<canvas id="canvas-chart" width="400" height="400"></canvas>
					</div>
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
	data() {
		return {
			data: {},
		}
	},
	props: {
		title: {
			type: String,
			default: "Gráfico"
		},
		route: {
			type: String,
			required: true
		},
		param: {
			default: null
		},
	},
	methods: {
		async generateChart() {
			await this.getData();
			
			var canvasChart = document.getElementById("canvas-chart");
			new Chart(canvasChart, {
				type: "bar",
				data: this.buildDataChart(),
				options: {
					legend: {
						display: false,
					}
				}
			});
		},
		convertToUSPattern(value) {
			return parseFloat(value).toLocaleString("en-US", {
				minimumFractionDigits: 2,
				maximumFractionDigits: 2,
				useGrouping:false
			});
		},
		getData(){
			return $.get(laroute.route(this.route), this.param)
				.done(function(data){
					this.data = data;
				}.bind(this));
		},
		buildDataChart(){
			
			let datasets = [];
			let dataSales = [];
			let dataOutlay = [];
			let labels = [];
			let backgroundColorSales = [];
			let backgroundColorOutlay = [];

			for (var item in this.data) {
				dataSales.push(this.convertToUSPattern(this.data[item].sales_total));
				dataOutlay.push(this.convertToUSPattern(this.data[item].outlay_total));
				labels.push(item);
				backgroundColorSales.push('#38c172');
				backgroundColorOutlay.push('#e3342f');
			}
			datasets.push({"data": dataSales, "backgroundColor": backgroundColorSales, "label": 'Total de Entrada'});
			datasets.push({"data": dataOutlay, "backgroundColor": backgroundColorOutlay, "label": 'Total de Saida'});

			return {
				"datasets": datasets,
				"labels": labels
			};
		}
	},
	mounted(){
		this.generateChart();
	},
};
</script>
