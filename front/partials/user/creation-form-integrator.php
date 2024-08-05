<?php
	$params = $this->data['params'];
	$cliente = user()->getData();
?>

<script type="text/javascript">
	window.MrPrint.creation_art_integrator = <?= json_encode([
		'form_id' => $params['form_id'],
		'pedido' => $this->data['pedido'],
		'item' => $this->data['item'],
		'cliente' => [
			'nome' => $cliente['dadosCliente']['customers_firstname'],
			'email' => $cliente['dadosCliente']['customers_email_address'],
			'celular' => $cliente['dadosCliente']['customers_celular'] ?: $cliente['dadosCliente']['customers_celular'],
		],
	], JSON_PRETTY_PRINT) ?>
</script>
