<?php

namespace MisterPrint\Components;

use Carbon\Carbon;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\SessionSupport;
use MisterPrint\BO\Pedido;

class CheckoutComponent extends Component
{
	public static function getSidebar()
	{
		$details = (new Pedido)->revisao_do_pedido(user()->getId());

		$prazo = Carbon::parse($details['valores']['previsaoEntrega']);

		$quantidade = isset($details['itensCarrinho']) ? count($details['itensCarrinho']) : 0;

		$shipping = $details['detalhesFrete'];

		$details = [
			'quant' => $quantidade,
			'subtotal' => $details['valores']['valorProdutos'],
			'cupom' => $details['cupom'],
			'descontos' => $details['valores']['descontos'],
			'credito' => $details['valores']['credito'],
			'total' => $details['valores']['total'],
			'preco_previo_carrinho' => $details['valores']['preco_previo_carrinho'],
			'valor_artes_carrinho' => $details['valores']['valor_artes_carrinho'],
			'total_credito' => $details['valores']['total_credito'],
			'date' => [
				'date' => $prazo->format('d/m/Y'),
				'day' => $prazo->format('l'),
			],
			'freight' => $details['valores']['valorFrete'],
			'endereco' => $details['enderecoDestino'],
			'shipping' => $shipping,
			'detailes' => $details
		];
		error_log('metodo getSidebar'.$details['valores']['total'] . PHP_EOL, 3, '/home/dev_ampliz/public_html/wp-content/plugins/misterprint-ecommerce/log-teste-valdi.log');
		
		return $details;
	}

	public function setParams()
	{
		$this->addParams([
			Vc::paramText('Titulo', 'Finalizar compra'),
			Vc::paramText('Subtitulo', 'Estamos quase fechando o seu pedido.'),
			Vc::paramText('Passo 1', 'Frete'),
			Vc::paramText('Passo 2', 'Confirmação de <br>compra'),
			Vc::paramText('Passo 3', 'Dados de cobrança <br> e Pagamento'),
		]);
	}
}
