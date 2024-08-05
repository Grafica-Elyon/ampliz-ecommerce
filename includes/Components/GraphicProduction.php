<?php

namespace MisterPrint\Components;

use MisterPrint\Support\View;

class GraphicProduction extends Component
{
	protected $name = 'Produção Gráfica';
	protected $description = 'Componente para a Produção Gráfica';
	protected $base = 'vc_mp_graphic_production';

	function render()
	{
		$product = (isset($_GET['categoria']) && !empty($_GET['categoria'])) ? $_GET['categoria'] : false;

		$producao = false;
		if($product) {
			$producao = $producao = \get_option('product_'.$product.'_producao');
			$producao = json_decode($producao, true);
		}

		if(!empty($producao['imagens'])) {
			$producao['imagens'] = array_map(function($item) {
				return wp_get_attachment_url($item['attachment_id']);
			}, $producao['imagens']);
		}

		return (new View('category/graphic-production', [
			'producao' => $producao,
			'params' => $this->getParamsAjax()
		]))->get();
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
				'default' => 'Produção Gráfica'
			],
			[
				"type" => "textfield",
				"class" => "",
				"heading" => "Subtitulo",
				"param_name" => "subtitle",
				"value" => '',
				'default' => 'Foco em tecnologia de impressão avançada, pré-impressão e comércio eletrônico.'
			],
		];
	}

}
