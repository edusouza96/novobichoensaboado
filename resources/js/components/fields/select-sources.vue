<template>
	<div class="form-group">
		<label for="source">Fonte</label>
		<select name="source" id="source" class="form-control" v-model="sourceId" @input="$emit('input', $event.target.value)">
			<option value>Selecione</option>
			<option v-for="source in sources" :value="source.id" :key="source.id">{{ source.display }}</option>
		</select>
	</div>
</template>

<script>
export default {
    data(){
        return {
			sources: [],
			sourceId:'',
        }
    },
	props: ['value', 'store'],
	methods: {
		getSources() {
			$.get(laroute.route("treasure.findByStore", { id: this.store })).done(
				function(data) {
					this.sources = data;
				}.bind(this)
			);
		}
	},
	created() {
		this.getSources();
		this.sourceId = this.value;
	}
};
</script>
