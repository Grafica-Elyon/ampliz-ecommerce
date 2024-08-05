<?php
namespace MisterPrint\Response;

use MisterPrint\Support\ConfiguredRequest;

class MakeDispatch extends ConfiguredRequest
{
	protected static $transient_key  = '';
	protected static $transient_time = 0;

	protected static $request_url    = 'balcao/realizar-despacho';
	protected static $request_method = self::REQUEST_METHOD_GET;

	public static function get( $orderId ) {
		return parent::get([
			'codigoCliente' => user()->getId(),
			'codigoPedido' => $orderId,
		], true);
	}

}
