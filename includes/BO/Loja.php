<?php

namespace MisterPrint\BO;

use MisterPrint\Request;
use MisterPrint\Response\HeaderMenuResponse;
use MisterPrint\Response\TestimonialsResponse;

class Loja
{
	public function get_menu_cabecalho() {
		// Verifica o cache
		$transient_key = 'mp_menu_header';
		if(($transient_value = get_transient($transient_key))) {
			return $transient_value;
		}

		// Caso não tenha no cache, ele pesquisa
		$data = [];
		$request = new Request( 'loja/get-menu-cabecalho' );
		$response = new HeaderMenuResponse( $request->get( $data ) );

		if ( ! $response->is_positive() ) {
			return false;
		}

		// Pega o valor pesquisado
		$result = $response->get_data();

		// Grava por meia hora
		set_transient($transient_key, $result, HOUR_IN_SECONDS * .5);

		//
		return $result;
	}

	public function get_testemunhal() {
			// $transient_key = 'mp_testimonials';
			// if(get_transient($transient_key)) {
			//     return get_transient($transient_key);
			// }
		$data = [];
		$request = new Request( '/loja/get-testemunhal' );
		$response = new TestimonialsResponse( $request->get( $data ) );

		if ( ! $response->is_positive() ) {
			return false;
		}

		$result = $response->get_data();
		set_transient($transient_key, $result, HOUR_IN_SECONDS * 2);
		return $result;
	}
}
