<?php
use MisterPrint\Support\View;
$data = $this->data['params'];
$prod = $this->data['info'];
$user = $this->data['user'];
$icons = [
	'cartao-de-credito' => 'icon-credit-card',
	'getnet-iframe' => 'icon-credit-card',
	'pix-deposito-transferencia' => 'icon-transfer-money',
	'pagar-na-retirada' => 'icon-transfer-money',
	'sinal' => 'icon-transfer-money',
	'pagseguro' => 'icon-transfer-money',
];
if(!$this->data['payments']){//se vier vazio ?>
	<div class="mp-checkbox-group">
		<label class="mp-checkbox mp-checkbox-icon">
			<div class="mp-checkbox-label mp-checkbox-label-icon" >
				<strong>Entre em contato com o setor comercial para liberar o fechamento de pedidos</strong>
			</div>
		</label>
	</div>
	<?php 
return;
}

$selectablePayments = array_filter(
	$this->data['payments'],
	function ( $p ) {
		return !in_array( $p['slugFormPgto'], ['cupom','credito'] );
	}
);
?>
<div class="mp-checkbox-group">
	<input type="radio" name="payment" style="display: none" data-payment="" value=""/>
	<?php foreach($selectablePayments as $payment) { ?>
		<?php $slug = sanitize_title($payment['slugFormPgto']) ?>
		<label class="mp-checkbox mp-checkbox-icon">
			<input type="radio" name="payment" data-payment="<?= $slug ?>" value="<?= $slug ?>"/>
			<span class="checkmark"></span>
			<div class="mp-checkbox-label mp-checkbox-label-icon" >
				<?php if ( isset($icons[$slug]) ): ?>
					<i class="<?= $icons[$slug] ?>"></i>
				<?php endif; ?>
				<strong><?= $payment['nomeFormPgto'] ?></strong>
			</div>
		</label>
	<?php } ?>
