<?php
	$pedido = $this->data['pedido'];
	$items = $pedido['items'];
?>

<?= new \MisterPrint\Support\View( 'user/creation-form-integrator', $this->data ) ?>

<div class="mp-user-panel">
	<div class="mp-heading">
		<div class="mp-heading-line">
			<h2 class="mp-head">Selecionar item</h2>
		</div>
		<p>Envie as informações dos itens para que possamos criar sua arte</p>
	</div>
	<div class="inner flexboxgrid">
		<div class="row center-xs around-xs">
			<?php foreach ($items as $i): ?>
				<?php
					$item = explode(' | ', $i['products_name']);
					$url = get_page_url('creation_form').$i['orders_id'].'/'.$i['orders_products_id']
				?>
				<div class="col-xs-12 col-md-6 col-lg-3">
					<a href="<?= $url ?>" target="_blank">
						<h3> <?= $item[1] ?> </h3>
						<h6> <?= $item[0] ?>x </h6>
						<h6> <?= $item[2] ?> </h6>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
