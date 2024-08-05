<?php
vc_map([
	'name'                      => 'Filtro de Produtos',
	'base'                      => 'product_filter',
	'category'                  => __( 'MP - Produtos', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Container dos filtos de produtos.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/product-filter.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/product/product-filter.php',
	'as_parent'                 => ['only,except' => 'product_format,product_print,product_paper,product_ennoblement,product_finishing,product_extra'], // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
	'content_element'           => true,
	'show_settings_on_create'   => false,
	'is_container'              => true,
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_filter_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_filter_label',
			'value'             => __('Fitros', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		]
	],
	'js_view' => 'VcColumnView'
]);

/* Product filter childs */
vc_map([
	'name' => 'Formatos',
	'base'                      => 'product_format',
	'category'                  => __( 'MP - Produtos', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Formatos dos produtos.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/product-format.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/product/product-format.php',
	'content_element'           => true,
	'as_child'                  => array('except' => 'product_filter'), // Use only|except attributes to limit parent (separate multiple values with comma)
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_format_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_format_label',
			'value'             => __('Formatos', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_format_placeholder',
			'value'             => __('Selecione...', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		]
	]
]);
vc_map([
	'name'                      => 'Impressão',
	'base'                      => 'product_print',
	'category'                  => __( 'MP - Produtos', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Tipo de Impressao dos produtos.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/product-print.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/product/product-print.php',
	'content_element'           => true,
	'as_child'                  => array('except' => 'product_filter'), // Use only|except attributes to limit parent (separate multiple values with comma)
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_print_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_print_label',
			'value'             => __('Impressão', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_print_placeholder',
			'value'             => __('Selecione...', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		]
	]
]);
vc_map([
	'name'                      => 'Papel',
	'base'                      => 'product_paper',
	'category'                  => __( 'MP - Produtos', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Tipo do Papel dos produtos.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/product-paper.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/product/product-paper.php',
	'content_element'           => true,
	'as_child'                  => array('except' => 'product_filter'), // Use only|except attributes to limit parent (separate multiple values with comma)
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_paper_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_paper_label',
			'value'             => __('Papel', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_paper_placeholder',
			'value'             => __('Selecione...', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		]
	]
]);
vc_map([
	'name'                      => 'Enobrecimento',
	'base'                      => 'product_ennoblement',
	'category'                  => __( 'MP - Produtos', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Tipo de enobrecimento dos produtos.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/product-ennoblement.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/product/product-ennoblement.php',
	'content_element'           => true,
	'as_child'                  => array('except' => 'product_filter'), // Use only|except attributes to limit parent (separate multiple values with comma)
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_ennoblement_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_ennoblement_label',
			'value'             => __('Enobrecimento', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_ennoblement_placeholder',
			'value'             => __('Selecione...', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		]
	]
]);
vc_map([
	'name'                      => 'Acabamentos',
	'base'                      => 'product_finishing',
	'category'                  => __( 'MP - Produtos', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Tipo de acabamento dos produtos.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/product-finishing.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/product/product-finishing.php',
	'content_element'           => true,
	'as_child'                  => array('except' => 'product_filter'), // Use only|except attributes to limit parent (separate multiple values with comma)
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_finishing_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_finishing_label',
			'value'             => __('Acabamentos', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_finishing_placeholder',
			'value'             => __('Selecione...', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		]
	]
]);
vc_map([
	'name'                      => 'Extras',
	'base'                      => 'product_extra',
	'category'                  => __( 'MP - Produtos', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Opçoes Extras.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/product-extra.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/product/product-extra.php',
	'content_element'           => true,
	'as_child'                  => array('except' => 'product_filter'), // Use only|except attributes to limit parent (separate multiple values with comma)
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_extra_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_extra_label',
			'value'             => __('Extras', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Placeholder', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_extra_placeholder',
			'value'             => __('Selecione...', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default placeholder, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		]
	]
]);

vc_map([
	'name'                      => 'Imagem do Produto',
	'base'                      => 'product_thumbnail',
	'category'                  => __( 'MP - Produtos', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Imagem(thumbnail) do produto.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/product-thumbnail.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/product/product-thumbnail.php',
	'content_element'           => true,
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_thumbnail_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_thumbnail_label',
			'value'             => __('Imagem do Produto', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		]
	]
]);

vc_map([
	'name'                      => 'Detalhes do Produto',
	'base'                      => 'product_detail',
	'category'                  => __( 'MP - Produtos', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Detalhes do produto.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/product-detail.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/product/product-detail.php',
	'content_element'           => true,
	'params'                    => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_detail_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_detail_label',
			'value'             => __('Detalhes do Produto', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		]
	]
]);

vc_map([
	'name'                      => 'Tabela de Preço do Produto',
	'base'                      => 'product_price_table',
	'category'                  => __( 'MP - Produtos', MISTERPRINT_PLUGIN_NAME ),
	'description'               => __( 'Exibe a tabela de preço do produto.', MISTERPRINT_PLUGIN_NAME ),
	"icon"                      => plugin_dir_url(dirname(__FILE__)) . 'icons/product-price-table.png',
	'html_template'             => plugin_dir_path(dirname(__FILE__)) . '../../front/shortcodes/product/product-price-table.php',
	'content_element'           => true,
	'params' => [
		[
			'type'              => 'textfield',
			'heading'           => __('Extra class name', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_price_class',
			'description'       => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', MISTERPRINT_PLUGIN_NAME)
		],
		[
			'type'              => 'textfield',
			'heading'           => __('Label', MISTERPRINT_PLUGIN_NAME),
			'param_name'        => 'product_price_label',
			'value'             => __('Tabela de Preço do Produto', MISTERPRINT_PLUGIN_NAME),
			'description'       => __('If you wish change the default label, you can do this here.', MISTERPRINT_PLUGIN_NAME)
		]
	]
]);
