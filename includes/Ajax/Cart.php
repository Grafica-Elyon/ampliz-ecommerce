<?php
namespace MisterPrint\Ajax;

use MisterPrint\BO\Carrinho;
use MisterPrint\Helper\Url;
use MisterPrint\Helper\User;

class Cart extends Ajax
{
	private $cart;
	public function init()
	{
		$this->cart = new Carrinho();
	}

	public function handle()
	{
		$this->init();

		$cart_totals = [];
		$cart_total = 0;
		$cart = array_map(function($product) use (&$cart_totals, &$cart_total) {

			$cart_totals[] = [
				'label' => $product['nomeProduto']. ' ' .$product['modelo'],
				'value' => 'R$ ' . number_format($product['preco'], 2, ',', '.')
			];
			$cart_total = $cart_total+$product['preco'];
			$product['preco'] = 'R$ ' . number_format($product['preco'], 2, ',', '.');
			return array_merge($product, ['remove' => Url::removeFromCartUrl($product['produtoId'])]);
		}, $this->cart->get_dados_carrinho_de_compras(User::getId()));

		$cart_totals[] = [
			'label' => 'Total',
			'value' => 'R$ ' . number_format($cart_total, 2, ',', '.')
		];
		return ['cart' => $cart, 'cart_totals' => $cart_totals];
	}
}
