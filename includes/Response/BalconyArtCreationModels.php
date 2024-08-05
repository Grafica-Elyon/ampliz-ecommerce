<?php
namespace MisterPrint\Response;

use MisterPrint\Support\ConfiguredRequest;

class BalconyArtCreationModels extends ConfiguredRequest
{
	protected static $transient_key  = 'mp_balcony_art_creation_product_models';
	protected static $transient_time = 1 * HOUR_IN_SECONDS;

	protected static $request_url    = 'balcao/criacao-arte/modelos';
	protected static $request_method = self::REQUEST_METHOD_GET;

}
