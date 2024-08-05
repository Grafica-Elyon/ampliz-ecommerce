<?php
namespace MisterPrint\Response;

use MisterPrint\Support\ConfiguredRequest;

class CustomerInterest extends ConfiguredRequest
{
	protected static $transient_key  = 'customer_interest';
	protected static $transient_time = 1 * MINUTE_IN_SECONDS;

	protected static $request_url    = 'cliente/get-interesses-clientes';
	protected static $request_method = self::REQUEST_METHOD_GET;

}
