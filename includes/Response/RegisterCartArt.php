<?php
namespace MisterPrint\Response;

use MisterPrint\Support\ConfiguredRequest;

class RegisterCartArt extends ConfiguredRequest
{
	protected static $request_url	 = 'carrinho/registrar-arte';
	protected static $request_method = self::REQUEST_METHOD_POST;

	public static function send( $item, $arquivo )
	{
		if ( !$item ) {
			return ['error'=>'Item não informado'];
		}
		if ( !$arquivo || !file_exists($arquivo) ) {
			return ['error'=>'Arquivo não informado ou inexistente'];
		}

		$codigoCliente = user()->getId();
		if ( !$codigoCliente ) {
			return ['error'=>'Cliente não logado'];
		}

		try {
			return parent::get([
				'codigoCliente' => user()->getId(),
				'codigoItem' => $item,
				'file' => new \CURLFile( $arquivo, mime_content_type($arquivo) ),
			]);
		} catch (\Exception $e) {
			return [
				'error' => 'Ocorreu um erro na requisição',
				'debug' => $e->getMessage(),
			];
		}
	}
}
