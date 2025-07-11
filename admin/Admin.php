<?php

namespace MisterPrint\Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    MisterPrint
 * @subpackage MisterPrint/admin
 */

use MisterPrint\Ajax\Components;
use MisterPrint\Ajax\ProcessedImages;
use MisterPrint\Components\Cart;
use MisterPrint\Components\CategoryConfiguration;
use MisterPrint\Components\ColorConversion;
use MisterPrint\Components\Category;
use MisterPrint\Components\CategoriesFeatured;
use MisterPrint\Components\CheckoutBilling;
//use MisterPrint\Components\CheckoutERedeCard;
use MisterPrint\Components\CheckoutConfirmation;
use MisterPrint\Components\CheckoutShipping;
use MisterPrint\Components\IncompleteRegister;
use MisterPrint\Components\Login;
use MisterPrint\Components\Newsletter;
use MisterPrint\Components\PanelAddresses;
use MisterPrint\Components\PanelData;
use MisterPrint\Components\PanelOrders;
use MisterPrint\Components\Register;
use MisterPrint\Components\SendArt;
use MisterPrint\Components\Categories;
use MisterPrint\Components\RecoveryPassword;
use MisterPrint\Components\Balcony\ArtCreation;
use MisterPrint\Helper\Api;
use MisterPrint\Support\AdminPage;
use MisterPrint\Support\PostRequest;
use MisterPrint\Support\View;
use StudioVisual\Support\Components\AjaxRequest;
use MisterPrint\Admin\Includes\Products;
use MisterPrint\Admin\Includes\Product;
use MisterPrint\Admin\Includes\Posts;
use function MisterPrint\Helper\config;

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    MisterPrint
 * @subpackage MisterPrint/admin
 * @author     Your Name <email@example.com>
 */
