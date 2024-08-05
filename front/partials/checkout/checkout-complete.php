<?php
use MisterPrint\Support\View;
$data = $this->data['params']
?>
<div class="mp-checkout-complete mp-text-center">
	<div class="mp-heading">
		<div class="mp-heading-line">
			<h2 class="mp-head"><?= $data['titulo']?></h2>
		</div>
		<p><?= $data['subtitulo']?></p>
	</div>
	<div class="mp-progress">
		<ul class="mp-progress-inner">
			<li class="active"><?= $data['passo_1']?></li>
			<li class="active"><?= $data['passo_2']?></li>
			<li class="active"><?= $data['passo_3']?></li>
		</ul>
	</div>
	<h3><?= $data['titulo_2']?></h3>
	<hr>
	<h3><?= $data['numero_pedido']?> <span id="checkout-number" class="checkout-number"><?= $this->data['checkoutNumber']?></span></h3>
	<!-- TODO adicionar os links -->
	<div><a href="<?= get_page_url('send_art') ?>pedido/<?= $this->data['checkoutNumber']?>" class="mp-btn-primary btn-send-art"><?= $data['botao_enviar_arte']?></a></div>
	<div class="bottom-links">
		<a href="<?= get_page_url('categories') ?>" class="mp-primary-color"><i class="fai fa-shopping-cart"></i> <?= $data['continuar_comprando']?></a></a>
		<a href="<?= get_page_url('my_orders') ?>"  class="mp-primary-color"><i class="fai fa-list"></i> <?= $data['acompanhar_pedido']?></a></a>
	</div>
</div>

<?= (new View('data-layers/checkout-payment', [
	'payment_code' => $this->data['pedido']['payment_code'],
	'products' => array_map(
		function ($item) {
			$itemInfos = explode(' | ', $item['products_name']);
			if ( is_numeric($itemInfos[0]) == false ) {
				array_pop($itemInfos);
			}
			return [
				"name" => "{$itemInfos[1]} $itemInfos[5]} $itemInfos[3]}",
				"id" => $item['products_id'],
				"price" => (float) str_replace(',','.',$item['products_price']),
				"brand" => "Mister Print",
				"category" => $itemInfos[1]
			];
		},
		$this->data['detalhes']['produtosPedido']
	)
]))->get() ?>
<script type="text/javascript">
	sendinblue.track('order_completed');
</script>
<?= (new View('data-layers/complete-order', [
	'pedido' => $this->data['detalhes']
]))->get() ?>
