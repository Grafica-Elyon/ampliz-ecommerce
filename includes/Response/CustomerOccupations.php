<?php
namespace MisterPrint\Response;

use MisterPrint\Support\ConfiguredRequest;

class CustomerOccupations extends ConfiguredRequest
{
	protected static $transient_key  = 'customers_occupations';
	protected static $transient_time = 1 * MINUTE_IN_SECONDS;

	protected static $request_url    = 'cliente/get-ocupacoes';
	protected static $request_method = self::REQUEST_METHOD_GET;

}