class Admin
{


	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 * @since    1.0.0
	 */
	public function __construct($plugin_name, $version)
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the front-facing side of the site.
	 *
	 * @since    1.0.0
	 *
	 * @todo Registrar estilos apenas na presença do shortcode que o requer.
	 */
	public function enqueue_styles()
	{
		wp_enqueue_style($this->plugin_name . '/admin.css', plugin_dir_url(__FILE__) . 'dist/admin.css', [], $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the front-facing side of the site.
	 *
	 * @since    1.0.0
	 *
	 * @todo Registrar script apenas na presença do shortcode que o requer.
	 */
	public function enqueue_scripts()
	{
		wp_enqueue_script($this->plugin_name . '/admin.js', plugin_dir_url(__FILE__) . 'dist/admin.js', ['jquery'], $this->version, true);
	}

	/**
	 * @param $template
	 * @return string
	 * @todo alterar o template apenas se a página for editada pelo Visual Composer.
	 */
	public function blank_page_template($template)
	{
		return plugin_dir_path(__FILE__) . 'partials/blank-template.php';
	}

	public function register_components()
	{
		register_nav_menus(['mp_socket_menu' => 'Menu Topo Misterprint']);

		$components = \config('components');

		foreach ($components as $component) {
			new $component(true);
		}
	}

	public function set_locale($lang)
	{
		return 'pt_BR';
	}

	/**
	 * Register all ajax
	 */
	public function register_ajax()
	{
		AjaxRequest::register('components', Components::ajax(), []);
		AjaxRequest::register('user_logged', function () {
			return user()->getId() !== null ? true : false;
		}, false);
		AjaxRequest::register('mp_newsletter', Newsletter::action(), []);
		AjaxRequest::register('mp_save_favorite', CategoryConfiguration::salvarFavorito(), []);
		AjaxRequest::register('mp_remove_favorite', CategoriesFeatured::removerFavorito(), []);
		AjaxRequest::register('mp_category_config', CategoryConfiguration::action(), []);
		AjaxRequest::register('mp_category_config_add', CategoryConfiguration::addToCart(), []);
		AjaxRequest::register('mp_category_config_prices', CategoryConfiguration::prices(), []);
		AjaxRequest::register('mp_cart', Cart::action(), []);
		AjaxRequest::register('mp_get_addresses', PanelAddresses::get_addresses(), []);
		AjaxRequest::register('mp_save_address', PanelAddresses::save_address(), []);
		AjaxRequest::register('mp_edit_address', PanelAddresses::edit_address(), []);
		AjaxRequest::register('mp_remove_address', PanelAddresses::remove_address(), []);
		AjaxRequest::register('mp_get_user_data', PanelData::get_data(), []);
		AjaxRequest::register('mp_get_edit_user_data', PanelData::edit_data(), []);
		AjaxRequest::register('mp_login', Login::action(), []);
		AjaxRequest::register('mp_login_funcionario', Login::actionFuncionario(), []);
		AjaxRequest::register('mp_incomplete_register', IncompleteRegister::action(), []);
		AjaxRequest::register('mp_checkout_shipping', CheckoutShipping::action(), []);
		AjaxRequest::register('mp_cache_freight', CheckoutShipping::cache_freight(), []);
		AjaxRequest::register('mp_save_design_online', CategoryConfiguration::addToCart(), []);
		AjaxRequest::register('mp_register', Register::action(), []);
		AjaxRequest::register('mp_cep', Api::cep(), []);
		AjaxRequest::register('mp_shipping_price', CheckoutShipping::shipping_price(), []);
		AjaxRequest::register('mp_balconies', CheckoutShipping::balconies(), []);
		AjaxRequest::register('mp_remessas', CheckoutShipping::remessas(), []);
		AjaxRequest::register('mp_coupon', CheckoutBilling::coupon(), []);
		AjaxRequest::register('mp_continue_pagseguro', CheckoutBilling::continuePagseguro(), []);
		//AjaxRequest::register('mp_checkout_e_rede_card', CheckoutERedeCard::action(), []);
		AjaxRequest::register('mp_orders', PanelOrders::orders(), []);
		AjaxRequest::register('mp_buscar_nota_por_id', PanelOrders::getNotaById(), []);
		AjaxRequest::register('mp_categories', Categories::categories(), []);
		AjaxRequest::register('mp_category_custom_quantitry', CategoryConfiguration::custom_quantity(), []);
		AjaxRequest::register('mp_recovery_password', RecoveryPassword::action(), []);
		AjaxRequest::register('mp_consult_price_product', Category::consult_price(), []);
		AjaxRequest::register('mp_clear_cart', Cart::action(), [], true);
		AjaxRequest::register('mp_session_token', function () {
			global $wpdb;
			$table = $wpdb->prefix . 'customers';
			$usuario = user()->getId();
			$res = $wpdb->get_results("SELECT * FROM $table WHERE customers_id = '{$usuario}'");
			if (count($res) > 0) {//se tem usuario no BD
				return $res[0]->token;
			}
			return false;
		}, false);
		AjaxRequest::register('mp_register_map',
			function () {
				global $wpdb;
				$table = $wpdb->prefix . 'mapmarker_marker';

				// excluindo pontos antigos
				//$url = config('plugin', 'api')."get-all-freights";
				$url = "https://api.misterprint.com.br/v3/get-all-freights";
				$table = $wpdb->prefix . 'mapmarker_marker';

				$query = $wpdb->query("DELETE FROM $table WHERE id > 0");
				//atualizando mapa com balcoes da tabela
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic bHVjaWFub0BtaXN0ZXJwcmludC5jb20uYnI6TjVvc3FmYUNHTzRXUXowaWJvcm1wOFdBZlpMUExOY1ZrU1NmMHhHV1U0VVEwWEtDRUZoeVN4MkJ0WDdY'
				));
				$response = curl_exec($ch);
				$placeholder = null;
				$response = json_decode($response, true);
				foreach ($response as $balcao) {
					$titulo = $balcao['title'] . " - " . $balcao['codigo'];
					$codigo = $balcao['codigo'];
					$endereco = $balcao['description'];
					$descricao = "Código: " . $codigo . " - " . $endereco;
					$latitude = $balcao['latitude'];
					$longitude = $balcao['longitude'];
					$imgMarker = (strpos($codigo, 'BR') !== false) ? "10387" : "";
					$text = $wpdb->prepare("INSERT INTO $table(`marker_id`, `titre`, `description`, `adresse`, `telephone`, `img_desc_marker`, `img_icon_marker`, `latitude`, `longitude`) VALUES(2, '%s', '%s', '%s', '0', '10387', %s, %f, %f)", $titulo, $descricao, $endereco, $imgMarker, $latitude, $longitude);
					$query = $wpdb->query($text);
				}
				return true;
			}
			, false);
		AjaxRequest::register('mp_delete_map',
			function () {
				global $wpdb;
				$codigo = $_POST['codigo'];

				$table = $wpdb->prefix . 'mapmarker_marker';
				$placeholder = "DELETE FROM $table WHERE titre = %s";

				//Prepare secure request
				$query = $wpdb->query(
					$wpdb->prepare(
						$placeholder,
						$codigo
					)
				);
				//If fail query
				if (!$query) {
					return false;
				}
				return true;
			}

			, false);
		AjaxRequest::register('mp_cache_clear', Api::cacheClear(), []);
		AjaxRequest::register('mp_clear_cache', Api::cacheClear(), []);
		AjaxRequest::register('qr_code', \MisterPrint\Helper\QrCode::generate(), false);
		ProcessedImages::registerRequests(function ($name, $callable) {
			AjaxRequest::register($name, $callable, []);
		});
		if (store_ip_identification()) {
			AjaxRequest::register('mp_balcony_payment_info', PanelOrders::payment_info(), []);
			AjaxRequest::register('mp_balcony_make_payment', PanelOrders::make_payment(), []);
			AjaxRequest::register('mp_balcony_make_dispatch', PanelOrders::make_dispatch(), []);
			AjaxRequest::register('mp_balcony_art_creation_send', ArtCreation::send(), []);
		}
		AjaxRequest::register('mp_product_sync', Products::sync(), []);
		AjaxRequest::register('mp_toggle_lp', Products::toggleLp(), []);
	}

