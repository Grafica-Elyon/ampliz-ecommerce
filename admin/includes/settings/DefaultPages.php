<?php

namespace MisterPrint\Admin;


class DefaultPages
{
	private $default_pages;

	/**
	 * Start up
	 */
	public function __construct()
	{
		// Set class property
		$this->default_pages = get_option( 'opt_default_pages' );

		/**
		 * Static Pages
		 */
		$this->default_pages['logout_page']      = '/sair/';
		$this->default_pages['cart_add_page']    = '/mp-cart/add/';
		$this->default_pages['cart_remove_page'] = '/mp-cart/remove/';

	}
	/**
	 *
	 * Get the page ID
	 * @param string $page : ['login_page', 'shop_page', 'cart_page', 'checkout_page', 'cad_full_page', 'cad_partial_page']
	 * @return mixed : the page ID
	 */
	public function getDefaultPage($page){
		return isset($this->default_pages[$page]) ? $this->default_pages[$page] : '';
	}
	/**
	 *
	 * Magic method to get page URL
	 * @param string $page : ['login_page', 'shop_page', 'cart_page', 'checkout_page', 'cad_full_page', 'cad_partial_page']
	 * @return string : the page URLs
	 */
	public function __get($page){
		return get_permalink($this->getDefaultPage($page));
	}
	/**
	 *
	 * Magic method to get page URL
	 * @param string $page : ['login_page', 'shop_page', 'cart_page', 'checkout_page', 'cad_full_page', 'cad_partial_page']
	 * @return string : the page URLs
	 */
	public function get_static($page){
		return $this->getDefaultPage($page);
	}

	/**
	 *
	 * Checks whether the current page matches by page id on the requested page
	 * @param $page : ['login_page', 'shop_page', 'cart_page', 'checkout_page', 'cad_full_page', 'cad_partial_page']
	 * @return bool
	 */
	public function isDefaultPage($page){
		if($this->getDefaultPage($page) == get_the_ID()){
			return true;
		}
		return false;
	}
}
