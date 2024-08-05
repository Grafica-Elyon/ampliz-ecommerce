<?php
vc_map([
	'name'                      => 'Cadastro Completo',
	'base'                      => 'cadastro_completo',
	'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Container do cadastro de usuario completo.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-completo.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/cadastro-completo.php',
	'as_parent'                 => [
									'only, except' =>'cadastro_completo_nome,cadastro_completo_nascimento,cadastro_completo_email,cadastro_completo_senha,cadastro_completo_telefone,cadastro_completo_celular,cadastro_completo_aparelho,cadastro_completo_operadora,cadastro_completo_skype,cadastro_completo_facebook,cadastro_completo_twitter,cadastro_completo_rg,cadastro_completo_cpf,cadastro_completo_genero,cadastro_completo_logradouro,cadastro_completo_logradouro_num,cadastro_completo_logradouro_bairro,cadastro_completo_logradouro_cidade,cadastro_completo_logradouro_estado,cadastro_completo_logradouro_cep,cadastro_completo_empresa,cadastro_completo_cnpj,cadastro_completo_loja,cadastro_completo_qtd_funcionarios,cadastro_completo_profissao,cadastro_completo_atividade,cadastro_completo_cargo,cadastro_completo_newsletter,cadastro_completo_termo,cadastro_completo_como_conheceu,cadastro_completo_observacoes'],
	'content_element'           => true,
	'show_settings_on_create'   => false,
	'is_container'              => true,
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_completo_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Texto do botão', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'cadastro_completo_submit_value',
			'value'             => __('Enviar', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('Texto do botão de envio do formulário', MISTERPRINT_PLUGIN_NAME),
		]
	],
	'js_view'                   => 'VcColumnView'
]);
/**
 *
 * DADOS PESSOAIS DO CLIENTE
 *
 */
	/**
	 * Nome
	 */
	vc_map([
		'name'                      => 'Nome',
		'base'                      => 'cadastro_completo_nome',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Nome completo do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-text.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/cliente-nome.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_nome_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_nome_label',
				'value'             => __('Nome', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_nome_placeholder',
				'value'             => __('Digite o seu nome.', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * Data de Nascimento
	 */
	vc_map([
		'name'                      => 'Data de Nascimento',
		'base'                      => 'cadastro_completo_nascimento',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Data de Nascimento do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-date.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/cliente-data-nascimento.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_nascimento_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_nascimento_label',
				'value'             => __('Data de Nascimento', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
		]
	]);
	/**
	 * Email
	 */
	vc_map([
		'name'                      => 'Email de Usuário',
		'base'                      => 'cadastro_completo_email',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Email do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-email.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/cliente-email.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_email_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_email_label',
				'value'             => __('Email', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_email_placeholder',
				'value'             => __('Digite o seu email', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * Senha
	 */
	vc_map([
		'name'                      => 'Senha de Usuário',
		'base'                      => 'cadastro_completo_senha',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Senha do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-password.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/cliente-senha.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_senha_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_senha_label',
				'value'             => __('Senha', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_senha_placeholder',
				'value'             => __('Digite a sua senha', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_confirma_senha_label',
				'value'             => __('Confirme a senha', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
			'type'                  => 'textfield',
			'heading'               => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
			'param_name'            => 'cadastro_completo_confirma_senha_placeholder',
			'value'                 => __('Redigite a sua senha', MISTERPRINT_PLUGIN_NAME),
			'description'           => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * Telefone
	 */
	vc_map([
		'name'                      => 'Telefone',
		'base'                      => 'cadastro_completo_telefone',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Telefone do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-number.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/cliente-telefone.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_telefone_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_telefone_label',
				'value'             => __('Telefone', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
		]
	]);
	/**
	 * Celular
	 */
	vc_map([
		'name'                      => 'Celular Número',
		'base'                      => 'cadastro_completo_celular',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Celular do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-number.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/cliente-celular.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_celular_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_celular_label',
				'value'             => __('Celular', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
		]
	]);
	/**
	 * Aparelho
	 */
	vc_map([
		'name'                      => 'Celular Aparelho',
		'base'                      => 'cadastro_completo_aparelho',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Aparelho do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-text.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/comunicacao-aparelho.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_aparelho_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_aparelho_label',
				'value'             => __('Aparelho', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_aparelho_placeholder',
				'value'             => __('Digite a marca e o modelo do seu celular.', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * Operadora
	 */
	vc_map([
		'name'                      => 'Celular Operadora',
		'base'                      => 'cadastro_completo_operadora',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Operadora de telefonia cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-text.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/comunicacao-operadora.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_operadora_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_operadora_label',
				'value'             => __('Operadora', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_operadora_placeholder',
				'value'             => __('Digite a sua operadora de telefonia', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * Skype
	 */
	vc_map([
		'name'                      => 'Skype',
		'base'                      => 'cadastro_completo_skype',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Skype do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-text.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/comunicacao-skype.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_skype_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_skype_label',
				'value'             => __('Skype', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_skype_placeholder',
				'value'             => __('Digite o seu skype.', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * Facebook
	 */
	vc_map([
		'name'                      => 'Facebook',
		'base'                      => 'cadastro_completo_facebook',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Facebook do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-text.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/comunicacao-facebook.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_facebook_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_facebook_label',
				'value'             => __('Facebook', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_facebook_placeholder',
				'value'             => __('Digite o seu facebook.', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * Twitter
	 */
	vc_map([
		'name'                      => 'Twitter',
		'base'                      => 'cadastro_completo_twitter',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Twitter do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-text.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/comunicacao-twitter.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_twitter_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_twitter_label',
				'value'             => __('Twitter', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_twitter_placeholder',
				'value'             => __('Digite o seu twitter.', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * RG
	 */
	vc_map([
		'name'                      => 'RG',
		'base'                      => 'cadastro_completo_rg',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'RG do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-number.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/cliente-rg.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_rg_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_rg_label',
				'value'             => __('RG', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
		]
	]);
	/**
	 * CPF
	 */
	vc_map([
		'name'                      => 'CPF',
		'base'                      => 'cadastro_completo_cpf',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'CPF do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-number.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/cliente-cpf.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_cpf_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_cpf_label',
				'value'             => __('CPF', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
		]
	]);
	/**
	 * Gênero
	 */
	vc_map([
		'name'                      => 'Gênero',
		'base'                      => 'cadastro_completo_genero',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Gênero(sexo) do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-radio.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/cliente-genero.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_genero_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_genero_label',
				'value'             => __('Escolha o seu Gênero', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_genero_male_label',
				'value'             => __('Masculino', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_genero_female_label',
				'value'             => __('Feminino', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
/**
 *
 * ENREREÇO DO CLIENTE
 *
 */
	/**
	 * Logradouro
	 */
	vc_map([
		'name'                      => 'Logradouro',
		'base'                      => 'cadastro_completo_logradouro',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Logradouro completo do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-text.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/endereco-logradouro.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_logradouro_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_logradouro_label',
				'value'             => __('Logradouro', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_logradouro_placeholder',
				'value'             => __('Digite o seu logradouro.', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * Logradouro Número
	 */
	vc_map([
		'name'                      => 'Logradouro Número',
		'base'                      => 'cadastro_completo_logradouro_num',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Número do Logradouro do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-number.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/endereco-logradouro-num.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_num_logradouro_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_num_logradouro_label',
				'value'             => __('Número', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
		]
	]);
	/**
	 * Logradouro Bairro
	 */
	vc_map([
		'name'                      => 'Logradouro Bairro',
		'base'                      => 'cadastro_completo_logradouro_bairro',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Bairro do logradouro do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-text.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/endereco-bairro.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_logradouro_bairro_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_logradouro_bairro_label',
				'value'             => __('Bairro', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_logradouro_bairro_placeholder',
				'value'             => __('Digite o seu bairro', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * Logradouro Cidade
	 */
	vc_map([
		'name'                      => 'Logradouro Cidade',
		'base'                      => 'cadastro_completo_logradouro_cidade',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Cidade do logradouro do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-text.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/endereco-cidade.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_logradouro_cidade_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_logradouro_cidade_label',
				'value'             => __('Cidade', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_logradouro_cidade_placeholder',
				'value'             => __('Digite a sua cidade', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * Logradouro Estado
	 */
	vc_map([
		'name'                      => 'Logradouro Estado',
		'base'                      => 'cadastro_completo_logradouro_estado',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Estado do logradouro do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-text.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/endereco-estado.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_logradouro_estado_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_logradouro_estado_label',
				'value'             => __('Estado', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_logradouro_estado_placeholder',
				'value'             => __('Selecione o seu estado', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * Logradouro CEP
	 */
	vc_map([
		'name'                      => 'Logradouro CEP',
		'base'                      => 'cadastro_completo_logradouro_cep',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Cep do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-number.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/endereco-cep.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_logradouro_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_logradouro_label',
				'value'             => __('CEP', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
		]
	]);
/**
 *
 * DADOS PROFISSIONAIS DO CLIENTE
 *
 */
/**
 * Empresa
 */
	vc_map([
		'name'                      => 'Empresa',
		'base'                      => 'cadastro_completo_empresa',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Empresa completo do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-text.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/cliente-empresa.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_empresa_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_empresa_label',
				'value'             => __('Empresa', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_empresa_placeholder',
				'value'             => __('Digite o nome da sua empresa.', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * CNPJ
	 */
	vc_map([
		'name'                      => 'CNPJ',
		'base'                      => 'cadastro_completo_cnpj',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'CNPF do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-number.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/cliente-cnpj.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_cnpj_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_cnpj_label',
				'value'             => __('CNPJ', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
		]
	]);
	/**
	 * Loja
	 */
	vc_map([
		'name'                      => 'Loja',
		'base'                      => 'cadastro_completo_loja',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Loja completo do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-text.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/cliente-loja.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_loja_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_loja_label',
				'value'             => __('Loja', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * Quantidade de Funcionários
	 */
	vc_map([
		'name'                      => 'Quantidade de Funcionários',
		'base'                      => 'cadastro_completo_qtd_funcionarios',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Total de funcionarios da empresa.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-number.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/empresa-qtd-funcionarios.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_qtd_funcionarios_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_qtd_funcionarios_label',
				'value'             => __('Total de Funcionários', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
		]
	]);
	/**
	 * Profissão
	 */
	vc_map([
		'name'                      => 'Profissão',
		'base'                      => 'cadastro_completo_profissao',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Profissão do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-text.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/cliente-profissao.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_profissao_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_profissao_label',
				'value'             => __('Profissão', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_profissao_placeholder',
				'value'             => __('Digite a sua profissão', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * Atividade
	 */
	vc_map([
		'name'                      => 'Atividade',
		'base'                      => 'cadastro_completo_atividade',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Atividade do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-text.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/empresa-atividade.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_atividade_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_atividade_label',
				'value'             => __('Atividade', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_atividade_placeholder',
				'value'             => __('Digite a sua atividade', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * Cargo
	 */
	vc_map([
		'name'                      => 'Cargo',
		'base'                      => 'cadastro_completo_cargo',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Cargo do cliente.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-text.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/empresa-cargo.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_cargo_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_cargo_label',
				'value'             => __('Cargo', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_cargo_placeholder',
				'value'             => __('Digite o seu cargo.', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
/**
 *
 * OUTRAS INFORMAÇOES E OU ATRIBUIÇOES
 *
 */
	/**
	 * Newsletter
	 */
	vc_map([
		'name'                      => 'Assinar a Newsletter',
		'base'                      => 'cadastro_completo_newsletter',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __( 'Assinar a Newsletter (sim/não).', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-radio.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/cliente-newsletter.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_newsletter_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_newsletter_label',
				'value'             => __('Deseja assinar a nossa Newsletter?', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_newsletter_sim_label',
				'value'             => __('Sim', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_newsletter_nao_label',
				'value'             => __('Feminino', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * Termos de Uso
	 */
	vc_map([
		'name'                      => 'Termos de Uso',
		'base'                      => 'cadastro_completo_termo',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __('Declaração de ciência dos termos de uso do site.', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-checkbox.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/cliente-termo.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_termo_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_termo_label',
				'value'             => __('Declaro que li, tenho ciência e concordo plenamente com os <strong>Termos de Uso</strong> do site.', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * Como Conheçeu
	 */
	vc_map([
		'name'                      => 'Como nos Conheceu',
		'base'                      => 'cadastro_completo_como_conheceu',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __('Descreva como nos conheceu', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-textarea.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/cliente-como-conheceu.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_como_conheceu_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_como_conheceu_label',
				'value'             => __('Como nos Conheceu?', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_como_conheceu_placeholder',
				'value'             => __('Descreva como nos conheceu', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
	/**
	 * Observações
	 */
	vc_map([
		'name'                      => 'Observações',
		'base'                      => 'cadastro_completo_observacoes',
		'category'                  => __( 'MP - Cadastro Completo', MISTERPRINT_PLUGIN_NAME ),
		'description'               => __('Descreva como nos conheceu', MISTERPRINT_PLUGIN_NAME ),
		"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cadastro-field-textarea.png',
		'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cadastro-completo/cliente-obs.php',
		'content_element'           => true,
		'show_settings_on_create'   => false,
		'as_child'                  => ['except' => 'cadastro_completo'], // Use only|except attributes to limit parent (separate multiple values with comma)
		'params' => [
			[
				'type'              => 'textfield',
				'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_observacoes_class',
				'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_observacoes_label',
				'value'             => __('Observações', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			],
			[
				'type'              => 'textfield',
				'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
				'param_name'        => 'cadastro_completo_observacoes_placeholder',
				'value'             => __('Cajo tenha alguma observação, crítica e ou sugestão, você pode digita-la aqui.', MISTERPRINT_PLUGIN_NAME),
				'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
			]
		]
	]);
