<?php
vc_map([
	'name'                      => 'Endereço de Entrega',
	'base'                      => 'shipping_address',
	'category'                  => __( 'MP - Checkout', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __('Endereços(s) de entrega do cliente.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/shipping-address.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/client/shipping-address.php',
	'content_element'           => true,
	'show_settings_on_create'   => false,
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Título da Sessão', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'shipping_address_title',
			'value'             => __('Endereço de Entrega do Cliente', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default title, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Título da Janela Adicionar', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'shipping_address_title_add',
			'value'             => __('Adicionar um Endereço', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default title, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Título da Janela de Sucesso ao Adicionar', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'shipping_address_title_add_sucess',
			'value'             => __('Endereço adicionado com sucesso!', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default title, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Título da Janela de Erro ao Adicionar', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'shipping_address_title_add_err',
			'value'             => __('Erro ao adicionar o endereço.', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default title, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Título da Janela Editar', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'shipping_address_title_edit',
			'value'             => __('Editar o Endereço', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default title, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Título da Janela de Sucesso ao Editar', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'shipping_address_title_edit_sucess',
			'value'             => __('Endereço editado com sucesso!', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default title, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Título da Janela de Erro ao Editar', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'shipping_address_title_edit_err',
			'value'             => __('Erro ao editar o endereço.', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default title, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Título da Janela Remover', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'shipping_address_title_del',
			'value'             => __('Remover o Endereço?', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default title, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Título da Janela de Sucesso ao Remover', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'shipping_address_title_del_sucess',
			'value'             => __('Endereço removido com sucesso!', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default title, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Título da Janela de Erro ao Remover', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'shipping_address_title_del_err',
			'value'             => __('Erro ao remover o endereço.', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default title, yofront_enqueue_jsu can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Informação na janela ao remover.', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'shipping_address_desc_del',
			'value'             => __('Deseja realmente remover o endereço de entrega?', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default title, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'shipping_address_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],

	]
]);
