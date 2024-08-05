<?php
$user = user()->getData();

$userData = !$user ? false : array_merge(
	$user['dadosCliente'],
	$user['dadosEndereco'],
	$user['dadosEmpresa'],
	$user['dadosComunicacao'],
	$user['info']
);

if ( $userData ) {
	$userData['endereco'] = "{$userData['entry_street_address']} nº {$userData['entry_street_number']}, {$userData['entry_suburb']}, {$userData['entry_city']} - {$userData['entry_state']} - CEP {$userData['entry_postcode']}";
}

$checkData = function( $key ) use ($userData) {
	return $userData && @$userData[$key] ? "value=\"{$userData[$key]}\" readonly" : '' ;
}
?>

<div class="mp-painel">
	<div class="mp-painel-header">
		<h3 class="mp-painel-title">Criação de arte</h3>
	</div>
	<div class="mp-painel-body mp-form">
		<form class="creation-arts">
			<input type="hidden" name="action" value="mp_balcony_art_creation_send">
			<div class="mp-form-row">
				<div class="mp-form-col-3">
					<div class="mp-form-group">
						<label class="mp-label" for="codigo_cliente">Id Cliente*</label>
						<input class="mp-input" type="number" <?= $checkData('customers_id') ?> id="codigo_cliente" name="codigo_cliente" placeholder="Insira o id" title="Insira o id" tabindex="1" required>
					</div>
				</div>
				<div class="mp-form-col-7">
					<div class="mp-form-group">
						<label class="mp-label" for="nome">Nome</label>
						<input class="mp-input" type="text" <?= $checkData('customers_firstname') ?> id="nome" name="nome" placeholder="Insira seu nome" title="Insira o seu nome" tabindex="2">
					</div>
				</div>
			</div>

			<div class="mp-form-row">
				<div class="mp-form-col-10">
					<div class="mp-form-group">
						<label class="mp-label" for="email">E-mail</label>
						<input class="mp-input" type="text" <?= $checkData('customers_email_address') ?> id="email" name="email" placeholder="Insira seu E-mail" title="Insira o seu E-mail" tabindex="3">
					</div>
				</div>
			</div>

			<div class="mp-form-row">
				<div class="mp-form-col-10">
					<div class="mp-form-group">
						<label class="mp-label" for="endereco_web">Endereço Web</label>
						<input class="mp-input" type="text" <?= $checkData('') ?> id="endereco_web" name="endereco_web" placeholder="Insira seu Endereço Web" title="Insira o seu nome" tabindex="3">
					</div>
				</div>
			</div>

			<div class="mp-form-row">
				<div class="mp-form-col-5">
					<div class="mp-form-group">
						<label class="mp-label" for="telefone">Telefone</label>
						<input class="mp-input" type="text" <?= $checkData('') ?> id="telefone" name="telefone" placeholder="Insira seu Telefone" title="Insira o seu telefone" tabindex="4">
					</div>
				</div>
				<div class="mp-form-col-5">
					<div class="mp-form-group">
						<label class="mp-label" for="celular">Celular</label>
						<input class="mp-input" type="text" <?= $checkData('customers_celular') ?> id="celular" name="celular" placeholder="Insira seu Celular" title="Insira o seu celular" tabindex="5">
					</div>
				</div>
			</div>

			<div class="mp-form-row">
				<div class="mp-form-col-10">
					<div class="mp-form-group">
						<label class="mp-label" for="endereco">Endereço</label>
						<input class="mp-input" type="text" <?= $checkData('endereco') ?> id="endereco" name="endereco" placeholder="Rua nº 0, Bairro, Cidade - UF, CEP xx.xxx-xxx" title="Rua nº 0, Bairro, Cidade - UF, CEP xx.xxx-xxx" tabindex="6">
					</div>
				</div>
			</div>

			<div class="mp-form-row">
				<div class="mp-form-col-10">
					<div class="mp-form-group">
						<label class="mp-checkbox">
							<input class="finish-input" type="checkbox" name="fura_fila"/>
							<span class="checkmark"></span>
							<div class="mp-checkbox-label"><strong>Prioridade de Criação ( fura fila )</strong></div>
						</label>
					</div>
				</div>
			</div>


			<h2 class="tituloDivisoriaCadastro">Artes</h2>
			<div class="arts-list">
				<div class="mp-form-row">
					<div class="mp-form-col-5 arts">
						<div class="mp-form-group">
							<label class="mp-label">Tipo do produto*</label>
							<select class="mp-select" name="tipo_produto[]" required>
								<option disabled selected value=""> Selecione a opção </option>
								<?php foreach ($this->data['product_types'] as $sigla => $texto): ?>
									<option value="<?= $sigla ?>"> <?= $texto ? $texto : $sigla ?> </option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="mp-form-col-4">
						<div class="mp-form-group">
							<label class="mp-label">Processo de Referência</label>
							<input class="mp-input" type="text" name="processo_referencia[]" title="Prioridade no pedido" tabindex="6">
						</div>
					</div>
					<div class="mp-form-col-1">
						<label class="mp-label"><br></label>
						<div>
							<button type="button" class="mp-btn mp-btn-primary fai fa-close remover-arte" style="float:right;display: none"></button>
							<button type="button" class="mp-btn mp-btn-primary fai fa-clone duplicar-arte" style="float:right"></button>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div class="mp-form-row">
				<button type="button" class="mp-form-col-2 more-art mp-btn mp-btn-darker-transparent" >
					Adicionar arte
				</button>
				<div class="mp-form-col-4"></div>
				<span class="mp-form-col-2">Campos Obrigatórios*</span>
				<button type="submit" class="mp-form-col-2 mp-btn mp-btn-primary" tabindex="15">Continuar</button>
			</div>
		</form>
	</div>
</div>
