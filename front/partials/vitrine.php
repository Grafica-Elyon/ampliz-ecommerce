<?php
global $wp;
$current_url = home_url( add_query_arg( [], $wp->request ));
?>

<div class="col-md-4">
	<form action="<?php echo $current_url ?>" accept-charset="utf-8">
		<div class="form-group">
			<label for="categorias" class="mr-2">Produtos</label>
			<select name="categoria" id="categorias" class="custom-select btn-block" onchange="this.form.submit()">
				<option value="0" disabled selected>Escolher...</option>
				<?php foreach ( $this->data as $menu ) : ?>
					<option value="<?php echo $menu['menu_id'] ;?>" <?php echo $_GET['categoria'] === (string) $menu['menu_id'] ? 'selected' : '' ?>>
						<?php echo $menu['name'] ?>
					</option>
				<?php endforeach ?>
			</select>
		</div>
	</form>

	<hr>
	<form action="<?php echo $current_url ?>" accept-charset="utf-8">
		<input type="hidden" name="categoria" value="<?php echo $_GET['categoria'] ?>">
		<div class="form-group">
			<label for="formatos" class="mr-2 <?php echo ! $this->has_data( $formatos ) ? 'text-muted' : '' ?>">Formatos</label>
			<select name="formato" id="formatos" class="custom-select btn-block" <?php echo ! $this->has_data( $formatos ) ? 'disabled' : '' ?> onchange="this.form.submit()">
				<option value="0" disabled selected>Escolher...</option>
				<?php foreach ( $formatos as $formato ) : ?>
					<option value="<?php echo $formato ?>" <?php echo $_GET['formato'] === $formato ? 'selected' : '' ?>>
						<?php echo $formato ?>
					</option>
				<?php endforeach ?>
			</select>
		</div>
	</form>

	<hr>
	<form action="<?php echo $current_url ?>" accept-charset="utf-8">
		<input type="hidden" name="categoria" value="<?php echo $_GET['categoria'] ?>">
		<input type="hidden" name="formato" value="<?php echo $_GET['formato'] ?>">
		<div class="form-group">
			<label for="cores" class="mr-2 <?php echo ! $this->has_data( $cor ) ? 'text-muted' : '' ?>">Impressão</label>
			<select name="cor" id="cores" class="custom-select btn-block" <?php echo ! $this->has_data( $cores ) ? 'disabled' : '' ?> onchange="this.form.submit()">
				<option value="0" disabled selected>Escolher...</option>
				<?php foreach ( $cores as $cor ) : ?>
					<option value="<?php echo $cor ?>" <?php echo $_GET['cor'] === (string) $cor ? 'selected' : '' ?>>
						<?php echo $cor ?>
					</option>
				<?php endforeach ?>
			</select>
		</div>
	</form>

	<hr>
	<form action="<?php echo $current_url ?>" accept-charset="utf-8">
		<input type="hidden" name="categoria" value="<?php echo $_GET['categoria'] ?>">
		<input type="hidden" name="formato" value="<?php echo $_GET['formato'] ?>">
		<input type="hidden" name="cor" value="<?php echo $_GET['cor'] ?>">
		<div class="form-group">
			<label for="papeis" class="mr-2 <?php echo ! $this->has_data( $papeis ) ? 'text-muted' : '' ?>">Papel</label>
			<select name="papel" id="papeis" class="custom-select btn-block" <?php echo ! $this->has_data( $papeis ) ? 'disabled' : '' ?> onchange="this.form.submit()">
				<option value="0" disabled selected>Escolher...</option>
				<?php foreach ( $papeis as $papel ) : ?>
					<option value="<?php echo $papel ?>" <?php echo $_GET['papel'] === (string) $papel ? 'selected' : '' ?>>
						<?php echo $papel ?>
					</option>
				<?php endforeach ?>
			</select>
		</div>
	</form>

	<hr>
	<form action="<?php echo $current_url ?>" accept-charset="utf-8">
		<input type="hidden" name="categoria" value="<?php echo $_GET['categoria'] ?>">
		<input type="hidden" name="formato" value="<?php echo $_GET['formato'] ?>">
		<input type="hidden" name="cor" value="<?php echo $_GET['cor'] ?>">
		<input type="hidden" name="papel" value="<?php echo $_GET['papel'] ?>">
		<div class="form-group">
			<label for="enobrecimentos" class="mr-2 <?php echo ! $this->has_data( $enobrecimentos ) ? 'text-muted' : '' ?>">Enobrecimentos</label>
			<select name="enobrecimento" id="enobrecimentos" class="custom-select btn-block" <?php echo ! $this->has_data( $enobrecimentos ) ? 'disabled' : '' ?> onchange="this.form.submit()">
				<option value="0" disabled selected>Escolher...</option>
				<?php foreach ( $enobrecimentos as $enobrecimento) : ?>
					<option value="<?php echo $enobrecimento['slug'] ?>" <?php echo $_GET['enobrecimento'] === (string) $enobrecimento['slug'] ? 'selected' : '' ?>>
						<?php echo $enobrecimento['descricao'] ?>
					</option>
				<?php endforeach ?>
			</select>
		</div>
	</form>

	<hr>
	<form action="<?php echo $current_url ?>" accept-charset="utf-8">
		<input type="hidden" name="categoria" value="<?php echo $_GET['categoria'] ?>">
		<input type="hidden" name="formato" value="<?php echo $_GET['formato'] ?>">
		<input type="hidden" name="cor" value="<?php echo $_GET['cor'] ?>">
		<input type="hidden" name="papel" value="<?php echo $_GET['papel'] ?>">
		<input type="hidden" name="enobrecimento" value="<?php echo $_GET['enobrecimento'] ?>">
		<div class="form-group">
			<label for="acabamentos" class="mr-2 <?php echo ! $this->has_data( $acabamentos ) ? 'text-muted' : '' ?>">Acabamentos</label>
			<select name="acabamento" id="acabamentos" class="custom-select btn-block" <?php echo ! $this->has_data( $acabamentos ) ? 'disabled' : '' ?> onchange="this.form.submit()">
				<option value="0" disabled selected>Escolher...</option>
				<?php foreach ( $acabamentos as $acabamento ) : ?>
					<option value="<?php echo $acabamento['id'] ?>" <?php echo $_GET['acabamento'] === (string) $acabamento['id'] ? 'selected' : '' ?>>
						<?php echo $acabamento['nome'] ?>
					</option>
				<?php endforeach ?>
			</select>
		</div>
	</form>

	<hr>
	<form action="<?php echo $current_url ?>" accept-charset="utf-8">
		<input type="hidden" name="categoria" value="<?php echo $_GET['categoria'] ?>">
		<input type="hidden" name="formato" value="<?php echo $_GET['formato'] ?>">
		<input type="hidden" name="cor" value="<?php echo $_GET['cor'] ?>">
		<input type="hidden" name="papel" value="<?php echo $_GET['papel'] ?>">
		<input type="hidden" name="enobrecimento" value="<?php echo $_GET['enobrecimento'] ?>">
		<input type="hidden" name="acabamento" value="<?php echo $_GET['acabamento'] ?>">
		<div class="form-group">
			<label for="extras" class="mr-2 <?php echo ! $this->has_data( $extras ) ? 'text-muted' : '' ?>">Extras</label>
			<select name="extra" id="extras" class="custom-select btn-block" <?php echo ! $this->has_data( $extras ) ? 'disabled' : '' ?> onchange="this.form.submit()">
				<option value="0" disabled selected>Escolher...</option>
				<?php foreach ( $extras as $extra ) : ?>
					<option value="<?php echo $extra ?>" <?php echo $_GET['extra'] === (string) $extra ? 'selected' : '' ?>>
						<?php echo $extra ?>
					</option>
				<?php endforeach ?>
			</select>
		</div>
	</form>
