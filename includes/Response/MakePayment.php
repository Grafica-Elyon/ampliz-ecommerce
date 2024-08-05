<?php
namespace MisterPrint\Response;

use MisterPrint\Support\ConfiguredRequest;

class MakePayment extends ConfiguredRequest
{
	protected static $transient_key  = '';
	protected static $transient_time = 0;

	protected static $request_url    = 'balcao/realizar-pagamento';
	protected static $request_method = self::REQUEST_METHOD_GET;

	public static function get( $orderId, $valor, $formaPgto, $comprovante = null, $parcelas = 1 ) {
		return parent::get([
			'codigoCliente' => user()->getId(),
			'codigoPedido' => $orderId,
			'valor' => $valor,
			'formaPgto' => $formaPgto,
			'comprovante' => $comprovante,
			'parcelas' => $parcelas,
		], true);
	}

}
