<?php
	use MisterPrint\Support\View;
	$orders = array_reverse($this->data);
?>

<table class="mp-table-sm mp-table-order-history">
	<thead>
		<th>Data</th>
		<th>Status</th>
		<th>Descrição</th>
	</thead>
	<tbody>
		<?php foreach ($orders as $h): 
			$date = date( 'd/m/Y H:i:s', strtotime($h['date_added']) );
			?>
			<tr>
				<td class="mp-py-1"> <?php echo "{$date}" ?> </td>
				<td class="mp-py-1"> <?= $h['orders_status_name_reduced'] ?> </td>
				<td class="mp-py-1" style="position: relative;"> 
					<?= $h['comments'] ?>
					<?php if(stripos($h['comments'], "Rastrear") !== false){ ?>
					<span class="mp-icon-tooltip" data-tooltip="Para rastrear este pedido, basta clicar no link e informar seu CPF ou CNPJ de cadastro."> i </span>
					<?php } ?>
				</td>
			</tr>
		<?php endforeach; ?>
		<tr style="display:none">
			<td colspan="3" class="text-center">
				<a href="javascript:void(0)">
					Mostrar Anteriores +
				</a>
			</td>
		</tr>
	</tbody>
</table>
<style type="text/css">
	.mp-icon-tooltip {
		position: absolute !important;
		background: silver !important;
		transform: translateY(-34%) !important;
		padding: 1px 12px !important;
		right: 5% !important;
		top: 40% !important;
		border-radius: 100% !important;
		font-size: 15px !important;
		color: #fff !important;
		width: 25px !important;
		height: 25px !important;
		display: flex !important;
		align-items: center;
		justify-content: center !important;
	}
	.mp-icon-tooltip::before {
		top: 6px !important;
	}
	.mp-icon-tooltip::after {
		transform: none !important;
		padding: 15px 10px !important;
		width: 100px;
		height: 20px;
		font-size: 1px;
	}
	.mp-icon-tooltip:hover:after {
		transform: none !important;
		padding: 15px 10px !important;
		width: 500px;
		height: 70px;
		font-size: 14px;
	}
</style>
