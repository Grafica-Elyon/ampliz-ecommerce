<?php 

$vc_params = $this->data['vc_params'];
$shortcode = '';
$compras = $this->data['compras'];
$cart = $this->data['cart'];
$gerar_popup = 0;
$usuario = user()->getData();
$prev_shortcode = str_replace('`{`', '[', $vc_params['popup']);
$shortcode = str_replace(
	'`}`',
	' left="'.$vc_params['distancia_lateral_porcentagem'].'" top="'.$vc_params['distancia_do_topo_porcentagem'].'"]',
	$prev_shortcode
);
if($vc_params['quantidade_de_compras_ate_onde_mostrar'] != -1){
	if($compras <= $vc_params['quantidade_de_compras_ate_onde_mostrar']){
		$gerar_popup = 1;
	}
}
if($vc_params['valor_do_carrinho_para_mostrar'] != -1){
	$precoCarrinho = 0.0;
	foreach($cart as $item){
		$precoCarrinho += (float) $item['price'];
	}
	if($precoCarrinho >= (float) $vc_params['valor_do_carrinho_para_mostrar']){
		$gerar_popup = 1;
	}
}
if($vc_params['nome_do_cliente_para_mostrar'] !="todos"){
	if(stripos($usuario['dadosCliente']['customers_firstname'], $vc_params['nome_do_cliente_para_mostrar']) !== false){
		$gerar_popup = 1;
	}
}
else{
	$gerar_popup = 1;
}
$gerar_popup = json_encode($gerar_popup);
if($gerar_popup > 0){
	do_shortcode("{$shortcode}");
}else{
	?><script type="text/javascript">document.querySelector('div[data-component="vc_mp_popus"]').outerHTML='';</script><?php
}



