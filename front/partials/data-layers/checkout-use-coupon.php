<?php
use MisterPrint\Support\View;

if ( !isset($this->data['success']) || $this->data['success'] == false ) {
	echo '<!-- Invalid Coupon -->';
	return;
}

$cart = isset($this->data['cart']) ? $this->data['cart'] : user()->getCartForGtm();

echo (new View('data-layers/push', [
	'event' => 'checkout',
	'ecommerce' => [
		'checkout' => [
			'actionField' => [
				'step' => 2,
				'option' => $this->data['name'],
				'value' => $this->data['value']
			],
			'products' => $cart
		]
	]
]))->get();
