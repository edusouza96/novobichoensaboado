<template>
	<div>
		<div class="card mb-3 text-center">
			<div class="card-header text-white bg-primary">
				<span>Valor em Caixa</span>
			</div>
			<div class="card-body">
				<p class="card-text">R$ {{value}}</p>
			</div>
		</div>
	</div>
</template>


<script>
export default {
	props: ['value']
};
</script>