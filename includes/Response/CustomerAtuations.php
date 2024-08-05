<?php
namespace MisterPrint\Response;

use MisterPrint\Support\ConfiguredRequest;

class CustomerAtuations extends ConfiguredRequest
{
	protected static $transient_key  = 'customer_atuations';
	protected static $transient_time = 1 * MINUTE_IN_SECONDS;

	protected static $request_url    = 'cliente/get-areas-atuacao-clientes';
	protected static $request_method = self::REQUEST_METHOD_GET;

}
