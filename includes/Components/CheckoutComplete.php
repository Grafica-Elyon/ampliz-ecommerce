<?php

namespace MisterPrint\Components;

use MisterPrint\BO\Pedido;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\SessionSupport;
use MisterPrint\Support\View;

class CheckoutComplete extends Component
{
	protected $name = 'Checkout concluído';
	protected $description = 'Componente para a conclusão do checkout';
	protected $base = 'vc_mp_checkout_complete';

	public function component()
	{
		if ( (new SessionSupport())::get('last-registered-order') == false ) {
			exit(wp_redirect(get_page_url('my_orders')));
		}
		return parent::component();
	}

	public function render()
	{
		$order = (new SessionSupport())::get('last-registered-order');
		return (new View('checkout/checkout-complete', [
			'checkoutNumber' => $order['codigoPedido'],
			'pedido' => $order,
			'detalhes' => (new Pedido)->get_detalhes_do_pedido($order['codigoPedido']),
			'params' => $this->getParamsAjax()
		]))->get();
	}

	public static function action()
	{
		return function () {
			return false;
		};
	}

	public function setParams()
	{
		parent::setParams();
		$this->addParams([
			Vc::paramText('Titulo', 'Finalizar compra'),
			Vc::paramText('Subtitulo', 'Seu pedido foi feito com sucesso!'),
			Vc::paramText('Passo 1', 'Frete'),
			Vc::paramText('Passo 2', 'Confirmação de <br>compra'),
			Vc::paramText('Passo 3', 'Dados de cobrança <br> e Pagamento'),
			Vc::paramText('Titulo 2', 'A sua compra foi confirmada.'),
			Vc::paramText('Numero pedido', 'Número do pedido:'),
			Vc::paramText('Botão enviar arte', 'Enviar arte'),
			Vc::paramText('Continuar comprando', 'Continuar comprando'),
			Vc::paramText('Acompanhar pedido', 'Acompanhar pedido'),
		]);
	}
}
