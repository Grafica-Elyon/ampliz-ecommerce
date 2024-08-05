<?php
namespace MisterPrint\Response;

use MisterPrint\Support\ConfiguredRequest;

class BalconyArtCreationRegister extends ConfiguredRequest
{
	protected static $transient_key  = null;
	protected static $transient_time = 0;

	protected static $request_url    = 'balcao/criacao-arte/registrar';
	protected static $request_method = self::REQUEST_METHOD_GET;

	public static function send( $data )
	{
		return self::get($data);
	}

}
