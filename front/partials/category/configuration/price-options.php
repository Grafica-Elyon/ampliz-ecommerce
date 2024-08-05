<div class="mp-prices-table">
	<?php if(!empty($this->data['products'])) { ?>
		<table cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<td>Qtd</td>
					<?php foreach ($this->data['days'] as $dayInfo) { ?>
						<?php
							$day = $dayInfo['date'];
							$diasUteis = $dayInfo['diasUteis'];
						?>
						<td>
							<div class="mp-date">
								<?php echo $day->dayName  ?>
								<strong><?php echo $day->format('d/m') ?></strong>
								<?php echo $diasUteis > 1 ? "$diasUteis dias úteis" : "$diasUteis dia útil" ?>
							</div>
						</td>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->data['products'] as $key => $quant) { ?>
					<tr>
						<td><?php echo $key ?> un</td>
						<?php foreach($quant as $product) { ?>
							<?php if(!is_array($product) || !isset($product['id'])) { ?>
								<td align="center" valign="middle">--</td>
							<?php } else { ?>
								<td>
									<label class="mp-checkbox"
										data-sobmedida="<?php echo ($product['sobmedida']) ? '1' : '0' ?>"
										data-description="<?= htmlspecialchars($product['product']['descricao']) ?>"
										data-peso="<?= $product['product']['peso'] ?>"
										data-modulos="<?= $product['product']['modulos'] ?>"
										title="Codigo: <?= $product['id']?>&#10;Descrição: <?= htmlspecialchars($product['product']['descricao']) ?>">

										<input type="radio" class="quantidade" name="product" value="<?php echo $product['id'] ?>" />
										<span class="checkmark"></span>

										<?php
											$product['pricePerUnit'] = str_replace(',', '.',$product['price']);
											$product['pricePerUnit'] = $product['pricePerUnit']/$key;
											$product['pricePerUnit'] = number_format($product['pricePerUnit'], 2, ',', '');

											if (
												// Verificação de preço diferente
												@$product['price'] !== @$product['prev_price']
												// Verficação do preço ser menor
											 && explode(',', $product['price'])[0] <= explode(',', $product['prev_price'])[0]
										 	) {
												?>
												<del>R$ <?= $product['prev_price'] ?> </del><br>
												<?php
											}
										?>

										<div class="mp-checkbox-label mp-price">
											<?php echo $product['price'].'<br />'; ?>
										</div>

										<div class="mp-price mp-price-per-unit">
											<?php echo $product['pricePerUnit']; ?>
										</div>
									</label>
								</td>
							<?php } ?>
						<?php } ?>
					</tr>
				<?php } ?>
			</tbody>
			<tbody>
				<td>
					<div class="mp-custom-quantity">
						<input type="text" class="mp-input" placeholder="Outra" name="custom_quantity" />
						<button type="button" id="mp-custom-quantity-send" class="mp-btn-custom-quantity">+</button>
					</div>
				</td>
				<?php foreach ($this->data['days'] as $day) { ?>
					<td align="center" valign="middle">--</td>
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>
</div>