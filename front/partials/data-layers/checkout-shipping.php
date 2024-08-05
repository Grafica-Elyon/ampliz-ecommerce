<?php
use MisterPrint\Support\View;

echo (new View('data-layers/push', [
	'event' => 'checkout',
	'ecommerce' => [
		'checkout' => [
			'actionField' => ['step' => 1, 'option' => $this->data['shipping_code']],
			'products' => $this->data['cart']
		]
	]
]))->get();
