<div class="mp-checkout-details">
	<h3 class="mp-details-title">PREVISÃO DE PRODUÇÃO</h3>
	<strong class="mp-checkout-previsao"><?php echo str_replace('-', '/', $this->data['detailes']['valores']['previsaoProducao'])?></strong> até 14h
	<p>
		<h3 class="mp-details-title">PREVISÃO DO FRETE</h3>
		<strong>
			<span class="mp-shipping-date"><?php echo $this->data['date']['date']; ?></span>
		</strong>
		<span class="mp-arrival-day-week">
			<?=
				[
					'Monday' => 'Segunda-Feira',
					'Tuesday' => 'Terça-Feira',
					'Wednesday' => 'Quarta-Feira',
					'Thursday' => 'Quinta-Feira',
					'Friday' => 'Sexta-Feira',
					'Saturday' => 'Sábado',
					'Sunday' => 'Domingo',
				][$this->data['date']['day']] ?: $this->data['date']['day']
			?>
		</span>
		<br />
		<br />
		<div class="mp-shipping-detail">
			<strong><?php echo $this->data['shipping']['codigo'] ?></strong>
			<?php echo $this->data['shipping']['titulo'] ?>
		</div>
		<br />
		<span class="mp-alert mp-alert-error mp-alert-light">Prazo a partir do pagamento / envio de arte</span>
	</p>
	<br />
	<div class="mp-checkout-order-review">
		<table>
			<tbody>
				<tr>
					<th>Qtd. produto(s):</th>
					<td align="right"><?php echo $this->data['quant']; ?></td>
				</tr>
				<tr>
					<th>Val. produtos:</th>
					<td data-order-price="<?= $this->data['subtotal']?>" align="right"><?php echo money($this->data['subtotal']); ?></td>
				</tr>

				<?php if($this->data['cupom']) { ?>
					<tr>
						<th>Cupom <?= $this->data['cupom']['cod'] ?>:</th>
						<td class="mp-cupom" data-coupon-price="<?= $this->data['cupom']['valor'] ?>" align="right"><?php echo "-".money($this->data['cupom']['valor']); ?></td>
					</tr>
				<?php } ?>
				<tr id="credit" <?php if ( floatval($this->data['credito']) == 0 ) echo 'style="display: none"' ?>>
					<th>Crédito:</th>
					<td class="mp-credit" data-credit-price="<?= $this->data['credito'] ?>" align="right"><?php echo "-".money($this->data['credito']); ?></td>
				</tr>
				<tr class="freight">
					<th>Frete:</th>
					<td data-freight-price="<?= $this->data['freight']?>" align="right"><?= money($this->data['freight'])?></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th>Total:</th>
					<td data-total-price="<?= $this->data['total']?>" align="right"><?php echo money($this->data['total_credito']); ?></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
