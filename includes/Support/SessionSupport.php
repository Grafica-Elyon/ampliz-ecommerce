<?php

namespace MisterPrint\Support;

/**
* SessionSupport class
*
* This is a general-purpose class that allows to manage PHP built-in sessions
* and the session variables passed via $_SESSION superglobal.
*
* @since 1.0.0
*/
class SessionSupport
{

	/**
	* @var array
	*/
	protected $settings;

	/**
	* The construct function of class
	*
	* @since  1.0.0
	*/
	public function __construct($settings = [])
	{
		add_action( 'init', array(&$this, 'register_session' ));

		$defaults = [
			'lifetime'    => '60 minutes',
			'name'        => 'mp_session',
			'autorefresh' => false,
		];

		$this->settings = array_merge($defaults, $settings);

		@ini_set('session.gc_probability', 1);
		@ini_set('session.gc_divisor', 1);
		@ini_set('session.gc_maxlifetime', strtotime($this->settings['lifetime']));
	}
	/**
	* Verify if sesssion exists an it's started
	*
	* @since  1.0.0
	*/
	public function register_session() {
		if ( ! session_id() ) {
			session_regenerate_id(false);
			session_start();
		}
	}

	/**
	* Get a session variable.
	*
	* @param string $key
	* @param mixed  $default
	*
	* @since  1.0.0
	* @return mixed
	*/
	public static function get($key, $default = null)
	{
		return self::exists($key)
		? $_SESSION[$key]
		: $default;
	}
	/**
	* Set a session variable.
	*
	* @param string $key
	* @param mixed  $value
	*
	* @since  1.0.0
	* @return $this
	*/
	public static function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}
	/**
	* Delete a session variable.
	*
	* @param string $key
	*
	* @since  1.0.0
	* @return $this
	*/
	public static function delete($key)
	{
		if (self::exists($key)) {
			unset($_SESSION[$key]);
		}
		return true;
	}
	/**
	* Delete any session variable in array.
	*
	* @param array $keys
	*
	* @since  1.0.0
	* @return $this
	*/
	public static function delete_group($keys)
	{
		foreach ($keys as $key) {
			if (self::exists($key)) {
				unset($_SESSION[$key]);
			}
		}
		return self;
	}
	/**
	* Clear all session variables.
	*
	* @since  1.0.0
	* @return $this
	*/
	public static function clear()
	{
		$_SESSION = [];
		return self;
	}
	/**
	* Check if a session variable is set.
	*
	* @param string $key
	*
	* @since  1.0.0
	* @return bool
	*/
	public static function exists($key)
	{
		$session = (isset($_SESSION) && !is_null($_SESSION)) ? $_SESSION : [];
		return array_key_exists($key, $session);
	}
	/**
	* Magic method for get.
	*
	* @param string $key
	*
	* @since  1.0.0
	* @return mixed
	*/
	public function __get($key)
	{
		return self::get($key);
	}
	/**
	* Magic method for set.
	*
	* @param string $key
	* @param mixed  $value
	*
	* @since  1.0.0
	*/
	public function __set($key, $value)
	{
		self::set($key, $value);
	}
	/**
	* Magic method for delete.
	*
	* @param string $key
	*
	* @since  1.0.0
	*/
	public function __unset($key)
	{
		self::delete($key);
	}
	/**
	* Magic method for exists.
	*
	* @param string $key
	*
	* @since  1.0.0
	* @return bool
	*/
	public function __isset($key)
	{
		return self::exists($key);
	}

}
