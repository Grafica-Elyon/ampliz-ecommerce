<?php use MisterPrint\Support\View; 
 $data = $this->data['vc_data'] ;
 ?>
<div class="mp-heading">
	<div class="mp-heading-line">
		<h2 class="mp-head"><?= $data['titulo'] ?></h2>
	</div>
	<p><?= $data['subtitulo'] ?></p>
</div>
<div class="mp-category-config">
	<?php if (!$this->data['has_category']) { ?>
		<div class="mp-alert mp-alert-error">Produto não encontrado. <a href="<?php echo home_url() ?>">Voltar</a></div>
	<?php } else { ?>
		<form class="mp-category-config-form mp-form">
			<div class="content">
				<main>
					<div class="mp-config-content active" data-configuration-step="1">
						<div class="mp-painel">
							<div class="mp-painel-header mp-has-counter">
								<div class="mp-painel-counter">1</div>
								<h3 class="mp-painel-title"><?= $data['titulo_painel_1'] ?></h3>
								<p><?= $data['subtitulo_painel_1'] ?></p>
							</div>

							<div class="mp-painel-body">
								<div class="art">
									<h3 class="mp-painel-title"><?= $data['painel_1_titulo_arte'] ?></h3>
								<?php if($this->data['has_arts'] == 1){ ?>
									<?php 
									$indice = 1;
									$tamanho = count($this->data['arts']);
									foreach($this->data['arts'] as $art) { 
										if($art['id'] != 8){?>
										<label class="mp-checkbox has-description">
											<input type="radio" name="art" <?= $art['selected'] ? 'checked' : '' ; ?> value="<?php echo $art['id'] ?>" data-value="<?php echo $art['title'] ?>" data-price="<?php echo $art['preco'] ?>" data-adic-price="<?= $art['preco_adic_modulo'] ?>">
											<span class="checkmark"></span>
											<div class="mp-checkbox-label">
												<strong><?php echo $art['title'] ?> - <?= 
													floatval(str_replace(",",".",$art['preco'])) > 0.0? '<span class="mp-grey">(A partir de R$'.$art['preco'].')</span>': '<span class="mp-grey">Grátis</span>'
													?></strong>

												<?php if($art['title'] == 'Enviar arquivo pronto para impressão') { ?>
													<span class="mp-tooltip" data-tooltip="<?= $data['painel_1_enviar_arte_info'] ?>"=>i</span>
												<?php } ?>

												<?php if($art['title'] == 'Enviar arquivo pronto para impressão com verificação técnica em 2 horas úteis') { ?>
													<span class="mp-tooltip" data-tooltip="<?= $data['painel_1_contratacao_info'] ?>"=>i</span>
												<?php } ?>

												<?php if($art['title'] == 'Enviar arquivo para verificação técnica e ajuste para impressão') { ?>
													<span class="mp-tooltip" data-tooltip="<?= $data['painel_1_alteracao_arte_info'] ?>"=>i</span>
												<?php } ?>

												<?php echo $art['desc'] ?>
											</div>

											<?php if($art['title'] == 'Enviar arte') { ?>
												<a class="mp-description" href="<?= $data['painel_1_enviar_arte_url'] ?>"><i class="mp-icon icon-star"></i></a>
											<?php } ?>

											<?php if($art['title'] == 'Contratar criação') { ?>
												<a class="mp-description" href="<?= $data['painel_1_contratacao_url'] ?>"><i class="mp-icon icon-star"></i></a>
											<?php } ?>

											<?php if($art['title'] == 'Alteração de arte') { ?>
												<a class="mp-description" href="<?= $data['painel_1_alteracao_arte_url'] ?>"><i class="mp-icon icon-star"></i></a>
											<?php } ?>
										</label>
											<?php 
											if ($indice < $tamanho) {
										        echo "<hr/>";
										    }
											$indice++; ?>
										
									
									<?php }
									} ?>
								</div>
								<?php }else { 
									foreach($this->data['arts'] as $art) { 
										if($art['id'] == 8){?>
									<label class="mp-checkbox has-description">
										<input type="radio" name="art" checked value="<?php echo $art['id'] ?>" data-value="<?php echo $art['title'] ?>" data-price="<?php echo $art['preco'] ?>" data-adic-price="<?= $art['preco_adic_modulo'] ?>">
										<span class="checkmark"></span>
										<div class="mp-checkbox-label">
											<strong>
												<?php echo $art['title'] ?>
											</strong>
										</div>
									</label>
								</div>
								<?php }}} ?>
							</div>
						</div>
					</div>
					<div class="mp-config-content" data-configuration-step="2">
						<div class="mp-painel">
							<div class="mp-painel-header mp-has-counter">
								<div class="mp-painel-counter">2</div>
								<h3 class="mp-painel-title"><?= $data['titulo_painel_2'] ?></h3>
								<p><?= $data['subtitulo_painel_2'] ?></p>
							</div>

							<div class="mp-painel-body">
								<div class="mp-config-print-options">
									<?php echo (new View('category/configuration/print-options',
										$this->data['options'] + ['vc_data' => $data]))->get() ?>
								</div>
							</div>
						</div>
					</div>
					<div class="mp-config-content" data-configuration-step="3">
						<div class="mp-painel">
							<div class="mp-painel-header mp-has-counter">
								<div class="mp-painel-counter">3</div>
								<h3 class="mp-painel-title"><?= $data['titulo_painel_3'] ?></h3>
								<p><?= $data['subtitulo_painel_3'] ?></p>
							</div>

							<div class="mp-painel-body">
								<h3 class="mp-painel-title"><?= $data['painel_3_titulo_quantidade'] ?></h3>
								<div class="mp-config-print-prices">
									<?php echo (new View('category/configuration/price-options', $this->data['products']))->get() ?>
								</div>
								<div class="mp-gabarito mp-text-center" style="display:none;">
									<br /><br />
									<div class="mp-row">
										<?php
										echo (new View(
											'product/template-downloader',
											[
												'text' => 'Download Gabarito',
												'class' => 'mp-col-10 mp-col-sm-10 mp-pb1',
												'has_arte' => $this->data['has_arts'],
												'gabaritos' => [1, 1]
											]
										))->get();
										?>
									</div>
								<div>
							</div>
						</div>
					</div>
				</main>
				<aside class="mp-config-sidebar" style="order:<?= $data['posicao_sidebar'] === 'left' ? '-1' : '0' ?>">
					<div class="sidebar-inner">
						<h4 class="text-uppercase"><strong>Resumo do pedido</strong></h4>
						<div class="configurations">
							<p class="product-name active"><strong>Produto:</strong>
								<span class="value"><?= $this->data['name'] ?></span></p>
							<p class="art"><strong>Arte:</strong> <span class="value"></span></p>
							<p class="format"><strong>Formato:</strong> <span class="value"></span></p>
							<p class="color"><strong>Cor:</strong> <span class="value"></span></p>
							<p class="paper"><strong>Substrato:</strong> <span class="value"></span></p>
							<p class="ennoblement"><strong>Enobrecimento:</strong> <span class="value"></span></p>
							<p class="finishing"><strong>Acabamento(s):</strong> <span class="value"></span></p>
							<p class="description"><strong>Descrição:</strong><br><span class="value"></span></p>
							<br />
							<div class="custos">
								<p class="custo_arte" style="display: flex;justify-content: space-between;"></p>
								<p class="custo_prod" style="display: flex;justify-content: space-between;"></p>
								<p class="custo_final" style="display: flex;justify-content: space-between;"></p>
								<hr>
							</div>
						</div>
					</div>
				</aside>
			</div>
			<div class="mp-form-footer">
				<div class="mp-form-row mp-form-footer-content">
					<div class="mp-errors mp-form-col-10">
						<h4>Encontramos alguns erros!</h4>
						<div class="mp-errors-inner"></div>
						<hr/>
					</div>
					<div class="mp-form-col-12 continuar" style="display:flex; justify-content: flex-end;width: 100%;">
						<?php if(user()->isLogged()){ ?>
						<button id="salvar_favorito" class="mp-btn-black" style="display:none;margin-right: 10px;background:#19202a !important">
							<img style="width:20px;filter: contrast(0) brightness(5); margin-right:5px;" src="<?php echo config('plugin', 'url') ?>front/assets/imgs/fav-off.svg"> Salvar como favorito
						</button>
						<?php } ?>
						<button type="submit" class="mp-continuar mp-form-col-3 mp-btn-primary wide">Continuar</button>
					</div>
					<br />

					<p class="mp-form-col-12 mp-errors mp-show" style="margin-top:30px"><?php echo $data['aviso'] ?></p>
				</div>
			</div>
		</form>
	<?php } ?>
