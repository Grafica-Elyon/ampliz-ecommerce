<h1><?= $this->data['product']->name ?></h1>
<p>Informações que irão aparecer na interna de cada produto</p>
<div class="container">
	<form action="<?= home_url('/wp-admin/admin-post.php') ?>" method="POST" class="form">
		<input type="hidden" name="action" value="mp_product_detail" />
		<input type="hidden" name="product" value="<?= $this->data['product']->id ?>" />

		<input type="hidden" name="product_tutorial" value='<?= json_encode($this->data['product']->tutorial) ?>' />
		<input type="hidden" name="product_vantagens_online" value='<?= json_encode($this->data['product']->vantagens['online']) ?>' />
		<input type="hidden" name="product_vantagens_misterprint" value='<?= json_encode($this->data['product']->vantagens['misterprint']) ?>' />
		<input type="hidden" name="product_vantagens_tradicionais" value='<?= json_encode($this->data['product']->vantagens['tradicionais']) ?>' />
		<input type="hidden" name="product_producao_imagens" value='<?= json_encode($this->data['product']->producao['imagens']) ?>' />

		<div class="mp-repeater" data-valueFrom="[name='product_tutorial']">
			<h2 class="container-title">Sessão: Tutorial</h2> <input data-repeater-create type="button" class="button-secondary ml-1" value="Adicionar"/>
			<div data-repeater-list="tutorial">
				<div data-repeater-item>
					<div class="input-block">
						<label>Titulo</label>
						<input type="text" name="title" class="input-control regular-text">
					</div>

					<div class="input-block">
						<label>Descrição</label>
						<textarea name="description" class="input-control large-text"></textarea>
					</div>

					<input data-repeater-delete type="button" value="-"/>
				</div>
			</div>
		</div>
		<hr />
		<div>
			<h2 class="container-title">Sessão: Vantagens</h2>
			<div class="mp-row text-center">
				<div class="mp-col-3">
					<div class="mp-repeater" data-valueFrom="[name='product_vantagens_online']">
						<strong class="container-title">Online</strong> <input data-repeater-create type="button" class="button-secondary ml-1" value="Adicionar"/>
						<div data-repeater-list="vantagens_online" class="mt-1">
							<div data-repeater-item>
								<div class="mp-row">
									<div class="mp-col-7">
										<div class="input-block">
											<label>Titulo</label>
											<input type="text" name="title" class="input-control regular-text">
										</div>
									</div>
									<div class="mp-col-3">
										<div class="input-block">
											<label>Vantagem?</label>
											<select name="vantagem" id="" class="input-control">
												<option value="0">Não</option>
												<option value="1">Sim</option>
											</select>
										</div>
									</div>
								</div>

								<input data-repeater-delete type="button" value="-"/>
							</div>
						</div>
					</div>
				</div>
				<div class="mp-col-4">
					<div class="mp-repeater" data-valueFrom="[name='product_vantagens_misterprint']">
						<strong class="container-title">MisterPrint</strong> <input data-repeater-create type="button" class="button-secondary ml-1" value="Adicionar"/>
						<div data-repeater-list="vantagens_misterprint" class="mt-1">
							<div data-repeater-item>
								<div class="mp-row">
									<div class="mp-col-7">
										<div class="input-block">
											<label>Titulo</label>
											<input type="text" name="title" class="input-control regular-text">
										</div>
									</div>
									<div class="mp-col-3">
										<div class="input-block">
											<label>Vantagem?</label>
											<select name="vantagem" id="" class="input-control">
												<option value="0">Não</option>
												<option value="1">Sim</option>
											</select>
										</div>
									</div>
								</div>

								<input data-repeater-delete type="button" value="-"/>
							</div>
						</div>
					</div>
				</div>
				<div class="mp-col-3">
					<div class="mp-repeater" data-valueFrom="[name='product_vantagens_tradicionais']">
						<strong class="container-title">Tradicionais</strong> <input data-repeater-create type="button" class="button-secondary ml-1" value="Adicionar"/>
						<div data-repeater-list="vantagens_tradicionais" class="mt-1">
							<div data-repeater-item>
								<div class="mp-row">
									<div class="mp-col-7">
										<div class="input-block">
											<label>Titulo</label>
											<input type="text" name="title" class="input-control regular-text">
										</div>
									</div>
									<div class="mp-col-3">
										<div class="input-block">
											<label>Vantagem?</label>
											<select name="vantagem" id="" class="input-control">
												<option value="0">Não</option>
												<option value="1">Sim</option>
											</select>
										</div>
									</div>
								</div>

								<input data-repeater-delete type="button" value="-"/>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div>
			<h2 class="container-title">Sessão: Produção Gráfica</h2>
			<div class="mp-row text-center">
				<div class="mp-col-5">
					<div class="mp-repeater" data-valueFrom="[name='product_producao_imagens']">
						<strong class="container-title">Imagens</strong> <input data-repeater-create type="button" class="button-secondary ml-1" value="Adicionar"/>
						<div data-repeater-list="producao_imagens" class="mt-1">
							<div data-repeater-item>
								<div class="input-block">
									<div class="media-library-field">
										<div class="image-preview-wrapper">
											<img class="image-preview" src="" style="max-height: 100px; width: 100px;">
										</div>
										<input type="button" class="button" value="Selecionar Imagem" />
										<input type="hidden" class="attachment_field" name="attachment_id" value="" />
									</div>
								</div>

								<input data-repeater-delete type="button" value="-"/>
							</div>
						</div>
					</div>
				</div>
				<div class="mp-col-5">
					<div class="input-block">
						<label>Descrição</label>
						<textarea name="producao_description" rows="5" class="input-control large-text"><?php echo isset($this->data['product']->producao['description']) ? $this->data['product']->producao['description'] : '' ?></textarea>
					</div>
				</div>
			</div>
		</div>
		<button class="button-primary" type="submit">Salvar</button>
	</form>
</div>
