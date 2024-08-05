<?php

namespace MisterPrint\Admin\Includes;

class Posts
{
	private $filter;

	public function __construct($filter)
	{
		$this->filter = $filter;
	}

	static public function handler($filter)
	{
		return function () use ($filter) {
			(new self($filter))->handle();
		};
	}

	public function handle()
	{
		$this->{$this->filter}();
	}

	public function admin_pages()
	{
		config()->saveOption('pages', $_POST['pages']);
	}

	public function main_color()
	{
		config()->saveOption('main_color', $_POST['color']);
	}

	public static function delete_transient($redir=true)
	{
		global $wpdb;
		$sql = 'DELETE FROM ' . $wpdb->options . ' WHERE option_name LIKE "_transient_%"';
		$wpdb->query($sql);
		add_action('admin_notices', 'blackhole_tools_admin_notice');
		if($redir && \wp_redirect($_SERVER['HTTP_REFERER'] . '&clear=1') ) {
			exit();
		}
	}

	public function social_links()
	{
		$links = $_POST;
		foreach($links as $key => $value){
			if($value != "" && substr($value, 0, 4) != 'http'){
				$_POST[$key] = 'https://'.$value;
			}
		}
		update_option('social_links', json_encode([
			'facebook' => $_POST['facebook_link'],
			'twitter' => $_POST['twitter_link'],
			'instagram' => $_POST['instagram_link'],
			'youtube' => $_POST['youtube_link']
		]));
		if(\wp_redirect($_SERVER['HTTP_REFERER'] . '&save_social=1')) {
			exit();
		}
	}
}