</div>

<?php if(user()->isLogged()){ ?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		var x = jQuery('input.enobrecimentos:checked');
		if(x[0]){
			jQuery('#salvar_favorito').css("display", "block");
		}
	});
	jQuery(document).change(function(){
		var x = jQuery('input.enobrecimentos:checked');
		if(x[0]){
			jQuery('#salvar_favorito').css("display", "block");
		}
	});

	jQuery('#salvar_favorito').click(function(e){
		e.preventDefault();
		var base_url = window.location.hostname == "localhost" 
			? "https://ampliz.com.br" 
			: "https://"+window.location.hostname;

		jQuery('.loader').css('display', "block");
		var cat = window.location.pathname.split("/");
		cat = window.location.hostname =="localhost" ? cat[4] : cat[3];
		var params = window.location.search
		params = params+"&cat="+cat;
		params = btoa(params);
		var id = jQuery('.quantidade:checked').val();
		var url = base_url+'/wp-admin/admin-ajax.php?action=mp_save_favorite&config='+params;
		url = id!=undefined ? url+"&products_id="+id : url;
		
		fetch(url).then(function(response) {
			jQuery('.loader').css('display', "none");
			if(response){
				alert('Seu produto foi salvo com sucesso. Seus favoritos estarão disponíveis na página inicial.');
				return;
			}else{
				alert("Houve um erro ao adicionar aos favoritos, tente novamente mais tarde.");
				return;
			}
		});
	});
</script>
<?php } 