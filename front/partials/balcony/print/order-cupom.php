<?php
$order = $this->data['order'];
$user = user()->getData();
?>

<div data-component="mp_balcony_print" data-ajax="0" class="no-style-component">
	<button class="mp-btn-primary mp-btn-sm mp-btn-print fai fa-file-text-o"></button>
	<div class="print-container"
		data-style="https://cdn.jsdelivr.net/npm/flexboxgrid@6.3.0/dist/flexboxgrid.min.css"
		data-title="Cupom de controle pedido <?= $order['number'] ?>">

		<pre>
			*{margin:0;padding:0}hr{margin:20px 0}body{padding:0 5px}
			.dotted-bottom {border-bottom:1px dotted black}.dotted-bottom *{background-color:white;padding:0 1px;margin-bottom:-1px}
			.spacing-0{padding-top: 0px}.spacing-1{padding-top: 5px}.spacing-2{padding-top: 10px}.spacing-3{padding-top: 15px}.spacing-4{padding-top: 20px}.spacing-5{padding-top: 25px}.spacing-6{padding-top: 30px}
			.small-text{font-size:10px;}.medium-text{font-size:13px;}.normal-text{font-size:15px;}.large-text{font-size:17px;}
		</pre>

		<!-- Numero Pedido -->
		<div class="row center-xs spacing-2">
			<h5>Controle de pedido</h5>
		</div>
		<div class="row center-xs spacing-0">
			<h2> <?= $order['number'] ?> </h2>
		</div>

		<!-- Data -->
		<div class="row center-xs spacing-2">
			<h4> <?= utf8_encode(strftime("%d/%m/%Y - %H:%M:%S", strtotime($order['date']))) ?> </h4>
		</div>

		<!-- Dados Cliente -->
		<div class="row between-xs dotted-bottom spacing-4 medium-text">
			<span>Cliente</span>
			<strong><?= $user['dadosCliente']['customers_firstname'] ?></strong>
		</div>
		<div class="row between-xs dotted-bottom spacing-1 medium-text">
			<span>Documento ( <?= strtoupper($user['dadosCliente']['customers_preference']) ?> ) </span>
			<strong>
				<?php
				if ( $user['dadosCliente']['customers_preference'] == 'cnpj' ) {
					// 17.136.884/0001-09
					echo preg_replace(
						"/([0-9]{2})([0-9]{3})([0-9]{3})([0-9]{4})([0-9]{2})/",
						'$1.$2.$3\/$4\-$5',
						$user['dadosCliente']['customers_cnpj']
					);
				}
				else {
					echo preg_replace(
						"/([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})/",
						'$1.$2.$3-$4',
						$user['dadosCliente']['customers_cpf']
					);
				}
				?>
			</strong>
		</div>

		<hr>

		<div class="row between-xs dotted-bottom spacing-0 medium-text">
			<span>Total:</span>
			<strong>R$ <?= number_format($order['item']['valor_total'],2,",","."); ?></strong>
		</div>
		<div class="row between-xs dotted-bottom spacing-0 medium-text">
			<span>Pago:</span>
			<strong>R$ <?= number_format($order['item']['valor_total'] - $order['item']['valor_areceber'],2,",",".") ?></strong>
		</div>
		<div class="row between-xs dotted-bottom spacing-0 medium-text">
			<span>à Pagar:</span>
			<strong>R$ <?= number_format($order['item']['valor_areceber'],2,",","."); ?></strong>
		</div>

		<hr>

		<div class="row center-xs spacing-0">
			<h4> Produtos </h4>
		</div>
		<br>
		<?php
			foreach ($order['products'] as $produto) :
				$nomeProduto = explode(" | ", $produto['name']);
				$nomeProduto = array_map("trim", $nomeProduto);
				$nomeProduto = array_filter($nomeProduto);
				if ( !is_numeric($nomeProduto[0]) ) {
					array_pop($nomeProduto);
				}

				$nomeProduto = [
					$nomeProduto[0].'x', // Quantidade
					$nomeProduto[1], // Nome
					explode(' ', $nomeProduto[2])[0].'DU',
				];

				?>
				<div class="row between-xs dotted-bottom spacing-0 small-text">
					<span><?= implode(' ', $nomeProduto) ?></span>
					<strong><?= $produto['value'] ?></strong>
				</div>
				<?php
			endforeach;
		?>

		<div class="row center-xs spacing-5">
			<span class="col-xs-9">
				A entrega deste pedido se fará ao titular do cadastro,
				com a apresentação deste controle e portando um documento com foto.
			</span>
		</div>
		<div class="row center-xs spacing-5">
			<span class="col-xs-9">
				A <?= get_option('blogname', true) ?> não é responsável pelos erros nas artes-finais
			</span>
		</div>

		<span class="spacing-6"></span>
	</div>
</div>
