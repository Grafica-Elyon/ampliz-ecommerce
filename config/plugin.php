<?php
return [
	'name' => 'misterprint-ecommerce',
	'version' => '1.3.9',

	// Configurações relativas à localidade dos arquivos do plugin
	'path' => plugin_dir_path( dirname( __FILE__ ) ),
	'url' => plugin_dir_url( dirname( __FILE__ ) ),
	'url_loja' => $this->get('env', 'APP_URL','https://dev.ampliz.com.br'),

	// Configurações principais do plugin, que podem ser configuradas via .env
	'api' => $this->get( 'env', 'APP_PLUGIN_URL_API', 'https://api.dev.ampliz.com.br/'),
	'upload_url' => $this->get( 'env', 'APP_UPLOAD_URL', 'https://up4.dev.ampliz.com.br/'),
	'thumbs' => $this->get( 'env', 'APP_PLUGIN_URL_THUMBS', 'https://thumbs.dev.ampliz.com.br/'),
	'debug' => $this->get( 'env', 'APP_PLUGIN_DEBUG', false),
	'franquia' => $this->get( 'env', 'APP_FRANQUIA', 1),
	'debug.log_request_ips' => $this->get( 'env', 'APP_PLUGIN_DEBUG_IPS', []),
	'google_clientid' => $this->get( 'env', 'APP_GOOGLE_CLIENTID', ''),
    'google_loginuri' => $this->get( 'env', 'APP_GOOGLE_LOGINURI', ''),
    'facebook_id' => $this->get( 'env', 'APP_FACEBOOK_ID', ''),
    'facebook_secret' => $this->get( 'env', 'APP_FACEBOOK_SECRET', ''),
	'facebook_version' => $this->get( 'env', 'APP_FACEBOOK_VERSION', ''),
	'franqueado_cep'  => $this->get( 'env', 'APP_FRANQUEADO_CEP', ''),
];
