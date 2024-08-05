<?php
vc_map([
	'name'                      => 'Autenticação',
	'base'                      => 'client_authentication',
	'category'                  => __( 'MP - Autenticação', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Container do formulário de autenticação.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/autenticacao.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/autenticacao/autenticacao.php',
	'as_parent'                 => ['only, except' => 'client_authentication_user,client_authentication_pass'],
	'content_element'           => true,
	'show_settings_on_create'   => false,
	'is_container'              => true,
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'client_authentication_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Título do formulário', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'client_authentication_title',
			'value'             => __('Login', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('Título de informação do formulário', MISTERPRINT_PLUGIN_NAME),
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Texto do botão', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'client_authentication_submit_value',
			'value'             => __('Enviar', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('Texto do botão de envio do formulário', MISTERPRINT_PLUGIN_NAME),
		]
	],
	'js_view' => 'VcColumnView'
]);

vc_map([
	'name'                      => 'Usuário',
	'base'                      => 'client_authentication_user',
	'category'                  => __( 'MP - Autenticação', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Login de usuário.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-email.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/autenticacao/usuario.php',
	'content_element'           => true,
	'show_settings_on_create'   => false,
	'as_child'                  => ['except' => 'client_authentication'], // Use only|except attributes to limit parent (separate multiple values with comma)
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'client_authentication_user_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'client_authentication_user_label',
			'value'             => __('Usuário', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'client_authentication_user_placeholder',
			'value'             => __('Digite o mail de cadastro.', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		]
	]
]);

vc_map([
	'name'                      => 'Senha',
	'base'                      => 'client_authentication_pass',
	'category'                  => __( 'MP - Autenticação', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Senha de usuário.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-password.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/autenticacao/senha.php',
	'content_element'           => true,
	'show_settings_on_create'   => false,
	'as_child'                  => ['except' => 'client_authentication'], // Use only|except attributes to limit parent (separate multiple values with comma)
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'client_authentication_pass_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'client_authentication_pass_label',
			'value'             => __('Senha', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'client_authentication_pass_placeholder',
			'value'             => __('Digite a sua senha.', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		]
	]
]);
