<?php
namespace MisterPrint\Response;

use MisterPrint\Support\ConfiguredRequest;

class CustomerDepartments extends ConfiguredRequest
{
	protected static $transient_key  = 'customers_company_departments';
	protected static $transient_time = 1 * MINUTE_IN_SECONDS;

	protected static $request_url    = 'cliente/get-empresa-departamentos';
	protected static $request_method = self::REQUEST_METHOD_GET;

}
