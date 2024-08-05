<?php
//Register "container" content element. It will hold all your inner (child) content elements
vc_map([
	"name" => 'Carrinho',
	"base" => "cart",
	'category'                  => __( 'MP - Checkout', MISTERPRINT_PLUGIN_NAME ),
	"show_settings_on_create" => false,
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cart.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cart/cart.php',
	"params" => [
		[
			"type" => "textfield",
			"heading" => __("Extra class name", "my-text-domain"),
			"param_name" => "el_class",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "my-text-domain")
		]
	],
]);

//Register "container" content element. It will hold all your inner (child) content elements
vc_map([
	"name" => 'Total no Carrinho',
	"base" => "cart_totals",
	'category'                  => __( 'MP - Checkout', MISTERPRINT_PLUGIN_NAME ),
	"show_settings_on_create" => false,
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/cart-totals.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/cart/cart-totals.php',
	"params" => [
		[
			"type" => "textfield",
			"heading" => __("Extra class name", "my-text-domain"),
			"param_name" => "el_class",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "my-text-domain")
		]
	],
]);
