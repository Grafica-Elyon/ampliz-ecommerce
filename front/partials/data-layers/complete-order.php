<?php
use MisterPrint\Support\View;

$user = isset($this->data['user']) ? $this->data['user'] : user()->getData();
$pedido = $this->data['pedido'];

$produtosPedido = array_map(
	function ($p) {
		$categoria = explode(" | ", $p['products_name']);
		if ( $hasIdentifier = !preg_match("/^[0-9]+ \| /", $p['products_name']) ) {
			$categoria = $categoria[2];
		}
		else {
			$categoria = $categoria[1];
		}
		return [
			'name' => $p['products_name'],
			'id' => $p['products_id'],
			'price' => $p['products_price'],
			'brand' => $p['products_model'],
			'category' => $categoria,
			'quantity' => $p['products_quantity']
		];
	},
	$pedido['produtosPedido']
);


echo (new View('data-layers/push', [
	'ecommerce' => [
		'purchase' => [
			'actionField' => [
				'id' => $pedido['prazoDias'],
				'affiliation' => 'Mister Print',
				'revenue' => $pedido['valor_produtos'],
				'shipping' => $pedido['valor_frete'], // Valor do frete
				'cupom' => $pedido['cupom']
			],
			'products' => $produtosPedido
		]
	],
	'email' => $user['dadosCliente']['customers_email_address'],
	'customer' => [
		'new_customer' => $user['info']['customer_is_new'],
		'orders_count' => $user['info']['customer_order_number'],
		'days_after_last_purchase' => $user['info']['idle_time_until_last_purchase']
	],
	'deadline' => $pedido['prazoDias']
]))->get();
