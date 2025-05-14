<?php

namespace MisterPrint\Helper;

use MisterPrint\Admin\DefaultPages;

class Url
{
	static function getSubdomain()
	{
		$subdomains_names = [
			'ampliz' => 'CentralAmpliz',
			// 'dg' => 'DigitalGraph',
		];
		$serverName = explode('.', $_SERVER['SERVER_NAME']);
		if ( $serverName[0] == 'www' ) {
			array_shift($serverName);
		}
		return isset($subdomains_names[$serverName[0]]) ? $subdomains_names[$serverName[0]] : $serverName[0];
	}

	/**
	 * Get Login Page URL
	 * @return string
	 */
	static function getLoginUrl()
	{
		return (new DefaultPages)->login_page;
	}
	/**
	 * Get Login Success Page URL
	 * @return string
	 */
	static function getLoginSuccessUrl()
	{
		return (new DefaultPages)->login_success_page;
	}
	/**
	 * Get Static Logout Page URL
	 * @return string
	 */
	static function getLogoutUrl()
	{
		return (new DefaultPages)->get_static('logout_page');
	}
	/**
	 * Get Shop Page URL
	 * @return string
	 */
	static function getShopUrl()
	{
		return (new DefaultPages)->shop_page;
	}
	/**
	 * Get Checkout Page URL
	 * @return string
	 */
	static function getCheckoutUrl()
	{
		return (new DefaultPages)->checkout_page;
	}
	/**
	 * Get Cad Full Page URL
	 * @return string
	 */
	static function getCadFullUrl()
	{
		return (new DefaultPages)->cad_full_page;
	}
	/**
	 * Get Cad Partial Page URL
	 * @return string
	 */
	static function getCadPartialUrl()
	{
		return (new DefaultPages)->cad_partial_page;
	}
	/**
	 * Get Cart Page URL
	 * @return string
	 */
	static function getCartUrl()
	{
		return (new DefaultPages)->cart_page;
	}
	/**
	 * Get Static Cart Add Product Page URL
	 * @return string
	 */
	static function getAddToCartUrl($id)
	{
		return (new DefaultPages)->get_static(cart_add_page) . $id;
	}
	/**
	 * Get Static Cart Remove Product Page URL
	 * @return string
	 */
	static function removeFromCartUrl($id)
	{
		return (new DefaultPages)->get_static(cart_remove_page) . $id;
	}
}