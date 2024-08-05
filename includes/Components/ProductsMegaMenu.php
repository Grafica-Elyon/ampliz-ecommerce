<?php
namespace MisterPrint\Components;

use MisterPrint\BO\Produto;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;

class ProductsMegaMenu extends Component
{
	protected $name = 'Mega Menu';
	protected $description = 'Mega Menu de produtos';
	protected $base = 'mp_mega_menu';

	public function html( $attr )
	{
		return $this->render();
	}

	public function render(){

		$productBO = new Produto();
		$grupos_produtos = $productBO->get_grupos_de_produtos();
		$lista_produtos = $productBO->get_produtos_mega_menu();
		$categories = [];
		$lista_produtos = json_decode($lista_produtos, true);
		foreach($lista_produtos as $category){
			$item = array();
			$item['id'] = $category['codigoMenu'];
			$item['name'] = $category['nomeMenu'];
			$item['slug'] = $category['slug'];
			$item['description'] = $category['descricao'];
			$item['label'] = $category['labels'];
			$item['label_colors'] = $category['labelColors'];
			$item['gray_scale'] = $category['grayScale'];
			$item['image'] = $category['urlImagem'];
			$item['is_master'] = isset($category['is_master']) ? $category['is_master'] : null;
			$item['master_id'] = isset($category['master_id']) ? $category['master_id'] : null;
			$item['grupo'] = $category['grupo'];
			$categories['all'][] = $item;
		}
		$categories['grupos'] = json_decode($grupos_produtos, true);
		return (new View('menu/do-mega-menu', $categories))->get();
	}
}
