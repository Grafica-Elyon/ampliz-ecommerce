<?php
namespace MisterPrint\Response;

use MisterPrint\Support\ConfiguredRequest;

class PagseguroValidateToken extends ConfiguredRequest
{
	protected static $transient_key  = null;
	protected static $transient_time = 0;

	protected static $request_url    = 'pagamento-pagseguro/validate-token';
	protected static $request_method = self::REQUEST_METHOD_GET;

	public static function get( $token )
	{
		return parent::get([
			'codigoCliente' => user()->getId(),
			'token' => $token,
		]);
	}

}
