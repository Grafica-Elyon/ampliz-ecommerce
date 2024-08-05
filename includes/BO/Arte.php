<?php

namespace MisterPrint\BO;

use MisterPrint\Request;
use MisterPrint\Response\ArtResponse;

class Arte
{
	public function get_opcoes_envio($category_id)
	{
		$data = ['codigoCategoria' => intval($category_id)];
		$request = new Request('arte/get-opcoes-envio');
		$response = new ArtResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		$result = $response->get_data();

		$ips = \MisterPrint\Response\BalconyIps::get();
		$isBalcony = !!array_filter(
			$ips,
			function( $ip ) {
				return $ip['dominio'] == $_SERVER['HTTP_HOST'];
			}
		);
		$isValidBalcony = !!array_filter(
			$ips,
			function( $ip ) {
				return ( $ip['dominio'] === null || $ip['dominio'] === $_SERVER['HTTP_HOST'] )
					&& $ip['dominio'] == $_SERVER['HTTP_HOST'];
			}
		);

		$result = array_filter(
			$result,
			function ( $opcao ) use ( $isBalcony, $isValidBalcony ) {
				// Se não for balcão, é uma loja, então retorna o status pela loja
				if ( !$isBalcony ) {
					return $opcao['status_loja'];
				}
				else {
					// Se não estiver habilitado pro balcão
					if ( !$opcao['status_balcao'] ) {
						return false;
					}
					return $isValidBalcony || $opcao['status_balcao_nao_funcionarios'];
				}
			}
		);
		$result = array_values( $result );

		return $result;
	}
}
