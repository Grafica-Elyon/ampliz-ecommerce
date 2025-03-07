<?php
namespace MisterPrint\Response;

use MisterPrint\Support\ConfiguredRequest;

class CustomerActivities extends ConfiguredRequest
{
	protected static $transient_key  = 'customer_activities';
	protected static $transient_time = 1 * MINUTE_IN_SECONDS;

	protected static $request_url    = 'cliente/get-areas-atuacao-clientes';
	protected static $request_method = self::REQUEST_METHOD_GET;

}
