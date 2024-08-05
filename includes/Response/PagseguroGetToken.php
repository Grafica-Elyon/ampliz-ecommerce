<?php
namespace MisterPrint\Response;

use MisterPrint\Support\ConfiguredRequest;

class PagseguroGetToken extends ConfiguredRequest
{
	protected static $request_url    = 'pagamento-pagseguro/get-token';
	protected static $request_method = self::REQUEST_METHOD_GET;

	public static function get( $data = [], $forceRequest = false, int $attempts = 0 ) {
		return parent::get(
			array_merge( $data, ['codigoCliente' => user()->getId() ] ),
			$forceRequest,
			$attempts
		);
	}
}
