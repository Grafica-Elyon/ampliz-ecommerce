<?php use MisterPrint\Support\View;
$data = $this->data['params'];
?>

<?php echo (new View('misc/errors', [
	'errors' => (isset($this->data['errors'])) ? $this->data['errors'] : []
]))->get() ?>
<div class="mp-cart-table mp-hide-small mp-hide-medium">
	<table cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th width="20%"><?= $data['tabela_produto']?></th>
				<th><?= $data['tabela_descricao']?></th>
				<th><?= $data['tabela_quantidade']?></th>
				<th><?= $data['tabela_sub_total']?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($this->data['cart'] as $item) { ?>
				<tr>
					<td><?php echo $item['name'] ?></td>
					<td>
						<strong><?= $data['tabela_formato']?> </strong><?php echo $item['format'] ?> cm<br />
						<strong><?= $data['tabela_peso']?> </strong><?php echo $item['weight'] ?><br />
						<strong><?= $data['tabela_acabamentos']?> </strong><?php 
						if(is_array($item['finishings'])){
							echo "<ul>";
							foreach($item['finishings'] as $finish){
								echo "<li>".$finish['nome']."</li>";
							}
						}else{
							echo json_encode($item['finishings']);
						}?><br />
						<strong><?= $data['tabela_cobertura']?> </strong><?php echo $item['cover']; ?><br />
						<strong><?= $data['tabela_envio_arte']?> </strong><?php echo $item['arte']; ?>
					</td>
					<td>
						<?php if($item['quant'] > 1) { ?>
							<strong>Quantidade: </strong><?php echo $item['quant'] ?> Unidades<br />
						<?php } else { ?>
							<strong>Quantidade: </strong><?php echo $item['quant'] ?> Unidade<br />
						<?php } ?>

						<?php if($item['prazo'] > 1) { ?>
							<strong>Produção: </strong><?php echo $item['prazo'] ?> Dias úteis<br />
						<?php } else { ?>
							<strong>Produção: </strong><?php echo $item['prazo'] ?> Dia útil<br />
						<?php } ?>
					</td>
					<?php 
						$preco_com_desconto = floatVal(str_replace(",",".",$item['price']));
						$custoArte = floatval(str_replace(",",".",$item['valorEnvioArte']));
						$preco = $preco_com_desconto + $custoArte;
					 ?>
					<td>R$ <?php echo number_format($preco, 2, ',', ''); ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

<div class="mp-cart-table  mp-show-small mp-hide-large">
	<?php if($this->data['cart']) {?>
		<?php foreach($this->data['cart'] as $item) { ?>
			<h4 class="mp-painel-title">Produto</h4>
			<a href="<?php echo get_product_url($item['product_id'], $item['name']); ?>"><?php echo $item['name'] ?></a>
			<hr />

			<h4 class="mp-painel-title">Descrição</h4>
			<strong>Formato: </strong><?php echo $item['format'] ?> cm<br />
			<strong>Peso: </strong><?php echo $item['weight'] ?> kg<br />
			<strong>Cobertura: </strong><?php echo $item['cover'] ?><br />
			<strong>Envio da Arte: </strong><?php echo $item['art'] ?>
			<?= (new View('cart/util/listar-acabamentos', $item['finishings']))->get() ?>
			<hr />

			<h4 class="mp-painel-title">Detalhes</h4>
			<?php if($item['quant'] > 1) { ?>
				<strong>Quantidade: </strong><?php echo $item['quant'] ?> Unidades<br />
			<?php } else { ?>
				<strong>Quantidade: </strong><?php echo $item['quant'] ?> Unidade<br />
			<?php } ?>

			<?php if($item['prazo'] > 1) { ?>
				<strong>Produção: </strong><?php echo $item['prazo'] ?> Dias úteis<br />
			<?php } else { ?>
				<strong>Produção: </strong><?php echo $item['prazo'] ?> Dia útil<br />
			<?php } ?>
			<hr class="bold" />

			<div class="mp-row">
				<div class="mp-col-5">
					<h4 class="mp-painel-title">Valor</h4>
					R$ <?php echo $item['price'] ?>
				</div>
			</div>
			<hr class="bold" /><br />
		<?php } ?>
	<?php } else { ?>
		<tr>
			<td colspan="5" align="center">
				<strong><?= $this->data['params']['sem_itens']?></strong>
			</td>
		</tr>
	<?php }?>
</div>

<?php
echo (new View('data-layers/checkout-shipping', [
	'shipping_code' => $this->data['sidebar']['shipping']['codigo'],
	'cart' => array_map(
		function ($product) {
			return [
				'name' => $product['name'],
				'id' => $product['product_id'],
				'price' => $product['price'],
				'brand' => $product['model'],
				'category' => $product['name'],
			];
		},
		$this->data['cart']
	),
]))->get();
?>
