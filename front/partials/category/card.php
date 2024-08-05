<?php

use MisterPrint\Support\View;

if (isset($this->data['special_product']) && $this->data['special_product']) {
	$url = home_url('/produto-fechado/'.sanitize_title($this->data['name']).'/'.$this->data['id']);
	$urlConfiguration = $url;
} else {
	$url = get_category_url($this->data['id'],$this->data['slug']);
	$urlConfiguration = get_page_url('category_configuration').$this->data['slug'].'/'.$this->data['id'];
} ?>
<div class="mp-card">
	<div class="mp-card-thumbnail
	<?php echo empty($this->data['image']) ? 'no-image' : ''; ?>
	<?php echo empty($this->data['label']) ?: 'has_img_label'; ?>"
	<?php echo empty($this->data['label']) ?: 'label="'.$this->data['label'].'"'; ?>
	<?php echo $this->data['label'] == null ?:'style="background:'.$this->data['label_colors'].';"'; ?>
	>
		<?php if(!empty($this->data['image'])) { ?>
			<?= new View('misc/async-image', $this->data['image']) ?>
		<?php } else { ?>
			<img src="<?php echo config('plugin', 'url') ?>front/assets/imgs/logo.png" />
		<?php } ?>
		<div class="mp-card-overlay mp-hide-small">
			<?php if ( isset($this->data['special_product']) && $this->data['special_product'] ): ?>
				<a class="mp-link-overlay" href="<?php echo $url ?>"></a>
				<?php if($this->data['has_products']){ ?>
				<a href="<?php echo $urlConfiguration ?>" class="mp-btn mp-btn-primary">Configurar produto</a>
				<?php } ?>
			<?php else: ?>
				<a class="mp-link-overlay" href="<?php echo $url ?>">
					<?php if($this->data['is_master']){ ?>
					<span class="mp-btn mp-btn-primary" style="left: 50%; transform: translate3d(-50%, -50%,0px);">
						 Explorar 
					</span>
					<?php }else{ ?>
						<strong><i class="mp-icon mp-icon-list"></i>Ver detalhes</strong>
					<?php } ?>
				</a>
				<?php if($this->data['has_products']){ ?>
				<a href="<?php echo $urlConfiguration ?>" class="mp-btn mp-btn-primary">Configurar produto</a>
				<?php } ?>
			<?php endif; ?>
		</div>
	</div>
	<div class="mp-card-caption">
		<h3 class="mp-card-title"><?php echo $this->data['name'] ?></h3>
		<p class="mp-card-description" ><i><?php echo $this->data['description'] ?></i></p>
		<?php if($this->data['has_products'] || $this->data['is_master']){ ?>
		<p>
			A partir de <span class="money mp-primary-color"><?php echo $this->data['price'] ?></span>
			<?php if ( $this->data['price_quant'] ): ?>
				/ <?= $this->data['price_quant'] ?>un
			<?php endif; ?>
		</p>
		<?php if ( $this->data['menorPrecoUnitario'] && $this->data['menorPrecoUnitarioQuantidade'] ): 
			if(floatval($this->data['menorPrecoUnitario']) == 0.00){ $this->data['menorPrecoUnitario'] = "0,01";}
			?>
			<p>
				<?= $this->data['menorPrecoUnitarioQuantidade'] ?> un por apenas <strong>R$ <?= $this->data['menorPrecoUnitario'] ?></strong> / un
			</p>
		<?php endif; ?>
		<?php } ?>
		<div class="mp-hide-large mp-hide-medium" style="text-align: center;">
			<a class="mp-btn mp-btn-primary" href="<?php echo $url ?>">Ver Detalhes</a>
		</div>
	</div>
</div>
