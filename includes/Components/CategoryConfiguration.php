<?php

namespace MisterPrint\Components;

use Carbon\Carbon;
use MisterPrint\BO\Carrinho;
use MisterPrint\BO\Produto;
use MisterPrint\BO\Cliente;
use MisterPrint\BO\Arte;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;
use MisterPrint\Support\SessionSupport;

class CategoryConfiguration extends Component
{
	protected $name = 'Configuração do Produto';
	protected $description = 'Mister Print componente para a configurar o produto';
	protected $base = 'vc_mp_category_configuration';

	public function render()
	{
		$data = $_POST['data'];

		$inputs = [];
		if(isset($_POST['data']['formato'])) {
			$inputs['configuration_format'] = urldecode($_POST['data']['formato']);
			if ( 'custom' == substr($data['formato'], 0, 6) ) {
				$medidas = substr($data['formato'], 7);
				$inputs['sob_medida_width'] = explode('x', $medidas)[0];
				$inputs['sob_medida_height'] = explode('x', $medidas)[1];
				$inputs['configuration_format'] = 'custom';
			}
		}

		if(isset($_POST['data']['cor'])) {
			$inputs['configuration_color'] = urldecode($_POST['data']['cor']);
		}

		if(isset($_POST['data']['papel'])) {
			$inputs['configuration_paper'] = urldecode($_POST['data']['papel']);
		}

		if(isset($_POST['data']['enobrecimento'])) {
			$inputs['configuration_ennoblement'] = urldecode($_POST['data']['enobrecimento']);
		}

		if(isset($_POST['data']['acabamento'])) {
			$inputs['configuration_finishing'] = explode(',', urldecode($_POST['data']['acabamento']));
		}

		if(isset($_POST['data']['arte'])) {
			$inputs['configuration_art'] = urldecode($_POST['data']['arte']);
		}

		$category = [
			'nome' => '',
			'has_category' => false
		];
		if(isset($data['category']) && !empty($data['category'])) {
			$category = (new Produto())->get_dados_da_categoria($data['category']);
			$category['has_category'] = false;
			if(isset($category['nome']) && !empty($category['nome'])) {
				$category['has_category'] = true;
			}
		}

		$arts = array_map(function($item) use ( $inputs ) {
			return [
				'id' => $item['id'],
				'slug' => $item['slug'],
				'selected' => isset($inputs['configuration_art']) && $item['id'] == $inputs['configuration_art'],
				'title' => $item['title'],
				'desc' => $item['desc'],
				'preco' => number_format($item['preco'], 2, ',', ''),
				'preco_adic_modulo' => number_format($item['preco_adic_modulo'], 2, ',', ''),
			];
		}, (new Arte())->get_opcoes_envio($data['category']));

		return (new View('category/configuration', [
			'name' => $category['nome'],
			'has_category' => $category['has_category'],
			'options' => self::getConfigurantions($data['category'], $inputs),
			'quants' => [],
			'products' =>  self::getProducts($data['category'], $inputs),
			'vc_data' => $this->getParamsAjax(),
			'arts' => $arts,
			'has_arts' => $category['tem_arte'],
		]))->get();
	}

	public function html($atts)
	{
		$paramns = ['formato','cor','papel','enobrecimento','acabamento','arte'];

		$hidden = "<input type='hidden' name='params' value='" . base64_encode(json_encode($atts)) . "'>";

		$selected = '';
		foreach($paramns as $param) {
			if(isset($_GET[$param])) {
				$selected .= ' data-'.$param.'="'.$_GET[$param].'"';
			}
		}

		$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

		return '<div class="mp-component">
				<div
					data-component="' . $this->base . '"
					data-category="' . $categoria . '"
					'.$selected.'></div>
				<div class="loader"></div>' . $hidden . '</div>';
	}

	static public function action()
	{
		return function () {
			$data = $_POST;
			$product = new Produto();
			$category_id = $data['data']['category'];

			$options = self::getConfigurantions($category_id, $data['inputs']);

			return (new View('category/configuration/print-options',
				$options + ['vc_data' => (new self())->getParamsAjax()]))->get();
		};
	}

