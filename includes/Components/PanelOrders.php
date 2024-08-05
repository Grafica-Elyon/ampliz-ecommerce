<?php
namespace MisterPrint\Components;

use MisterPrint\BO\Pedido;
use MisterPrint\BO\Produto;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;
use Carbon\Carbon;
use MisterPrint\Helper\Log;

class PanelOrders extends PanelComponent
{
	protected $name = 'Painel de pedidos do usuário';
	protected $description = 'Painel com os pedidos do usuário';
	protected $base = 'vc_mp_panel_orders';

	public function render() {
		return (new View('user/panel-orders', [
			'params' => $this->getParamsAjax(),
			'orders' => self::getOrders(),
			'status' => (new Pedido())->get_lista_filtros(user()->getId())
		]))->get();
	}

	public static function orders() {

		return function() {
			$params = json_decode(base64_decode($_POST['data']['params']), true);

			$filter = $_POST['data']['filter'];
			$orders = self::getOrders($_POST['data']['page'], $filter);
			
			return (new View(
				'user/panel-orders/order-list',
				$orders['data']
			))->get();
		};
	}

	public static function getOrders($page = 1, $filter = null)
	{
		$orders = (new Pedido())->get_lista_pedidos_do_cliente(user()->getId(), $page, $filter);
		$orders['data'] = array_map(function($item) {
			$products = [];
			$quantity = 0;
			$needsUpload = false;
			$hasCreation = false;
			foreach($item['produtosPedido'] as $product) {
				$previewType = '3d';
				if ( $product['qnt_paginas'] > 4 ) {
					$previewType = 'normal';
				}

				$products[] = [
					'id' => $product['orders_products_id'],
					'order' => $product['orders_id'],
					'name' => $product['products_name'],
					'value' => money($product['products_price']),
					'days' => $product['products_prazo'],
					'upload' => $product['need_upload'],
					'creation' => $product['is_creation'],
					'qnt_paginas' => $product['qnt_paginas'],
					'preview_type' => $previewType,
					'tamanho' => $product['tamanho'],
					'tem_verso' => $product['tem_verso'],
					'core' => [
						'horizontal' => $product['gabarito_horizontal_corel'],
						'vertical' => $product['gabarito_vertical_corel']
					],
					'illustrator' => [
						'horizontal' => $product['gabarito_horizontal_illustrator'],
						'vertical' => $product['gabarito_vertical_illustrator']
					],
				];
				$quantity = $quantity + $product['products_quantity'];
				if ( $product['need_upload'] ) {
					$needsUpload = true;
				}
				if ( $product['is_creation'] ) {
					$hasCreation = true;
				}
			}

			return [
				'date' => Carbon::createFromFormat('Y-m-d H:i:s', $item['date_purchased']),
				'comprovante' => $item['comprovante'],
				'orders_nf' => $item['orders_nf'],
				'prazo_frete' => $item['prazo_frete'],
				'orders_nf_emitida' => $item['orders_nf_emitida'],
				'orders_rastreio' => $item['orders_rastreio'],
				'orders_nota_fiscal' => $item['orders_nota_fiscal'],
				'shipping' => $item['customers_frete'],
				'shipping_is_delivery' => $item['frete_is_entrega'],
				'shipping_address' => $item['frete_endereco'],
				'number' => $item['orders_id'],
				'products' => $products,
				'quantity' => $quantity,
				'status_code' => $item['orders_status'],
				'prazo' => [
					'prazo_producao' => $item['prazo_producao'],
					'prazo_entrega' => $item['prazo_entrega'],
					'prazo' => $item['prazo'],
					'previsao_producao' => date('d/m', strtotime($item['previsao_producao'])),
					'previsao_entrega' => date('d/m', strtotime($item['previsao_entrega'])),
					'previsao' => date('d/m', strtotime($item['previsao'])),
					'inicio_producao' => date('d/m', strtotime($item['inicio_producao'])),
				],
				'time' => $item['prazo'],
				'values' => [
					'products' => money($item['valor_produtos']),
					'discount' => money($item['valor_desconto']),
					'credit' => money($item['valor_credito']),
					'shipping' => money($item['valor_frete']),
					'total' => money($item['valor_total']),
					'areceber' => money($item['valor_areceber']),
				],
				'status' => $item['orders_status_name'],
				'upload' => $needsUpload,
				'creation' => $hasCreation,
				'item' => $item,
				'historico' => $item['historico'],
			];
		}, $orders['data']);

		$orders['pagination'] = [
			'current' => $orders['from'],
			'total' => $orders['last_page'],
		];
		return $orders;
	}

	public static function getNotaById(){
		return function(){
			$notaFiscal = $_POST['id_nota'];
			$pedido = (new Pedido)->get_nota_fiscal($notaFiscal);
			return $pedido;
		};
		
	}

	public static function payment_info() {
		return function () {
			$data = $_POST['data'];
			if ( !isset($data['codigoPedido']) ) {
				return false;
			}
			else {
				$f = config("plugin", "franquia");
				Log::info($data['codigoPedido']." : ".$f);
				$info = (new Pedido)->get_payment_info($data['codigoPedido']);
				Log::info(json_encode($info));
				return $info;
				//return \MisterPrint\Response\PaymentInfo::get();
			}
		};
	}

	public static function make_payment() {
		return function () {
			$data = $_POST['data'];
			if ( !isset($data['codigoPedido']) || !isset($data['valorDoPagamento']) ) {
				return false;
			}
			else {
				$data = [
					"codigoPedido" => $data['codigoPedido'],
					"valorDoPagamento" => $data['valorDoPagamento'],
					"formaPgto" => $data['formaPgto'],
					"comprovante" => $data['comprovante'],
					"parcelas" => $data['parcelas']
				];

				$pay = (new Pedido)->balcony_make_payment($data);
				return $pay;
				Log::info(json_encode($pay));
				/*return \MisterPrint\Response\MakePayment::get(
					$data['codigoPedido'],
					$data['valorDoPagamento'],
					$data['formaPgto'],
					$data['comprovante'],
					$data['parcelas']
				);*/
			}
		};
	}

	public static function make_dispatch() {
		return function () {
			$data = $_POST['data'];
			if ( !isset($data['codigoPedido']) ) {
				return false;
			}
			else {
				return \MisterPrint\Response\MakeDispatch::get( $data['codigoPedido'] );
			}
		};
	}

	public function setParams()
	{
		parent::setParams();
		$this->addParams([
			Vc::paramText('Titulo painel', 'Meus pedidos'),
		]);
	}
}
