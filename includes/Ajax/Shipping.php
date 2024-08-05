<?php

namespace MisterPrint\Ajax;

use MisterPrint\BO\Frete;
use MisterPrint\Helper\User;

class Shipping extends Ajax
{
	private $cart;

	public function init()
	{
		$this->expects = isset($_POST['expects']) ? $_POST['expects'] : false;
		$this->method = isset($_POST['method']) ? $_POST['method'] : false;
		$this->shipping = new Frete();
	}

	public function handle()
	{
		$this->init();

		if ('shipping_method' === $this->expects) {
			return $this->getShippingMethod();
		}

		return [];
	}


	function getShippingMethod()
	{
		if('correios' === $this->method) {
			$options = $this->shipping->get_opcoes_fretes(User::getId());
		} else if('balcao' === $this->method) {
			$options = $this->shipping->get_opcoes_balcoes(User::getId());
		} else if('transportadora' === $this->method) {
			$options = $this->shipping->get_opcoes_transportadoras(User::getId());
		} else if('motoboy' === $this->method) {
			$options = $this->shipping->get_opcoes_motoboy(User::getId());
		}

		return array_map(function($option) {

			$option['valor'] = 'R$ ' . number_format($option['valor'], 2, ',', '.');
			$option['prazo'] = $option['prazo'] . ' Dias';
			return $option;
		}, $options);
	}
}