	public static function addToCart()
	{
		return function () {
			$redirect = isset($_GET['redirect']) ?: strpos($_SERVER['REQUEST_URI'], '-post.php') !== false;
			$carrinho = new Carrinho();
			$data = $_POST;

			$redirectFunction = function ( $status, $url ) use ( $redirect ) {
				if ( $redirect ) {
					if( wp_redirect( $url ) ) {
						exit;
					}
				} else {
					return [
						'response' => $status,
						'redirect' => $url,
					];
				}
			};

			// Caso o usuário não esteja logado, coloca as informações na sessão para ao logar inserir
			if(!user()->isLogged()) {
				SessionSupport::set('add-to-cart-data', $data['data']);
				$redirectTo = home_url('/wp-admin/admin-ajax.php?redirect=true&action='.$_REQUEST['action']);
				return $redirectFunction(
					true,
					get_page_url('login').'?redirectTo='.urlencode($redirectTo)
				);
			}

			// Caso não esteja especificado os valores, pega da sessão
			if ( !isset($data['data']) ) {
				// Verifica se existe informações na sessão
				if ( SessionSupport::exists( 'add-to-cart-data' ) ) {
					$data['data'] = SessionSupport::get( 'add-to-cart-data' );
					SessionSupport::delete( 'add-to-cart-data' );
				}
				// Caso não ter, redireciona para a home
				else {
					return $redirectFunction(
						false,
						'/'
					);
				}
			}

			if ( $data['data']['configuration_format'] == 'custom' ) {
				$data['data']['configuration_format'] = $data['data']['sob_medida_width'].'x'.$data['data']['sob_medida_height'];
			}

			if($data['data']['art'] == 6 ){
				$lados = 1;
				$verniz = 0;
				$cores = explode('x', $data['data']['configuration_color']);
				if (intval($cores[1]) > 0) {
					$lados = $lados + 1;
				}
				$enoblement = $data['data']['configuration_ennoblement'];
				if(strpos($enoblement,'local') !== false){
					$verniz = $lados;
				}
				$url = "https://".$_SERVER['SERVER_NAME'];
				return[
					'response' => 'success',
					'redirect' => $url.'/design-online?dp_mode=designer&product_id='.$data['data']['product'].
					'&format='.$data['data']['configuration_format'].
					'&design_id=120'.
					'&sides='.$lados.
					'&verniz='.$verniz.
					'&configuration_ennoblement='.$data['data']['configuration_ennoblement'].
					'&configuration_paper='.$data['data']['configuration_paper'].
					'&custom_quantity_input='.$data['data']['custom_quantity_input'].
					'&peso='.$data['data']['peso'].
					'&modulos='.$data['data']['modulos'].
					'&valor='.$data['data']['valor'].
					'&quantidade='.$data['data']['custom_quantity'].
					'&category_id='.$data['data']['category_id']
				];

			}

			$lados=null;
			$formato=null;

			if($data['data']['mode'] == "save-design"){
				$data['data']['art'] = 6;
				$lados = explode('x', $data['data']['format']);
				$formato = $lados[1].'x'.$lados[0];
				$data['data']['format'] = $formato;
				$pdf = fopen(ColorConversion::gerarCmyk(), 'r');
			}
			
			$result = $carrinho->adicionar_item_carrinho(
				user()->getId(),
				$data['data']['product'] ?: $data['data']['product_id'],
				$data['data']['custom_quantity'] ?: 1,
				$data['data']['art'],
				$data['data']['configuration_finishing'],
				[
					// 'valor' => $data['data']['valor'],
					'formato' =>  "{$data['data']['sob_medida_width']}x{$data['data']['sob_medida_height']}",
					'peso' =>  $data['data']['peso'],
					'modulos' => $data['data']['modulos'],
				],
				$data['data']['category_id']
			);
			if($result){
				@session_start();
				$_SESSION['update'] = 1;
			}

			if($data['data']['mode'] == "save-design"){
				//salvando no carrinho
				$registerArtResult = $carrinho->registrar_arte_carrinho($result['item_atual'], $pdf);
			}

			user()->clearCart();

			return $redirectFunction( $result['response'] == 'success', get_page_url('cart') );
		};
	}

