<?php

namespace MisterPrint\Admin;

use MisterPrint\BO\Produto;

class Product
{
	public $id;
	public $name;
	public $tutorial;
	public $vantagens;
	public $producao;

	public function __construct($id)
	{
		$this->id = $id;
		$this->setData();
	}

	private function setData()
	{
		$products = \get_option('mp_products');

		if(isset($products[$this->id])) {
			$this->name = $products[$this->id];
		}


		$tutorial = \get_option('product_'.$this->id.'_tutorial');
		$vantagens = \get_option('product_'.$this->id.'_vantagens');
		$producao = \get_option('product_'.$this->id.'_producao');

		$this->tutorial = json_decode($tutorial, true);
		$this->vantagens = json_decode($vantagens, true);
		$this->producao = json_decode($producao, true);

		$this->producao['imagens'] = array_map(function($item) {
			return [
				'image' => wp_get_attachment_url($item['attachment_id']),
				'attachment_id' => $item['attachment_id'],
			];
		}, $this->producao['imagens']);
	}

	public static function save()
	{
		return function () {
			$product = (isset($_POST['product']) && !empty($_POST['product'])) ? $_POST['product'] : false;

			if(!$product) {
				return;
			}

			// Tutorial
			if(isset($_POST['tutorial'])) {
				$tutorial = $_POST['tutorial'];
				\update_option('product_'.$product.'_tutorial', json_encode($tutorial));
			}

			// Vantagens
			$vantagens_online = [];
			if(isset($_POST['vantagens_online'])) {
				$vantagens_online = $_POST['vantagens_online'];
			}

			$vantagens_misterprint = [];
			if(isset($_POST['vantagens_misterprint'])) {
				$vantagens_misterprint = $_POST['vantagens_misterprint'];
			}

			$vantagens_tradicionais = [];
			if(isset($_POST['vantagens_tradicionais'])) {
				$vantagens_tradicionais = $_POST['vantagens_tradicionais'];
			}

			\update_option('product_'.$product.'_vantagens', json_encode([
				'online' => $vantagens_online,
				'misterprint' => $vantagens_misterprint,
				'tradicionais' => $vantagens_tradicionais,
			]));


			// Produção
			$producao_imagens = [];
			if(isset($_POST['producao_imagens'])) {
				$producao_imagens = $_POST['producao_imagens'];
			}

			if(isset($_POST['producao_description'])) {
				$producao_description = $_POST['producao_description'];
			}

			\update_option('product_'.$product.'_producao', json_encode([
				'imagens' => $producao_imagens,
				'description' => $producao_description
			]));

			if(wp_redirect(home_url('/wp-admin/admin.php?page=misterprint-ecommerce%2Fprodutos.php'))) {
				exit;
			}
		};
	}
}
