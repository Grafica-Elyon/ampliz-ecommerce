<?php
namespace MisterPrint\Response;

use MisterPrint\Support\ConfiguredRequest;

class CreationArtSubmit extends ConfiguredRequest
{
	protected static $transient_key  = null;
	protected static $transient_time = 0;

	protected static $request_url  	 = 'creation-art/submit';
	protected static $request_method = self::REQUEST_METHOD_POST;

	public static function send( $codigoPedido = null, $codigoItem = null )
	{
		if ( !isset($codigoPedido) ) {
			return ['error'=>'Pedido não informado'];
		}
		if ( !isset($codigoItem) ) {
			return ['error'=>'Item não informado'];
		}
		return self::get([
			'codigoCliente' => user()->getId(),
			'codigoPedido' => $codigoPedido,
			'codigoItem' => $codigoItem,
		]);
	}

}
