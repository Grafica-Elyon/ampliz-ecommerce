<?php

namespace MisterPrint\Admin\Includes;

use MisterPrint\BO\Produto;
use MisterPrint\Helper\Log;
use MisterPrint\Admin\Includes\Posts;

class Products
{
	private $produtoBO;
	private $products;
	private $products_map;

	public function __construct()
	{
		$this->produtoBO = new Produto();
		$this->setProducts();
	}

	public static function sync()
	{
		return function () {
			Posts::delete_transient(false); //limpando cachê antes
			global $wpdb;
			$defaultProductPage = '[vc_row][vc_column][vc_mp_category precos_ligados="1"][/vc_column][/vc_row]';
			$productsObj = new self();
			$products = $productsObj->getProductsFromAPI();
			$ids = array_filter(array_column($products, 'codigoMenu'), 'is_numeric');

			$status = [false => 'draft', true => 'publish'];

			$products_transient = [];
			foreach ($products as $product) {
				$result_raw = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = 'mp_product_id' AND meta_value = '" . $product['codigoMenu'] . "'");

				if (count($result_raw) == 0) {
					Log::info("categoria {$product['codigoMenu']} nova ou nao encontrada");
					// Insert the post into the database
					$post_id = wp_insert_post([
						'post_title' => wp_strip_all_tags($product['nomeMenu']),
						'post_name' => $product['slug'],
						'post_content' => $defaultProductPage,
						'post_status' => $status[$product['status']],
						'post_type' => 'product'
					]);

					if (is_wp_error($post)) {
						$post_id = false;
					}
				} else {
					$post_id = false;
					if (isset($result_raw[0]->post_id) && !empty($result_raw[0]->post_id)) {
						$post = get_post($result_raw[0]->post_id, 'ARRAY_A');
						$post['post_name'] = $product['slug'];
						$post['post_title'] = wp_strip_all_tags($product['nomeMenu']);
						$post_id = $result_raw[0]->post_id;
						wp_update_post($post);
						Log::info("categoria {$product['codigoMenu']} - ({$product['nomeMenu']}) atualizada");
					}
				}

				update_post_meta($post_id, 'mp_product_id', $product['codigoMenu']);
				$products_transient[$product['codigoMenu']] = $post_id;

				$post = get_post($post_id, 'ARRAY_A');

				if ($post['post_status'] != $status[$product['status']]) {
					$post['post_status'] = $status[$product['status']];
					wp_update_post($post);
				}
			}

			// Caso a categoria não exista mais, coloca na lixeira
			if (!empty($ids)) {
				$idsString = implode(',', $ids);
				$result_raw = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = 'mp_product_id' AND meta_value not in ($idsString)");
				foreach ($result_raw as $postmeta) {
					$post = get_post($postmeta->post_id, 'ARRAY_A');
					$post['post_status'] = 'trash';
					wp_update_post($post);
				}
			}
			update_option('mp_products_map', json_encode($products_transient));

			if (wp_redirect($_SERVER['HTTP_REFERER'] . "&updated=1")) {
				exit;
			}
		};
	}

	static public function toggleLp()
	{
		return function () {
			global $wpdb;
			$id = $_POST['id'];
			$status = $_POST['status'];
			$result_raw = $wpdb->get_results(
				"SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key='mp_product_id' AND meta_value='{$id}'"
			);

			if (count($result_raw) > 0) {
				if (isset($result_raw[0]->post_id) && !empty($result_raw[0]->post_id)) {
					$post_id = $result_raw[0]->post_id;
					$post = get_post($post_id, 'ARRAY_A');
					$post['post_status'] = $status == 1 ? "publish" : "draft";
					$post['post_name'] = $post_name;
					wp_update_post($post);
					return "success";
				}
				return "error: post excluído";
			}
			return "error: produto não existe";
		};
	}

	public function getProductsMap()
	{
		return $this->products_map;
	}

	private function setProducts()
	{
		$products_map = get_option('mp_products_map');

		$this->products_map = json_decode($products_map, true);
	}

	public function getProductPostID($id)
	{
		return isset($this->products_map[$id]) ? $this->products_map[$id] : false;
	}


	public function getProductsFromAPI()
	{

		$page = 0;
		$products;
		$this->products = [];

		do {
			$page++;
			$products = $this->produtoBO->get_menu_de_produtos_sync(null, $page, 50, true, false);
			$this->products = array_merge($this->products, $products['data']);
		} while ($products['last_page'] > $page);

		return $this->products;
	}
}
