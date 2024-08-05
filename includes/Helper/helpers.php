<?php

use MisterPrint\Admin\Includes\Products;

/**
 * Helper para pegar configurações do sistema.
 */
function config($conf = null, $value = null, $defaultValue = null) {
	global $config;

	if(!($config instanceof \MisterPrint\Helper\Config)) {
		$config = new \MisterPrint\Helper\Config();
	}

	if(is_null($conf)) {
		return $config;
	}

	return $config->get($conf, $value, $defaultValue);
}
function get_id_loja() {
	$codSite = \config("plugin", "APP_FRANQUIA");
	return $codSite;
}

/**
 * Helper para pegar configurações do sistema.
 */
function user() {
	global $user;

	if(!($user instanceof \MisterPrint\Helper\User)) {
		$user = new \MisterPrint\Helper\User();
	}

	return $user;
}

/**
 * Helper para ajudar na relação entre os produtos da API e os produtos cadastrados no wordpress
 */
function products() {
	global $products;

	if(!($products instanceof \MisterPrint\Admin\Includes\Products)) {
		$products = new \MisterPrint\Admin\Includes\Products();
	}

	return $products;
}

/**
 * Helper para ajudar na verificação de IPs
 */
function is_balcony() {
	global $is_balcony;
	if(gettype($is_balcony) !== "boolean") {
		$ip = \MisterPrint\Response\BalconyIps::getCurrentIp();
		$is_balcony = !!$ip;
	}

	return $is_balcony;
}

/**
 * Coleta a identificação de balcão de acordo com o ip de acesso
 */
function store_ip_identification() {
	global $store_ip_dentification;

	if( $store_ip_dentification === null ) {
		$ip = \MisterPrint\Response\BalconyIps::getCurrentIp();
		$store_ip_dentification = $ip ? $ip['loja'] : $ip;
	}

	return $store_ip_dentification;
}

/**
 * Returna Array com paginas
 */
function get_all_pages()
{
	$pages = [];

	// the query
	$the_query = new WP_Query([
		'post_type' => 'page',
		'posts_per_page' => -1
	]);
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$pages[get_the_ID()] = get_the_title();
		}
		wp_reset_postdata();
	}

	return $pages;
}

function get_full_url()
{
	return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."";
}

function get_page_url($page = '')
{
	$pages = config('options', 'pages');

	return (isset($pages[$page])) ? get_permalink($pages[$page]) : false;
}

function get_page_path($page = '')
{
	$pages = config('options', 'pages');

	if((isset($pages[$page]))) {
		$post = get_post($pages[$page], ARRAY_A);

		return $post['post_name'];
	}

	return false;
}

function get_logout_url()
{
	session_start();
	$_SESSION['cadastroSocial'] = null;
	$_SESSION['credential_google'] = null;
	$_SESSION['userData_google'] = null;
	$_SESSION['access_token_face'] = null;
	$_SESSION['userData_face'] = null;
	return home_url('/sair');
}

function get_week_day($number) {
	$options = [
		'Domingo',
		'Segunda-Feira',
		'Terça-Feira',
		'Quarta-Feira',
		'Quinta-Feira',
		'Sexta-Feira',
		'Sabado',
	];

	return $options[$number];
}

function get_page_id($page = '')
{
	$pages = config('options', 'pages');

	return (isset($pages[$page])) ? $pages[$page] : false;
}

/**
 * Convert to monetary value
 */
function money($val)
{
	return 'R$ ' . number_format($val, 2, ',', '.');
}

function from_camel_case($input)
{
	$input = remove_accents($input);
	$input = strtolower($input);
	return str_replace(' ', '_', $input);
}


/**
 * Retorna a banderia do numero de cartão de credito passado
 *
 * @param string $card_number
 * @return void
 */
function get_card_brand($card_number)
{
	$card_number = preg_replace( '/[^0-9]/', '', $card_number );

	// Brands regex
	$brands = array(
		'Visa'       => '/^4\d{12}(\d{3})?$/',
		'mastercard' => '/^(5[1-5]\d{4}|677189)\d{10}$/',
		'diners'     => '/^3(0[0-5]|[68]\d)\d{11}$/',
		'discover'   => '/^6(?:011|5[0-9]{2})[0-9]{12}$/',
		'elo'        => '/^((((636368)|(438935)|(504175)|(451416)|(636297))\d{0,10})|((5067)|(4576)|(4011))\d{0,12})$/',
		'amex'       => '/^3[47]\d{13}$/',
		'jcb'        => '/^(?:2131|1800|35\d{3})\d{11}$/',
		'aura'       => '/^(5078\d{2})(\d{2})(\d{11})$/',
		'hipercard'  => '/^(606282\d{10}(\d{3})?)|(3841\d{15})$/',
		'maestro'    => '/^(?:5[0678]\d\d|6304|6390|67\d\d)\d{8,15}$/',
	);

	foreach ( $brands as $_brand => $regex ) {
		if ( preg_match( $regex, $card_number ) ) {
			return $_brand;
		}
	}
	return false;
}

/**
 * Retorna a URL da pagina de categoria
 *
 */
function get_category_url($id, $slug)
{

	return get_the_permalink(products()->getProductPostID($id));
}

/**
 * Retorna a URL da pagina de categoria
 *
 */
function get_configuration_url($id, $slug)
{
	return get_page_url('category_configuration').$slug.'/'.$id;
}

/**
 * Retorna a URL da pagina de categoria
 *
 */
function get_product_url($id, $name)
{
	return '/produto-fechado/'.sanitize_title($name).'/'.$id;
}