	public static function prices()
	{
		return function () {
			$data = $_POST;
			$category_id = $data['data']['category'];

			$products = self::getProducts($category_id, $data['inputs']);
			return (new View('category/configuration/price-options', $products))->get();
		};
	}

	public static function custom_quantity()
	{
		return function () {
			$data = $_POST;
			$category_id = $data['data']['category'];

			$products = self::getProductsCustom($category_id, $data['inputs']);
			return (new View('category/configuration/price-options-custom', $products))->get();
		};
	}

	public static function getProducts($category_id, $inputs)
	{
		$products = [];

		foreach ($inputs as $key => $input) {
			$inputs[str_replace('configuration_', '', $key)] = $input;
		}

		if(!empty($inputs['ennoblement'])) {
			$product_api = new Produto();

			$sobmedida = ($inputs['format'] == 'custom') ? true : false;

			$format = $sobmedida ? $inputs['sob_medida_width'].'x'.$inputs['sob_medida_height'] : $inputs['format'];

			if ( !is_array( $inputs['finishing'] ) ) {
				$inputs['finishing'] = explode(',', $inputs['finishing']);
			}

			$productsRaw = $product_api->get_resumo_e_previsao_de_produtos($category_id, $format, $inputs['color'],
				$inputs['paper'], $inputs['ennoblement'], $inputs['finishing'], '', $sobmedida);

			foreach ($productsRaw as $product) {
				$date = date_create_from_format('d/m/Y', $product['prazo']);
				$days[$date->format('dm')] = [
					'date' => $date,
					'diasUteis' => $product['prazoDias'],
				];
			}

			$products = [];
			foreach ($productsRaw as $product) {
				$quant = $product['quantidade'];

				if(!isset($products[$quant])) {
					$products[$quant] = $days;
				}

				$gabaritos = [];
				if(isset($product['gabarito_horizontal_corel']) || isset($product['gabarito_vertical_corel'])) {
					$gabaritos['corel']['horizontal'] = $product['gabarito_horizontal_corel'];
					$gabaritos['corel']['vertical'] = $product['gabarito_vertical_corel'];
				}

				if(isset($product['gabarito_horizontal_illustrator']) || isset($product['gabarito_vertical_illustrator'])) {
					$gabaritos['illustrator']['horizontal'] = $product['gabarito_horizontal_illustrator'];
					$gabaritos['illustrator']['vertical'] = $product['gabarito_vertical_illustrator'];
				}

				$date = date_create_from_format('d/m/Y', $product['prazo']);
				$products[$quant][$date->format('dm')] = [
					'id' => $product['id'],
					'name' => $product['nome'],
					'quant' => $product['quantidade'],
					'descricao' => $product['descricao'],
					'modulos' => $product['modulos'],
					'price' => number_format($product['preco'], 2, ',', ''),
					'prev_price' => number_format($product['prev_price'], 2, ',', ''),
					'discount' => $product['discount'],
					'deadline' => $date,
					'gabarito' => $gabaritos,
					'product' => $product,
					'sobmedida' => $sobmedida
				];
			}
		}

		return [
			'products' => $products,
			'days' => $days,
			'custom_quantity' => $inputs['custom_quantity'],
		];
	}

