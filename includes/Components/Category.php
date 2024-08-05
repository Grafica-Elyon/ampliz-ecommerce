<?php

namespace MisterPrint\Components;

use MisterPrint\BO\Produto;
use MisterPrint\BO\Arte;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;
use Carbon\Carbon;

class Category extends Component
{
	protected $name = 'Produto';
	protected $description = 'Mister Print componente para a interna de Produto';
	protected $base = 'vc_mp_category';

	public function render()
	{
		$data = isset($_POST['data']) ? $_POST['data'] : $_GET;

		if(!isset($data['categoria']) && !isset($data['produto'])) {
			$data['categoria'] = $this->getCategoryId();
		}

		if(isset($data['categoria'])) {
			$category = (new Produto())->get_dados_da_categoria($data['categoria']);
			if($category['is_master']){
				$category = $data['categoria'];
				$subcategories = (new Produto)->getSubCategories($category);
				return (new View('category/subcategories', [
					'master' => $subcategories['nome_master'],
					'subcats' => $subcategories['categorias'],
					'params' => $this->getParamsAjax()
				]))->get();
			}
			$params =  [
				'id' => $category['codigoMenu'],
				'name' => $category['nome'],
				'short_description' => 'Placeholder',
				'slug' => $category['slug'],
				'images' => !empty($category['urlImagem']) ? [$category['urlImagem']] : [],
				'description' => $category['descricao'],
				'price' => number_format($category['precoAPartirDe'], 2, ',', ''),
				'discount' => $category['discount'],
				'price_quant' => $category['quantidadeMenorPreco'],
				'menorPrecoUnitario' => number_format($category['menorPrecoUnitario'], 2, ',', ''),
				'menorPrecoUnitarioQuantidade' => $category['menorPrecoUnitarioQuantidade'],
				'category' => $category,
				'params' => $this->getParamsAjax()
			];

			return (new View('category/category', $params))->get();
		}

		if(isset($data['produto'])) {
			$product = (new Produto())->get_detalhes_do_produto($data['produto']);

			$arts = array_map(function($item) {
				return [
					'id' => $item['id'],
					'slug' => $item['slug'],
					'title' => $item['title'],
					'desc' => $item['desc'],
					'acabamentos' => $item['acabamentos'],
					'preco' => number_format($item['preco'], 2, ',', ''),
					'preco_adic_modulo' => number_format($item['preco_adic_modulo'], 2, ',', ''),
				];
			}, (new Arte())->get_opcoes_envio(@$product['menu_id']));

			$params =  [
				'product' => $product,
				'id' => $product['id'],
				'name' => $product['name'],
				'quant' => $product['quantidade'],
				'format' => $product['formato'],
				'cor' => $product['cor'],
				'substrato' => $product['substrato'],
				'covering' => $product['cobertura'],
				'prazo' => $product['prazo'],
				'description' => $product['products_description'] ?: $product['descricao'],
				'price' => number_format($product['precoTotal'], 2, ',', ''),
				'prev_price' => number_format($product['precoAnterior'], 2, ',', ''),
				'discount' => $product['discount'],
				'minimum' => $product['quantidade_minima'],
				'images' => [],
				'envio' => $arts,
				'params' => $this->getParamsAjax()
			];
			if($product['imagem'] == true){
				$params['images'][] = $product['imagem'];
			}
			if($product['imagem_produto'] == true){
				$params['images'][] = $product['imagem_produto'];
			}

			return (new View('product/product', $params))->get();
		}
	}

	public function getCategoryId()
	{
		$post_id = get_the_ID();
		return get_post_meta( $post_id, 'mp_product_id', true );
	}

	public static function consult_price()
	{
		return function() {

			$data = $_POST['data'];
			$boProduto = new Produto();
			$new = [];
			if(isset($data['configuration_finishing']) && !empty($data['configuration_finishing'])){
				foreach($data['configuration_finishing'] as $key => $value){
					if(is_array($value)){
						foreach($values as $item){
							$new[] = $item;
						}
					}else{
						$new[] = $value;
					}
				}
				$data['configuration_finishing'] = $new;
			}
			
			$preco = $boProduto->get_preco_do_produto(
				$data['product'],
				$data['product_quantity'] ?: $data['custom_quantity'],
				$data['configuration_finishing'] ?: []
			);

			return [
				'data' => $_POST['data'],
				'price' => $preco
			];
		};
	}

	public function setParams()
	{
		parent::setParams();
		$preco = array("Sim" => 1, "Não" => 0);
			$this->addParams([
				Vc::paramDropdown('Preços ligados', $preco),
				Vc::paramText('Titulo', 'Qual a próxima etapa?'),
				Vc::paramText('Subtitulo', 'Defina a personalização do seu produto e saiba qual o valor total.'),
				Vc::paramText('Botão', 'Configure seu produto'),
				Vc::paramText('Fail Titulo', 'Erro'),
				Vc::paramText('Fail Subtitulo', 'Produto não encontrado'),
				Vc::paramText('Fail Texto', 'O produto selecionado não foi encontrado ou não está mais disponível, em caso de dúvidas, entre em contato'),
				Vc::paramText('Fail Voltar', 'Voltar para o início'),
			]);
	}

	public function component()
	{
		if(isset($_GET['produto'])) {
			$data = 'data-produto="' . $_GET['produto'] . '"';
		}

		if(isset($_GET['categoria'])) {
			$data = 'data-categoria="' . $_GET['categoria'] . '"';
		}

		if(!isset($_GET['categoria']) && !isset($_GET['produto'])) {
			$data = 'data-categoria="' . $this->getCategoryId() . '"';
		}

		return '<div data-component="' . $this->base . '" '.$data.' data-ajax="0">'.$this->render().'</div><div class="loader"></div>';
	}
}
