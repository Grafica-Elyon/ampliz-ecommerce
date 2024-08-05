<?php
	use MisterPrint\Support\View;
	//exit('<pre>'.json_encode($this->data, JSON_PRETTY_PRINT));
	$product = $this->data['product'];
	$arts = $this->data['envio'];
	$desconto = $this->data['discount']?:0;
?>
<?php if ( !$product ): ?>
	<div class="mp-single-category mp-text-center">
		<div class="mp-heading">
			<div class="mp-heading-line">
				<h2 class="mp-head"><?= $this->data['params']['fail_titulo'] ?></h2>
			</div>
			<?php if ( isset( $this->data['params']['fail_subtitulo'] ) ) { ?>
				<p><?= $this->data['params']['fail_subtitulo']?></p>
			<?php } ?>
		</div>
		<?php if ( isset( $this->data['params']['fail_texto'] ) ) { ?>
			<hr>
			<p><?= $this->data['params']['fail_texto']?></p>
			<br>
		<?php } ?>
		<div>
			<a href="/" class="mp-btn-primary btn-send-art"><?= $this->data['params']['fail_voltar']?></a>
		</div>
	</div>
	<?php return; ?>
<?php endif; ?>



<div class="mp-single-category flexboxgrid row">
	<div class="mp-category-images col-xs-12 col-sm-4">
			<?php if (!empty($this->data['images'])) { ?>
				<?php foreach ($this->data['images'] as $image) { ?>
					<div class="mp-category-image">
						<img src="<?php echo $image ?>"/>
					</div>
				<?php } ?>
			<?php } else { ?>
				<div class="mp-category-image no-image">
					<img src="<?php echo config('plugin', 'url') ?>front/assets/imgs/logo.png"/>
				</div>
			<?php } ?>
		<br />
		<!-- SE O PRODUTO TIVER GABARITO -->
		<?php if($product["gabarito"] != "" || $product["gabarito_vertical"] != ""){?>
		<div class="mp-product-gabarito mp-text-center">
			<p>Download do Gabarito</p>
				<?php if($product["gabarito"]){?>
				<button type="button" id="horizontal" onclick="baixar('h')" class="mp-btn-darker-transparent">
					<i class="mp-icon mp-icon-download"></i> Horizontal
				</button>
				<?php } ?>
				<?php if($product["gabarito_vertical"]){?>
				<button type="button" id="vertical" onclick="baixar('v')" class="mp-btn-darker-transparent">
					<i class="mp-icon mp-icon-download"></i> Vertical
				</button>
				<?php } ?>
		</div>
		<?php } ?>
	</div>
	<div class="mp-category-content col-xs-12 col-sm-8">
		<h1 class="mp-category-title"><?php echo str_replace("*","",$this->data['name']) ?></h1>
		<div class="row">
			<div class="col-xs-12 col-sm-5">
				<strong class="mp-category-subtitle">Informações do produto</strong>
				<ul class="mp-category-list">

					<li><strong>Código:</strong> <?php echo $this->data['id'] ?></li>
					<?php if(!$product['hide_info']){?>
					<li><strong>Formato:</strong> <?php echo $this->data['format'] ?>cm</li>
					<li><strong>Cores:</strong> <?php echo $this->data['cor'] ?></li>
					<li><strong>Substrato:</strong> <?php echo $this->data['substrato'] ?></li>
					<li><strong>Cobertura:</strong> <?php echo $this->data['covering'] ?></li>
					<?php } ?>
					<li>
						<strong>Prazo de Produção:</strong>
						<?php if($this->data['prazo'] > 1) { ?>
							<?php echo $this->data['prazo'] ?> dias úteis
						<?php } else { ?>
							<?php echo $this->data['prazo'] ?> dia útil
						<?php } ?>
					</li>
				</ul>
			</div>
			<div class="col-xs-12 col-sm-7">
				<br />
				<?php if(user()->isLogged()) { ?>
					<div class="mp-add-to-cart-form">
						<form method="POST" action="<?= home_url('/wp-admin/admin-post.php') ?>" class="mp-form">
							<input type="hidden" name="action" value="mp_add_to_cart">
							<input type="hidden" name="data[product]" value="<?php echo $this->data['id'] ?>">
							<input type="hidden" name="data[unit_price]" value="<?php echo str_replace(',', '.', $this->data['price']) ?>">
							<div class="mp-form-group">
								<label class="mp-label">Quantidade</label>
								<div class="mp-input-group">
								<!-- SE A QUANTIDADE MINIMA E MAXIMA SÃO A MESMA ENTÃO SO SE VENDE UMA UNIDADE DELE -->
								<?php if($product['quantidade_maxima'] == $product['quantidade_minima']){ ?>
									<input type="number" class="mp-input" value="<?php echo $product['quantidade_maxima']; ?>" name="data[custom_quantity]" readonly data-minimum="<?php echo $this->data['minimum'] * $this->data['quant'] ?>"/>
									<?php }else{ ?>
									<input type="number" class="mp-input" value="<?php echo $this->data['minimum'] * $this->data['quant'] ?>" data-minimum="<?php echo $this->data['minimum'] * $this->data['quant'] ?>" name="data[custom_quantity]"/>
									<?php } ?>
								</div>
							</div>
							<!-- SE NÃO HOUVER ARTE, NÃO HÁ FORMA DE ENVIO -->
							<?php if(!$product['without_art']) { ?>
							<div class="mp-form-group">
								<label class="mp-label">Forma de envio</label>
								<select class="mp-select" name="data[art]">
									<?php foreach ($arts as $a): ?>
										<option value="<?= $a['id'] ?>"
												data-price="<?= str_replace(',', '.', $a['preco']) ?>"
												data-price-mod="<?= str_replace(',', '.', $a['preco_adic_modulo']) ?>"
											>
											<?= ucfirst(trim(str_replace('Enviar arquivo para','', $a['title']))) ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							<?php }else{ ?>
								<input type="hidden" name="data[art]" value="1">
							<?php } ?>

							<?php if($product['acabamentos']){?>
							<div class="mp-form-group">
								<label class="mp-label">Acabamentos</label>
								<?php echo (new View('category/configuration/finishing', [
									'items' => $product['acabamentos'],
									'titulo' => '',
									'name' => 'data[configuration_finishing]',
									'painel_2_sem_dados' => 'Sem acabamento',
								]))->get() ?>
							</div>
							<?php } ?>
							<table class="mp-table mp-prices-table mp-product-prices-table">
								<tbody class='form-valid'>
									<tr>
										<td class="prazo">Prazo: <span></span>du</td>
										<td rowspan="2">
											<button type="submit" class="mp-btn-primary mp-btn mp-btn-sm pull-right">Comprar</button>
										</td>
									</tr>
									<tr>
										<td>
											<div class="mp-prev-price" <?php if ( $this->data['prev_price'] == $this->data['price'] ) echo 'style="display: none"' ?>>
												De:
												<del class="money-sm money-no-space"><?php echo $this->data['prev_price'] ?></del>
											</div>
											<div class="mp-price">
												<span class="not-on-prev-price not-on-art">
													Total:
												</span>
												<span class="not-on-prev-price on-art">
													Sub-total:
												</span>
												<span class="on-prev-price not-on-art">
													Total:
												</span>
												<span class="on-prev-price on-art">
													Por:
												</span>
												<b class="money-sm money-no-space mp-primary-color"><?php echo $this->data['price'] ?></b>
											</div>
											<div class="mp-art-price" style="display:none">
												Arte:
												<b class="money-sm money-no-space"><?php echo $this->data['price'] ?></b>
											</div>
											<div class="mp-total-price">
												Total:
												<b class="money-sm money-no-space mp-primary-color"><?php echo $this->data['price'] ?></b>
											</div>
										</td>
									</tr>
								</tbody>
								<tbody class='form-invalid'>
									<tr>
										<td class="mp-errors-container"></td>
									</tr>
								</tbody>
								<tbody class="form-loading">
									<tr>
										<td>
											<h3>
												Calculando...
											</h3>
										</td>
									</tr>
								</tbody>
							</table>
						</form>
					</div>

				<?php } else { ?>
					<div class="mp-text-center">
						<p>Para visualizar o produto é necessario estar logado</p>
						<a href="<?php echo \get_page_url('login').'?redirectTo='.urlencode($_SERVER['REQUEST_URI']); ?>" class="mp-btn-primary mp-btn">Login/Cadastro</a>
					</div>
				<?php } ?>
			</div>
		</div>
		<hr/>
		<strong class="mp-category-subtitle">Descrição</strong>
		<p><?php echo nl2br($this->data['description']) ?></p>
	</div>
</div>
<?= (new View('data-layers/product', [
	[
		'name' => "{$product['name']} {$product['substrato']} {$product['gramatura']}g/m² {$product['cor']}",
		'id' => $product['id'],
		'price' => $product['preco'],
		'brand' => $product['modelo'],
		'category' => $product['name'],
	]
]))->get() ?>

<script type="text/javascript">
	function baixar(hv){
		var x = jQuery('.finishing-options .mp-checkbox input:checked');
		var resposta = x[0] ? x[0].value :'nenhum';
		window.open("<?php echo config('plugin','api'); ?>gabarito/<?php echo $product['id'] ?>/"+hv+"/"+resposta, '_blank');
	}
</script>
