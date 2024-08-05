<?php
use MisterPrint\Support\View;

$data = $this->data['params'];
$extratoCompleto = $this->data['credit_extract'];
?>
<div class="mp-user-panel">
	<div class="mp-heading">
		<div class="mp-heading-line">
			<h2 class="mp-head"><?= $data['titulo']?></h2>
		</div>
		<p><?= $data['subtitulo']?></p>
	</div>
	<div class="inner">
		<div class="sidebar" style="order:<?= $data['posicao_sidebar'] === 'right' ? '1': '0' ?>">
			<?= (new View('elements/menu-user-panel', ['params' => $data, 'active' => 'credit_extract']))->get() ?>
		</div>
		<main>
			<div class="mp-painel">
				<div class="mp-painel-header">
					<h3 class="mp-painel-title"><?= $data['titulo_painel']?></h3>
				</div>
				<div class="mp-painel-body">
					<?= (new View('elements/flash', ['classes' => 'data-message']))->get() ?>
					<form action="#" class="mp-form" id="edit-data">

						<center>
							<table class="table table-hover table-bordered">
								<thead class = "table-head">
									<tr>
										<th colspan="6"><b>Extrato</b></th>
									</tr>
									<tr>
										<th><?= $data['formulario_data']?></th>
										<th><?= $data['formulario_historico']?></th>
										<th><?= $data['formulario_pedido']?></th>
										<th><?= $data['formulario_debito']?></th>
										<th><?= $data['formulario_credito']?></th>
										<th> <?= $data['formulario_saldo']?></th>
									</tr>
								</thead>
								<?php

								foreach($extratoCompleto['extrato'] as $h)
								{
									$debito = ($h['debito'] > 0.00) ? '-'.$h['debito'] : '';
									$credito = ($h['credito'] > 0.00) ? $h['credito'] : '';
								?>
									<tr>

										<td>
											<?php echo date("d/m/Y H:i:s", strtotime($h['datetime'] == $horario ? '' : $h['datetime'])); ?>
										</td>
										<td>
											<?php echo str_replace('Nova Loja', '', $h['historico']); ?>
										</td>
										<td>
											<?php if ($h['orders_id'] !=0): ?>
												<?php echo $h['orders_id']; ?>
											<?php endif; ?>
										</td>
										<td align="Right">
											<?php if ($h['credito'] !=0): ?>
												<?php echo number_format((float) $h['credito'],2,",",""); ?>
											<?php endif; ?>
										</td>
										<td align="Right" style="color: <?php echo ($h['debito'] <= 0.00) ? '#000000' : '#FF0000';?>">
											<?php if ($h['debito'] !=0): ?>
												<?php echo number_format((float) $debito,2,",","") ?>
											<?php endif; ?>
										</td>
										<td align="Right" style="color: <?php echo ($h['saldo'] > 0.00) ? '#000000' : '#FF0000';?>">
											<b><?php echo number_format($h['saldo'],2,",",""); ?></b>
										</td>
										<?php $horario = $h['datetime'];?>
									</tr>
									<?php
								}
								?>
							</table>
						</center>
					</div>
				</form>
			</div>
		</div>
	</main>