<?php
	use MisterPrint\Support\View;
	$values = $this->data;
?>

<table class="mp-table-sm">
	<tbody>
		<tr>
			<td><strong>Sub-Total</strong></td>
			<td align="right"><?= $values['products'] ?></td>
		</tr>
			<?php 
			$aux = str_replace('R$ ','',$values['credit']);
			$aux2 = str_replace('R$ ','',$values['discount']);
			$aux3 = str_replace('R$ ','',$values['total']);
			$credit = floatval(str_replace(',','.',$aux));
			$discount = floatval(str_replace(',','.',$aux2));
			$v_total = str_replace('.','',$aux3);
			$v_total = floatval(str_replace(',','.',$v_total));

			$total = $v_total - $discount - $credit;
			$total = "R$".number_format($total, 2, ',', '.');

			if($credit > 0.00){ ?>
		<tr>
			<td><strong>Crédito</strong></td>
			<td align="right"><?= $values['credit'] ?></td>
		</tr>
		<?php } 
		if($discount > 0.00){ ?>
		<tr>
			<td><strong>Descontos</strong></td>
			<td align="right"><?= $values['discount'] ?></td>
		</tr>
		<?php } ?>
		<tr>
			<td><strong>Frete</strong></td>
			<td align="right"><?= $values['shipping'] ?></td>
		</tr>
		<tr>
			<td><strong>Total</strong></td>
			<td align="right"><?= $total;//$values['total'] ?></td>
		</tr>
	</tbody>
</table>