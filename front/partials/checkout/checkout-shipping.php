<?php use MisterPrint\Support\View;
$data = $this->data['params'];
if(isset($this->data['redirect']) && !empty($this->data['redirect'])){ ?> 
	<script type="text/javascript"> window.location.href = "/painel/meus-dados?err=Atualize%20seus%20dados%20para%20continuar"; </script> 
<?php }//fim if
$inputs = shortcode_atts([
	'shipping_type' => null,
	'shipping' => null,
	'shipping_code' => null,
	'address' => $this->data['endereco_id'],
	'direct_cep' => null,
	'direct_endereco' => null,
	'direct_numero' => null,
	'direct_complemento' => null,
	'direct_bairro' => null,
	'direct_cidade' => null,
	'direct_uf' => null,
	'direct_value' => null,
	'direct_document' => null,
	'direct_document_type' => null,
], $this->data['data']); 

?>

<input type="hidden" name="params" value="<?= base64_encode(json_encode($data)) ?>" />
<div class="mp-checkout">
	<div class="mp-heading">
		<div class="mp-heading-line">
			<h2 class="mp-head"><?= $data['titulo']?></h2>
		</div>
		<p><?= $data['subtitulo']?></p>
	</div>
	<div class="mp-progress">
		<ul class="mp-progress-inner">
			<li><?= $data['passo_1']?></li>
			<li><?= $data['passo_3']?></li>
		</ul>
	</div>
	<form class="mp-checkout-shipping-form mp-form">
		<input type="hidden" name="shipping_code" value="<?= $inputs['shipping_code'] ?>" />
		<main class="mp-checkout-content">
			<div class="mp-painel">
				<div class="mp-painel-header">
					<h3 class="mp-painel-title"><?= $data['titulo_painel']?></h3>
					<p><?= $data['subtitulo_painel']?></p>
				</div>

				<div class="mp-painel-body">
				<div class="mp-listing" data-item="3">
						<div class="mp-item">
							<label class="mp-checkbox">
								<?php $checked = ('shipping' == $inputs['shipping_type']) ? 'checked' : '' ?>
								<input <?= $checked ?> type="radio" name="shipping_type" value="shipping">
								<span class="checkmark"></span>
								<div class="mp-checkbox-label mp-font-lg"><strong>Receber no meu endereço</strong></div>
							</label>
						</div>
					</div>
					<hr />
					<div data-type="shipping" style="<?= ('shipping' != $inputs['shipping_type']) ? 'display:none;' : '' ?>">
						<fieldset class="mp-fieldset">
							<div class="mp-address">
								<div class="mp-form-group">
									<label class="mp-label"><?= $data['endereco_de_entrega']?></label>
									<?php if (!empty($this->data['address'])) { ?>
										<div class="mp-checkbox-group">
											<?php foreach ($this->data['address'] as $address) { ?>
												<label class="mp-checkbox">
													<?php $checked = ($address['id'] == $inputs['address']) ? 'checked' : '';  ?>
													<input <?= $checked ?> type="radio" name="address" value="<?= $address['id'] ?>" />
													<span class="checkmark"></span>
													<span class="mp-checkbox-label">
														<?php echo $address['rua'] ?>,
														<?php echo $address['numero'] . ' ' . $address['complemento'] ?> -
														<?php echo $address['bairro'] ?>
														<br/>
														CEP: <?php echo $address['cep'] ?><br/></span>
												</label>
											<?php } ?>
										</div>
									<?php } else { 
										$this->data['errors'][] = 'Cadastre um endereço em "<a class="text-danger" href="'.home_url("/painel/meus-enderecos?message=Cadastre um endereço para continuar comprando").'">Meus endereços</a>" para continuar';
										?>

										<input type="hidden" name="address" value="" />
										<p>Nenhum endereço cadastrado</p>
										<a href="<?= get_page_url('my_addresses') ?>" class="mp-btn-primary mp-btn-modal">
											Adicionar endereço de entrega
										</a>
									<?php } ?>
								</div>
							</div>
						</fieldset>
						<?php $esconder = (empty($this->data['address']) || is_null($inputs['address'])) ? true : false; ?>
						<div class="mp-send-options" style="<?= $esconder ? 'display:none;' : '' ?>">
							<hr class="mp-separator"/>
							<fieldset class="mp-fieldset mp-checkboxes">
								<div class="mp-form-group">
									<label class="mp-label"><?= $data['formas_de_envio']?></label>
									<div class="mp-checkbox-group">
										<?php if(!empty($this->data['correio'])) { ?>
											<label class="mp-checkbox">
												<?php $checked = ('correio' == $inputs['shipping']) ? 'checked' : '' ?>
												<input <?= $checked ?> type="radio" name="shipping" value="correio"/>
												<span class="checkmark"></span>
												<span class="mp-checkbox-label">Correios</span>
											</label>
										<?php } ?>	
									</div>
								</div>
							</fieldset>
						</div>

						<fieldset class="mp-fieldset mp-selects" >
							<?php $display = ('correio' == $inputs['shipping']) ? '' : 'display:none;' ?>
							<div class="mp-form-group" data-shipping="correio" style="<?= $display ?>">
								<label class="mp-label">Correios: </label>
								<?php if(!empty($this->data['correio'])) { ?>
									<?php if ( isset($this->data['correio']['error'])): ?>
										<strong class="mp-primary-color">Atenção!</strong><br>
										<?php echo $this->data['correio']['error'] ?>
									<?php else: ?>
										<?php foreach($this->data['correio'] as $correio) { ?>
											<?php if (  $correio['ativo'] == false ): ?>
												<?php echo $correio['titulo'] ?>
												<br />
												<span class="mp-primary-color"><?php echo $correio['erro'] ?: 'Não disponível' ?></span>
												<br>
												<br>
											<?php else: ?>
												<input type="hidden" value='<?= base64_encode(json_encode($correio)); ?>' name="shipping_data_<?= $correio['codigo'] ?>" />
												<label class="mp-checkbox">
													<?php $checked = ($correio['codigo'] == $inputs['shipping_code']) ? 'checked' : '';  ?>
													<input <?= $checked ?> type="radio" data-value="<?= $correio['valor'] ?>" name="shipping_code" value="<?= $correio['codigo'] ?>" data-prazo="<?php echo str_replace ('-','/',$correio['prazoData']) ?>" data-titulo="<?php echo $correio['titulo'] ?>"/>
													<span class="checkmark"></span>
													<span class="mp-checkbox-label">
														<?php echo $correio['titulo'] ?>
														<strong>
															<?= $correio['codigo'] ?> 
															-
															<?php echo money($correio['valor']) ?>
														</strong>
														<?php if ( $correio['erro'] ): ?>
															<p class="mp-alert mp-alert-error mp-alert-light">
																<small>
																	<?= $correio['erro'] ?>
																</small>
															</p>
														<?php endif; ?>
													</span>
												</label>
											<?php endif; ?>
										<?php } ?>
										<span class="mp-alert mp-alert-error mp-alert-light">Prazo a partir do pagamento / envio de arte</span>
									<?php endif; ?>
								<?php }else{ ?>
									<strong class="mp-primary-color">Carrinho possui produtos sem envio via correios</strong>
								<?php } ?>
							</div>	
							
						</fieldset>
					</div>
				</div>
			</div>
			<div class="mp-checkout-content-footer">
				<div class="mp-errors mp-errors-right" style="display: <?= $this->data['errors'] ? 'block' : 'none' ?>;">
					<h4>Encontramos alguns erros!</h4>
					<div class="mp-errors-inner"><?php
						if ( $this->data['errors'] ) {
							foreach ($this->data['errors'] as $e) {
								?>
								<div class="mp-field"><label class="mp-error"><?= $e ?></label></div>
								<?php
							}
						}
					?></div>
				</div>
				<div class="mp-checkout-content-footer-left">
					<a href="<?= get_page_url('cart') ?>">
						<i class="mp-icon mp-icon-arrow-left-grey"></i><?= $data['botao_voltar']?>
					</a>
				</div>
				<div class="mp-checkout-content-footer-right">
					<button type="submit" class="mp-btn-primary"><?= $data['botao_avancar']?></button>
				</div>
			</div>
		</main>
		<aside class="mp-checkout-sidebar" style="order:<?= $data['posicao_sidebar'] === 'left' ? '-1': '0' ?>">
			<div class="sidebar-inner">
				<?php 
				echo (new View('checkout/sidebar', $this->data['sidebar']))->get() ?>
			</div>
		</aside>
	</form>
	<div class="mp-add-address-wrapper">
		<form action="#" class="mp-form mp-add-address">
			<div class="mp-container">
				<h3>Cadastrar endereço</h3>
				<div class="mp-form-row">
					<div class="mp-form-col-3">
						<div class="mp-form-group">
							<label class="mp-label" for="cep">CEP</label>
							<input type="text" name="cep" id="cep" class="mp-input" required>
						</div>
					</div>
					<div class="mp-form-col-3">
						<div class="mp-form-group">
							<label class="mp-label" for="estado">Estado</label>
							<select name="estado" id="estado" class="mp-select" required>
								<option value="">Estado</option>
								<?php foreach(config('states') as $key => $state) { ?>
									<option value="<?= $key ?>"><?= $state ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="mp-form-col-3">
						<div class="mp-form-group">
							<label class="mp-label" for="cidade">Cidade</label>
							<input type="text" name="cidade" id="cidade" class="mp-input" required>
						</div>
					</div>
					<div class="mp-form-col-5">
						<div class="mp-form-group">
							<label class="mp-label" for="rua">Rua</label>
							<input type="text" name="rua" id="rua" class="mp-input" required>
						</div>
					</div>
					<div class="mp-form-col-5">
						<div class="mp-form-group">
							<label class="mp-label" for="bairro">Bairro</label>
							<input type="text" name="bairro" id="bairro" class="mp-input" required>
						</div>
					</div>
				</div>
				<div class="mp-form-row">
					<div class="mp-form-col-3">
						<div class="mp-form-group">
							<label class="mp-label" for="numero">Numero</label>
							<input type="text" name="numero" id="numero" class="mp-input" required>
						</div>
					</div>
					<div class="mp-form-col-3">
						<div class="mp-form-group">
							<label class="mp-label" for="complemento">Complemento</label>
							<input type="text" name="complemento" id="complemento" class="mp-input">
						</div>
					</div>
					<div class="mp-form-col-3">
						<div class="mp-form-group">
							<label class="mp-label" for="telefone">Telefone</label>
							<input type="text" name="telefone" id="telefone" class="mp-input" required>
						</div>
					</div>
				</div>
				<div class="mp-form-footer">
					<button type="button" class="mp-btn-primary mp-close">Fechar</button>
					<button type="submit" class="mp-btn-primary mp-submit">Cadastrar</button>
				</div>
			</div>
		</form>
	</div>
</div>
<style type="text/css">
	.mp-icon-tooltip {
		position: absolute !important;
		background: silver !important;
		transform: translateY(-34%) !important;
		padding: 1px 12px !important;
		right: 0 !important;
		top: 50% !important;
		border-radius: 100% !important;
		font-size: 15px !important;
		color: #fff !important;
		width: 25px !important;
		height: 25px !important;
		display: flex !important;
		align-items: center;
		justify-content: center !important;
	}
	.mp-icon-tooltip::before {
		top: 6px !important;
	}
	.mp-icon-tooltip::after {
		transform: none !important;
		padding: 15px 10px !important;
		width: 100px;
		height: 20px;
		font-size: 1px;
	}
	.mp-icon-tooltip:hover:after {
		transform: none !important;
		padding: 15px 10px !important;
		width: 500px;
		height: 70px;
		font-size: 14px;
	}
	.btn-page {
	    display: inline-flex;
	    width: 32px;
	    justify-content: center;
	    padding: 10px;
	    background: var(--primary-color);
	    color: #fff;
	    cursor: pointer;
	    margin-bottom: 5px;
	}
	.btn-page.active {
	    background: #fff !important;
	    color: var(--primary-color) !important;
	    border: 1px solid var(--primary-color);
	}
	tr[data-page-index]{
		display: none;
	}
	tr[data-page-index].active{
		display: table-row;
	}
</style>

<script type="text/javascript">
	jQuery('body').on('click', '.btn-page', function(){
		var index = jQuery(this).data("page");
		jQuery("tr[data-page-index].active").removeClass("active");

		jQuery('tr[data-page-index="'+index+'"]').addClass("active");
		jQuery('.btn-page.active').removeClass("active");
		jQuery(this).addClass("active");
	});
</script>