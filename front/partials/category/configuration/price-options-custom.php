<tbody>
	<?php if(!empty($this->data['products'])) { ?>
		<?php foreach($this->data['products'] as $key => $quant) { ?>
			<tr>
				<td><?php echo $key ?> un</td>
				<?php foreach($quant as $product) { ?>
					<?php if(!is_array($product)) { ?>
						<td align="center" valign="middle">--</td>
					<?php } else { ?>
						<td>
							<label class="mp-checkbox"
								data-sobmedida="<?php echo ($product['sobmedida']) ? '1' : '0' ?>"
								data-description="<?= htmlspecialchars($product['product']['descricao']) ?>"
								data-peso="<?= $product['product']['peso'] ?>"
								data-modulos="<?= $product['product']['modulos'] ?>"
								data-qtde="<?= $product['quant'] ?>"
								title="Codigo: <?= $product['id']?>&#10;Descrição: <?= htmlspecialchars($product['product']['descricao']) ?>">

								<input type="radio" class="quantidade" name="product" value="<?php echo $product['id'] ?>" />
								<span class="checkmark"></span>

								<?php
									$product['pricePerUnit'] = str_replace(',', '.',$product['price']);
									$product['pricePerUnit'] = $product['pricePerUnit']/$key;
									$product['pricePerUnit'] = number_format($product['pricePerUnit'], 2, ',', '');
								?>

								<div class="mp-checkbox-label mp-price"><?php echo $product['price'] ?></div>
								<div class="mp-checkbox-label mp-price mp-price-per-unit"><?php echo $product['pricePerUnit'] ?></div>
							</label>
						</td>
					<?php } ?>
				<?php } ?>
			</tr>
		<?php } ?>
	<?php } ?>
</tbody>