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
	'balcony_cep' => null,
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
	'balcony_state' => null,
	'balcony_city' => null,
	'balcony_cod' => null
], $this->data['data']); 

$this->data['balconies'] = $this->data['balconies'] == null ? [] : $this->data['balconies'];
$this->data['balconies_nearby'] = $this->data['balconies_nearby'] == null ? [] : $this->data['balconies_nearby'];
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
						<div class="mp-item">
							<label class="mp-checkbox">
								<?php $checked = ('withdraw' == $inputs['shipping_type']) ? 'checked' : '' ?>
								<input <?= $checked ?> type="radio" name="shipping_type" value="withdraw">
								<span class="checkmark"></span>
								<div class="mp-checkbox-label mp-font-lg"><strong>Retirar Pessoalmente</strong></div>
							</label>
						</div>
						<?php if(intval($this->data['data']['remessa_direta_ativa']) > 0){ ?>
						<div class="mp-item">
							<label class="mp-checkbox">
								<?php $checked = ('direct' == $inputs['shipping_type']) ? 'checked' : '' ?>
								<input <?= $checked ?> type="radio" name="shipping_type" value="direct">
								<span class="checkmark"></span>
								<div class="mp-checkbox-label mp-font-lg"><strong>Enviar para meu cliente</strong></div>
							</label>
						</div>
						<?php } ?>
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
										<?php if(isset($this->data['melhor_envio']) && $this->data['melhor_envio'] !== false) { ?>
											<label class="mp-checkbox">
												<?php $checked = ('melhor_envio' == $inputs['shipping']) ? 'checked' : '' ?>
												<input <?= $checked ?> type="radio" name="shipping" value="melhor_envio"/>
												<span class="checkmark"></span>
												<span class="mp-checkbox-label">Melhor envio</span>
											</label>
										<?php } ?>
										<?php if(!empty($this->data['motoboy'])) { ?>
											<label class="mp-checkbox">
												<?php $checked = ('motoboy' == $inputs['shipping']) ? 'checked' : '' ?>
												<input <?= $checked ?> type="radio" name="shipping" value="motoboy"/>
												<span class="checkmark"></span>
												<span class="mp-checkbox-label">Motoboy</span>
											</label>
										<?php } ?>
										<?php if(!empty($this->data['astrolog'])) { ?>
											<label class="mp-checkbox">
												<?php $checked = ('astrolog' == $inputs['shipping']) ? 'checked' : '' ?>
												<input <?= $checked ?> type="radio" name="shipping" value="astrolog"/>
												<span class="checkmark"></span>
												<span class="mp-checkbox-label">Astrolog</span>
											</label>
										<?php } ?>
										<label class="mp-checkbox">
											<?php $checked = ('transportadora' == $inputs['shipping']) ? 'checked' : '' ?>
											<input <?= $checked ?> type="radio" name="shipping" value="transportadora"/>
											<span class="checkmark"></span>
											<span class="mp-checkbox-label">Transportadora indicada pelo cliente</span>
										</label>
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
							<?php $display = ('melhor_envio' == $inputs['shipping']) ? '' : 'display:none;' ?>
							<div class="mp-form-group" data-shipping="melhor_envio" style="<?= $display ?>">
								<label class="mp-label">Melhor Envio: </label>
								<?php if(!empty($this->data['melhor_envio'])) { ?>
									<?php foreach($this->data['melhor_envio'] as $melhor_envio) { ?>
									<?php if(isset($melhor_envio['id'])) { ?>
										<?php  $name = "MENV-".$melhor_envio['company']['name']."-".str_replace("-", "_",$melhor_envio['name']); 
										?>
									<input type="hidden" value='<?= base64_encode(json_encode($melhor_envio)); ?>' name="shipping_data_<?= $name ?>" />
									<label class="mp-checkbox">
										<?php $checked = ($name == $inputs['shipping_code']) ? 'checked' : '';  ?>
										<input <?= $checked ?> type="radio" data-value="<?= $melhor_envio['price'] ?>" name="shipping_code" value="<?= $name ?>" data-prazo="<?php echo str_replace ('-','/',$melhor_envio['prazoData']) ?>" data-titulo="<?php echo $name ?> escolhido via CEP"/>
										<span class="checkmark"></span>
										<span class="mp-checkbox-label">
											<?php echo $name ?>
											<strong><?php echo money($melhor_envio['price']) ?> -
											<?= $melhor_envio['custom_delivery_time'] ?> <?= $melhor_envio['custom_delivery_time'] <= 1 ? 'Dia útil' : 'Dias úteis' ?>
											</strong>
										</span>
									</label>
									<?php } ?>
									<?php } ?>
									<span class="mp-alert mp-alert-error mp-alert-light">Prazos de produção e entrega são contados a partir da confirmação do pagamento e envio da arte</span>
								<?php } ?>
							</div>
							<?php $display = ('transportadora' == $inputs['shipping']) ? '' : 'display:none;' ?>
							<div class="mp-form-group" data-shipping="transportadora" style="<?= $display ?>">
								<label class="mp-label">Transportadora: </label>
								<?php if(!empty($this->data['transportadora'])) { ?>
									<?php foreach($this->data['transportadora'] as $transportadora) { ?>
										<input type="hidden" value='<?= base64_encode(json_encode($transportadora)); ?>' name="shipping_data_<?= $transportadora['codigo'] ?>" />
										<label class="mp-checkbox">
											<?php $checked = ($transportadora['codigo'] == $inputs['shipping_code']) ? 'checked' : '';  ?>
											<input <?= $checked ?> type="radio" data-value="<?= $transportadora['valor'] ?>" name="shipping_code" value="<?= $transportadora['codigo'] ?>" data-titulo="<?= $transportadora['titulo']; ?>" data-prazo="-" />
											<span class="checkmark"></span>
											<span class="mp-checkbox-label"><?php echo $transportadora['titulo'] ?></span>
										</label>
									<?php } ?>
								<?php }else{ ?>
									<strong class="mp-primary-color">Carrinho possui produtos sem envio via transportadora</strong>
								<?php } ?>
							</div>

							<?php $display = ('astrolog' == $inputs['shipping']) ? '' : 'display:none;' ?>
							<div class="mp-form-group" data-shipping="astrolog" style="<?= $display ?>">
								<label class="mp-label">Astrolog: </label>
								<?php if(!empty($this->data['astrolog'])) { ?>
									<?php foreach($this->data['astrolog'] as $astrolog) { ?>
										<?php if(isset($astrolog['codigo'])){ ?>
										<input type="hidden" value='<?= base64_encode(json_encode($astrolog)); ?>' name="shipping_data_<?= $astrolog['codigo'] ?>" />
										<label class="mp-checkbox">
											<?php $checked = ($astrolog['codigo'] == $inputs['shipping_code']) ? 'checked' : '';  ?>
											<input <?= $checked ?> type="radio" data-value="<?= $astrolog['valor'] ?>" name="shipping_code" value="<?= $astrolog['codigo'] ?>" data-titulo="<?= $astrolog['titulo']; ?>" data-prazo="<?= str_replace('-','/',$astrolog['previsao']); ?>" />
											<span class="checkmark"></span>
											<span class="mp-checkbox-label"><?php echo $astrolog['titulo'] ?></span>
											<span><strong><?php echo money($astrolog['valor']) ?></strong></span>
										</label>
									<?php }else{ ?>
										<strong class="mp-primary-color"><?= $astrolog ?></strong>
									<?php } 
									}
								} ?>
							</div>

							<?php $display = ('motoboy' == $inputs['shipping']) ? '' : 'display:none;' ?>
							<div class="mp-form-group" data-shipping="motoboy" style="<?= $display ?>">
								<label class="mp-label">Motoboy: </label>
								<?php if(!empty($this->data['motoboy'])) { ?>
									<?php if ( isset($this->data['motoboy']['valid']) && $this->data['motoboy']['valid'] == false ): ?>
										<strong class="mp-primary-color"><?php echo $this->data['motoboy']['error'] ?></strong><br>
										
									<?php else: ?>
										<?php foreach($this->data['motoboy'] as $motoboy) { ?>
											<input type="hidden" value='<?= base64_encode(json_encode($motoboy)); ?>' name="shipping_data_<?= $motoboy['codigo'] ?>" />
											<label class="mp-checkbox">
												<?php $checked = ($motoboy['codigo'] == $inputs['shipping_code']) ? 'checked' : '';  ?>
												<input <?= $checked ?> type="radio" data-value="<?= $motoboy['valor'] ?>" name="shipping_code" value="<?= $motoboy['codigo'] ?>" data-titulo="<?php echo $motoboy['titulo']; ?>" data-prazo="-"/>
												<span class="checkmark"></span>
												<span class="mp-checkbox-label"><?php echo $motoboy['titulo'] ?>
													<strong><?php echo money($motoboy['valor']) ?></strong>
												</span>
											</label>
										<?php } ?>
									<?php endif; ?>
								<?php }else{ ?>
									<strong class="mp-primary-color">Carrinho possui produtos sem envio via motoboy</strong>
								<?php } ?>
							</div>
						</fieldset>
					</div>
					<div data-type="withdraw" style="<?= ('withdraw' != $inputs['shipping_type']) ? 'display:none;' : '' ?>">
						<fieldset class="mp-fieldset">
							<h3 class="mp-painel-title">Retirar no balcão:</h3>
							<p><?= $data['subtitulo_balcao'] ?></p>
							<div id="procurar-balcao-tipo" class="mp-listing" data-item="3">
								<div class="mp-item">
									<label class="mp-checkbox">
										<?php $checked_cep = $this->data['data']['tipo-procura-balcao'] == 'cep' ? 'checked':'' ?>
										<input <?= $checked_cep ?> type="radio" name="tipo-procura-balcao" value="cep">
										<span class="checkmark"></span>
										<div class="mp-checkbox-label mp-font-lg"><strong>Por CEP</strong></div>
									</label>
								</div>
								<div class="mp-item">
									<label class="mp-checkbox">
										<?php $checked_cidade = $this->data['data']['tipo-procura-balcao'] == 'cidade' ? 'checked':'' ?>
										<input <?= $checked_cidade ?> type="radio" name="tipo-procura-balcao" value="cidade">
										<span class="checkmark"></span>
										<div class="mp-checkbox-label mp-font-lg"><strong>Pela Cidade</strong></div>
									</label>
								</div>
								<div class="mp-item">
									<label class="mp-checkbox">
										<?php $checked_cod = $this->data['data']['tipo-procura-balcao'] == 'cod' ? 'checked':'' ?>
										<input <?= $checked_cod ?> type="radio" name="tipo-procura-balcao" value="cod">
										<span class="checkmark"></span>
										<div class="mp-checkbox-label mp-font-lg"><strong>Pelo código</strong></div>
									</label>
								</div>
							</div>
							<div class="mp-form-row">
								<div class="mp-form-col-3 forma-de-procura" data-tipo="cep"  <?php if($checked_cep == false) echo 'style="display: none"' ?>>
									<div class="mp-form-group">
										<label class="mp-label">CEP</label>
										<input class="mp-input" type="text" name="balcony_cep"
											value="<?= empty($inputs['balcony_cep']) ? $this->data['user_cep' ]: $inputs['balcony_cep']; ?>"
											placeholder="00000-000" />
									</div>
								</div>
								<div class="mp-form-col-3 forma-de-procura" data-tipo="cidade" <?php if($checked_cidade == false) echo 'style="display: none"' ?>>
									<div class="mp-form-group">
										<label class="mp-label">Estado</label>
										<select class="mp-select" name="balcony_state">
											<option value="">Selecione</option>
											<?php foreach(config('states') as $key => $state) { ?>
												<option <?php echo ($key == $inputs['balcony_state']) ? 'selected="selected"' : '' ?> value="<?php echo $key ?>"><?php echo $state ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="mp-form-col-3 forma-de-procura" data-tipo="cidade" <?php if($checked_cidade == false) echo 'style="display: none"' ?>>
									<div class="mp-form-group">
										<label class="mp-label">Cidade</label>
										<input class="mp-input" type="text" name="balcony_city"
											value="<?= isset($inputs['balcony_city']) ? $inputs['balcony_city'] : ''; ?>"
											placeholder="Cidade"  />
									</div>
								</div>
								<div class="mp-form-col-3 forma-de-procura" data-tipo="cod" <?php if($checked_cod == false) echo 'style="display: none"' ?>>
									<div class="mp-form-group">
										<label class="mp-label">Codigo do Balcão</label>
										<input class="mp-input" type="text" name="balcony_cod"
										value="<?= isset($inputs['balcony_cod']) ? $inputs['balcony_cod'] : '' ?>"
										placeholder="COD" />
									</div>
								</div>
							</div>
							<div class="forma-de-procura" data-tipo="all" <?php if( isset($this->data['data']['tipo-procura-balcao']) == false ) echo 'style="display: none"' ?>>
								<div class="mp-form-group">
									<button type="button" id="get_balconies" class="mp-btn-primary">Pesquisar</button>
								</div>
							</div>
							<br><br>
							<?php 
								$todos = count($this->data['balconies']); 
								$todos += $this->data['balconies_nearby'] == null ? 0 : count($this->data['balconies_nearby']); 
								if($todos == 0){
									?><strong class="mp-primary-color">Carrinho possui produtos sem envio para balcões</strong><?php
								} 
							?>
							<div>
							<?php foreach ($this->data['balconies_nearby'] as $key => $balcony) { ?>
								<input type="hidden" value='<?= base64_encode(json_encode($balcony)); ?>' name="shipping_data_<?= $balcony['codigo'] ?>" />
							<?php } ?>
							<?php foreach ($this->data['balconies'] as $key => $balcony) { ?>
								<input type="hidden" value='<?= base64_encode(json_encode($balcony)); ?>' name="shipping_data_<?= $balcony['codigo'] ?>" />
							<?php } ?>
							<div class="mp-form-group" style="<?= (empty($this->data['balconies_nearby']) && empty($this->data['balconies'])) ? 'display:none;' : ''; ?>">
								<label class="mp-label">Balcões</label>
								<div class="mp-cart-table">
									<table cellpadding="1" cellspacing="1">
										<thead>
											<tr>
												<th></th>
												<th>ID</th>
												<th>Endereço</th>
												<th>Prazo</th>
												<th width="20%" style="text-align: center;">Valor</th>
											</tr>
										</thead>
										<tbody id="tbl-balcony">
											<?php $i = 1; $page_index=1; $itens = count($this->data['balconies'])+count($this->data['balconies_nearby']); $TAM_PAG = 10;
											if($itens > $TAM_PAG){ 
												$pages = ($itens / $TAM_PAG);
												$pages += $itens%$TAM_PAG > 0 ? 1 : 0; 
											} ?>
											<?php foreach($this->data['balconies_nearby'] as $balcony) { ?>
												<tr data-page-index="<?= $page_index; ?>" class="<?= $page_index==1? 'active':''; ?>" style="<?= isset($balcony['tamanho_maximo']) ? 'color:#ccc;':''; ?>">
													<td style="vertical-align: middle;<?= isset($balcony['tamanho_maximo']) ? 'pointer-events:none;':''; ?>">
														<label class="mp-checkbox-only">
															<?php $checked = ($balcony['codigo'] == $inputs['shipping_code']) &&
															!isset($balcony['tamanho_maximo'])
															? 'checked' 
															: '';  
															?>
															<input <?= $checked ?> type="radio" name="shipping_code" data-value="<?= $balcony['valor'] ?>" value="<?= $balcony['codigo'] ?>" data-titulo="<?= $balcony['titulo'] ?>" data-prazo="<?= date('d/m/Y', strtotime($balcony['dataPrevisao'])) ?>"/>
															<span class="checkmark <?= isset($balcony['tamanho_maximo']) ? 'disabled_checkmark':''; ?>"></span>
														</label>
													</td>
													<td style="vertical-align: middle;"><?= $balcony['codigo']; ?></td>
													<td style="vertical-align: middle;">
														<strong><?= $balcony['titulo']; ?></strong><br />
														<sub><?= $balcony['detalhe']; ?></sub>
													</td>
													<?php  if(substr($balcony['codigo'], 0, 2) == "BR"){
														$menosTres = $balcony['prazo'] - 3; ?>
														<td style="vertical-align: middle;"><?= $balcony['prazo'] ? "{$menosTres} a {$balcony['prazo']} dias úteis" : 'Sem acréscimo'; ?></td>
														<?php
													}else{?>
														<td style="vertical-align: middle;"><?= $balcony['prazo'] ? "{$balcony['prazo']} dias úteis" : 'Sem acréscimo'; ?></td>
													<?php } ?>
													<td style="vertical-align: middle;text-align: center;position:relative;">
														<?= intval($balcony['valor']) > 0 ? \money($balcony['valor']) : "Grátis"; ?>
													</td>
													<td style="vertical-align: middle;text-align: center;position:relative;">
														<?= isset($balcony['tamanho_maximo']) 
															? '<span class="mp-icon-tooltip" data-tooltip="'.$data['texto_tooltip'].'" >
																	i
																</span>
															':'<span class="mp-icon-tooltip" data-tooltip="O prazo de entrega inicia a partir da finalização de produção do último item" >
																	i
																</span>'; 
														?>
													</td>
												</tr>
											<?php } ?>

											<?php foreach($this->data['balconies'] as $key => $balcony) { ?>
												<tr data-page-index="<?= $page_index; ?>" class="<?= $page_index==1? 'active':''; ?>" style="<?= isset($balcony['tamanho_maximo']) ? 'color:#ccc;':''; ?>">
													<td style="vertical-align: middle;<?= isset($balcony['tamanho_maximo']) ? 'pointer-events:none;':''; ?>">
														<label class="mp-checkbox-only">
															<?php $checked = ($balcony['codigo'] == $inputs['shipping_code']) &&
															!isset($balcony['tamanho_maximo'])
															? 'checked' 
															: '';  
															?>
															<input <?= $checked ?> type="radio" name="shipping_code" data-value="<?= $balcony['valor'] ?>" value="<?= $balcony['codigo'] ?>" data-titulo="<?= $balcony['titulo'] ?>" data-prazo="<?= date('d/m/Y', strtotime($balcony['dataPrevisao'])) ?>"/>
															<span class="checkmark <?= isset($balcony['tamanho_maximo']) ? 'disabled_checkmark':''; ?>"></span>
														</label>
													</td>
													<td style="vertical-align: middle;"><?= $balcony['codigo']; ?></td>
													<td style="vertical-align: middle;">
														<strong><?= $balcony['titulo']; ?></strong><br />
														<sub><?= $balcony['detalhe']; ?></sub>
													</td>
													<?php  if(substr($balcony['codigo'], 0, 2) == "BR"){
														$menosTres = $balcony['prazo'] - 3; ?>
														<td style="vertical-align: middle;"><?= $balcony['prazo'] ? "{$menosTres} a {$balcony['prazo']} dias úteis" : 'Sem acréscimo'; ?></td>
														<?php
													}else{?>
														<td style="vertical-align: middle;"><?= $balcony['prazo'] ? "{$balcony['prazo']} dias úteis" : 'Sem acréscimo'; ?></td>
													<?php } ?>
													<td style="vertical-align: middle;text-align: center;position:relative;">
														<?= intval($balcony['valor']) > 0 ? \money($balcony['valor']) : "Grátis"; ?>
													</td>
													<td style="vertical-align: middle;text-align: center;position:relative;">
														<?= isset($balcony['tamanho_maximo']) 
															? '<span class="mp-icon-tooltip" data-tooltip="'.$data['texto_tooltip'].'" >
																	i
																</span>
															':'<span class="mp-icon-tooltip" data-tooltip="O prazo de entrega inicia a partir da finalização de produção do último item" >
																	i
																</span>'; 
														?>
													</td>
												</tr>
												<?php $i++; ?>
												<?php if($i > 1 && $i%$TAM_PAG == 1) $page_index++; ?>
											<?php } ?>
										</tbody>
									</table>
										<?php $itens = count($this->data['balconies']);
										if($itens > $TAM_PAG){ 
											$pages = ($itens / $TAM_PAG);
											$pages += $itens%$TAM_PAG > 0 ? 1 : 0;
										?><div class="mp-painel-body"><?php
												for ($count=1; $count <= $pages ; $count++) {?>	
												<div class="btn-page <?= $count==1?'active':'' ?>" data-page="<?= $count ?>"><?= $count ?></div>
												<?php } 
										?></div><?php
										} ?>
									
									<script type="text/javascript">
										window.balconies = <?php echo json_encode($this->data['balconies']);?>;
										console.log(window.balconies);
									</script>
								</div>
							</div>
						</fieldset>
					</div>
					<div data-type="direct" style="<?= ('direct' != $inputs['shipping_type']) ? 'display:none;' : '' ?>">
						<fieldset class="mp-fieldset">
							<h3 class="mp-painel-title">Endereço do cliente: </h3>
							<div class="mp-form-row">
								<div class="mp-form-col-4 mp-form-col-md-10">
									<div class="mp-form-group">
										<label class="mp-label">Nome: </label>
										<input class="mp-input" type="text" name="direct_name"
											value="<?= $inputs['direct_name'] ?: $this->data['data']['past']['direct_name']; ?>"
											placeholder="Nome Completo" />
									</div>
								</div>
								<div class="mp-form-col-3 mp-form-col-md-6">
									<div class="mp-form-group">
										<label class="mp-label">Documento: </label>
										<input class="mp-input" type="text" name="direct_document"
										value="<?= $inputs['direct_document'] ?: $this->data['data']['past']['direct_document']; ?>"
										placeholder="" />
										<input type="hidden" name="direct_document_type" value="<?= $inputs['direct_document_type']; ?>"/>
									</div>
								</div>
								<div class="mp-form-col-3 mp-form-col-md-4">
									<div class="mp-form-group">
										<label class="mp-label">Tipo: </label>
										<div id="tipo-documento" class="mp-btn-group mp-btn-group-selection">
											<button
												style="width: 50%"
												class="mp-btn mp-btn-sm <?= $inputs['direct_document_type']!='cnpj'? 'mp-btn-primary' : 'mp-btn-darker-transparent'?>"
												type="button"
												value="cpf">
												CPF
											</button>
											<button
												style="width: 50%"
												class="mp-btn mp-btn-sm <?= $inputs['direct_document_type']=='cnpj'? 'mp-btn-primary' : 'mp-btn-darker-transparent'?>"
												type="button"
												value="cnpj">
												CNPJ
											</button>
										</div>
									</div>
								</div>
							</div>
							<div class="mp-form-row">
								<div class="mp-form-col-4">
									<div class="mp-form-group">
										<label class="mp-label">Valor Declarado: </label>
										<input class="mp-input" type="text" name="direct_value"
											value="<?= $inputs['direct_value'] ?: $this->data['data']['past']['direct_value']; ?>"
											placeholder="00,00" />
									</div>
								</div>
								<div class="mp-form-col-3">
									<div class="mp-form-group">
										<label class="mp-label">CEP: </label>
										<input class="mp-input" type="text" name="direct_cep"
											value="<?= $inputs['direct_cep'] ?: $this->data['data']['past']['direct_cep']; ?>"
											placeholder="00000-000" />
									</div>
								</div>
								<div class="mp-form-col-3">
									<div class="mp-form-group">
										<label class="mp-label"> </label>
										<button type="button" id="get_remessa" class="mp-btn-primary">Pesquisar</button>
									</div>
								</div>
								<?php if ( !$inputs['direct_cep'] && $this->data['data']['past']['direct_cep'] ): ?>
									<script type="text/javascript">
										btnr=document.querySelectorAll('#get_remessa');setTimeout(function(){btnr[btnr.length-1].click()},500);
									</script>
								<?php endif; ?>
							</div>
							<div class="mp-form-row">
								<div class="mp-form-col-6">
									<div class="mp-form-group">
										<label class="mp-label">Endereço: </label>
										<input class="mp-input" type="text" name="direct_endereco"
											value="<?= $inputs['direct_endereco'] ?: $this->data['data']['past']['direct_endereco'] ?>"
											<?php if ( $inputs['direct_endereco'] ) echo "disabled" ?>
											placeholder="Rua MisterPrint" />
									</div>
								</div>
								<div class="mp-form-col-2">
									<div class="mp-form-group">
										<label class="mp-label">Nº:</label>
										<input class="mp-input" type="text" name="direct_numero"
											value="<?= $inputs['direct_numero'] ?: $this->data['data']['past']['direct_numero'] ?>"
											placeholder="123" />
									</div>
								</div>
								<div class="mp-form-col-2">
									<div class="mp-form-group">
										<label class="mp-label">Comp:</label>
										<input class="mp-input" type="text" name="direct_complemento"
											value="<?= $inputs['direct_complemento'] ?: $this->data['data']['past']['direct_complemento'] ?>"
											placeholder="Apto 2" />
									</div>
								</div>
							</div>
							<div class="mp-form-row">
								<div class="mp-form-col-4">
									<div class="mp-form-group">
										<label class="mp-label">Bairro: </label>
										<input class="mp-input" type="text" name="direct_bairro"
											value="<?= $inputs['direct_bairro'] ?: $this->data['data']['past']['direct_bairro'] ?>"
											<?php if ( $inputs['direct_bairro'] ) echo "disabled" ?>
											placeholder="Bairro" />
									</div>
								</div>
								<div class="mp-form-col-3">
									<div class="mp-form-group">
										<label class="mp-label">Cidade: </label>
										<input class="mp-input" type="text" name="direct_cidade"
											value="<?= $inputs['direct_cidade'] ?: $this->data['data']['past']['direct_cidade'] ?>"
											<?php if ( $inputs['direct_cidade'] ) echo "disabled" ?>
											placeholder="Cidade" />
									</div>
								</div>
								<div class="mp-form-col-3">
									<div class="mp-form-group">
										<label class="mp-label">Estado: </label>
										<input class="mp-input" type="text" name="direct_uf"
											value="<?= $inputs['direct_uf'] ?: $this->data['data']['past']['direct_uf'] ?>"
											<?php if ( $inputs['direct_uf'] ) echo "disabled" ?>
											placeholder="Estado" />
									</div>
								</div>
							</div>
							<div class="mp-form-group">
								<label class="mp-label">Remessa Direta: </label>
								<?php if(!empty($this->data['remessa'])) { ?>
									<?php if ( isset($this->data['remessa']['valid']) && $this->data['remessa']['valid'] == false ): ?>
										<strong class="mp-primary-color">Erro</strong><br>
										<?php echo $this->data['remessa']['error'] ?>

									<?php else: ?>
										<?php foreach($this->data['remessa'] as $remessa) { ?>

											<?php if (  $remessa['ativo'] == false ): ?>
												<?php echo $remessa['titulo'] ?>
												<br />
												<span class="mp-primary-color"><?php echo $remessa['erro'] ?: 'Não disponível' ?></span>
												<br>
												<br>

											<?php else: ?>
												<input type="hidden" value='<?= base64_encode(json_encode($remessa)); ?>' name="shipping_data_<?= $remessa['codigo'] ?>" />
												<label class="mp-checkbox">
													<?php $checked = ($remessa['codigo'] == $inputs['shipping_code']) ? 'checked' : '';  ?>
													<input <?= $checked ?> type="radio" data-value="<?= $remessa['valor'] ?>" name="shipping_code" value="<?= $remessa['codigo'] ?>" data-prazo="<?= $remessa['prazoData']; ?>" data-titulo="<?= $remessa['titulo']; ?>"/>
													<span class="checkmark"></span>
													<span class="mp-checkbox-label"><?php echo $remessa['titulo'] ?>
														<strong><?php echo money($remessa['valor']) ?></strong>
													</span>
												</label>
											<?php endif; ?>
										<?php } ?>
									<?php endif; ?>
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