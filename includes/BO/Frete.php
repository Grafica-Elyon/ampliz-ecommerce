<?php

namespace MisterPrint\BO;

use MisterPrint\Request;
use MisterPrint\Response\FreightCountersOptionsResponse;
use MisterPrint\Response\FreightOptionsResponse;
use MisterPrint\Response\FreightSetAddressResponse;
use MisterPrint\Response\FreightSetOptionResponse;
use MisterPrint\Response\MotoboyOptionsResponse;
use MisterPrint\Response\ShippingOptionsResponse;

class Frete
{
	public function get_opcoes_balcoes( $client_id, $cep, $prazoAdicional = 0 ) {
		$data = [
			'codigoCliente' => $client_id,
			'cep' => $cep ? str_replace('-', '', $cep) : null,
			'prazoAdicional' => $prazoAdicional,
		];

		$request = new Request( 'frete/get-opcoes-balcoes' );
		$response = new FreightCountersOptionsResponse( $request->get( $data ) );

		if ( ! $response->is_positive() ) {
			return false;
		}

		return $response->get_data();
	}

	public function get_todos_balcoes() {
		$request = new Request( 'get-all-freights' );
		return $request->get()['body'];
	}

	public function remessaDiretaAtiva() {
		$request = new Request( 'frete/get-remessas-diretas' );
		return $request->get()['body'];
	}

	public function get_opcoes_fretes( $client_id ) {
		$data = [ 'codigoCliente' => $client_id ];
		$request = new Request( 'frete/get-opcoes-fretes' );
		$response = new FreightOptionsResponse( $request->get( $data ) );

		if ( ! $response->is_positive() ) {
			return false;
		}

		return $response->get_data();
	}

	public function get_opcoes_menv( $client_id ) {
		$data = [ 'codigoCliente' => $client_id ];
		$request = new Request( 'frete/get-opcoes-menv' );
		$response = new FreightOptionsResponse( $request->get( $data ) );

		if ( ! $response->is_positive() ) {
			return false;
		}

		return $response->get_data();
	}

	public function definir_opcao_de_frete( $client_id, $freight_id ) {
		$data = [
			'codigoCliente' => $client_id,
			'codigoFrete' => $freight_id
		];

		$request = new Request( 'frete/definir-opcao-de-frete', $data );
		$response = new FreightSetOptionResponse( $request->post() );

		if ( ! $response->is_positive() ) {
			return false;
		}

		return true;
	}

	public function get_opcoes_balcoes_by_city( $client_id, $state, $city ) {
		$data = [
			'codigoCliente' => $client_id,
			'cidade' => $city,
			'estado' => $state,
			'page' => 1
		];

		$request = new Request( 'frete/get-balcoes' );
		$response = new FreightCountersOptionsResponse( $request->get( $data ) );

		if ( ! $response->is_positive() ) {
			return false;
		}

		$data = $response->get_data();

		return (isset($data['data'])) ? $data['data'] : [];
	}

	public function get_balcao( $client_id, $codigoBalcao ) {
		$data = [
			'codigoCliente' => $client_id,
			'codigoBalcao' => $codigoBalcao,
			'page' => 1
		];

		$request = new Request( 'frete/get-balcao' );
		$response = new FreightCountersOptionsResponse( $request->get( $data ) );

		if ( ! $response->is_positive() ) {
			return false;
		}

		$data = $response->get_data();

		return $data;
	}

	public function adicionar_endereco_remessa_direta( $client_id, $address, $frete = 'DSX' ) {
		$data = [
			'codigoCliente' => $client_id,
			'codigoFrete' => $frete,
			'nome' => $address['nome'],
			'valor' => $address['valor'],
			'documento' => $address['documento'],
			'documento_tipo' => $address['documento_tipo'],
			'endereco' => $address['endereco'],
			'numero' => $address['numero'],
			'complemento' => $address['complemento'],
			'bairro' => $address['bairro'],
			'cep' => $address['cep'],
			'cidade' => $address['cidade'],
			'estado' => $address['estado']
		];

		$request = new Request( 'frete/adicionar-endereco-remessa-direta', $data );
		$response = new FreightSetOptionResponse( $request->post() );

		if ( ! $response->is_positive() ) {
			return false;
		}

		return $response->get_data();
	}

	public function definir_endereco_entrega( $client_id, $address_id ) {
		$data = [
			'codigoCliente' => $client_id,
			'codigoEndereco' => $address_id,
			'idFranquia' => FranquiaUtil::getIdFranquia(),
		];

		$request = new Request( 'cliente/definir-endereco-entrega', $data );
		$response = new FreightSetAddressResponse( $request->post());

		if ( ! $response->is_positive() ) {
			return false;
		}

		return $response->get_data();
	}

	public function get_opcoes_motoboy( $client_id ) {
		$data = [ 'codigoCliente' => $client_id ];
		$request = new Request( 'frete/get-opcoes-motoboy' );
		$response = new MotoboyOptionsResponse( $request->get( $data ) );

		if ( ! $response->is_positive() ) {
			return false;
		}

		return $response->get_data();
	}

	public function get_opcoes_transportadoras( $client_id ) {
		$data = [ 'codigoCliente' => $client_id ];
		$request = new Request( 'frete/get-opcoes-transportadoras' );
		$response = new ShippingOptionsResponse( $request->get( $data ) );

		if ( ! $response->is_positive() ) {
			return false;
		}

		return $response->get_data();
	}

	public function get_opcoes_astrolog( $client_id ) {
		$request = new Request( 'frete/get-opcoes-astrolog' );
		$response = $request->get(['codigoCliente' => $client_id])['body'];
		return !empty($response) ? json_decode($response, true) : null;
	}

	public function get_opcoes_remessa_direta( $client_id, $cep ) {
		$data = [
			'codigoCliente' => $client_id,
			'cep' => preg_replace('/\D/', '', $cep),
		];

		$request = new Request( 'frete/get-opcoes-remessa-direta' );
		$response = new ShippingOptionsResponse( $request->get( $data ) );

		if ( ! $response->is_positive() ) {
			return false;
		}

		return $response->get_data();
	}
}
