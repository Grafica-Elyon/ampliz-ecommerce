<?php
namespace MisterPrint\Response;

use MisterPrint\Support\ConfiguredRequest;

class CustomerPositions extends ConfiguredRequest
{
	protected static $transient_key  = 'customers_company_positions';
	protected static $transient_time = 1 * MINUTE_IN_SECONDS;

	protected static $request_url    = 'cliente/get-empresa-cargos';
	protected static $request_method = self::REQUEST_METHOD_GET;

}
