<?php
use MisterPrint\Support\View;
$data = $this->data['params'];
//gerar popup na página
$precoCarrinho=0.0;
$cart = $this->data['cart'];
foreach($cart as $item){
	$precoCarrinho += (float) $item['price'];
}
if($data['valor_em_compras_para_popup'] != 0.0){
	if($precoCarrinho >= (float) $data['valor_em_compras_para_popup']){
		$prev_shortcode = str_replace('`{`', '[', $data['shortcode_da_popup']);
		$shortcode = str_replace(
			'`}`',
			' width="'.$data['largura_da_popup'].'" height="'.$data['altura_da_popup'].'"]',
			$prev_shortcode
		);
		echo do_shortcode($shortcode);
	}	
}

?>
<div class="mp-heading">
	<div class="mp-heading-line">
		<h2 class="mp-head"><?= $data['titulo'] ?> (<?= count($this->data['cart'])?>)</h2>
	</div>
	<p><?= $data['subtitulo'] ?></p>
	<script type="text/javascript">
			var x = new URLSearchParams(location.search);
			var error = x.get("error") || null;
			if(x.get("error") !== null){
				jQuery('.mp-cart-footer').prepend('<span style="color: var(--primary-color);margin-bottom: 10px; display: block;width:100%;text-align:center;"><strong>'+x.get("error")+'</strong></span>');
			}
	</script>
</div>
<div class="mp-cart">
	<div class="mp-painel">
		<div class="mp-painel-header">
			<h3 class="mp-painel-title"><?= $data['titulo_da_tabela'] ?></h3>
			<p><?= $data['subtitulo_da_tabela'] ?></p>
		</div>

		<div class="mp-painel-body">
			<div class="mp-config-print-prices">
				<?php echo (new View('cart/cart-table', $this->data))->get() ?>
			</div>
		</div>
	</div>

	<div class="mp-cart-footer">
		<?php if(isset($_SESSION['cart_error'])){ ?>
		<div class="mp-errors mp-errors-right" style="display:block;text-align: right;color:red; width: 100%;">
			<h4 style="color:red;">Atenção!</h4>
			<div class="mp-errors-inner">
				<?php echo $_SESSION['cart_error'];
				unset($_SESSION['cart_error']); ?>
			</div>
		</div>
		<?php } ?>
		<div class="mp-cart-footer-left">
			<a href="<?php echo home_url('/'); ?>" class="mp-btn-black">
				<?= $data['titulo_do_botao_preto'] ?>
			</a>
		</div>
		<div class="mp-cart-footer-right">
			<a href="<?php echo get_page_url('checkout_shipping'); ?>" class="mp-btn-primary">
				<?= $data['titulo_do_botao_vermelho'] ?>
			</a>
		</div>
	</div>
</div>
<?php
	echo (new View('data-layers/checkout',array_map(
		function ($item) {
			return [
				'name' => "{$item['name']} {$item['substrate']} {$item['color']}",
				'id' => $item['product_id'],
				'price' => $item['price'],
				'brand' => 'Mister Print',
				'category' => $item['name']
			];
		},
		$this->data['cart']
	)))->get();
?>
