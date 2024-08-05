<?php

namespace MisterPrint\BO;

use MisterPrint\Request;
use MisterPrint\Response\CompanyBanksInfoResponse;
use MisterPrint\Response\CompanyInfoResponse;

class Empresa
{
	public function get_dados_basicos_empresa() {
		$data = [];
		$request = new Request( 'empresa/get-dados-basicos-empresa' );
		$response = new CompanyInfoResponse( $request->get( $data ) );

		if ( ! $response->is_positive() ) {
			return false;
		}

		return $response->get_data();
	}

	public function get_dados_bancarios() {
		$request = new Request( 'empresa/get-dados-bancarios' );
		$response = new CompanyBanksInfoResponse( $request->get([]) );

		if ( ! $response->is_positive() ) {
			return false;
		}

		return $response->get_data();
	}
}