	public static function getProductsCustom($category_id, $inputs)
	{
		$products = [];

		foreach ($inputs as $key => $input) {
			$inputs[str_replace('configuration_', '', $key)] = $input;
		}

		if(!empty($inputs['ennoblement'])) {
			$product_api = new Produto();

			$sobmedida = ($inputs['format'] == 'custom') ? true : false;

			$format = $sobmedida ? $inputs['sob_medida_width'].'x'.$inputs['sob_medida_height'] : $inputs['format'];

			$products = [];
			if(isset($inputs['custom_quantity_input']) && !empty($inputs['custom_quantity_input'])) {
				$productsCustomQuantity = $product_api->get_resumo_e_previsao_de_produtos($category_id, $format, $inputs['color'],
				$inputs['paper'], $inputs['ennoblement'], $inputs['finishing'], '', $sobmedida, $inputs['custom_quantity_input']);

				foreach ($productsRaw as $product) {
					$date = date_create_from_format('d/m/Y', $product['prazo']);
					$days[$date->format('dm')] = [
						'date' => $date,
						'diasUteis' => $product['prazoDias'],
					];
				}

				foreach ($productsCustomQuantity as $product) {
					$quant = $product['quantidade'];

					if(!isset($products[$quant])) {
						$products[$quant] = $days;
					}

					$gabaritos = [];
					if(isset($product['gabarito_horizontal_corel']) && isset($product['gabarito_vertical_corel'])) {
						$gabaritos['corel']['horizontal'] = $product['gabarito_horizontal_corel'];
						$gabaritos['corel']['vertical'] = $product['gabarito_vertical_corel'];
					}

					if(isset($product['gabarito_horizontal_illustrator']) && isset($product['gabarito_vertical_illustrator'])) {
						$gabaritos['illustrator']['horizontal'] = $product['gabarito_horizontal_illustrator'];
						$gabaritos['illustrator']['vertical'] = $product['gabarito_vertical_illustrator'];
					}

					$date = date_create_from_format('d/m/Y', $product['prazo']);
					$products[$quant][$date->format('dm')] = [
						'id' => $product['id'],
						'name' => $product['nome'],
						'quant' => $product['quantidade'],
						'modulos' => $product['modulos'],
						'price' => number_format($product['preco'], 2, ',', ''),
						'deadline' => $date,
						'gabarito' => $gabaritos,
						'product' => $product,
						'sobmedida' => $sobmedida
					];
				}
			}
		}

		return [
			'days' => $days,
			'products' => $products,
		];
	}

	public static function getConfigurantions($category, &$inputs)
	{
		$product = new Produto();

		$options = [
			'formats' => ['items' => $product->get_formatos_do_produto($category), 'item' => ''],
			'colors' => ['items' => [], 'item' => ''],
			'papers' => ['items' => [], 'item' => ''],
			'ennoblements' => ['items' => [], 'item' => ''],
			'finishings' => ['items' => [], 'item' => ''],
			'extras' => ['items' => [], 'item' => ''],
		];

		$sobmedida = false;
		foreach ($inputs as $key => $input) {
			if ($key == 'configuration_format') {
				$options['formats']['item'] = $input;
				$options['formats']['custom_width'] = $inputs['sob_medida_width'];
				$options['formats']['custom_height'] = $inputs['sob_medida_height'];
				$sobmedida = ($input == 'custom') ? true : false;

				if ( $sobmedida ) {
					if (
						$options['formats']['custom_width'] > $options['formats']['items']['largura_maxima']
						||
						$options['formats']['custom_height'] > $options['formats']['items']['altura_maxima']
						||
						$options['formats']['custom_width'] < $options['formats']['items']['largura_minima']
						||
						$options['formats']['custom_height'] < $options['formats']['items']['altura_minima']
				 	) {
						unset($inputs['color']);
						unset($inputs['paper']);
						unset($inputs['ennoblement']);
						unset($inputs['finishing']);
						unset($inputs['configuration_color']);
						unset($inputs['configuration_paper']);
						unset($inputs['configuration_ennoblement']);
						unset($inputs['configuration_finishing']);
						break;
					}
				}

				$options['colors']['items'] = $product->get_cores_do_produto(
					$category,
					$options['formats']['item'],
					$sobmedida
				);
			}

			if(count($options['colors']['items']) === 1 && ! isset($inputs['configuration_color'])) {
				$key = 'configuration_color';
				$input = $options['colors']['items'][0];
			}

			if ($key == 'configuration_color') {
				$options['colors']['item'] = $input;
				$options['papers']['items'] = $product->get_papeis_do_produto(
					$category,
					$options['formats']['item'],
					$options['colors']['item'],
					$sobmedida
				);
			}

			if(count($options['papers']['items']) === 1 && ! isset($inputs['configuration_paper']))  {
				$key = 'configuration_paper';
				$input = $options['papers']['items'][0]['slug'].'-'.$options['papers']['items'][0]['gramatura'];
			}

			if ($key == 'configuration_paper') {
				$options['papers']['item'] = $input;
				$options['ennoblements']['items'] = $product->get_enobrecimentos_do_produto(
					$category,
					$options['formats']['item'],
					$options['colors']['item'],
					$options['papers']['item'],
					$sobmedida
				);
			}

			if(count($options['ennoblements']['items']) === 1 && ! isset($inputs['configuration_ennoblement']))  {
				$key = 'configuration_ennoblement';
				$input = $options['ennoblements']['items'][0]['slug'];
			}

			if ($key == 'configuration_ennoblement') {
				$options['ennoblements']['item'] = $input;
				$options['finishings']['items'] = $product->get_acabamentos_do_produto(
					$category,
					$options['formats']['item'],
					$options['colors']['item'],
					$options['papers']['item'],
					$options['ennoblements']['item'],
					$sobmedida
				);
			}

			if ($key == 'configuration_finishing') {
				$options['finishings']['item'] = $input;
			}
		}

		return $options;
	}

