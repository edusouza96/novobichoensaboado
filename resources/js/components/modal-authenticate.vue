<template>
	<div id="modal-authenticate" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Autenticação</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<form action="">

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="username">Usuario</label>
									<input type="text" name="username" id="username" class="form-control" v-model="username" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="password">Senha</label>
									<input type="password" name="password" id="password" class="form-control" v-model="password" autocomplete />
								</div>
							</div>
						</div>

						<div class="row text-center" v-if="message">
							<div class="col-md-12">
								<div class="alert" :class="classAlert" role="alert">{{message}}</div>
							</div>
						</div>	
					</form>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
					<button
						type="button"
						class="btn btn-success"
						@click="confirm()"
					>Autenticar</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data: function() {
		return {
			username: null,
			password: null,
			message: null,
      		classAlert: null,
		};
	},
	props: ['action'],
	methods: {
		confirm() {
			$.post(laroute.route("user.acessAdmin"), {
				username: this.username,
				password: this.password,
			})
			.done(
				function(result) {
					this.$emit(this.action);
					$('#modal-authenticate').modal('hide');
				}.bind(this)
			)
			.fail(
				function(error) {
					this.message = error.responseJSON.message;
					this.classAlert = "alert-danger";
				}.bind(this)
			);
		},
		
	},
};
</script>