</div>
<br /><br />
<div class="mp-checkout-payments">
	<?php foreach($selectablePayments as $payment) { ?>
		<?php $slug = sanitize_title($payment['slugFormPgto']) ?>
		<div class="mp-checkout-payment" data-inputs="<?= $slug ?>">
			<?php if('cartao-de-credito' == $slug) { ?>
				<div class="mp-form-group">
					<label class="mp-label"><?= $data['painel_pagamento_cartao_nome']?></label>
					<input class="mp-input" type="text" name="card-name"
						   placeholder="<?= $data['painel_pagamento_cartao_nome_placeholder']?>"/>
				</div>
				<div class="mp-form-row">
					<div class="mp-form-col-5">
						<div class="mp-form-group">
							<label class="mp-label"><?= $data['painel_pagamento_cartao_numero']?></label>
							<input class="mp-input" type="text" name="card-number"
								   placeholder="<?= $data['painel_pagamento_cartao_numero_placeholder']?>"/>
						</div>
					</div>
					<div class="mp-form-col-5">
						<div class="mp-form-row">
							<div class="mp-form-col-5">
								<div class="mp-form-group">
									<label class="mp-label"><?= $data['painel_pagamento_cartao_vencimento']?></label>
									<input class="mp-input" type="text" name="card-valid"
										   placeholder="<?= $data['painel_pagamento_cartao_vencimento_placeholder']?>"/>
								</div>
							</div>
							<div class="mp-form-col-5">
								<div class="mp-form-group">
									<label class="mp-label"><?= $data['painel_pagamento_cartao_cvv']?></label>
									<input class="mp-input" type="text" name="card-code"
										   placeholder="<?= $data['painel_pagamento_cartao_cvv_placeholder']?>"/>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php $temParcelas = (isset($payment['parcelas']) && $payment['parcelas'] > 1) ?>
				<div id="parcelas-cartao"
					class="mp-form-group"
					data-max-parcelas="<?= $payment['max_parcelas'] ?>"
					data-min-valor-parcela="<?= $payment['min_valor_parcela'] ?>"
					data-text-first="<?= $data['painel_pagamento_cartao_parcelas_1'] ?>"
					data-text="<?= $data['painel_pagamento_cartao_parcelas_outros'] ?>"
					<?php if ( $temParcelas == false ) echo 'style="display: none"' ?>
					>
					<label class="mp-label"><?= $data['painel_pagamento_cartao_parcelas'] ?></label>
					<select class="mp-select" name="card-parcelas">
						<?php if ( $temParcelas ): ?>
							<?php foreach (range(1, $payment['parcelas']) as $numParcelas): ?>
								<option value="<?= $numParcelas ?>" <?= $numParcelas == 1 ?'selected':'' ?>><?=
									str_replace(
										['%qtde%', '%valor%'],
										[$numParcelas, number_format( ($this->data['info']['total'] / $numParcelas) - 0.0049, 2, ',', '.' )],
										$numParcelas == 1 ? $data['painel_pagamento_cartao_parcelas_1'] : $data['painel_pagamento_cartao_parcelas_outros']
									)
								?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
				<div class="mp-errors-container"></div>
			<?php } ?>
			<?php if('pix-deposito-transferencia' == $slug) { ?>
				<div class="mp-form-group" id="tela1">
					<label class="mp-label">Comprovante</label>
					<input class="mp-input" type="file" name="comprovante" id="previewComprovante"/>
					<div class="mp-cart-table" id="tabelaContas">
						<table cellspacing="0" cellpadding="0">
							<thead>
								<tr>
									<th><?= $data['painel_pagamento_banco']?></th>
									<th><?= $data['painel_pagamento_conta']?></th>
									<th><?= $data['painel_pagamento_agencia']?></th>
									<th><?= $data['painel_pagamento_cnpj']?></th>
									<th><?= $data['painel_pagamento_titular']?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($this->data['banks'] as $bank) { ?>
									<tr>
										<td><strong><?= $bank['banco'] ?></strong>(<?= $bank['codigoBanco'] ?>)</td>
										<td><?= $bank['conta'] ?></td>
										<td><?= $bank['agencia'] ?></td>
										<td><?= $bank['cnpj'] ?></td>
										<td><?= $bank['titular'] ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>

				<div class="mp-form-group" id="pegarComprovante">
					<iframe  id="imgComprovante" style="height: 35rem"></iframe>
					<table>
						<tr>
							<td>
								<button type="button" class="mp-btn-primary" id="Descartar">
									<strong> Descartar</strong>
								</button>

								<button type="button" class="mp-btn-primary" id="enviarComprovante">
									<strong> Enviar</strong>
								</button>
							</td>
						</tr>
					</table>
				</div>

				<div class="mp-form-group" id="comprovanteEnviado">
					<div class="mp-progress">
						<ul class="mp-progress-inner">
							<li class="active" style="float: unset; margin: auto">Comprovante aprovado com sucesso</li>
						</ul>
					</div>
				</div>
			<?php } ?>
			<?php if('sinal'== $slug) { ?>
				<div class="mp-form-group">
					<label class="mp-label">Valor</label>
					<input class="mp-input money-input" type="text" name="sinal[valor]" />
				</div>
				<div class="mp-form-group">
					<label class="mp-label">Forma de Pagamento</label>
					<select class="mp-select" name="sinal[forma]">
						<option value="dinheiro" data-show-comprovante="0" selected>Dinheiro</option>
						<option value="credito-vista" data-show-comprovante="1" >Crédito a vista</option>
						<option value="credito-parcelado" data-show-comprovante="1" data-show-parcelas="1">Crédito parcelado</option>
						<option value="bradesco" data-show-comprovante="1" >Bradesco</option>
						<option value="itau" data-show-comprovante="1" >Itaú</option>
						<option value="santander" data-show-comprovante="1" >Santander</option>
						<option value="bb" data-show-comprovante="1" >Banco do Brasil</option>
					</select>
				</div>
				<div class="mp-form-group">
					<label class="mp-label">Parcelas</label>
					<select class="mp-select" name="sinal[parcelas]">
						<option value="1" selected>1 vez</option>
						<option value="2" >2 vezes</option>
						<option value="3" >3 vezes</option>
					</select>
				</div>
				<div class="mp-form-group">
					<label class="mp-label">Comprovante</label>
					<input class="mp-input" type="text" name="sinal[comprovante]" />
				</div>
			<?php } ?>
			<?php if('getnet-iframe' == $slug) { ?>
				<div class="mp-form-group">
					<div class="mp-checkout-payment" data-inputs="<?= $slug ?>">
					<?php echo (new View('checkout/getnet-iframe', [
						'user' => $this->data['user'],
						'slug' => $slug,
					]))->get()  ?>
				</div>
				</div>
			<?php } ?>
			<?php if('pagseguro' == $slug) { ?>
				<div class="mp-form-group">
					<input type="hidden" name="cpf" value="<?= $user['customers_cpf_cnpj']; ?>" />
					<label class="mp-label">Você será redirecionado para a tela do PagSeguro</label>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
</div>
