<?php 
$dados = $this->data['dados'];

?>

<div class="mp-coupon">
	<div class="mp-heading">
		<div class="mp-heading-line">
			<h2 class="mp-head"><?= $this->data['params']['titulo'] ?></h2>
		</div>
		<p><?= $this->data['params']['subtitulo'] ?></p>
	</div>
<br />
		<?php if(empty($dados)){ ?>
		<div class="mp-painel-body">
			<div class="mp-painel-header">
				<center>
					<h3 class="mp-painel-title"><?= $this->data['params']['titulo_sem_pedidos'] ?></h3>
					<p><?= $this->data['params']['subtitulo_sem_pedidos'] ?></p>
				</center>
			</div>
		</div>
		<?php }else{?>
		<div class="mp-painel">
			<div class="mp-painel-header">
				<h3 class="mp-painel-title"><?= $this->data['params']['titulo'] ?></h3>
			</div>
			<div class="mp-painel-body">
				<table class="mp-painel-body" cellspacing="0" cellpadding="50" width="100%" style="border-spacing: 30px;">
					<thead style="border-bottom: 3px solid #e0dede;">
						<tr>
							<th width="auto">Pedido</th>
							<th width="auto">Compra</th>
							<th width="auto">Pagamento</th>
							<th width="auto" style="text-align:right;">Produtos</th>
							<th width="auto" style="text-align:right;">Artes</th>
							<th width="auto" style="text-align:right;">Descontos</th>
							<th width="auto" style="text-align:right;">Valor no cupom</th>
							<th width="auto" style="text-align:center;">Gerou cupom?</th>
							<th width="auto"></th>
						</tr><td>
					</td></thead>
					<tbody>
						<?php foreach($dados->pedidos as $i){ ?>
							<tr><td><br /></td></tr>
							<tr>
								<td colspan="1" ><?= $i->orders_id ?></td>
								<td colspan="1" ><?= date('d/m/Y H:i:s', strtotime($i->date_purchased)) ?></td>
								<td colspan="1" ><?= date('d/m/Y H:i:s', strtotime($i->date_payment)) ?></td>
								<td colspan="1" style="text-align:right;">R$<?= number_format($i->products_price, 2, ",", "") ?></td>
								<td colspan="1" style="text-align:right;">R$<?= number_format($i->arte, 2, ",", "") ?></td>
								<td colspan="1" style="text-align:right;">R$<?= number_format($i->desconsiderar, 2, ",", "") ?></td>
								<td colspan="1" style="text-align:right;">R$<?= number_format(($i->products_price - $i->desconsiderar), 2, ",", "") ?></td>
								<td colspan="1" style="text-align:center;"><?= $i->gerou_cupom ? "Sim" : "Não" ?></td>
								<?php if($i->desconsiderar > $i->valor_desconto){ ?>
									<td colspan="1" style="vertical-align: middle;text-align: center;position:relative;">
										<span class="mp-icon-tooltip" data-tooltip="O pedido contem itens que não são aplicaveis no cupom"> i </span>
									</td>
								<?php } ?>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<br />
				<table width="100%">
					<thead style="border-bottom: 3px solid #e0dede;">
						<tr>
							<th width="50%" style="text-align:right;">Total de Produtos</th>
							<th width="auto" style="text-align:right;">Total de descontos</th>
							<th width="auto" style="text-align:right;">Total no ultimo cupom</th>
							<th width="auto" style="text-align:right;">Válido para o próximo</th>
						</tr>
					</thead>
					<tbody>
						<tr><td><br /></td></tr>
						<tr>
							<td colspan="1" style="text-align:right;" >R$<?= number_format($dados->total_produtos, 2, ",","") ?></td>
							<td colspan="1" style="text-align:right;" >R$<?= number_format($dados->descontos_gerais, 2, ",","") ?></td>
							<td colspan="1" style="text-align:right;" >R$<?= number_format($dados->total_gerou_cupom, 2, ",","") ?></td>
							<td colspan="1" style="text-align:right;" >R$<?= number_format($dados->total_proximo_cupom, 2, ",","") ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		<?php } ?>
	</div>
</div>

<style type="text/css">
.mp-coupon .mp-icon-tooltip {
  position: absolute !important;
  background: silver !important;
  padding: 1px 12px !important;
  right: 0 !important;
  top: 50% !important;
  border-radius: 100% !important;
  font-size: 15px !important;
  color: #fff !important;
  width: 25px !important;
  height: 25px !important;
  display: flex !important;
  align-items: center;
  justify-content: center !important;
}
.mp-coupon .mp-icon-tooltip::after {
	content: attr(data-tooltip);
	font-family: Montserrat,sans-serif;
	background: silver;
	font-size: 14px;
	width: 499px;
	margin-left: -525px;
	padding: 25px 10px;
	color: #8b8989;
	transform-origin: unset;
	transform: none;
}
</style>