<?php
    use MisterPrint\Support\View;
    $data = $this->data['params'];
    $formasPagamento = is_array($this->data['payments']) ? array_column($this->data['payments'], 'slugFormPgto') : [];
    $this->data['payments'] = is_array($this->data['payments']) ? $this->data['payments'] : [];
    $token = $this->data['token'];
?>
<script type="text/javascript">
	window.token = "<?= $token; ?>";
	var check = async () =>{
		await setInterval(() => {
	    	fetch("<?= home_url('/') ?>wp-admin/admin-ajax.php?action=mp_session_token").then(res => res.json()).then(res => {
		        if (window.token != res) {
		        	console.log(res);
		        	console.log(window.token);
		            alert('Identificamos outra aba de pagamento aberta. Pedimos a gentileza de não utilizar duas abas ao mesmo tempo.');
		            window.location.href = "<?= home_url('/') ?>";
		        }
		    })
	    }, 15000);
	};
	check();

</script>
<div class="mp-checkout">
	<div class="mp-heading">
		<div class="mp-heading-line">
			<h2 class="mp-head"><?= $data['titulo']?></h2>
		</div>
		<p><?= $data['subtitulo']?></p>
	</div>
	<div class="mp-progress">
		<ul class="mp-progress-inner">
			<li class="active"><a href="<?= get_page_url('checkout_shipping') ?>"></a><?= $data['passo_1']?></li>
			<li><?= $data['passo_3']?></li>
		</ul>
	</div>
	<form class="mp-checkout-shipping-form mp-form" action="<?php echo home_url('/wp-admin/admin-post.php') ?>" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="action" value="mp_checkout_billing" />
		<?php wp_nonce_field( 'mp_login_action', 'mp_login' ); ?>
		<main class="mp-checkout-content">
			<div class="mp-painel mp-painel-auto mp-mb-3">
				<div class="mp-painel-header">
					<h3 class="mp-painel-title"><?= $data['titulo_painel_dados']?></h3>
					<p><?= $data['subtitulo_painel_dados']?></p>
				</div>

				<input type="hidden" name="address_id" value="<?= $this->data['address']['id'] ?>" />
				<div class="mp-painel-body">
					<div class="mp-cart-table">
						<div class="mp-hide-small">
							<table cellspacing="0" cellpadding="0">
								<thead>
									<tr>
										<th><?= $data['painel_dados_nome']?></th>
										<th><?= $data['painel_dados_endereco']?></th>
										<th><?= $data['painel_dados_telefone']?></th>
										<th><?= $data['painel_dados_nota_fiscal']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?= $this->data['user']['dadosCliente']['customers_firstname'] ?></td>
										<td>
											<?php if($this->data['address']) { ?>
												<?= $this->data['address']['rua'] ?>, <?= $this->data['address']['numero'] ?> <?= $this->data['address']['complemento'] ?><br/>
												CEP: <?= $this->data['address']['cep'] ?> - <?= $this->data['address']['bairro'] ?><br/>
												<?= $this->data['address']['cidade'] ?> / <?= $this->data['address']['estado'] ?>
											<?php }?>
										</td>
										<td>
											<?php if($this->data['address']) { ?>
												<?= $this->data['address']['telefone'] ?>
											<?php }?>
										</td>
										<td>
											<?php //escolha de geração de nota fiscal
												switch( $customersPreference = $this->data['user']['dadosCliente']['customers_preference'] ) {
													case 'cpf': ?>
														<input type="hidden" value="Pessoa Física" name="pessoa">
														<div class="mp-checkbox-label"><strong>Pessoa Física</strong></div>

													<?php break; case 'cnpj': ?>
														<input type="hidden" value="Pessoa Jurídica" name="pessoa">
														<div class="mp-checkbox-label"><strong>Pessoa Jurídica</strong></div>

													<?php break; default:
														 $is_cpf = $this->data['user']['dadosCliente']['doc_selected'] == "cpf";
													?>
														<label class="mp-checkbox">
															<input type="radio" <?= $is_cpf?'checked':'' ?> name="pessoa" value="Pessoa Física"/>
															<span class="checkmark"></span>
															<div class="mp-checkbox-label"><strong>Pessoa Física</strong></div>
														</label>
														<label class="mp-checkbox">
															<input type="radio" <?= $is_cpf?'':'checked' ?> name="pessoa" value="Pessoa Jurídica" />
															<span class="checkmark"></span>
															<div class="mp-checkbox-label"><strong>Pessoa Jurídica</strong></div>
														</label>
													<?php
												}
											?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="mp-hide-medium mp-hide-large">
							<h4 class="mp-painel-title"><?= $data['painel_dados_nome']?></h4>
							<td><?= $this->data['user']['dadosCliente']['customers_firstname'] ?></td>
							<hr />

							<h4 class="mp-painel-title"><?= $data['painel_dados_endereco']?></h4>
							<?php if($this->data['address']) { ?>
								<?= $this->data['address']['rua'] ?>, <?= $this->data['address']['numero'] ?> <?= $this->data['address']['complemento'] ?><br/>
								CEP: <?= $this->data['address']['cep'] ?> - <?= $this->data['address']['bairro'] ?><br/>
								<?= $this->data['address']['cidade'] ?> / <?= $this->data['address']['estado'] ?>
							<?php } ?>
							<hr />


							<h4 class="mp-painel-title"><?= $data['painel_dados_telefone']?></h4>
							<?php if($this->data['address']) { ?>
								<?= $this->data['address']['telefone'] ?>
							<?php }?>
							<hr />

							<h4 class="mp-painel-title"><?= $data['painel_dados_nota_fiscal']?></h4>
							<label class="mp-checkbox">
								<input type="radio" name="pessoa" value="Pessoa Física"/>
								<span class="checkmark"></span>
								<div class="mp-checkbox-label"><strong>Pessoa Física</strong></div>
							</label>
							<label class="mp-checkbox">
								<input type="radio" name="pessoa" value="Pessoa Jurídica"/>
								<span class="checkmark"></span>
								<div class="mp-checkbox-label"><strong>Pessoa Jurídica</strong></div>
							</label>
						</div>
					</div>
				</div>
			</div>

			<div class="mp-row">
                <?php
                    $cupomHabilitado = in_array('cupom', $formasPagamento);
                    $creditoHabilitado = in_array('credito', $formasPagamento) && $this->data['credit'] > 0;
                ?>
				<?php if ( $cupomHabilitado ): ?>
					<div class="mp-checkout-billing-cupom mp-col-sm-10 <?php echo $creditoHabilitado ? 'mp-col-5' : 'mp-col-10'; ?>">
						<?php echo (new View('checkout/checkout-billing-cupom', ['coupon' => $this->data['coupon']]))->get() ?>
					</div>
				<?php endif; ?>
				<?php if ( $creditoHabilitado ) { ?>
					<div class="<?php echo $cupomHabilitado ? 'mp-col-5' : 'mp-col-10'; ?>">
						<div class="mp-painel mp-painel-auto mp-mb-3">
							<div class="mp-painel-header">
								<h3 class="mp-painel-title">Crédito em Conta</h3>
								<p>Caso possua crédito em conta corrente interna, informe abaixo</p>
							</div>

							<div class="mp-painel-body">
								<div class="mp-form-group">
									<label class="mp-label mp-inline-block">Utilizar Crédito</label>
									<div class="mp-tex-default-lg mp-pb-1">Valor atual em conta:
										<span class="mp-secundary-color"><?= money($this->data['credit'])?></span>
									</div>
									<div class="mp-checkbox-group">
										<label class="mp-checkbox">
											<input type="radio" name="credito" data-credit="<?= $this->data['credit'] ?>" value="utilizar"/>
											<span class="checkmark"></span>
											<div class="mp-checkbox-label">
												<strong>Utilizar Crédito</strong>
											</div>
										</label>
										<label class="mp-checkbox">
											<input type="radio" name="credito" value="nao-utilizar" checked/>
											<span class="checkmark"></span>
											<div class="mp-checkbox-label">
												<strong>Não utilizar crédito</strong>
											</div>
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>

			<div id="payment" class="mp-painel mp-painel-auto ">
				<div class="mp-painel-header">
					<h3 class="mp-painel-title"><?= $data['titulo_painel_pagamento']?></h3>
					<p><?= $data['subtitulo_painel_pagamento']?></p>
				</div>

				<div class="mp-painel-body">
					<?php echo (new View('checkout/payments', [
						'payments' => $this->data['payments'],
						'cards' => $this->data['cards'],
						'banks' => $this->data['banks'],
						'params' => $data,
						'info' => $this->data['sidebar'],
					]))->get() ?>
				</div>
			</div>

			<div class="mp-checkout-content-footer">
				<div class="mp-errors mp-errors-right" style="<?php echo (isset($this->data['errors']) && count($this->data['errors']) > 0) ? 'display:block;' : '' ?>">
					<h4>Encontramos alguns erros!</h4>
					<div class="mp-errors-inner">
						<?php foreach($this->data['errors'] as $error) { ?>
							<div class="mp-field">
								<label class="mp-error">
									<?php echo is_array($error) ? implode("<br />", $error) : "".$error ?>
									</label>
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="mp-checkout-content-footer-left">
					<?php if($this->data['sidebar']['shipping']['codigo'] == "MALA"){?>
						<a href="#vazio" id="link_back"><i class="mp-icon mp-icon-arrow-left-grey"></i><?= $data['botao_voltar']?></a>
					<?php }else{?>
						<a href="<?= get_page_url('checkout_shipping') ?>" id="link_back"><i class="mp-icon mp-icon-arrow-left-grey"></i><?= $data['botao_voltar']?></a>
					<?php } ?>
				</div>

				<?php if(empty($this->data['errors']) && !empty($this->data['payments'])){?>
				<div class="mp-checkout-content-footer-right">
					<button type="submit" class="mp-btn-primary"><?= $data['botao_avancar']?></button>
				</div>
				<?php } ?>
			</div>
		</main>
		<aside class="mp-checkout-sidebar" style="order:<?= $data['posicao_sidebar'] === 'left' ? '-1': '0' ?>">
			<div class="sidebar-inner">
				<?php echo (new View('checkout/sidebar', $this->data['sidebar']))->get() ?>
			</div>
		</aside>
	</form>
</div>
<script type="text/javascript">
	let url = 'https://api.dev.ampliz.com.br/ajax/atualiza-preferencia-cliente/<?= user()->getId() ?>/';
	jQuery('[name="pessoa"]').on("click", (e) =>{
		let pfpj = e.target.value == "Pessoa Física"? "cpf" : "cnpj";
		fetch(url+pfpj, {
	        headers: {
	          'Content-Type': 'application/json',
	          'Accept': 'application/json'
	        }
		}).then(res => res.json()).then((res) => {console.info(res)});
	});
</script>
