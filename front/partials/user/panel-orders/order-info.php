<?php
	use MisterPrint\Support\View;
	$order = $this->data;
?>

<strong>Nome:</strong> <?= $order['item']['emitir_nota_como'] == "cpf"? $order['item']['customers_name']: $order['item']['empresa']; ?><br />
<strong>Documento: </strong> <?= $order['item']['emitir_nota_como'] == "cnpj"? $order['item']['cnpj']: $order['item']['cpf']; ?><br />
<strong>Nota fiscal como: </strong>Pessoa <?= $order['item']['emitir_nota_como'] == "cpf"? "Física": "Jurídica"?><br />
<?php if ( $order['item']['comprovante']){?>
<strong>Comprovante: </strong><a class="bt-ticket" href="<?= $order['item']['comprovante'] ?>" >Download</a><br /><br />
<?php } else { ?>
	<strong>Comprovante:</strong> Sem comprovante<br /><br />
<?php }?>
<strong>Data da Compra: </strong> <?= $order['date']->format('d/m/Y H:i:s') ?><br />


<?php if ( $order['upload'] ): ?>
	<strong>Prazo de Produção: </strong><?= $order['prazo']['prazo_producao'] ?> <?= $order['prazo']['prazo_producao']==1 ? 'dia útil' : 'dias úteis' ?> <br />
	<strong>Prazo de Entrega: </strong><?= $order['prazo']['prazo'] ?> <?= $order['prazo']['prazo_entrega'] ==1 ? 'dia útil' : 'dias úteis' ?> <br />
<?php else: ?>
	<strong>Início de produção: </strong><?= $order['prazo']['inicio_producao'] ?><br />
	<strong>Previsão para produção: </strong><?= $order['prazo']['previsao_producao'] ?><br />
	<strong>Previsão para entrega: </strong><?= $order['prazo']['previsao_entrega'] ?><br />
<?php endif; ?>
<?php $is_jad = substr(strtoupper($order['shipping']), 0,2) !== "BR" ? false : true; ?>
<?php $prazo_menor = $is_jad ? ($order['prazo']['prazo_entrega'] - 3)." a" : ""; ?>
<strong>Frete: </strong><?= $order['shipping']." (".$prazo_menor." ".$order['prazo_frete']." dias uteis)"; ?><br />
<strong><?= $order['shipping_is_delivery'] ? 'Endereço de retirada: ' : 'Endereço de entrega: ' ?></strong>
<?= $order['shipping_address']; ?><br />
<?php if ($order['orders_rastreio'] != "") { ?>
<?php $link_rastreio = $is_jad 
	? "http://www.jadlog.com.br/siteInstitucional/tracking.jad?pedido=".$order['orders_rastreio'] 
	: "https://www2.correios.com.br/sistemas/rastreamento/default.cfm" 
?>
	<strong>Rastreamento: </strong><a target="_blank" href="<?= $link_rastreio?>"><?= $order['orders_rastreio'] ?></a><br />
<?php } ?>
<?php if($order['orders_nf_emitida'] == "Y"){ ?>
	<strong>Nota fiscal: </strong><a href="#." onclick="getNota(<?= explode('/',$order['orders_nf'])[0]; ?>)"><?= $order['orders_nf'] ?></a><br />
<?php } ?>
<?php if($order['orders_nota_fiscal'] != ""){ ?>
	<strong>Nota fiscal de transporte: </strong><?= $order['orders_nota_fiscal'] ?><br />
<?php } ?>
<script type="text/javascript">
	function getNota(nota){
		let url = window.location.protocol+"//"+window.location.host+"/wp-admin/admin-ajax.php?action=mp_buscar_nota_por_id";
		jQuery.post(url, {'id_nota': nota}).done(function(response){
			console.log(response);
			if(response.url != null){
				url = response.url;
				window.open(url, "_blank");
			}else{
				console.log('Nota não existe no sistema');
			}
		});
	}
</script>