<?php
namespace MisterPrint\Response;

use MisterPrint\Support\ConfiguredRequest;

class PaymentInfo extends ConfiguredRequest
{
	protected static $request_url    = 'balcao/informacao-pagamentos';
	protected static $request_method = self::REQUEST_METHOD_GET;

	public static function get( $orderId , $forceRequest = false, $attempts = 0 ) {
		return parent::get([
			'codigoCliente' => user()->getId(),
			'codigoPedido' => $orderId
		], true, 0);
	}

}
