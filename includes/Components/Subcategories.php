<?php

namespace MisterPrint\Components;

use MisterPrint\BO\Produto;
use MisterPrint\BO\Arte;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;
use Carbon\Carbon;

class Subcategories extends Component
{
	protected $name = 'Subcategorias';
	protected $description = 'Mister Print subcategorias de produtos';
	protected $base = 'vc_mp_subcategories';

	public function render()
	{
		//-- Esse bloco pega o id de post
		$data = isset($_POST['data']) ? $_POST['data'] : $_GET;

		if(!isset($data['categoria']) && !isset($data['produto'])) {
			$data['categoria'] = $this->getCategoryId();
		}
		//------------------------

		$category = $data['categoria'];
		$subcategories = (new Produto)->getSubCategories($category);
		return (new View('category/subcategories', [
			'master' => $subcategories['nome_master'],
			'subcats' => $subcategories['categorias'],
			'params' => $this->getParamsAjax()
		]))->get();
	}

	public function getCategoryId()
	{
		$post_id = get_the_ID();
		return get_post_meta( $post_id, 'mp_product_id', true );
	}

	public function component()
	{
		//essa função faz com que possa seratualizada a página e possa ser pego o post_id
		return '<div data-component="' . $this->base . '" data-ajax="0">'.$this->render().'</div><div class="loader"></div>';
	}

	public function setParams()
	{
		$titulo = array("Sim" => 1, "Não" => 0);
		$preco = array("Sim" => 1, "Não" => 0);
		$this->addParams([
			Vc::paramDropdown('Titulo ligado', $titulo),
			Vc::paramDropdown('Preços ligados', $preco),
		]);
	}
}
