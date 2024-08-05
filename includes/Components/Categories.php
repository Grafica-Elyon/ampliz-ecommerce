<?php

namespace MisterPrint\Components;

use MisterPrint\BO\Produto;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;

class Categories extends Component
{
	protected $name = 'Produtos';
	protected $description = 'Mister Print Produtos';
	protected $base = 'vc_mp_categories';

	public function component()
	{
		return '<div data-component="' . $this->base . '" data-ajax="0">'.$this->render().'</div><div class="loader"></div>';
	}

	function render()
	{
		$produto = new Produto();
		$categories = $produto->get_menu_de_produtos(user()->getId(), 1, 4 * 200);

		$special_categories = [];
		if(user()->isLogged()) {
			$special_categories = $produto->get_produtos_negociacao_especial();
		}

		usort(
			$categories['data'],
			function ($a, $b) {
				return $a['ordem'] - $b['ordem'];
			}
		);

		return (new View('category/categories', [
			'params' => $this->getParamsAjax(),
			'categories' => self::getProducts($categories),
			'special_products' => self::getProducts($special_categories, true),
			'pagination' => self::getPagination($categories)
		]))->get();
	}

	public static function categories()
	{
		return function() {
			$page = isset($_POST['page']) ? $_POST['page'] : 1;
			$categories = (new Produto())->get_menu_de_produtos(user()->getId(), 1, 4 * 200);

			usort(
				$categories['data'],
				function ($a, $b) {
					return $a['ordem'] - $b['ordem'];
				}
			);

			return (new View('category/categories', [
				'params' => json_decode(base64_decode($_POST['params']), true),
				'categories' => self::getProducts($categories),
				'pagination' => self::getPagination($categories)
			]))->get();
		};
	}

	public static function getProducts($categories, $special = false)
	{
		if($special) {
			// [prazo] => 01/05
			// [id] => 136014
			// [quantidade] => 50
			// [nome] => Adesivos
			// [preco] => 17.59
			// [modelo] => DIG1
			// [cor] => 4x0
			// [formato] => 3.00x3.00
			// [cobertura] => sem-enobrecimento
			// [sobmedida] => N
			// [largura_minima] => 3
			// [altura_minima] => 3
			// [gabarito_horizontal_corel] => https://gabaritos.misterprint.com.br/.cdr
			// [gabarito_vertical_corel] => https://gabaritos.misterprint.com.br/110541_adesivos__50x50_4x0.cdr
			// [gabarito_horizontal_illustrator] => https://gabaritos.misterprint.com.br/illustrator-new/.ai
			// [gabarito_vertical_illustrator] => https://gabaritos.misterprint.com.br/illustrator-new/110541_adesivos__50x50_4x0.ai
			$categories = $categories['data'] != null ? array_map(function ($category) {
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
					'has_products' => $category['hasProducts'],
				];
			}, $categories['data']) : [];

			return $categories;
		}

		$categories = array_map(function ($category) {
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
				'has_products' => $category['hasProducts'],
			];
		}, $categories['data']);

		return $categories;
	}

	public static function getPagination($categories)
	{
		return [
			'current' => $categories['current_page'],
			'total' => $categories['last_page'],
		];
	}

	public function setParams()
	{
		parent::setParams();
		$this->addParams([
			Vc::paramText('Titulo', 'Produtos'),
			Vc::paramText('Subtitulo', 'Escolha o formato ideal para personalizar e receba em seu endereço.'),
			Vc::paramText('Card title margin size (px)', 10),
			Vc::paramText('Card description margin size (px)', 10),
			Vc::paramText('Card text margin size (px)', 5),
		]);
	}
}
