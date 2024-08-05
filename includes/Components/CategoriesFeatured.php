<?php
namespace MisterPrint\Components;

use MisterPrint\BO\Produto;
use MisterPrint\BO\Cliente;
use MisterPrint\BO\User;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;

class CategoriesFeatured extends Component
{
	protected $name = 'Produtos em destaque';
	protected $description = 'Mister Print produtos mais visitados, lançamentos e em oferta.';
	protected $base = 'vc_mp_categories_featured';

	public function component()
	{
		return '<div data-component="' . $this->base . '" data-ajax="0">'.$this->render().'</div><div class="loader"></div>';
	}

	public function render()
	{
		$productBO = new Produto();

		if(user()->isLogged()){
			$quantidade_compras = (new User)->get_orders_quant();
		}


		$todos = $productBO->get_menu_de_produtos(user()->getId(), 1, 4 * 200);
		$categories['all'] = [];
		if(is_array($todos['data'])) {
			usort(
				$todos['data'],
				function ($a, $b) {
					return $a['ordem'] - $b['ordem'];
				}
			);
			$categories['all'] = array_map(function ($category) {
				return $category = [
					'id' => $category['codigoMenu'],
					'name' => $category['nomeMenu'],
					'slug' => $category['slug'],
					'image' => $category['urlImagem'],
					'is_master' => $category['is_master'],
					'master_id' => $category['master_id'],
					'description' => $category['descricao'],
					'price' => number_format($category['precoAPartirDe'], 2, ',', ''),
					'price_quant' => $category['quantidadeMenorPreco'],
					'menorPrecoUnitario' => number_format($category['menorPrecoUnitario'], 2, ',', ''),
					'menorPrecoUnitarioQuantidade' => $category['menorPrecoUnitarioQuantidade'],
					'label' => $category['labels'],
					'label_colors' => $category['labelColors'],
					'gray_scale' => $category['grayScale'],
					'has_products' => $category['hasProducts']
				];
			}, $todos['data']);
		}

		$user = new Cliente();
		$favoritas = $user->buscar_favoritos();
		$categories['favorite'] = json_decode($favoritas);

		$mais_visitadas = $productBO->get_categorias_mais_visitadas();
		$categories['most_visited'] = [];
		if(is_array($mais_visitadas)) {
			$categories['most_visited'] = array_map(function ($category) {
				return $category = [
					'id' => $category['codigoMenu'],
					'name' => $category['nomeMenu'],
					'slug' => $category['slug'],
					'image' => $category['urlImagem'],
					'description' => $category['descricao'],
					'price' => number_format($category['precoAPartirDe'], 2, ',', ''),
					'price_quant' => $category['quantidadeMenorPreco'],
					'menorPrecoUnitario' => number_format($category['menorPrecoUnitario'], 2, ',', ''),
					'menorPrecoUnitarioQuantidade' => $category['menorPrecoUnitarioQuantidade'],
					'label' => $category['labels'],
					'label_colors' => $category['labelColors'],
					'gray_scale' => $category['grayScale'],
					'has_products' => $category['hasProducts']

				];
			}, $mais_visitadas);
		}

		$especial = $productBO->get_produtos_negociacao_especial(1, 4 * 200);
		$categories['especial'] = [];
		if(is_array($especial['data'])) {
			usort(
				$especial['data'],
				function ($a, $b) {
					return strcmp($a['nome'], $b['nome']);
				}
			);
			$categories['especial'] = array_map(function ($category) {
				return $category = [
					'id' => $category['id'],
					'name' => $category['nome'],
					'slug' => $category['slug'],
					'image' => $category['image'],
					'description' => $category['nome'],
					'price' => number_format($category['preco'], 2, ',', ''),
					'special_product' => true,
					'label' => $category['labels'],
					'label_colors' => $category['labelColors'],
					'gray_scale' => $category['grayScale'],
					'has_products' => $category['hasProducts']
				];
			}, $especial['data']);
		}

		$balcao = $productBO->get_produtos_balcao(1, 4 * 200);
		$categories['balcao'] = [];
		if(is_array($balcao) && !empty($balcao)) {
			usort(
				$balcao,
				function ($a, $b) {
					return strcmp($a['nome'], $b['nome']);
				}
			);
			$categories['balcao'] = array_map(function ($category) {
				return $category = [
					'id' => $category['id'],
					'name' => $category['nome'],
					'slug' => $category['slug'],
					'image' => $category['image'],
					'description' => $category['nome'],
					'price' => number_format($category['preco'], 2, ',', ''),
					'special_product' => true,
					'label' => $category['labels'],
					'label_colors' => $category['labelColors'],
					'gray_scale' => $category['grayScale'],
					'has_products' => $category['hasProducts']
				];
			}, $balcao);
		}

		// $lancamentos = $productBO->get_categorias_lancamentos();
		// $categories['new'] = [];
		// if(is_array($lancamentos)) {
		//     $categories['new'] = array_map(function ($category) {
		//         return $category = [
		//             'id' => $category['codigoMenu'],
		//             'name' => $category['nomeMenu'],
		//             'slug' => $category['slug'],
		//             'image' => $category['urlImagem'],
		//             'description' => $category['descricao'],
		//             'price' => number_format($category['precoAPartirDe'], 2, ',', ''),
		//         ];
		//     }, $productBO->get_categorias_lancamentos());
		// }
		//
		//
		// $ofertas = $productBO->get_categorias_ofertas();
		// $categories['offer'] = [];
		// if(is_array($ofertas)) {
		//     $categories['offer'] = array_map(function ($category) {
		//         return $category = [
		//             'id' => $category['codigoMenu'],
		//             'name' => $category['nomeMenu'],
		//             'slug' => $category['slug'],
		//             'image' => $category['urlImagem'],
		//             'description' => $category['descricao'],
		//             'price' => number_format($category['precoAPartirDe'], 2, ',', ''),
		//         ];
		//     }, $productBO->get_categorias_ofertas());
		// }

		$categories['params'] = $this->getParamsAjax();
		if(user()->isLogged()){
			$categories['compras'] = $quantidade_compras['quantidade'];
		}

		return (new View('category/categories-featured', $categories))->get();
	}

	public static function removerFavorito(){
		return function(){
			$data = array(
				"params" => $_GET['id'],
				"user" => user()->getId()
			);
			$cliente = new Cliente();
			$resposta = $cliente->remove_favorito($data);
			return $resposta;
		};
	}

	public function setParams()
	{
		parent::setParams();
		$this->addParams([
			Vc::paramText('Titulo', 'Produtos Misterprint'),
			Vc::paramText('Subtitulo', 'Escolha o formato ideal para personalizar e receba em seu endereço.'),
			Vc::paramText('Todos', 'Produtos'),
			Vc::paramText('Mais visitados', 'Mais visitados'),
			Vc::paramText('Lançamentos', 'Lançamentos'),
			Vc::paramText('favoritos', 'Favoritos'),
			Vc::paramText('Ofertas', 'Ofertas'),
			Vc::paramText('Especial', 'Exclusivos'),
			Vc::paramText('Balcão', 'Balcões'),
			Vc::paramText('Art Creation', 'Criação de Arte'),
			Vc::paramText('Card title margin size (px)', 10),
			Vc::paramText('Card description margin size (px)', 10),
			Vc::paramText('Card text margin size (px)', 5),
		]);
	}
}
