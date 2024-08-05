<?php use MisterPrint\Support\View;
	//exit('<pre>'.json_encode($this->data, JSON_PRETTY_PRINT));
	$desconto_fixo = isset($this->data['discount']['fixo'])? $this->data['discount']['fixo'] :0;
	$desconto_porcentagem = isset($this->data['discount']['porcentagem']) ? $this->data['discount']['porcentagem'] : 0;
	$price = floatval(str_replace($this->data['price'], ',', '.'));
	$prev_price = 0.0;
	if($desconto_fixo > 0 || $desconto_porcentagem > 0){ 
		if($desconto_porcentagem > 0){
			$prev_price += $price * (1 + ($desconto_porcentagem / 100));
		}if($desconto_fixo > 0){
			$prev_price +=(float) $price + $desconto_fixo;
		}
	}
?>
<div class="mp-single-category flexboxgrid row">
	<div class="mp-show-mobile mp-hide-medium mp-hide-large">
		<div class="mp-category-content">
			<h1 class="mp-category-title"><?php echo $this->data['name'] ?></h1>
			<!-- <p class="mp-category-short-description"><?php echo $this->data['short_description'] ?></p> -->
		</div>
	</div>
	<div class="mp-category-images col-xs-12 col-sm-4">
			<?php if (!empty($this->data['images'])) { ?>
				<?php foreach ($this->data['images'] as $image) { ?>
					<div class="mp-category-image">
						<img src="<?php echo $image ?>"/>
					</div>
				<?php } ?>
			<?php } else { ?>
				<div class="mp-category-image no-image">
					<img src="<?= get_option('bs_publisher_theme_options')['logo_image'] ?>"/>
				</div>
			<?php } ?>

	</div>
	<div class="mp-category-content col-xs-12 col-sm-8">
		<div class="mp-hide-mobile mp-show-medium mp-show-large">
			</br>
			<h1 class="mp-category-title"><?php echo str_replace("*","",$this->data['name']) ?></h1>
			<!-- <p class="mp-category-short-description"><?php echo $this->data['short_description'] ?></p> -->
		</div>
		<div class="mp-price-box">
			<strong>A partir de </strong>
			<span class="money-xlg mp-primary-color"><?php echo $this->data['price'] ?></span>
			<?php if ( $this->data['price_quant'] ): ?>
				<strong>/ <?= $this->data['price_quant'] ?>un</strong>
			<?php endif; ?>
			<?php if ( $this->data['menorPrecoUnitario'] && $this->data['menorPrecoUnitarioQuantidade'] ): ?>
			<p>
				<?= $this->data['menorPrecoUnitarioQuantidade'] ?> un por apenas <strong>R$ <?= $this->data['menorPrecoUnitario'] ?></strong> / un
			</p>
		<?php endif; ?>
		</div>
		<hr/>
		<p class="mp-category-description"><?php echo $this->data['description'] ?></p>
		<div class="mp-cateory-meta">
			<div class="mp-category-reviews"></div>
			<div class="mp-category-share"></div>
		</div>
		<div class="mp-category-add-to-cart">
			<h3><?= $this->data['params']['titulo'] ?></h3>
			<p><?= $this->data['params']['subtitulo'] ?></p>
			<div class="mp-text-center-mb">
				</br>
				<a href="<?php echo get_configuration_url($this->data['id'], $this->data['slug']) ?>"
					class="mp-btn-primary mp-btn-lg"><?= $this->data['params']['botao'] ?></a>
			</div>
		</div>
	</div>
</div>
<?= (new View('data-layers/product', [
	[
		'name' => "{$this->data['name']}",
		'id' => $this->data['name'],
		'price' => $this->data['price'],
		'brand' => 'Mister Print',
		'category' => $this->data['name'],
	]
]))->get() ?>


<style type="text/css">
.price_tag {
    background: #e30614;
    display: flex;
    width: 60px;
    height: 60px;
    flex-flow: row wrap;
    justify-content: center;
    align-items: center;
    color: #fff;
    position: absolute;
    font-weight: bold;
    border-radius: 50px;
    top: 0;
    left: 90%;
    z-index: 99;
    transform: translate3d(-50%,-50%,0px);
}
</style>