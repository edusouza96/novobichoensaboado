<template>
	<div id="modal-chart-pie" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
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
				type: "pie",
				data: this.buildDataChart()
			});
		},
		getData(){
			return $.get(laroute.route(this.route), {param:this.param})
				.done(function(data){
					this.data = data;
				}.bind(this));
		},
		generateColor(){
			var hexadecimal = '0123456789ABCDEF';
			var color = '#';
		
			for (var i = 0; i < 6; i++ ) {
				color += hexadecimal[Math.floor(Math.random() * 16)];
			}
			return color;
		},
		buildDataChart(){
			let datasets = [];
			let data = [];
			let labels = [];
			let backgroundColor = [];

			for (var item in this.data) {
				data.push(this.data[item]);
				labels.push(item);
				backgroundColor.push(this.generateColor());
			}
			datasets.push({"data": data, "backgroundColor": backgroundColor});

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
