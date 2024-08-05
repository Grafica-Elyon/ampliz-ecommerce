<?php 

$params = $this->data['params'];
$balcoes = json_decode($this->data['balconies']);
//$balcoes = array_splice($balcoes,0, 20);
?>
<div class="mp-heading">
	<div class="mp-heading-line">
		<h2 class="mp-head"><?= $params['titulo'] ?></h2>
	</div>
	<p><?= $params['subtitulo']?></p>
</div>
<br />
<div class="mp-row">
	<div class="mp-listing mp-card-listing">
		<?php foreach($balcoes as $item){ 
			$item->valor_fixo = $item->valor_fixo == "0.00" ? "Calculado por peso" : "R$ ".$item->valor_fixo;
			$end = str_replace(" ","+",$item->description);
			?>
		<div class="card_freight">
			<center style="width: 100%;"><h5 class="card_freight_title"><strong><?= $item->title ?> - <?= $item->codigo ?></strong></h5></center>
			<hr style="width: 100%;margin:0px;">
			<p class="card_freight_content">
				<span><strong>Nome:</strong> <?= $item->title?></span>
				<span><strong>Endereço:</strong> <?= $item->description?></span>
				<span><strong>Custo:</strong> <?= $item->valor_fixo?></span>
				<?php if($item->previsao_10kg != null){ ?>
				<span><strong>Previsão pra 10 Kg:</strong> R$<?= $item->previsao_10kg?></span>
				<?php } ?>
			</p>
			<hr style="width: 100%;margin:0px;">
			<a class="mp-btn mp-btn-primary card_freight_map" href="https://www.google.com.br/maps/place/<?= $end?>/@<?= $item->latitude?>,<?= $item->longitude?>z" target="_blank">Abrir no mapa</a>
		</div>
		<?php } ?>
	</div>
</div>
<style type="text/css">
.mp-card-listing{
	display: flex;
	flex-flow: row wrap;
	justify-content: center;
}
.card_freight {
	position: relative;
	display: flex;
	flex-flow: row wrap;
	margin: 10px;
	border-radius: 10px;
	box-shadow: 0px 2px 30px -7px #7777;
	padding: 10px 20px;
	width: 400px;
	height: 300px;
	float: left;
	justify-content: right;
	text-align: justify;
	align-items: center;
}

.card_freight_content{
    width: 100%;
    display: flex;
    flex-flow:row wrap;
}
.card_freight_content span{
    width: 100%;
}
.card_freight_map{
	display: block;
	float: right;
}
</style>