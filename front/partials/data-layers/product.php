<?php
use MisterPrint\Support\View;

$products = $this->data;
foreach ($products as $p) {
	$p = [
		'name' => $p['name'],
		'id' => $p['id'],
		'price' => $p['price'],
		'brand' => $p['brand'],
		'category' => $p['category'],
	];
}

echo (new View('data-layers/push', [
	'ecommerce' => [
		'detail' => [
			'actionField' => ['list' => 'Página de produto'],
			'products' => $products
		]
	]
]))->get();
