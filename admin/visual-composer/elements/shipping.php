<?php
vc_map([
	'name'                      => 'Frete',
	'base'                      => 'shipping',
	'category'                  => __( 'MP - Checkout', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __('Tipo de frete a ser escolhido.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/shipping.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/shipping/shipping.php',
   'content_element'           => true,
	'show_settings_on_create'   => false,
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'shipping_class',
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'shipping_label',
			'value'             => __('Frete', MISTERPRINT_PLUGIN_NAME),
		],
		[
			'type'              => 'checkbox',
			'heading'           => __('Remover opção de frete', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'removed_shipping',
			'value'             => [
										'Correios'          => 'correios',
										'Balcão'            => 'balcao',
										'Transportadora'    => 'transportadora',
										'Motoboy'           => 'motoboy'
									],
		],

	],
]);
