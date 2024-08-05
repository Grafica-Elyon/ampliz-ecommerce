<?php
vc_map([
	'name'                      => 'Cadastro Incompleto',
	'base'                      => 'cadastro_incompleto',
	'category'                  => __( 'MP - Cadastro Incompleto', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Container do cadastro de usuario incompleto.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-incompleto.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-incompleto/cadastro-incompleto.php',
	'as_parent'                 => ['only, except' => 'cadastro_incompleto_nome,cadastro_incompleto_email,cadastro_incompleto_telefone,cadastro_incompleto_profissao,cadastro_incompleto_cep,cadastro_incompleto_como_conheceu'],
	'content_element'           => true,
	'show_settings_on_create'   => false,
	'is_container'              => true,
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Texto do botão', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_submit_value',
			'value'             => __('Enviar', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('Texto do botão de envio do formulário', MISTERPRINT_PLUGIN_NAME),
		]
	],
	'js_view' => 'VcColumnView'
]);
/* Cadastro filter childs */
vc_map([
	'name'                      => 'Nome',
	'base'                      => 'cadastro_incompleto_nome',
	'category'                  => __( 'MP - Cadastro Incompleto', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Nome completo do cliente.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-text.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-incompleto/nome.php',
	'content_element'           => true,
	'show_settings_on_create'   => false,
	'as_child'                  => ['except' => 'cadastro_incompleto'], // Use only|except attributes to limit parent (separate multiple values with comma)
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_nome_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_nome_label',
			'value'             => __('Nome', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_nome_placeholder',
			'value'             => __('Digite o seu nome.', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		]
	]
]);
vc_map([
	'name'                      => 'Email',
	'base'                      => 'cadastro_incompleto_email',
	'category'                  => __( 'MP - Cadastro Incompleto', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Email do cliente.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-email.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-incompleto/email.php',
	'content_element'           => true,
	'show_settings_on_create'   => false,
	'as_child'                  => ['except' => 'cadastro_incompleto'], // Use only|except attributes to limit parent (separate multiple values with comma)
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_email_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_email_label',
			'value'             => __('Email', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_email_placeholder',
			'value'             => __('Digite o seu email', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		]
	]
]);
vc_map([
	'name'                      => 'Telefone',
	'base'                      => 'cadastro_incompleto_telefone',
	'category'                  => __( 'MP - Cadastro Incompleto', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Telefone do cliente.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-number.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-incompleto/telefone.php',
	'content_element'           => true,
	'show_settings_on_create'   => false,
	'as_child'                  => ['except' => 'cadastro_incompleto'], // Use only|except attributes to limit parent (separate multiple values with comma)
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_telefone_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_telefone_label',
			'value'             => __('Telefone', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		]
	]
]);
vc_map([
	'name'                      => 'Profissao',
	'base'                      => 'cadastro_incompleto_profissao',
	'category'                  => __( 'MP - Cadastro Incompleto', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Profissao do cliente.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-text.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-incompleto/profissao.php',
	'content_element'           => true,
	'show_settings_on_create'   => false,
	'as_child'                  => ['except' => 'cadastro_incompleto'], // Use only|except attributes to limit parent (separate multiple values with comma)
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_profissao_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_profissao_label',
			'value'             => __('Profissao', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_profissao_placeholder',
			'value'             => __('Digite o seu profissao', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		]
	]
]);
vc_map([
	'name'                      => 'Cep',
	'base'                      => 'cadastro_incompleto_cep',
	'category'                  => __( 'MP - Cadastro Incompleto', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Cep do cliente.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-number.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-incompleto/cep.php',
	'content_element'           => true,
	'show_settings_on_create'   => false,
	'as_child'                  => ['except' => 'cadastro_incompleto'], // Use only|except attributes to limit parent (separate multiple values with comma)
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_cep_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_cep_label',
			'value'             => __('Cep', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_cep_placeholder',
			'value'             => __('Digite o seu CEP', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		]
	]
]);
vc_map([
	'name'                      => 'Como nos Conheceu',
	'base'                      => 'cadastro_incompleto_como_conheceu',
	'category'                  => __( 'MP - Cadastro Incompleto', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __('Descreva como nos conheceu', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-textarea.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-incompleto/comoconheceu.php',
	'content_element'           => true,
	'show_settings_on_create'   => false,
	'as_child'                  => ['except' => 'cadastro_incompleto'], // Use only|except attributes to limit parent (separate multiple values with comma)
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_como_conheceu_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_como_conheceu_label',
			'value'             => __('Como nos Conheceu?', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_incompleto_como_conheceu_placeholder',
			'value'             => __('Descreva como nos conheceu', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		]
	]
]);