</div>

<?php if ( isset( $categoria ) ) : ?>
	<div class="col-md-8">
		<div class="row">
			<div class="col-md-5">
				<?php if ( ! empty( $categoria['urlImagem'] ) ) : ?>
					<img src="<?php echo $categoria['urlImagem']?>" class="img-thumbnail" alt="<?php echo $categoria['nome'] ?>">
				<?php else : ?>
					<img src="http://via.placeholder.com/260x130/cdd3d8/0275d8/?text=IMAGE" class="img-thumbnail" alt="Placeholder">
				<?php endif ?>
			</div>
			<div class="col-md-7">
				<h2><?php $this->the_attr( $categoria['nome'] )?></h2>
				<p><?php $this->the_attr( $categoria['descricao'] )?></p>

				<?php if ( isset( $preview ) ) : ?>
					<form action="<?php add_query_arg( $_SERVER['QUERY_STRING'], '', home_url( $wp->request ) ) ?>" method="POST">
						<div class="form-inline">
							<label for="produto-quantidade" class="mr-2">Quantidade</label>
							<select name="produto-quantidade" id="produto-quantidade" class="custom-select">
								<option value="0" disabled selected>Escolher...</option>
								<?php foreach( $preview as $item ) : ?>
									<option value="<?php $this->the_attr( $item['id'] )?>"><?php $this->the_attr( $item['quantidade'] )?></option>
								<?php endforeach ?>
							</select>
							<input type="submit" class="btn btn-success btn-adicionar-carrinho" value="Adicionar ao carrinho" disabled>
						</div>
					</form>
				<?php endif;?>
			</div>
		</div>

		<?php if ( $this->has_data( $_POST['produto-quantidade'] ) ) : ?>
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-success alert-card" role="alert">
					Item adicionado ao carrinho com sucesso.
				</div>
			</div>
		</div>
		<?php endif ?>

		<?php if ($this->has_data( $relacionados )) : ?>
			<div class="row">
				<div class="col-md-12 mt-lg-4">
					<h4>Produtos Relacionados</h4>
					<?php
						$relacionados = array_chunk($relacionados, 3);
						foreach ($relacionados as $items ) : ?>
							<div class="row mt-4">
							<?php foreach ($items as $item ) : ?>
							   <div class="col-md-4 mb-4">
									<div class="card text-center item-<?php echo $item['codigoProduto']?>">
										<div class="card-header"><?php echo $item['nomeProduto']?></div>
										<?php if ( ! empty( $item['urlImagem'] ) ) : ?>
											<img class="card-img-top" src="<?php echo $item['urlImagem'] ?>" alt="<?php echo $item['nomeProduto']?>">
										<?php else : ?>
											<img class="card-img-top" src="http://via.placeholder.com/260x130/cdd3d8/0275d8/?text=IMAGE" alt="Placeholder">
										<?php endif ?>
										<div class="card-block">
											<p> A partir de R$<?php echo $item['preco'] ?></p>
											<p class="card-text"><a href="loja?categoria=<?php echo $item['codigoProduto']?>" class="btn btn-primary">Visualizar</a></p>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
							</div>
						<?php endforeach; ?>
				</div>
			</div>
		<?php endif ?>
	</div>
<?php endif?>

