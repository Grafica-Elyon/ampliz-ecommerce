<?php
use MisterPrint\Support\View;
$data = $this->data['params'];?>
<div class="mp-user-panel">
	<div class="mp-heading">
		<div class="mp-heading-line">
			<h2 class="mp-head"><?= $data['titulo']?></h2>
		</div>
		<p><?= $data['subtitulo']?></p>
	</div>
	<div class="inner">
		<div class="sidebar" style="order:<?= $data['posicao_sidebar'] === 'right' ? '1': '0' ?>">
			<?= (new View('elements/menu-user-panel', ['params' => $data, 'active' => 'data']))->get(); ?>
			
		</div>
		<main>
			<div class="mp-painel">
				<div class="mp-painel-header">
					<h3 class="mp-painel-title"><?= $data['titulo_painel']?></h3>
				</div>
				<div class="mp-painel-body">
					<?= (new View('elements/flash', ['classes' => 'data-message']))->get() ?>
					<div class="mp-error btn hidden" style="
						padding: 10px;
					    width: 100%;
					    background: #da302b;
					    font-weight: bold;
					    text-align: left;
					    margin: 0px 0px 10px 0px;padding: 10px;
					    width: 100%;
					    background: #da302b;
					    font-weight: bold;
					    text-align: left;
					    margin: 0px 0px 10px 0px;
						">
						<div class="flash-body"></div>
						<div class="close"></div>
					</div>
					<form action="#" class="mp-form" id="edit-data">
						<div class="mp-form-row">
							<h3><?= $data['titulo_painel']?></h3><br />
							<div class="mp-form-col-5">
								<div class="mp-form-group">
									<label class="mp-label" for="apelido"><?= $data['formulario_apelido']?></label>
									<input type="text" name="apelido" id="apelido" class="mp-input" required>
									
								</div>
							</div>
							<div class="mp-form-col-5">
								<div class="mp-form-group">
									<label class="mp-label" for="name"><?= $data['formulario_nome']?></label>
									<input type="text" name="name" id="name" class="mp-input" style="pointer-events:none;">
								</div>
							</div>
							<div class="mp-form-col-5">
								<div class="mp-form-group">
									<label class="mp-label" for="cpf"><?= $data['formulario_cpf']?></label>
									<input type="text" name="cpf" id="cpf" class="mp-input" disabled>
								</div>
							</div>
							<div class="mp-form-col-5">
								<div class="mp-form-group">
									<label class="mp-label" for="email"><?= $data['formulario_email']?></label>
									<input type="text" name="email" id="email" class="mp-input" disabled>
								</div>
							</div>
						</div>
						<div class="mp-form-row">
							<div class="mp-form-col-5">
								<div class="mp-form-group">
									<label class="mp-label" for="telephone"><?= $data['formulario_telefone']?></label>
									<input type="text" name="telephone" id="telephone" class="mp-input" ><!-- required -->
								</div>
							</div>
							<div class="mp-form-col-5">
								<div class="mp-form-group">
									<label class="mp-label" for="celular"><?= $data['formulario_celular']?></label>
									<input type="text" name="celular" id="celular" class="mp-input" required>
								</div>
							</div>
							<div class="mp-form-col-5">
								<div class="mp-checkbox-group">
									<label class="mp-label"><?= $data['formulario_sexo']?></label>
									<label class="mp-checkbox">
										<input type="radio" name="sexo" value="M" <?= @$this->data['fields']['sexo'] == 'M' ? 'checked':'' ?>/>
										<span class="checkmark"></span>
										<div class="mp-checkbox-label"><strong><?= $data['formulario_sexo_masculino']?></strong></div>
									</label>
									<label class="mp-checkbox">
										<input type="radio" name="sexo" value="F" <?= @$this->data['fields']['sexo'] == 'F' ? 'checked':'' ?>/>
										<span class="checkmark"></span>
										<div class="mp-checkbox-label"><strong><?= $data['formulario_sexo_feminino']?></strong></div>
									</label>
									<label class="mp-checkbox">
										<input type="radio" name="sexo" value="O" <?= @$this->data['fields']['sexo'] == 'O' ? 'checked':'' ?>/>
										<span class="checkmark"></span>
										<div class="mp-checkbox-label"><strong><?= $data['formulario_sexo_outros']?></strong></div>
									</label>
								</div>
							</div>
							<div class="mp-form-col-5">
								<div class="mp-form-group">
									<label class="mp-label" for="nascimento"><?= $data['formulario_nascimento']?></label>
									<input type="text" name="nascimento" id="nascimento" class="mp-input">
								</div>
							</div>
							<div class="mp-form-col-5">
								<div class="mp-form-group">
									<label class="mp-label" for="password"><?= $data['formulario_senha']?></label>
									<input type="password" name="password" id="password" class="mp-input">
								</div>
							</div>
							<div class="mp-form-col-5">
								<div class="mp-form-group">
									<label class="mp-label" for="confirm_password"><?= $data['formulario_senha_confirmacao']?></label>
									<input type="password" name="confirm_password" id="confirm_password" class="mp-input">
								</div>
							</div>
						</div>
						<div class="mp-form-row">
							<hr />
							<h3><?= $data['formulario_dados_empresa']?></h3><br />
							<div class="mp-form-col-5">
								<div class="mp-form-group">
									<label class="mp-label" for="razao_social"><?= $data['formulario_nome_razao_social']?></label>
									<input type="text" name="razao-social" id="razao-social" class="mp-input" style="pointer-events:none;" />
									<input type="hidden" name="ativ_principal_text"	value="<?= isset($this->data['fields']['ativ_principal_text']) 
								? $this->data['fields']['ativ_principal_text'] : '' ?>" />
							<input type="hidden" name="ativ_principal_code"	value="<?= isset($this->data['fields']['ativ_principal_code']) 
								? $this->data['fields']['ativ_principal_code'] : '' ?>" />

							<input type="hidden" name="ativ_sec1_text"	value="<?= isset($this->data['fields']['ativ_sec1_text']) 
								? $this->data['fields']['ativ_sec1_text'] : '' ?>" />
							<input type="hidden" name="ativ_sec1_code"	value="<?= isset($this->data['fields']['ativ_sec1_code']) 
								? $this->data['fields']['ativ_sec1_code'] : '' ?>" />

							<input type="hidden" name="ativ_sec2_text"	value="<?= isset($this->data['fields']['ativ_sec2_text']) 
								? $this->data['fields']['ativ_sec2_text'] : '' ?>" />
							<input type="hidden" name="ativ_sec2_code"	value="<?= isset($this->data['fields']['ativ_sec2_code']) 
								? $this->data['fields']['ativ_sec2_code'] : '' ?>" />
								</div>
							</div>
							<div class="mp-form-col-5">
								<div class="mp-form-group">
									<label class="mp-label" for="cnpj"><?= $data['formulario_cnpj']?></label>
									<input type="text" name="cnpj" id="cnpj" class="mp-input">
								</div>
							</div>
							<div class="mp-form-col-5">
								<div class="mp-checkbox-group">
									<label class="mp-label"><?= $data['formulario_emitir_nota_como']?></label>
									<label class="mp-checkbox">
										<input type="radio" use="cpf" name="emitir_nota_como" value="" />
										<span class="checkmark"></span>
										<div class="mp-checkbox-label"><strong><?= $data['formulario_emitir_nota_cpf']?></strong></div>
									</label>
									<label class="mp-checkbox">
										<input type="radio" use="cnpj" name="emitir_nota_como" value="" />
										<span class="checkmark"></span>
										<div class="mp-checkbox-label"><strong><?= $data['formulario_emitir_nota_cnpj']?></strong></div>
									</label>
								</div>
							</div>
						</div>
						<hr>
						<?=
							(new View('forms/classificacao-lead',[
								'title' => 'Informações Adicionais',
								'uso'			=> [ 'tamanho' => 5 ],
								'faturamento'	=> [ 'tamanho' => 5 ],
								'loja-fisica'	=> [ 'tamanho' => 5 ],
								'funcionarios'	=> [ 'tamanho' => 5 ],
								'software'		=> [ 'tamanho' => 10 ],
								'formulario_info_software_valores' => $data['formulario_info_software_valores']
							]))->get()
						?>
						<hr>
						<h3><?= $data['formulario_dados_endereco']?></h3><br />
						<div class="mp-form-row">
							<div class="mp-form-col-3">
								<div class="mp-form-group">
									<label class="mp-label" for="cep"><?= $data['formulario_cep']?></label>
									<input type="text" name="cep" id="cep" class="mp-input" required>
								</div>
							</div>
							<div class="mp-form-col-7">
								<div class="mp-form-group">
									<label class="mp-label" for="street"><?= $data['formulario_rua']?></label>
									<input type="text" name="street" id="street" class="mp-input" required>
								</div>
							</div>
						</div>
						<div class="mp-form-row">
							<div class="mp-form-col-7">
								<div class="mp-form-group">
									<label class="mp-label" for="neighborhood"><?= $data['formulario_bairro']?></label>
									<input type="text" name="neighborhood" id="neighborhood" class="mp-input" required>
								</div>
							</div>
							<div class="mp-form-col-3">
								<div class="mp-form-group">
									<label class="mp-label" for="number"><?= $data['formulario_numero']?></label>
									<input type="text" name="number" id="number" class="mp-input" required>
								</div>
							</div>
							<div class="mp-form-col-4">
								<div class="mp-form-group">
									<label class="mp-label" for="complement"><?= $data['formulario_complemento']?></label>
									<input type="text" name="complement" id="complement" class="mp-input">
								</div>
							</div>
							<div class="mp-form-col-3">
								<div class="mp-form-group">
									<label class="mp-label" for="city"><?= $data['formulario_cidade']?></label>
									<input type="text" name="city" id="city" class="mp-input" required>
								</div>
							</div>
							<div class="mp-form-col-3">
								<div class="mp-form-group">
									<label class="mp-label" for="state"><?= $data['formulario_estado']?></label>
									<select name="state" id="state" class="mp-select">
										<option value="">Estado</option>
										<?php foreach(config('states') as $key => $state) { ?>
											<option value="<?= $key ?>"><?= $state ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="mp-form-footer">
							<button type="submit" class="mp-btn-primary mp-link"><?= $data['botao_alterar_dados']?></button>
						</div>
					</form>
				</div>
			</div>
		</main>
	</div>
</div>
<script type="text/javascript">
	let url = new URL(window.location.href);
	let params = new URLSearchParams(url.search);
	let err = params.get('err') // 'chrome-instant'
		console.log(err);
	if(err != undefined && err != null){
		jQuery('.mp-error').removeClass("hidden");
		document.querySelector('.mp-error > .flash-body').innerText = err;
		setTimeout(function(){
			jQuery('.mp-error').addClass("hidden");
			document.querySelector('.mp-error > .flash-body').innerText = "";
		}, 10000);
	}
</script>
<?php 
