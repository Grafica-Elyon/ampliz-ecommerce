<?php
namespace MisterPrint\Response;

use MisterPrint\Support\ConfiguredRequest;

class BalconyIps extends ConfiguredRequest
{
	protected static $transient_key  = 'mp_balcony_ips';
	protected static $transient_time = 30 * MINUTE_IN_SECONDS;

	protected static $request_url    = 'empresa/get-ips-balcoes';
	protected static $request_method = self::REQUEST_METHOD_GET;

	public static function getCurrentIp() {

		$ips_balcoes = self::get();
		if ( !$ips_balcoes ) {
			return false;
		}

		$ips_balcoes_validos = array_filter(
			$ips_balcoes,
			function ( $ip ) {
				return $_SERVER['REMOTE_ADDR'] == $ip['dns'];
			}
		);

		foreach ($ips_balcoes_validos as $ip) {
			if ( $ip['dominio'] === null || $ip['dominio'] === $_SERVER['HTTP_HOST']) {
				return $ip;
			}
		}

		return false;
	}

}