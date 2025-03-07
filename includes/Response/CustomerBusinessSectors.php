<?php
namespace MisterPrint\Response;

use MisterPrint\Support\ConfiguredRequest;

class CustomerBusinessSectors extends ConfiguredRequest
{
	protected static $transient_key  = 'customers_business_sectors';
	protected static $transient_time = 1 * MINUTE_IN_SECONDS;

	protected static $request_url    = 'cliente/get-ramos-atividades';
	protected static $request_method = self::REQUEST_METHOD_GET;

}
