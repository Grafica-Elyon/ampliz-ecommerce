<?php

namespace MisterPrint\BO;

use MisterPrint\Request;
use MisterPrint\Admin\Log;
use MisterPrint\Response\ClientOrderListResponse;
use MisterPrint\Response\OrderResponse;
use MisterPrint\Response\PaymentResponse;
use MisterPrint\Response\RegisterOrderResponse;
use MisterPrint\Response\OrderReview;
use MisterPrint\Response\ClientStatusResponse;

class Pedido
{
	public function get_lista_pedidos_do_cliente( $client_id, $page = 1, $filter = null) {
		$data = [ 'codigoCliente' => $client_id, 'page' => $page, 'filter' => $filter ];
		$request = new Request( 'pedido/get-lista-pedidos-do-cliente' );
		$response = new ClientOrderListResponse( $request->get( $data ) );
		if ( ! $response->is_positive() ) {
			return false;
		}
		return $response->get_data();
	}

	public function get_nota_fiscal( $nota_id) {	
		$data = ['nota_id' => $nota_id];
		$request = new Request('pedido/buscar-nota', $data);
		$response =  json_decode(json_encode($request->post()['body']));
		return $response;
	}

	public function get_payment_info( $pedido) {	
		$data = ['codigoPedido' => $pedido];
		$request = new Request('balcao/informacao-pagamentos', $data);
		$response = $request->get();
		$result = json_decode($response['body']);
		return $result;
	}

	public function balcony_make_payment( $dados) {	
		$request = new Request('balcao/realizar-pagamento', $dados);
		$response = $request->get();
		$result = json_decode($response['body']);
		return $result;
	}

	public function get_status_promo($user){
		$request = new Request( 'pedido/get-status-promo', ['codigoCliente' => $user]);
		return json_decode(json_encode($request->post()['body']));
	}
	
	public function get_last_order($user){
		$request = new Request( 'produto/get-last-order', ['codigoCliente' => $user]);
		return json_decode($request->post()['body'],true)[0];
	}

	public function get_lista_filtros( $client_id) {
		$data = [ 'codigoCliente' => $client_id];
		$request = new Request( 'pedido/get-lista-status-pedidos');
		$response = new ClientStatusResponse( $request->get( $data ));

		if ( ! $response->is_positive() ) {
			return false;
		}

		return $response->get_data();
	}

	public function get_getnet_payment_id($client_id) {
		$data = [ 'codigoCliente' => $client_id];
		$response = new Request( 'pagamento-getnet/get-iframe-pagamento-info', $data);
		$response = $response->get();
		$result = json_decode($response['body'], true);
		return $result;
	}

	public function validar_pedido($client_id, $credit = false){
		$data = [
			'codigoCliente' => $client_id,
			'usoDeCredito' => $credit,
			'subDomain' => ""
		];

		$request = new Request('pedido/validar-pedido', $data);
		$response = json_decode(json_encode($request->post()['body']));
		return $response;
	}

	public function registrar_pedido($client_id, $pagamento, $remessa = null, $credit = false, $nota = "")
	{
		$data = [
			'codigoCliente' => $client_id,
			'usoDeCredito' => $credit,
			'subDomain' => "",
			"codigoPagamento" => ($pagamento == null ? "" : $pagamento),
			"emitirNotaComo" => $nota,
		];

		if(!empty($remessa)) {
			$data['codigoRemessa'] = $remessa;
		}

		$request = new Request('pedido/registrar-pedido', $data);
		$response = new RegisterOrderResponse($request->post());

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function get_resumo_do_pedido($order_id)
	{
		$data = [
			'codigoPedido' => $order_id
		];

		$request = new Request('pedido/get-resumo-do-pedido');
		$response = new OrderResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function get_detalhes_do_pedido($order_id)
	{
		$data = [
			'codigoPedido' => $order_id
		];

		$request = new Request('pedido/get-detalhes-do-pedido');
		$response = new OrderResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function revisao_do_pedido($client_id) {
		$data = ['codigoCliente' => $client_id];

		$request = new Request('pedido/revisao-do-pedido');
		$response = new OrderReview($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function check_id_client($id_pedido, $id_cliente)
	{
		$data = [
			'codigoCliente' => $id_cliente,
			'codigoPedido' => $id_pedido
		];
		$request = new Request('cliente/checar-pedido', $data);
		$response =  json_decode($request->post()['body'], true);

		return $response;
	}

	public function get_user_token()
	{
		$request = new Request('upload-arte/get-token', [], [], config('plugin', 'upload_url'));
		$response = new RegisterOrderResponse($request->get());

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}
}
