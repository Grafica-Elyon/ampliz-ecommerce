<?php

namespace MisterPrint\Components;

use MisterPrint\BO\Carrinho;
use MisterPrint\BO\Produto;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;
use MisterPrint\Support\SessionSupport;

class Cart extends Component
{
	protected $name = 'Carrinho de compras';
	protected $description = 'Mister Print componente para o carrinho de compras';
	protected $base = 'vc_mp_cart';

	public function render()
	{
		return (new View('cart/cart', [
			'cart' => user()->getCart(),
			'user' => user()->getId(),
			'params' => $this->getParamsAjax()
		]))->get();
	}

	static public function action()
	{
		return function () {
			$data = $_POST['data'];
			$response = [];
			$errors = [];
			if ($data['action'] == 'copy') {
				if(!is_numeric($data['qtd'])){ $data['qtd'] = 1;}
				$response = (new Carrinho())->duplicar_item_carrinho(user()->getId(), $data['id'], $data['qtd']);
				user()->clearCart();
				if (!$response) {
					$errors[] = 'Erro ao duplicar o produto, tente novamente mais tarde!';
				}
			}
			
			if ($_GET['action'] === 'mp_clear_cart') {
				$response = (new Carrinho())->limpar_carrinho(user()->getId());
				user()->clearCart();
				if (!$response) {
					$errors[] = 'Erro ao limpar carrinho, tente novamente mais tarde!';
				}
			}

			if ($data['action'] == 'delete') {
				$response = (new Carrinho())->remover_item_carrinho(user()->getId(), $data['id']);
				user()->clearCart();
				if (!$response) {
					$errors[] = 'Erro ao remover o produto do carrinho, tente novamente mais tarde!';
				}
			}
			@session_start();
			$_SESSION['update'] = 1;

			return (new View('cart/cart-table', [
				'cart' => user()->getCart(),
				'errors' => $errors,
				'response' => $response,
			]))->get();
		};
	}

	protected function getCart()
	{
		$cart = (new Carrinho())->get_dados_carrinho_de_compras(user()->getId());

		return array_map(function ($item) {
			return [
				'id' => $item['id'],
				'product_id' => $item['produtoId'],
				'name' => $item['nomeProduto'],
				'price' => number_format($item['preco'], 2, ',', ''),
				'prev_price' => number_format($item['preco_previo'], 2, ',', ''),
				'weight' => $item['peso'],
				'model' => $item['modelo'],
				'quant' => $item['quantidade'],
				'category' => $item['categoria'],
				'min_quant' => $item['quantidadeMinima'],
				'cover' => $item['cobertura'],
				'format' => $item['formato'],
				'prazo' => $item['prazo'],
				'finishings' => (!empty($item['acabamentos'])) ? $item['acabamentos'] : 'Sem Acabamentos',
				'images' => [$item['imagemProduto']],
				'art' => $item['tipoEnvioArte']
			];
		}, $cart);
	}

	static public function add_to_cart()
	{
		return function () {
			$data = $_REQUEST;

			$carrinho = new Carrinho();

			if ( isset($data['from-session']) ) {
				$data = SessionSupport::get('add-to-cart-after-login');

				$response = $carrinho->adicionar_item_carrinho(
					user()->getId(),
					$data['product'],
					$data['custom_quantity'] ?: 1,
					$data['art'],
					$data['configuration_finishing'],
					[
						'valor' => $data['valor'],
						'formato' =>  "{$data['sob_medida_width']}x{$data['sob_medida_height']}",
						'peso' =>  $data['peso'],
						'modulos' =>  $data['modulos'],
					]
				);

				user()->clearCart();

				if(wp_redirect(get_page_url('cart'))) {
					exit;
				}
			}
			else if(isset($data['product']) && !empty($data['product'])) {
				$response = (new Carrinho())->adicionar_item_carrinho(
					user()->getId(),
					$data['product'],
					$data['product_quantity'],
					$data['art'],
					$data['configuration_finishing']
				);
				user()->clearCart();

				if(wp_redirect(get_page_url('cart'))) {
					exit;
				}
			}
		};
	}

	public function setParams()
	{
		$this->addParams([
			Vc::paramText('Titulo', 'Carrinho'),
			Vc::paramText('Subtitulo', 'Vamos conferir seu carrinho de compras?'),
			Vc::paramText('Titulo da tabela', 'Confirmação do pedido'),
			Vc::paramText('Subtitulo da tabela', 'As informações do seu pedido estão corretas?'),
			Vc::paramText('Titulo do botão preto', 'Comprar outro produto'),
			Vc::paramText('Titulo do botao vermelho', 'Continuar'),
			Vc::paramText('Sem itens', 'Você ainda não tem itens no carrinho.'),
			Vc::paramText('Shortcode da popup', ''),
			Vc::paramText('Valor em compras para popup', 0.0),
			Vc::paramText('Altura da popup', 200),
			Vc::paramText('Largura da popup', 150)
		]);
	}
}
