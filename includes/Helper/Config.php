<?php

namespace MisterPrint\Helper;

class Config {
	private $prefix = 'mp_';
	private $files = [
		'plugin',
		'components',
		'pages',
		'credentials',
		'states'
	];

	private $config = [];

	public function __construct() {

		$this->config['env'] = parse_ini_file( plugin_dir_path( dirname( __DIR__ ) ).'/.env' );

		$this->loadConfigs();
	}

	private function loadConfigs() {
		foreach ( $this->files as $file ) {
			$this->config[ $file ] = include( plugin_dir_path( dirname( __DIR__ ) ) . 'config/' . $file . '.php' );
		}
	}

	public function get( $config, $value = null, $defaultValue = null ) {

		if($config == 'options') {
			return $this->getOption($value);
		}

		if ( is_null( $value ) ) {
			if ( isset( $this->config[ $config ] ) ) {
				return $this->config[ $config ];
			}
		}

		if ( isset( $this->config[ $config ] ) && isset( $this->config[ $config ][ $value ] ) ) {
			return $this->config[ $config ][ $value ];
		}

		return $defaultValue;
	}

	public function getOption($option)
	{
		$option_value_raw =  \get_option($this->prefix.$option);
		$option_value = json_decode($option_value_raw, true);

		if(json_last_error() == JSON_ERROR_NONE) {
			return $option_value;
		}

		return $option_value_raw;
	}

	public function saveOption($option, $value)
	{
		if(\is_array($value)) {
			$value = json_encode($value);
		}

		\update_option($this->prefix.$option, $value);

		if(\wp_redirect($_SERVER['HTTP_REFERER'])) {
			exit();
		}
	}
}
