<?php

namespace MisterPrint\Components;

use MisterPrint\Support\View;
use MisterPrint\BO\Produto;

class Tutorial extends Component
{
	protected $name = 'Tutorial';
	protected $description = 'Mister Print Tutorial';
	protected $base = 'vc_mp_tutorial';

	function render()
	{
		$product = (isset($_GET['categoria']) && !empty($_GET['categoria'])) ? $_GET['categoria'] : false;

		if(!$product) {
			$product = (isset($_GET['produto']) && !empty($_GET['produto'])) ? $_GET['produto'] : false;
			if($product) {
				$productArray = (new Produto())->get_detalhes_do_produto($product);
			}
		}

		$tutorial = false;
		if($product) {
			$tutorial = $tutorial = \get_option('product_'.$product.'_tutorial');
			$tutorial = json_decode($tutorial, true);
		}
			return (new View('category/tutorial', [
				'tutorial' => $tutorial,
				'params' => $this->getParamsAjax()]
			))->get();
	}

	public function component()
	{
		if(isset($_GET['categoria'])) {
			$data = 'data-categoria="' . $_GET['categoria'] . '"';
		}

		if(isset($_GET['produto'])) {
			$data = 'data-produto="' . $_GET['produto'] . '"';
		}

		return '<div data-component="' . $this->base . '" '.$data.' data-ajax="0">'.$this->render().'</div><div class="loader"></div>';
	}

	public function setParams()
	{
		$this->params = [
			[
				"type" => "textfield",
				"class" => "",
				"heading" => "Titulo",
				"param_name" => "title",
				"value" => '',
				'default' => 'Tutorial'
			],
			[
				"type" => "textfield",
				"class" => "",
				"heading" => "Subtitulo",
				"param_name" => "subtitle",
				"value" => '',
				'default' => 'Saiba como aproveitar melhor seu produto.'
			],
			[
				"type" => "attach_image",
				"class" => "",
				"heading" => "Imagem",
				"param_name" => "thumbnail",
				"value" => '',
				'default' => config('plugin', 'url') . 'front/assets/imgs/mp_graphic_production_01.jpg'
			],
		];
	}
}
