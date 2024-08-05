<?php

namespace MisterPrint\BO;

use MisterPrint\Response\PaymentResponse;
use MisterPrint\Response\PaymentMethodResponse;
use MisterPrint\Request;

class Pagamento
{
	public function get_formas_de_pagamento($client_id)
	{
		$data = [ 'codigoCliente' => $client_id, "ip" => user()->getIp() ];
		$request = new Request('pagamento/get-formas-de-pagamento');
		$response = new PaymentMethodResponse($request->get($data));

		return $response->get_data();
	}

	public function usar_cupom( $client_id, $cupom )
	{
		$data = [
			'codigoCliente' => $client_id,
			'codigoCupom' => $cupom
		];

		$request = new Request('pagamento/registrar-uso-cupom', $data);
		$response = new PaymentMethodResponse($request->post());

		return $response->get_data();
		if (!$response->is_positive()) {
			return false;
		}

	}

	public function get_iframe_info()
	{
		$request = new Request('pagamento-getnet/get-iframe-info');
		return $request->get()['body'];
	}

	public function get_opcoes_cartao_de_credito($client_id)
	{
		$data = [ 'codigoCliente' => $client_id];
		$request = new Request('pagamento/get-opcoes-cartao-de-credito');
		$response = new PaymentMethodResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function registrar_pagamento($client_id, $info)
	{
		$data = [
			'codigoCliente' => $client_id,
			'credito' => $info['credito'],
			'dadosTransacao' => [
				'parcelas' => preg_replace('/[^0-9]/', '', $info['installment']),
				'ncartao' => preg_replace('/[^0-9]/', '', $info['card-number']),
				'cvc' => preg_replace('/[^0-9]/', '', $info['card-code']),
				'mes' => preg_replace('/[^0-9]/', '', $info['card-valid']['month']),
				'ano' => preg_replace('/[^0-9]/', '', $info['card-valid']['year']),
				'portador' => $info['card-name'],
				'bandeira' => \get_card_brand($info['card-number']),
			]
		];

		$request = new Request('pagamento-getnet/registrar-pagamento', $data);
		$response = new PaymentResponse($request->post());

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}


	public function registrar_transferencia($client_id, $info)
	{
		$data = [
			'codigoCliente' => $client_id,
			'portador' => $info['portador'],
			'total' => $info['total']
		];

		$request = new Request('pagamento-transferencia/registrar-pagamento');
		$response = $request->postFile($data, $info['comprovante']);

		if (isset($response['body']['response']) && $response['body']['response'] == 'success') {
			return $response['body'];
		}

		return false;
	}

	public function registrar_sinal( $client_id, $info )
	{
		$data = [
			'codigoCliente' => $client_id,
			'forma' => $info['forma'],
			'parcelas' => $info['parcelas'],
			'total' => $info['total'],
			'comprovante' => $info['comprovante'],
			'credito' => !!$info['credito'],
		];

		$request = new Request('pagamento-sinal/registrar-pagamento', $data);
		$response = new PaymentResponse($request->post());

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function registrar_pagamento_retirada( $client_id )
	{
		$data = [
			'codigoCliente' => $client_id
		];

		$request = new Request('pagamento-total-retirada/registrar-pagamento', $data);
		$response = new PaymentResponse($request->post());

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

}
