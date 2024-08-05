<?php

namespace MisterPrint\Core;

/**
 * Fired every request, at init action.
 *
 *
 * @since      1.0.0
 * @package    MisterPrint
 * @subpackage MisterPrint/includes
 * @author     Your Name <email@example.com>
 */
class Request {

	private $pages;
	private $page;
	private $page_slug;

	public function __construct()
	{
		$this->pages = [];
		$this->page = get_the_ID();

		@array_walk(config('pages'), function($page, $key) {
			$this->pages[$key] = $page;
			$this->pages[$key]['id'] = get_page_id($key);

			if(empty($this->pages[$key]['id'])) {
				unset($this->pages[$key]);
			}
		});

		$this->filter();
	}


	private function filter()
	{
		@array_walk($this->pages, function($page, $key) {
			if($page['id'] == get_the_ID()) {
				$this->page_slug = $key;
				$this->handle($page);
			}
		});
	}

	private function handle($page)
	{
		if(isset($page['auth']) && $page['auth']) {
			if(!user()->isLogged()) {
				$this->redirect('login', get_full_url());
			}
		}

		if(isset($page['validate']) && is_callable($page['validate'])) {
			$page['validate']();
		}
	}

	private function redirect($page, $redirectTo = null)
	{
		$url = get_page_url($page);
		if(!is_null($redirectTo)) {
			$url = get_page_url($page).'?redirectTo='.urlencode($redirectTo);
		}

		if(wp_redirect($url)) {
			exit();
		}
	}
}
