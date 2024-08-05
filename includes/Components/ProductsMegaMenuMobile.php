<?php
namespace MisterPrint\Components;

use MisterPrint\BO\Produto;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;

class ProductsMegaMenuMobile extends Component
{
	protected $name = 'Mega Menu Mobile';
	protected $description = 'Mega Menu de produtos para menus mobile';
	protected $base = 'mp_mobile_mega_menu';

	public function html( $attr )
	{
		return $this->render();
	}

	public function render(){

		$productBO = new Produto();

		$lista_produtos = $productBO->get_produtos_mega_menu(user()->getId(), 1, 4 * 200);
		$categories = [];
		if(isset($lista_produtos['data']) && is_array($lista_produtos['data'])) {
			usort(
				$lista_produtos['data'],
				function ($a, $b) {
					return $a['ordem'] - $b['ordem'];
				}
			);
			usort(
				$lista_produtos['data'],
				function ($a, $b){
					if ($a == $b) {
						return 0;
					}
					return ($a < $b) ? -1 : 1;
				}
			);
			$categories['all'] = array_map(function ($category) {
				return $category = [
					'id' => $category['codigoMenu'],
					'name' => $category['nomeMenu'],
					'slug' => $category['slug'],
					'label' => $category['labels'],
					'image' => $category['urlImagem']
				];
			}, $lista_produtos['data']);
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
			usort(
				$especial['data'],
				function ($a, $b){
					if ($a == $b) {
						return 0;
					}
					return ($a < $b) ? -1 : 1;
				}
			);
			$categories['especial'] = array_map(function ($category) {
				return $category = [
					'id' => $category['id'],
					'name' => $category['nome'],
					'slug' => $category['slug'],
					'image' => $category['image'],
					'label' => $category['labels'],
					'special_product' => true
				];
			}, $especial['data']);
		}

		return (new View('menu/do-mobile-mega-menu', $categories))->get();
	}
}
