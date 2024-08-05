<?php

namespace MisterPrint\Front;

if (!session_id()) {
	ob_start();
	session_start();
}

use Brain\Cortex\Route\RedirectRoute;
use Brain\Cortex\Route\RouteCollectionInterface;
use MisterPrint\BO\Carrinho;
use MisterPrint\BO\Cliente;
use MisterPrint\BO\Empresa;
use MisterPrint\BO\Loja;
use MisterPrint\BO\Produto;
use MisterPrint\BO\Slide;
use MisterPrint\Components\Clients;
use MisterPrint\Components\Header;
use MisterPrint\Helper\Url;
use MisterPrint\Support\View;
use StudioVisual\Support\Components\Shortcode;
use MisterPrint\Helper\User as UserHelper;
use MisterPrint\Support\SessionSupport;
use MisterPrint\Admin\DefaultPages;
use MisterPrint\Core\Request;

/**
 * The front-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    MisterPrint
 * @subpackage MisterPrint/front
 *
 * @todo Verificar se a resposta do ws possui realmente as chaves esperadas pelo shortcode. Ex: `isset($this->>data['nome']))'.
 */

/**
 * The front-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    MisterPrint
 * @subpackage MisterPrint/front
 * @author     Your Name <email@example.com>
 */
class Front
{
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	private $plugin_path;

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
	 * @since    1.0.0
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 * @param string $plugin_path O caminho absoluto deste plugin.
	 */
	public function __construct($plugin_name, $version, $plugin_path)
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_path = $plugin_path;
	}

	public function routes(RouteCollectionInterface $routes)
	{
		$routes->addRoute(new RedirectRoute(
			'mp-cart/add/{id:[0-9]+}',
			function (array $matches) {
				if (UserHelper::isLogged()) {
					(new Carrinho())->adicionar_item_carrinho(UserHelper::getId(), $matches['id'], 1);
					if (wp_redirect(Url::getCartUrl())) {
						exit;
					}
				}

				if (wp_redirect(home_url())) {
					exit;
				}
			}
		));
		$routes->addRoute(new RedirectRoute(
			'mp-cart/remove/{id:[0-9]+}',
			function (array $matches) {
				if (UserHelper::isLogged()) {
					(new Carrinho())->remover_item_carrinho(UserHelper::getId(), $matches['id']);
					if (wp_redirect(Url::getCartUrl())) {
						exit;
					}
				}

				if (wp_redirect(home_url())) {
					exit;
				}
			}
		));

		$routes->addRoute(new RedirectRoute(
			'sair',
			function (array $matches) {
				$logout = user()->logout();
				if ($logout) {
					if (wp_redirect(home_url())) {
						exit;
					}
				}
			}
		));
	}

	public function define_routes()
	{
		// \WP_Route::get('/configuracao/categoria/formato/cores/papel/enobrecimento/acabamento/arte', ['\MisterPrint\Controllers\CategoryController', 'configuration']);

		// add tags with `_` prefix to avoid screwing up query
		add_rewrite_tag( '%_categoria%', '(\d*)' );
		add_rewrite_tag( '%_produto%', '(\d*)' );
		add_rewrite_tag( '%_pedido%', '(\d*)' );
		add_rewrite_tag( '%_item%', '(\d*)' );
		add_rewrite_tag( '%_formato%', '([^/]+)' );
		add_rewrite_tag( '%_cor%', '([^/]+)' );
		add_rewrite_tag( '%_papel%', '([^/]+)' );
		add_rewrite_tag( '%_enobrecimento%', '([^/]+)' );
		add_rewrite_tag( '%_acabamento%', '([^/]+)' );
		add_rewrite_tag( '%_arte%', '([^/]+)' );


		// create URL rewrite
		// /configuracao/categoria/formato/cores/papel/enobrecimento/acabamento
		add_rewrite_rule(
			'^configuracao/([^/]+)/([^/]+)/([^/]+)/([^/]+)/([^/]+)/([^/]+)?',
			'index.php?page_id='.\get_page_id('category_configuration').'&_categoria=$matches[1]&_formato=$matches[2]&_cor=$matches[3]&_papel=$matches[4]&_enobrecimento=$matches[5]&_acabamento=$matches[6]',
			'top'
		);

		add_rewrite_rule(
			'^configuracao/([^/]+)/([^/]+)/([^/]+)/([^/]+)/([^/]+)?',
			'index.php?page_id='.\get_page_id('category_configuration').'&_categoria=$matches[1]&_formato=$matches[2]&_cor=$matches[3]&_papel=$matches[4]&_enobrecimento=$matches[5]',
			'top'
		);

		add_rewrite_rule(
			'^configuracao/([^/]+)/(\d*)',
			'index.php?page_id='.\get_page_id('category_configuration').'&_categoria=$matches[2]',
			'top'
		);

		// /produto/slug/id
		add_rewrite_rule(
			'^produto/([^/]+)/([^/]+)',
			'index.php?page_id='.\get_page_id('category').'&_categoria=$matches[2]',
			'top'
		);

		// /produto-fechado/slug/id
		add_rewrite_rule(
			'^produto-fechado/([^/]+)/([^/]+)',
			'index.php?page_id='.\get_page_id('category').'&_produto=$matches[2]',
			'top'
		);

		// /enviar-arte/pedido/id
		add_rewrite_rule(
			'^'.\get_page_path('send_art').'/pedido/([^/]+)',
			'index.php?page_id='.\get_page_id('send_art').'&_pedido=$matches[1]',
			'top'
		);

		// /criacao-de-arte/{pedido}/{item_pedido}
		add_rewrite_rule(
			'^'.\get_page_path('creation_form').'/([0-9]+)(/([0-9]+))?',
			'index.php?page_id='.\get_page_id('creation_form').'&_pedido=$matches[1]&_item=$matches[3]',
			'top'
		);

		// required once after rules added/changed
		flush_rewrite_rules( true );
	}

	public function parse_paramns() {
		$paramns = ['_produto', '_categoria','_formato','_cor','_papel','_enobrecimento','_acabamento','_arte','_pedido','_item'];
		foreach($paramns as $param) {
			if(false !== get_query_var($param) && !empty(get_query_var($param))){
				$_GET[str_replace('_', '', $param)] = get_query_var($param);
			}
		}
	}

	public function prefix__pre_get_posts( $query ) {

		if ( isset( $query->query_vars[ 'p' ], $query->query_vars[ '_rid' ], $query->query_vars[ '_title' ] ) ) {

		}
	}

	public function requests()
	{
		new Request();
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
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'dist/app.css', [], $this->version, 'all');
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
		wp_enqueue_script('owl-carousel', plugins_url($this->plugin_name) . '/node_modules/owl.carousel/dist/owl.carousel.min.js', ['jquery'], '', true);
		$agora = date('m.d.H.i');
		wp_enqueue_script($this->plugin_name . '/app.js', plugin_dir_url(__FILE__) . 'dist/app.js', ['jquery'], $agora, true);
		wp_localize_script($this->plugin_name . '/app.js', 'wp', array_merge(['ajax_url' => admin_url('admin-ajax.php')]));
	}

	/**
	 *   Add the 'sair' query variable so WordPress
	 *   to call logout user api
	 */
	public function add_query_vars($vars)
	{
		$vars[] = "sair";

		return $vars;
	}

	/**
	 * @param $items
	 * @param $args
	 *
	 * @return string
	 * @todo implementar submenus
	 * @todo ordenar itens pelo campo "ordem"
	 */
	public function custom_main_menu($items, $args)
	{
		global $wp_query;

		$loja = new Loja();
		$menu = $loja->get_menu_cabecalho();

		if ('primary' === $args->theme_location) {
			foreach ($menu as $item) {
				$items .= '
				<li id="menu-item-' . $item['codigoMenu'] . '" class="nav-item menu-item menu-item-' . $item['codigoMenu'] . ' menu-item-type-post_type menu-item-object-page">
					<a class="nav-link" href="' . site_url($item['urlMenu']) . '">' . $item['nomeMenu'] . '</a>
				</li>';
			}
		}

		return $items;
	}

	public function vitrine()
	{
		$shortcode = new ShortCode('vitrine', $this->plugin_path . 'front/shortcodes');
		if (!$shortcode->is_present()) {
			return;
		}

		$produto = new Produto();
		$categorias = $produto->get_categorias_de_produtos(667118);
		$shortcode->print_out($categorias);

		if (isset($_GET['categoria'])) {
			$shortcode->add_attr([
				'formatos' => $produto->get_formatos_do_produto($_GET['categoria']),
				'categoria' => $produto->get_dados_da_categoria($_GET['categoria']),
			]);
		}

		if (isset($_GET['formato'])) {
			$shortcode->add_attr([
				'cores' => $produto->get_cores_do_produto($_GET['categoria'], $_GET['formato']),
				'preview' => $produto->get_resumo_e_previsao_de_produtos($_GET['categoria'], $_GET['formato']),
			]);
		}

		if (isset($_GET['cor'])) {
			$shortcode->add_attr([
				'papeis' => $produto->get_papeis_do_produto($_GET['categoria'], $_GET['formato'], $_GET['cor']),
				'preview' => $produto->get_resumo_e_previsao_de_produtos($_GET['categoria'], $_GET['formato'], $_GET['cor']),
			]);
		}

		if (isset($_GET['papel'])) {
			$shortcode->add_attr([
				'enobrecimentos' => $produto->get_enobrecimentos_do_produto($_GET['categoria'], $_GET['formato'], $_GET['cor'], $_GET['papel']),
				'preview' => $produto->get_resumo_e_previsao_de_produtos($_GET['categoria'], $_GET['formato'], $_GET['cor'], $_GET['papel']),
			]);
		}

		if (isset($_GET['enobrecimento'])) {
			$shortcode->add_attr([
				'acabamentos' => $produto->get_acabamentos_do_produto($_GET['categoria'], $_GET['formato'], $_GET['cor'], $_GET['papel'], $_GET['enobrecimento']),
				'preview' => $produto->get_resumo_e_previsao_de_produtos($_GET['categoria'], $_GET['formato'], $_GET['cor'], $_GET['papel'], $_GET['enobrecimento']),
			]);
		}

		if (isset($_GET['acabamento'])) {
			$shortcode->add_attr([
				'extras' => $produto->get_extras_do_produto($_GET['categoria'], $_GET['formato'], $_GET['cor'], $_GET['papel'], $_GET['enobrecimento'], $_GET['acabamento']),
				'preview' => $produto->get_resumo_e_previsao_de_produtos($_GET['categoria'], $_GET['formato'], $_GET['cor'], $_GET['papel'], $_GET['enobrecimento'], $_GET['acabamento']),
			]);
		}

		if (isset($_POST['produto-quantidade']) && !empty ($_POST['produto-quantidade'])) {
			$carrinho = new Carrinho();

			// O ID já representa a quantidade de itens na API!
			// Não faz sentido chamar o metodo de get_resumo_e_previsao_de_produtos novamente, já que o ID do
			// produto abstrai a quantidade de items no ID. Se não mudarmos a API, será necessário chamar dois métodos
			// ao mesmo tempo para adicionar o produto no carrinho, ou enviar para a API dados que ela já vincula por lá...
			// Necessário falar com o cliente para que ele remova a necessidade deste parâmetro no método adicionar_item_carrinho.
			// TODO: Resolver o problema e remover este blocão de texto.

			$qtd = '?';

			// Retornar bool no método do carrinho para que na view possamos saber quando mostrar a mensagem de sucesso ao usuário.
			$shortcode->add_attr([
				'carrinho' => $carrinho->adicionar_item_carrinho(667118, $_POST['produto-quantidade'], $qtd)
			]);
		}

		if (isset($_GET['categoria'])) {
			$shortcode->add_attr([
				'relacionados' => $produto->get_produtos_relacionados(667118, 106422)
			]);
		}

	}

	public function produtos()
	{
		$shortcode = new Shortcode('produtos', $this->plugin_path . 'front/shortcodes');

		if (!$shortcode->is_present()) {
			return;
		}

		$produto = new Produto();
		$shortcode->print_out($produto->get_menu_de_produtos(667118));
	}

	public function empresa()
	{
		$shortcode = new Shortcode('empresa', $this->plugin_path . 'front/shortcodes');

		if (!$shortcode->is_present()) {
			return;
		}

		$empresa = new Empresa();
		$shortcode->print_out($empresa->get_dados_basicos_empresa());
	}

	public function getHeader()
	{
		$color = config()->getOption('main_color');
		$cart = user()->getCart();
		$social_links = get_option('social_links', true);

		echo (new View('header', [
			'client' => (new Cliente())->get_dados_do_cliente(user()->getId()),
			'color' => $color ? $color : '#ea1d20',
			'cart_count' => is_array($cart) ? count($cart) : null,
			'social_links' => json_decode($social_links, true)
		]))->get();
	}

    public function registerRefererSession()
    {
    	return false;
        if ( @$_SERVER['HTTP_REFERER'] ) {
            $urls = [
                'ampliz',
                'misterprint',
            ];
            $ignore = count(
                array_filter(
                    $urls,
                    function( $url ) {
                        return strpos($_SERVER['HTTP_REFERER'], $url);
                    }
                ),
            );

            $referer = $_SERVER['HTTP_REFERER'];
            $referer = str_replace("\\", '/', $referer);
            $referer = preg_replace("/http(s)?:[\/]{2}/", '', $referer);
            $referer = preg_replace("/[\/]$/", '', $referer);
            $referer = preg_replace("/^www./", '', $referer);

            // $file = __DIR__.'/../referers.json';
            // $log = json_decode(file_get_contents($file), true);
            // if ( !is_array($log) ) {
            //     $log = [];
            // }
            // if ( !isset($log[$referer]) ) {
            //     $log[$referer] = 0;
            // }
            // $log[$referer]++;
            //file_put_contents( $file, json_encode($log, JSON_PRETTY_PRINT) );

            SessionSupport::set('origin_referer', $referer);
        }
    }

	public function repeater()
	{
		return 'teste';
	}

	function prefix_nav_description( $item_output, $item, $depth, $args ) {
		if ( !empty( $item->description ) ) {
			if(substr($item->description, 0,1) == '['){
				$title = $item->title == "" ? get_post_field( 'post_title', $item->ID ) : $item->title;
				$item_output = "<li class=\"menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children\" id=\"products\">
					<a href=\"{$item->url}\" class=\"nav-link\" >{$title}</a>";

				$item_output .= do_shortcode($item->description);
				$item_output .= "</li>";
			}
		}
		return $item_output;
	}
}

ob_flush();
