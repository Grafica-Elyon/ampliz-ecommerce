<?php
use MisterPrint\Support\View;
$data = $this->data['params'];
$pagination = $this->data['orders']['pagination'];
$statusLista = $this->data['status'];
?>

<input type="hidden" name="params" value="<?= base64_encode(json_encode($data)) ?>" />
<div class="mp-user-panel">
	<div class="mp-heading">
		<div class="mp-heading-line">
			<h2 class="mp-head"><?= $data['titulo']?></h2>
		</div>
		<p><?= $data['subtitulo']?></p>
	</div>
	<div class="inner">
		<main>
			<div class="mp-painel">
				<div class="mp-painel-header">
					<form class="mp-form" style="float: right;">
						<label class="mp-label-select">
							<select class="mp-select" id="filtro-orders" name="filter">
								<option value="">Todos</option>
								<?php foreach($statusLista as $item){?>
									<option value="<?= $item['orders_status_name'] ?>"><?= $item['orders_status_name'] ?></option>
								<?php }?>
							</select>
						</label>
					</form>
					<h3 class="mp-painel-title"><?= $data['titulo_painel']?></h3>
				</div>
				<div class="mp-painel-body">
					<?= (new View('elements/flash', ['classes' => 'address-message']))->get() ?>


					<div class="mp-accordions mp-mb-3">
						<?php
						echo (new View('user/panel-orders/order-list', $this->data['orders']['data']))->get();
						?>
					</div>

					<?php if ( false == ( $pagination['current'] == 1 && $pagination['total'] == 1 ) ): ?>
						<div id="orders-pagination">
							<?php echo (new View('category/pagination', ['pagination' => $pagination, 'with-helpers' => true]))->get() ?>
						</div>
					<?php endif; ?>
					<!-- <br />
					<div class="text-center">
						<a href="#" class="mp-load-more">
							<i class="mp-icon mp-icon-arrow-down-grey"></i> Ver mais
						</a>
					</div> -->
				</div>
			</div>
		</main>
	</div>
</div>