	/**
	 * Register all posts
	 */
	public function register_posts()
	{
		PostRequest::register('admin_pages', Posts::handler('admin_pages'), [], true);
		PostRequest::register('main_color', Posts::handler('main_color'), [], true);
		PostRequest::register('mp_login', Login::action(), [], true);
		PostRequest::register('mp_checkout_billing', CheckoutBilling::action(), [], true);
		PostRequest::register('delete_transient', Posts::handler('delete_transient'), [], true);
		PostRequest::register('social_links', Posts::handler('social_links'), [], true);
		PostRequest::register('mp_add_to_cart', CategoryConfiguration::addToCart(), [], true);
		PostRequest::register('mp_product_sync', Products::sync(), [], true);
	}

	public function register_pages()
	{
		$mister_print = (new AdminPage())->add('Mister Print', function () {
			$social_links = get_option('social_links', true);
			echo (new View('options', [
				'social_links' => json_decode($social_links, true)
			], true))->get();
		});

		(new AdminPage())->add('Paginas', function () {
			echo (new View('pages', [], true))->get();
		}, $mister_print);

		(new AdminPage())->add('Produtos', function () {
			echo (new View('products/products', [
				'products' => (new Products())->getProductsMap(),
			], true))->get();
			return;
		}, $mister_print);
	}

	public function register_products()
	{
		$labels = array(
			'name' => _x('Produtos', 'Post Type General Name', 'misterprint_plugin'),
			'singular_name' => _x('Produto', 'Post Type Singular Name', 'misterprint_plugin'),
			'menu_name' => __('Produtos', 'misterprint_plugin'),
			'name_admin_bar' => __('Produtos', 'misterprint_plugin'),
			'archives' => __('Item Archives', 'misterprint_plugin'),
			'attributes' => __('Item Attributes', 'misterprint_plugin'),
			'parent_item_colon' => __('Parent Item:', 'misterprint_plugin'),
			'all_items' => __('All Items', 'misterprint_plugin'),
			'add_new_item' => __('Add New Item', 'misterprint_plugin'),
			'add_new' => __('Add New', 'misterprint_plugin'),
			'new_item' => __('New Item', 'misterprint_plugin'),
			'edit_item' => __('Edit Item', 'misterprint_plugin'),
			'update_item' => __('Update Item', 'misterprint_plugin'),
			'view_item' => __('View Item', 'misterprint_plugin'),
			'view_items' => __('View Items', 'misterprint_plugin'),
			'search_items' => __('Search Item', 'misterprint_plugin'),
			'not_found' => __('Not found', 'misterprint_plugin'),
			'not_found_in_trash' => __('Not found in Trash', 'misterprint_plugin'),
			'featured_image' => __('Featured Image', 'misterprint_plugin'),
			'set_featured_image' => __('Set featured image', 'misterprint_plugin'),
			'remove_featured_image' => __('Remove featured image', 'misterprint_plugin'),
			'use_featured_image' => __('Use as featured image', 'misterprint_plugin'),
			'insert_into_item' => __('Insert into item', 'misterprint_plugin'),
			'uploaded_to_this_item' => __('Uploaded to this item', 'misterprint_plugin'),
			'items_list' => __('Items list', 'misterprint_plugin'),
			'items_list_navigation' => __('Items list navigation', 'misterprint_plugin'),
			'filter_items_list' => __('Filter items list', 'misterprint_plugin'),
		);
		$args = array(
			'label' => __('Produto', 'misterprint_plugin'),
			'labels' => $labels,
			'supports' => array('title', 'editor', 'thumbnail'),
			'hierarchical' => false,
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 5,
			'show_in_admin_bar' => true,
			'show_in_nav_menus' => true,
			'can_export' => true,
			'has_archive' => false,
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'capability_type' => 'page',
			'taxonomies' => array('category', 'post_tag'),
		);
		register_post_type('product', $args);
	}
}
