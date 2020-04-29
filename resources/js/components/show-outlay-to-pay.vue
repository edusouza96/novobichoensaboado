<template>
	<div v-show="has">
		<div class="card mb-3">
			<div class="card-header text-center text-white bg-primary">
				<i class="fas fa-dollar-sign text-warning"></i> Contas a Pagar
			</div>
			<div>
				<table-outlay-to-pay :store="store" type="yesterday" @count="countYesterday =  $event"></table-outlay-to-pay>
				<table-outlay-to-pay :store="store" type="today" @count="countToday =  $event"></table-outlay-to-pay>
				<table-outlay-to-pay :store="store" type="tomorrow" @count="countTomorrow =  $event"></table-outlay-to-pay>
				
			</div>
		</div>
	</div>
</template>


<script>
export default {
	data: function() {
		return {
			countYesterday: 0,
			countToday: 0,
			countTomorrow: 0,
		};
	},
	props: ["store"],
	computed:{
		has(){
			let count = this.countYesterday + this.countToday + this.countTomorrow;
			return count > 0;
		}
	}
};
</script>