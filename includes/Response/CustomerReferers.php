<?php
namespace MisterPrint\Response;

use MisterPrint\Support\ConfiguredRequest;

class CustomerReferers extends ConfiguredRequest
{
	protected static $transient_key  = 'customer_referers';
	protected static $transient_time = 15 * MINUTE_IN_SECONDS;

	protected static $request_url    = 'cliente/get-referrers';
	protected static $request_method = self::REQUEST_METHOD_GET;

}
