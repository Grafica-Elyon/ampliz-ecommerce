<?php
use MisterPrint\Support\View;

$paymentType = $this->data['payment_code'];
$products = $this->data['products'];

echo (new View('data-layers/push', [
	'event' => 'checkout',
	'ecommerce' => [
		'checkout' => [
			'actionField' => [
				'step' => 3,
				'option' => $paymentType
			],
			'products' => $products
		]
	]
]))->get();
