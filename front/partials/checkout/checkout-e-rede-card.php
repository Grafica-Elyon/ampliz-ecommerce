<?php

use MisterPrint\Support\View;

$data = $this->data['params'];
error_log($data . PHP_EOL, 3, '/home/mrprint/sandbox.mrprint.com.br/wp-content/plugins/misterprint-ecommerce/erede.log');
?>

<input type="hidden" name="params" value="<?= base64_encode(json_encode($data)) ?>" />

<div class="mp-checkout-e-rede-card">
	<div class="mp-painel">
		<div class="mp-painel-header">
			<h3 class="mp-painel-title"><?= $data['titulo_checkout_e_rede_card'] ?></h3>
		</div>

		<form method="POST" class="mp-checkout-e-rede-card-form mp-form">
			<input type="hidden" name="action" value="mp_checkout_e_rede_card" />
			<?php if (isset($this->data['redirect'])) { ?>
				<input type="hidden" name="redirect" value="<?php echo $this->data['redirect'] ?>" />
			<?php } ?>

			<?php wp_nonce_field('mp_checkout_e_rede_card_action', 'mp_checkout_e_rede_card'); ?>

			<?php echo (new View('misc/errors', [
				'errors' => (isset($this->data['errors'])) ? $this->data['errors'] : []
			]))->get() ?>

			<div class="mp-form-row">
				<div class="mp-form-col-4">
					<div class="mp-form-group">
						<label class="mp-label"><?= $data['label_card_number_checkout_e_rede_card'] ?></label>
						<input type="text" class="mp-input" id="card-number-checkout-e-rede-card" name="card-number-checkout-e-rede-card" title="Digite um número de cartão válido com 16 dígitos">
					</div>
				</div>

				<div class="mp-form-col-2">
					<div class="mp-form-group">
						<label for="expiryDate" class="mp-label">Mês/Validade</label>
						<input type="text" class="mp-input month-expiry-date" id="monthExpiryDate" name="monthExpiryDate" placeholder="12" title="Digite uma data de expiração válida no formato MM">
					</div>
				</div>

				<div class="mp-form-col-2">
					<div class="mp-form-group">
						<label for="expiryDate" class="mp-label">Ano/Validade</label>
						<input type="text" class="mp-input year-expiry-date" id="yearExpiryDate" name="yearExpiryDate" placeholder="2030" title="Digite uma data de expiração válida no formato AAAA">
					</div>
				</div>
				<div class="mp-form-col-2">
					<div class="mp-form-group">
						<label for="cvv" class="mp-label">Código CVV</label>
						<input type="text" class="mp-input" id="cvv" name="cvv" pattern="\d{3}" title="Digite um código CVV válido com 3 dígitos">
					</div>
				</div>
			</div>

			<div class="mp-form-row">

				<div class="mp-form-col-5">
					<div class="mp-form-group">
						<label for="cardName" class="mp-label">Nome no Cartão</label>
						<input type="text" id="cardName" name="cardName" class="mp-input">
					</div>
				</div>

				<div class="mp-form-col-5">
					<div class="mp-form-group">
						<label for="cardName" class="mp-label">Número de CPF</label>
						<input type="text" id="cardCpf" name="cardCpf" class="mp-input cpf">
					</div>
				</div>
			</div>
			<div class="mp-form-row">
				<div class="mp-form-col-5">
					<div class="mp-form-group">
						<label for="formatoPagamento" class="mp-label">Formato de Pagamento</label>
						<select id="formatoPagamento" name="formatoPagamento" class="mp-select">
							<option value="credito">Cartão de Crédito</option>
							<option value="debito">Cartão de Débito</option>
						</select>
					</div>
				</div>

				<div class="mp-form-col-5">
					<div class="mp-form-group" id="parcelamentoGroup">
						<label for="parcelamento" style="display: inline;" class="mp-label">Opção de Parcelamento</label>
						<select id="parcelamento" name="parcelamento" class="mp-select">

						</select>
					</div>
				</div>
			</div>

			<div class="mp-form-footer">
				<button id="buttonPagamentoRede" class="mp-btn-primary mp-link">Realizar Pagamento</button>
			</div>

	</div>

</div>
</div>