	/**
	 * -----------------------------------
	 * Função que salva uma configuração nos favoritos do cliente
	 * caso o cliente já tenha uma salva, ele não consegue salvar novamente 
	 * a não ser que exclua a anterior, pois o base64 servirá de hash para 
	 * a configuração.
	 * -----------------------------------
	 * @access public 
	 * @param $_POST
	 * @return true (sucesso), false (erro)
	 */
	public static function salvarFavorito(){
		return function(){
			$data = array(
				"params" => $_GET['config'],
				"products_id" => isset($_GET['products_id']) ? $_GET['products_id'] : null,
				"user" => user()->getId()
			);
			$cliente = new Cliente();
			$resposta = $cliente->salva_favorito($data);
			return $resposta;
		};
	}

	public function setParams()
	{
		$this->addParams([
			Vc::paramText('Titulo', 'Configuração'),
			Vc::paramText('Subtitulo', 'Veja só como é simples e do seu jeito.'),
			Vc::paramText('Titulo painel 1', 'Vamos começar pela arte'),
			Vc::paramText('Subtitulo painel 1', 'Escolha um dos serviços para configurar seu produto'),
			Vc::paramText('Painel 1 titulo arte', 'Como deseja enviar sua arte?'),
			Vc::paramText('Painel 1 enviar arte URL', '#'),
			Vc::paramText('Painel 1 contratação URL', '#'),
			Vc::paramText('Painel 1 alteração arte URL', '#'),
			Vc::paramText('Titulo painel 2', 'Opções da Impressão'),
			Vc::paramText('Subtitulo painel 2', 'Escolha um tipo de serviço para o seu pedido.'),
			Vc::paramText('Painel 2 formato', 'Formato'),
			Vc::paramText('Painel 2 formato URL', '#'),
			Vc::paramText('Painel 2 cores', 'Cores'),
			Vc::paramText('Painel 2 papel', 'Papel'),
			Vc::paramText('Painel 2 enobrecimento', 'Enobrecimento'),
			Vc::paramText('Painel 2 acabamentos', 'Acabamentos'),
			Vc::paramText('Painel 2 sem dados', 'Nenhuma opção...'),
			Vc::paramText('Titulo painel 3', 'Prazos e Quantidade'),
			Vc::paramText('Subtitulo painel 3', 'Escolha a quantidade e selecione a data para recebimento'),
			Vc::paramText('Painel 3 titulo quantidade', 'Quantidade'),
			Vc::paramText('Aviso', ''),
			Vc::paramText('painel 1 enviar arte info', 'Você pode enviar seu arquivo também nas extensões: Jpg ou tiff com padão de cores CMYK. finalizado para impressão'),
			Vc::paramText('painel 1 contratação info', 'Vocẽ pode enviar seu arquivo nas extensões: cdr, pdf, jpg ou tiff'),
			Vc::paramText('painel 1 alteração arte info', 'vocẽ pode enviar seu arquivo nas extensões: pdf, ai, jpg ou tiff, nossa equipe fará a verificaçao e os ajustes necessários'),
		]);
	}
}
