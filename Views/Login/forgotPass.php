<div class="container-fluid">
	<div id="layoutAuthentication">
		<div id="layoutAuthentication_content">
			<main>
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-5">
							<div class="card shadow-lg border-0 rounded-lg mt-5">
								<div class="card-header"><h3 class="text-center font-weight-light my-4">Recuperação de Senha</h3></div>
								<div class="card-body">
									<div class="small mb-3 text-muted">Um novo email será enviado para sua redefinição de senha.</div>
									<form>
										<div class="form-group">
											<label class="small mb-1" for="email">Email</label>
											<input class="form-control py-4" id="email" type="email" aria-describedby="emailHelp" placeholder="email" />
										</div>
										<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
											<a class="small" href="<?= BASE_URL; ?>Login">Login</a>
											<a class="btn btn-primary" href="<?= BASE_URL; ?>Login/resetPass">Redefinir Senha</a>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>
	</div>
</div>