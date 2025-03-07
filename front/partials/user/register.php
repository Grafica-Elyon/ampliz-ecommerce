<?php
use MisterPrint\Support\View;
use MisterPrint\Support\SessionSupport;
$data = $this->data['params'];
?>
<input type="hidden" name="params" value="<?= base64_encode(json_encode($data)) ?>" />
<div class="mp-heading mp-pb-1">
	<div class="mp-heading-line">
		<h2 class="mp-head"><?= $data['titulo']?></h2>
	</div>
	<p><?= $data['subtitulo']?></p>
</div>

<div class="mp-login mp-mb-3">
	<div class="mp-painel mp-painel-lg">
		<div class="mp-painel-header">
			<h3 class="mp-painel-title-sm"><?= $data['titulo_painel']?></h3>
			<h3 class="mp-painel-subtitle"><?= $data['subtitulo_painel']?></h3>
		</div>
		<div class="mp-painel-body">
			<form action="" method="post" class="mp-login-form mp-form">

				<input type="hidden" name="action" value="mp_register"/>
				<input type="hidden" name="session" value="<?= isset($this->data['session']) ? $this->data['session'] : '1' ?>"/>
				<input type="hidden" name="origin_referer" value="<?= SessionSupport::get('origin_referer') ?>"/>

				<?php if (isset($this->data['redirect'])) { ?>
					<input type="hidden" name="redirect" value="<?= $this->data['redirect'] ?>"/>
				<?php } ?>

				<?php

				wp_nonce_field('mp_register_action', 'mp_register');

				if(isset($this->data['errors'])) {
					echo (new View('misc/errors', [
						'errors' => (isset($this->data['errors'])) ? $this->data['errors'] : []
					]))->get();
				}
				?>

				<div class="mp-checkbox-group mp-itens-center">
					<label class="mp-checkbox">
						<input type="radio" name="pessoa" value="Pessoa Física" checked/>
						<span class="checkmark"></span>
						<div class="mp-checkbox-label"><strong><?= $data['formulario_pessoa_fisica']?></strong></div>
					</label>
					<label class="mp-checkbox">
						<input type="radio" name="pessoa" value="Pessoa Jurídica"/>
						<span class="checkmark"></span>
						<div class="mp-checkbox-label"><strong><?= $data['formulario_pessoa_juridica']?></strong></div>
					</label>
				</div>

				<hr class="mp-mt-3 mp-mb-3">


				<div class="mp-config-content active" data-configuration-step="1">

					<h5 class="mp-h5 mp-pb-1"><b><?= $data['formulario_dados_pessoais']?></b></h5>

					<!-- CPF, Telefone, Celular, Nascimento -->
					<div class="mp-form-row" style="display: flex;justify-content: space-between;">
						<div class="mp-form-col-3 mp-col-sm-12">
							<div class="mp-form-group">
								<label class="mp-label"><?= $data['formulario_data_nascimento']?></label>
								<input class="mp-input" type="text" name="nascimento"
									   placeholder="dd/mm/aaaa"
									   value="<?= isset($this->data['fields']['nascimento']) ? $this->data['fields']['nascimento'] : '' ?>" />
							</div>
						</div>
						<div class="mp-form-col-3">
							<div class="mp-form-group">
								<label class="mp-label"><?= $data['formulario_cpf']?></label>
								<input class="mp-input" type="text" name="cpf" id="cpf"
									   value="<?= isset($this->data['fields']['cpf']) ? $this->data['fields']['cpf'] : '' ?>"
									   placeholder="<?= $data['formulario_cpf_placeholder']?>" minlenght="14" />
							</div>
						</div>
						<div class="mp-form-col-3">
							<div class="mp-form-group">
								<label class="mp-label"><?= $data['formulario_telefone']?></label>
								<input class="mp-input" type="text" name="telefone"
									   value="<?= isset($this->data['fields']['telefone']) ? $this->data['fields']['telefone'] : '' ?>"
									   placeholder="<?= $data['formulario_telefone_placeholder']?>"/>
							</div>
						</div>
						<div class="mp-form-col-3">
							<div class="mp-form-group">
								<label class="mp-label"><?= $data['formulario_celular']?></label>
								<input class="mp-input" type="text" name="celular"
									   value="<?= isset($this->data['fields']['celular']) ? $this->data['fields']['celular'] : $this->data['celular']  ?>"
									   placeholder="<?= $data['formulario_celular_placeholder']?>"/>
							</div>
						</div>
					</div>

					<!-- Apelido, Nome Social, Gênero -->
					<div class="mp-form-row" >
						<div class="mp-form-col-3">
							<div class="mp-form-group">
								<label class="mp-label"><?= $data['formulario_nome_social']?></label>
								<input class="mp-input" type="text" name="customers_social_name"
									   value="<?= isset($this->data['customers_social_name']) ? $this->data['customers_social_name'] : '' ?>"
									   placeholder="<?= $data['formulario_nome_social_placeholder']?>"/>
							</div>
						</div>

						<div class="mp-form-col-3">
							<div class="mp-form-group">
								<label class="mp-label"><?= $data['formulario_nome']?></label>
								<input class="mp-input"
									   type="text"
									   name="nome-completo"
									   disabled
									   value="<?= isset($this->data['nome-completo']) ? $this->data['nome-completo'] : '' ?>"
									   placeholder="<?= $data['formulario_nome_placeholder']?>"/>
							</div>
						</div>

						<div class="mp-form-col-4" >
							<div class="mp-checkbox-group mp-form-group">
								<label class="mp-label"><?= $data['formulario_genero']?></label>
								<label class="mp-checkbox">
									<input type="radio" name="genero" value="M" <?= @$this->data['fields']['genero'] == 'M' ? 'checked':'' ?>/>
									<span class="checkmark"></span>
									<div class="mp-checkbox-label"><strong><?= $data['formulario_masculino']?></strong></div>
								</label>
								<label class="mp-checkbox">
									<input type="radio" name="genero" value="F" <?= @$this->data['fields']['genero'] == 'F' ? 'checked':'' ?>/>
									<span class="checkmark"></span>
									<div class="mp-checkbox-label"><strong><?= $data['formulario_feminino']?></strong></div>
								</label>
								<label class="mp-checkbox">
									<input type="radio" name="genero" value="O" <?= @$this->data['fields']['genero'] == 'O' ? 'checked':'' ?>/>
									<span class="checkmark"></span>
									<div class="mp-checkbox-label"><strong><?= $data['formulario_outros']?></strong></div>
								</label>
								<label class="mp-checkbox">
									<input type="radio" name="genero" value="1" <?= @$this->data['fields']['genero'] == '1' ? 'checked':'' ?>/>
									<span class="checkmark"></span>
									<div class="mp-checkbox-label"><strong><?= $data['formulario_prefiro_nao_dizer']?></strong></div>
								</label>
							</div>
						</div>
					</div>


					<!-- Profissão, Área de Interesse -->
					<div class="mp-checkbox-group">
						<div class="mp-form-row">
							<div class="mp-form-col-<?= intval($data['formulario_info_tamanho_uso']) ?>">
								<div class="mp-form-group">
									<label class="mp-label"><?= $data['formulario_ocupacao']?></label>
									<select name="ocupacao" class="mp-select" id="ocupacao">
										<option value="" disabled >Selecione</option>
										<?php foreach($data['formulario_ocupacoes_valores'] as $field) { ?>
											<?php $selected = (isset($this->data['fields']['ocupacao']) && $this->data['fields']['ocupacao'] == $field['occupations_id']) ? 'selected="selected"' : ''; ?>
											<option value="<?= $field['occupations_id'] ?>" <?= $selected ?>><?= $field['occupations_description'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="mp-form-col-<?= intval($data['formulario_info_tamanho_faturamento']) ?>">
								<div class="mp-form-group">
									<label class="mp-label"><?= $data['formulario_area_atuacao']?></label>
									<select name="area_atuacao" class="mp-select" id="area_atuacao">
										<option value="" disabled selected>Selecione</option>
										<?php foreach($data['formulario_atuacao_valores'] as $field) { ?>
											<?php $selected = (isset($this->data['fields']['area_atuacao']) && $this->data['fields']['area_atuacao'] == $field['activities_id']) ? 'selected="selected"' : ''; ?>
											<option value="<?= $field['activities_id'] ?>" <?= $selected ?>><?= $field['activities_description'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
					</div>


					<!-- Dados PJ -->
					<div class="mp-form-row cnpj-fields" style="display: none;">
						<hr class="mp-mt-3 mp-mb-3">
						<h5 class="mp-h5 mp-pb-1"><b><?= $data['formulario_dados_juridicos']?></b></h5>
						<div class="mp-form-col-3">
							<div class="mp-form-group">
								<label class="mp-label"><?= $data['formulario_cnpj']?></label>
								<input class="mp-input" type="text" name="cnpj" id="cnpj"
									   value="<?= isset($this->data['fields']['cnpj']) ? $this->data['fields']['cnpj'] : '' ?>"
									   placeholder="<?= $data['formulario_cnpj_placeholder']?>"/>
							</div>
						</div>
						<div class="mp-form-col-7">
							<div class="mp-form-group">
								<label class="mp-label"><?= $data['formulario_razao_social']?></label>
								<input class="mp-input" type="text" name="razao-social" disabled
									   value="<?= isset($this->data['fields']['razao-social']) ? $this->data['fields']['razao-social'] : '' ?>"
									   placeholder="<?= $data['formulario_razao_social_placeholder']?>"/>

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
						<div class="mp-form-col-3">
							<div class="mp-form-group">
								<label class="mp-label"><?= $data['formulario_inscricao_estadual']?></label>
								<input class="mp-input" type="text" name="inscricao-estadual"
									   value="<?= isset($this->data['fields']['inscricao-estadual']) ? $this->data['fields']['inscricao-estadual'] : '' ?>"
									   placeholder="<?= $data['formulario_inscricao_estadual_placeholder']?>" maxlength="18"/>
							</div>
						</div>
						<div class="mp-form-col-7">
							<div class="mp-form-group">
								<label class="mp-label"><?= $data['formulario_areas_atuacao']?></label>
								<select name="area-atuacao" class="mp-select" id="area-atuacao">
									<option value="" disabled >Selecione</option>
									<?php foreach($data['formulario_atuacao_valores']as $area){ ?>
										<?php $selected = (isset($this->data['fields']['area-atuacao']) && $this->data['fields']['area-atuacao'] == $area['atividade_id']) ? 'selected="selected"' : ''; ?>
										<option value="<?= $area['atividade_id'] ?>" <?= $selected ?>><?= $area['atividade_descricao'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

					</div>

				</div>

				<hr class="mp-mt-3 mp-mb-3">

				<div class="mp-config-content active" data-configuration-step="2">
					<h5 class="mp-h5 mp-pb-1"><b><?= $data['formulario_dados_endereco']?></b></h5>

					<div class="mp-form-row">
						<div class="mp-form-col-2">
							<div class="mp-form-group">
								<label class="mp-label"><?= $data['formulario_cep']?></label>
								<input class="mp-input" type="text" name="cep" id="cep"
									   value="<?= isset($this->data['fields']['cep']) ? $this->data['fields']['cep'] : '' ?>"
									   placeholder="<?= $data['formulario_cep_placeholder']?>"/>
							</div>
						</div>
						<div class="mp-form-col-4">
							<div class="mp-form-group">
								<label class="mp-label"><?= $data['formulario_logradouro']?></label>
								<input class="mp-input" type="text" name="logradouro" id="rua"
									   value="<?= isset($this->data['fields']['logradouro']) ? $this->data['fields']['logradouro'] : '' ?>"
									   placeholder="<?= $data['formulario_logradouro_placeholder']?>"/>
							</div>
						</div>
						<div class="mp-form-col-4">
							<div class="mp-form-row">
								<div class="mp-form-col-5">
									<div class="mp-form-group">
										<label class="mp-label"><?= $data['formulario_numero']?></label>
										<input class="mp-input" type="text" name="numero" id="numero"
											   value="<?= isset($this->data['fields']['numero']) ? $this->data['fields']['numero'] : '' ?>"
											   placeholder="<?= $data['formulario_numero_placeholder']?>"/>
									</div>
								</div>
								<div class="mp-form-col-5">
									<div class="mp-form-group">
										<label class="mp-label"><?= $data['formulario_complemento']?></label>
										<input class="mp-input" type="text" name="complemento" id="complemento"
											   value="<?= isset($this->data['fields']['complemento']) ? $this->data['fields']['complemento'] : '' ?>"
											   placeholder="<?= $data['formulario_complemento_placeholder']?>"/>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="mp-form-row">
						<div class="mp-form-col-5">
							<div class="mp-form-group">
								<label class="mp-label"><?= $data['formulario_bairro']?></label>
								<input class="mp-input" type="text" name="bairro" id="bairro"
									   value="<?= isset($this->data['fields']['bairro']) ? $this->data['fields']['bairro'] : '' ?>"
									   placeholder="<?= $data['formulario_bairro_placeholder']?>" />
							</div>
						</div>
						<div class="mp-form-col-5">
							<div class="mp-form-row">
								<div class="mp-form-col-5">
									<div class="mp-form-group">
										<label class="mp-label"><?= $data['formulario_cidade']?></label>
										<input class="mp-input" type="text" name="cidade" id="cidade"
											   value="<?= isset($this->data['fields']['cidade']) ? $this->data['fields']['cidade'] : '' ?>"
											   placeholder="<?= $data['formulario_cidade_placeholder']?>" />
									</div>
								</div>
								<div class="mp-form-col-5">
									<div class="mp-form-group">
										<label class="mp-label"><?= $data['formulario_estado']?></label>
										<select name="estado" class="mp-select" id="estado">
											<option value=""><?= $data['formulario_estado']?></option>
											<?php foreach(config('states') as $key => $state) { ?>
												<?php $selected = (isset($this->data['fields']['estado']) && $this->data['fields']['estado'] == $key) ? 'selected="selected"' : ''; ?>
												<option <?= $selected ?> value="<?= $key ?>"><?= $state ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>



				<div class="mp-config-content active" data-configuration-step="4">

					<div class="mp-form-row cnpj-fields" style="display: none;">

						<hr class="mp-mt-3 mp-mb-3">
						<h5 class="mp-h5 mp-pb-1"><b><?= $data['formulario_recebimento']?></b></h5>
						<div class="mp-checkbox-group">
							<label class="mp-checkbox">
								<input type="radio" name="nota-fiscal" value="Pessoa Física"/>
								<span class="checkmark"></span>
								<div class="mp-checkbox-label"><strong><?= $data['formulario_recebimento_fisica']?></strong></div>
							</label>
							<label class="mp-checkbox">
								<input type="radio" name="nota-fiscal" value="Pessoa Jurídica" checked/>
								<span class="checkmark"></span>
								<div class="mp-checkbox-label"><strong><?= $data['formulario_recebimento_juridica']?></strong></div>
							</label>
						</div>

					</div>
				</div>
				<hr class="mp-mt-3 mp-mb-3">
				<div class="mp-config-content active" data-configuration-step="5">
					<h5 class="mp-h5 mp-pb-1"><b><?= $data['formulario_info']?></b></h5>

					<div class="mp-checkbox-group">
						<div class="mp-form-row">
							<?php if ( is_array( $data['formulario_como_conheceu'] ) ): ?>
								<div class="mp-form-col-5">
									<div class="mp-form-group">
										<label class="mp-label" ><?= $data['formulario_info_referrer']?></label>
										<select name="info-referer" class="mp-select" id="info-referer">
											<option value="" disabled selected><?= $data['formulario_info_referrer_placeholder'] ?></option>
											<?php foreach( $data['formulario_como_conheceu'] as $field) { ?>
												<?php $selected = (isset($this->data['fields']['info-referer']) && $this->data['fields']['info-referer'] == $field) ? 'selected="selected"' : ''; ?>
												<option <?= $selected ?> value="<?= $field ?>"><?= $field ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							<?php else: ?>
								<div class="mp-form-col-5">
									<div class="mp-form-group">
										<label class="mp-label" ><?= $data['formulario_info_referrer']?></label>
										<input class="mp-input" type="text" name="info-referer"
											   value="<?= isset($this->data['fields']['info-referer']) ? $this->data['fields']['info-referer'] : '' ?>"
											   placeholder="<?= $data['formulario_info_referrer_placeholder']?>"/>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>

				</div>
				<hr class="mp-mt-3 mp-mb-3">

				<div class="mp-config-content active" data-configuration-step="6">
					<div class="mp-form-row">
						<div class="mp-form-col-5">
							<div class="mp-form-group">
								<label class="mp-label"><?= $data['formulario_email']?></label>
								<input class="mp-input" type="text" name="email"
									<?php if ( $this->data['email'] ) echo 'disabled' ?>
									   value="<?= @$this->data['email'] ?>"
									   placeholder="<?= $data['formulario_email_placeholder']?>"/>
							</div>
						</div>
						<div class="mp-form-col-5">
							<div class="mp-form-group">
								<label class="mp-label"><?= $data['formulario_email_confirmacao']?></label>
								<input class="mp-input" type="text" name="confirm-email"
									<?php if ( $this->data['email'] ) echo 'disabled' ?>
									   value="<?= @$this->data['email'] ?>"
									   placeholder="<?= $data['formulario_email_confirmacao_placeholder']?>"/>
							</div>
						</div>
					</div>
					<div class="mp-row">
						<div class="mp-col">
							<div class="mp-form-group">
								<label class="mp-label"><?= $data['formulario_senha']?></label>
								<input class="mp-input" type="password" name="password" value=""
									   placeholder="<?= $data['formulario_senha_placeholder']?>"/>
							</div>
						</div>
						<div class="mp-col">
							<div class="mp-form-group">
								<label class="mp-label"><?= $data['formulario_senha_confirmacao']?></label>
								<input class="mp-input" type="password" name="confirm-password" value=""
									   placeholder="<?= $data['formulario_senha_confirmacao_placeholder']?>"/>
							</div>
						</div>
					</div>
					<hr class="mp-mt-3 mp-mb-3">


					<div class="mp-checkbox-group receber-ofertas" >
						<label class="mp-checkbox">
							<input type="checkbox" name="receber-ofertas" value="receber-ofertas" checked/>
							<span class="checkmark"></span>
							<!-- <div class="mp-checkbox-label"><strong><?= $data['formulario_receber_email']?></strong></div> -->
							<div class="mp-checkbox-label" style="text-align: justify; padding: 0 15px; flex-wrap: wrap; "><strong>Ao me cadastrar, eu confirmo que li e concordo com os Termos de Uso, Privacidade e Garantia da Mr. Print e que receberei notificações, orientações e promoções através dos canais de contato. Podendo desabilitar essa função a qualquer momento.</span></strong></div>

						</label>

					</div>

				</div>


				<div class="mp-checkbox-group mp-itens-center" style="margin: 5% 0">
					<button type="submit" class="mp-btn mp-btn-primary"><?= $data['formulario_botao']?></button>
				</div>
			</form>
		</div>
	</div>
</div>
