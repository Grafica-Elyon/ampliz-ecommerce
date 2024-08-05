<?php
	use MisterPrint\Support\View;
	use MisterPrint\BO\User;
	$is_balcony = (new User)->get_is_balcony();
	$orders = $this->data;
?>

<?php
if(!empty($orders)) {
	foreach($orders as $order) {
		?>
		<div class="mp-accordion-orders" data-order-id="<?= $order['number'] ?>">
			<div class="mp-accordion-header">
				<i class="mp-accordion-icon"></i>
				<div class="mp-row">
					<div class="mp-col-3"><strong>Pedido: </strong><?= $order['number'] ?></div>
					<div class="mp-col-3"><?= $order['date']->format('d/m/Y H:i:s') ?></div>
					<div class="mp-col-4 mp-text-right"><strong>Status: </strong> <?= $order['status'] ?></div>
				</div>
			</div>
			<div class="mp-accordion-body">
			
				<?php
					// Verifica se tem necessidade de upload
					$hasAction = $order['upload'];

					// Verifica se é um balcão e tem a necessidade de realizar lançamento
					$hasAction = $hasAction || store_ip_identification() == $order['shipping'];
					$hasAction = $hasAction || $is_balcony;



					$orderInfo = new View('user/panel-orders/order-info', $order);
					$orderValues = new View( 'user/panel-orders/order-value', $order['values'] );
					$productList = new View( 'user/panel-orders/product-list', $order['products'] );
					$orderHistory = new View( 'user/panel-orders/order-history', $order['historico'] );
				?>

				<?php if ( $hasAction ): ?>
					<div class="mp-row mp-mb-2">
						<div class="mp-col-6">
							<h4><strong>Informações </strong></h4>
							<?= $orderInfo->get() ?>
						</div>
						<div class="mp-col-4">
							<br />
							<?php if($order['upload'] && $order['status_code'] < 299) { ?>
								<a href="<?= get_page_url('send_art') ?>pedido/<?= $order['number']?>" class="mp-btn-primary mp-btn-sm">Enviar arte</a>
							<?php } ?>
							<?php if($order['creation']) { ?>
								<a href="<?= get_page_url('creation_form') . $order['number']?>" class="mp-btn-primary mp-btn-sm">Formulário de criação</a>
							<?php } ?>
							<?php
								if ( $is_balcony ) {
									if($order['values']['areceber'] != 'R$ 0,00') {
										echo new View('balcony/payment', ['order' => $order['number']]);
									}
									if(
										$order['values']['areceber'] == 'R$ 0,00' // Pago
									 && store_ip_identification() == $order['shipping'] // Da filial atual
									 && $order['status_code'] > 300 && 550 >= $order['status_code'] // Disponível para retirada
									) {
										echo new View('balcony/dispatch', ['order' => $order['number']]);
									}
									echo new View('balcony/print/order-cupom', ['order' => $order]);
								}
							?>
						</div>
					</div>
					<div class="mp-row mp-mb-2">
						<div class="mp-col-6">
							<h4><strong>Produtos</strong></h4>
							<?= $productList->get() ?>
						</div>
						<div class="mp-col-4">
							<h4><strong>Valores</strong></h4>
							<?= $orderValues->get() ?>
						</div>
					</div>
				<?php else: ?>
					<div class="mp-row mp-mb-2">
						<div class="mp-col-6">
							<h4><strong>Informações </strong></h4>
							<?= $orderInfo->get() ?>
						</div>
						<div class="mp-col-4">
							<h4><strong>Valores</strong></h4>
							<?= $orderValues->get() ?>
						</div>
					</div>
					<div class="mp-row mp-mb-2">
						<div class="mp-col-10">
							<h4><strong>Produtos</strong></h4>
							<?= $productList->get() ?>
						</div>
					</div>
				<?php endif; ?>
				<div class="mp-row">
					<div class="mp-col-10">
						<h4><strong>Historico</strong></h4>
						<?= $orderHistory->get() ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
?>
