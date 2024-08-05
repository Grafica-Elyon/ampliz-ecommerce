<?php

namespace MisterPrint\BO;

use MisterPrint\Request;
use MisterPrint\Response\CategoryDataResponse;
use MisterPrint\Response\ProductCategoriesMostVisitedResponse;
use MisterPrint\Response\ProductCategoriesOffersResponse;
use MisterPrint\Response\ProductCategoriesReleasesResponse;
use MisterPrint\Response\ProductCategoriesResponse;
use MisterPrint\Response\ProductColorsResponse;
use MisterPrint\Response\ProductEnnoblementsResponse;
use MisterPrint\Response\ProductExtrasResponse;
use MisterPrint\Response\ProductFinishesResponse;
use MisterPrint\Response\ProductFormatsResponse;
use MisterPrint\Response\ProductMenuResponse;
use MisterPrint\Response\ProductPapersResponse;
use MisterPrint\Response\ProductRelatedResponse;
use MisterPrint\Response\ProductSummaryPreviewResponse;
use StudioVisual\Support\Components\Collection;

class Produto
{
	public function get_menu_de_produtos($client_id=null,$page=1,$numPerPage=12,$showDisabled=false,$ignoreCache=false){
		$data = [
			'codigoCliente' => user()->getId(),
			'page' => $page,
			'numPerPage' => $numPerPage
		];

		if ( $showDisabled ) {
			$data['all'] = true;
		}

		$transient_key = "menu_de_produtos_{$data['codigoCliente']}_{$data['page']}_{$data['numPerPage']}";
		if ( $showDisabled ) {
			$transient_key .= '_all';
		}
		if( !$ignoreCache && $transient_value = get_transient($transient_key) ) {
			return $transient_value;
		}

		$request = new Request('produto/get-menu-de-produtos');
		$response = new ProductMenuResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		$result = $response->get_data();

		set_transient($transient_key, $result, HOUR_IN_SECONDS * 0.5);

		return $result;
	}

	public function get_grupos_de_produtos()
	{
		$request = new Request('produto/get-grupos-produtos');
		$response = $request->get();

		$result = $response['body'];

		return $result;
	}

	public function get_menu_de_produtos_sync($client_id=null,$page=1,$numPerPage=12,$showDisabled=false,$ignoreCache=true){
		$data = [
			'codigoCliente' => user()->getId(),
			'page' => $page,
			'numPerPage' => $numPerPage
		];

		if ( $showDisabled ) {
			$data['all'] = true;
		}

		$transient_key = "menu_de_produtos_{$data['codigoCliente']}_{$data['page']}_{$data['numPerPage']}";
		if ( $showDisabled ) {
			$transient_key .= '_all';
		}
		if( !$ignoreCache && $transient_value = get_transient($transient_key) ) {
			return $transient_value;
		}

		$request = new Request('produto/get-menu-de-produtos-sync');
		$response = new ProductMenuResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		$result = $response->get_data();

		set_transient($transient_key, $result, HOUR_IN_SECONDS * 0.5);

		return $result;
	}

	public function get_produtos_mega_menu()
	{
		$data = ['codigoCliente' => user()->getId()];
		$request = new Request('produto/get-produtos-mega-menu', $data);
		$response = $request->get();

		$result = $response['body'];

		return $result;
	}

	public function get_favoritos()
	{
		$data = ['codigoCliente' => user()->getId()];
		$request = new Request('cliente/buscar-favoritos', $data);
		$response = $request->post();

		$result = $response['body'];

		return $result;
	}

	public function getSubCategories($cat)
	{
		$data = ['category' => $cat];
		$request = new Request('produto/get-subcategories', $data);
		$response = $request->post();

		$result = $response['body'];
		return json_decode($result, true);
	}

	public function get_produtos_negociacao_especial($page = 1)
	{
		$data = [
			'codigoCliente' => user()->getId(),
			'page' => $page,
			'withImage' => 1,
		];
		if ( !$data['codigoCliente'] ) {
			return false;
		}
		$request = new Request('produto/get-produtos-negociacao-especial');
		$response = new ProductMenuResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		$result = $response->get_data();

		return $result;
	}

	public function get_produtos_balcao($page = 1)
	{
		if ( !is_balcony() ) {
			return false;
		}
		$data = [
			'page' => $page,
			'withImage' => 1,
		];
		$request = new Request('produto/get-produtos-balcao');
		$response = new ProductMenuResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		$result = $response->get_data();

		return $result;
	}

	public function get_categorias_de_produtos($client_id = null)
	{
		$data = [ 'codigoCliente' => $client_id];

		$request = new Request('produto/get-categorias-de-produtos');
		$response = new ProductCategoriesResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		$result = $response->get_data();
		Collection::order_by('display_order', $result);
		return $result;
	}

	public function get_formatos_do_produto($category_id)
	{
		$data = [ 'codigoCategoria' => $category_id];
		$request = new Request('produto/get-formatos-do-produto');
		$response = new ProductFormatsResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function get_cores_do_produto($category_id, $format, $sob_medida = false)
	{
		$data = [
			'codigoCategoria' => $category_id,
			'formato' => $format,
		];

		if($sob_medida) {
			unset($data['formato']);
			$data['medidasInformadas'] = 'true';
		}

		$request = new Request('produto/get-cores-do-produto');
		$response = new ProductColorsResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function get_papeis_do_produto($category_id, $format, $color, $sob_medida = false)
	{
		$data = [
			'codigoCategoria' => $category_id,
			'formato' => $format,
			'cor' => $color,
		];
		if($sob_medida) {
			unset($data['formato']);
			$data['medidasInformadas'] = 'true';
		}

		$request = new Request('produto/get-papeis-do-produto');
		$response = new ProductPapersResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function get_enobrecimentos_do_produto($category_id, $format, $color, $paper, $sob_medida = false)
	{
		$data = [
			'codigoCategoria' => $category_id,
			'formato' => $format,
			'cor' => $color,
			'papel' => $paper,
		];

		if($sob_medida) {
			unset($data['formato']);
			$data['medidasInformadas'] = 'true';
		}

		$request = new Request('produto/get-enobrecimentos-do-produto');
		$response = new ProductEnnoblementsResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function get_acabamentos_do_produto($category_id, $format, $color, $paper, $ennoblement, $sob_medida = false)
	{
		$data = [
			'codigoCategoria' => $category_id,
			'formato' => $format,
			'cor' => $color,
			'papel' => $paper,
			'enobrecimento' => $ennoblement
		];

		if($sob_medida) {
			unset($data['formato']);
			$data['medidasInformadas'] = 'true';
		}

		$request = new Request('produto/get-acabamentos-do-produto');
		$response = new ProductFinishesResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function get_extras_do_produto($category_id, $format, $color, $paper, $ennoblement, $finishing, $sob_medida = false)
	{
		$data = [
			'codigoCategoria' => $category_id,
			'formato' => $format,
			'cor' => $color,
			'papel' => $paper,
			'enobrecimento' => $ennoblement,
			'acabamento' => $finishing
		];

		if($sob_medida) {
			unset($data['formato']);
			$data['medidasInformadas'] = 'true';
		}

		$request = new Request('produto/get-extras-do-produto');
		$response = new ProductExtrasResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function get_resumo_e_previsao_de_produtos(
		$category_id,
		$format,
		$color = '',
		$paper = '',
		$ennoblement = '',
		$finishing = '',
		$extra = '',
		$sob_medida = false,
		$custom_quantity = false
	) {
		$data = [
			'codigoCategoria' => $category_id,
			'formato' => $format,
			'cor' => $color,
			'papel' => $paper,
			'enobrecimento' => $ennoblement,
			'acabamentos' => $finishing,
			'extra' => $extra,
		];

		$clienteId = user()->getId();
		if ( $clienteId ) {
			$data['codigoCliente'] = $clienteId;
		}

		if ( is_array($data['acabamentos']) ) {
			$data['acabamentos'] = implode(',', $data['acabamentos']);
		}

		if($sob_medida) {
			$data['medidasInformadas'] = 'true';
		}

		if($custom_quantity) {
			$data['quantidade'] = $custom_quantity;
		}

		$request = new Request('produto/get-resumo-e-previsao-de-produtos');
		$response = new ProductSummaryPreviewResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function get_dados_da_categoria($category_id)
	{
		// $transient_key = 'mp_category_' . $category_id;
		// if( $transient_value = get_transient($transient_key) ) {
		// 	return $transient_value;
		// }
		$data = [
			'codigoCategoria' => $category_id,
			'codigoCliente' => user()->getId(),
		];
		$request = new Request('produto/get-dados-da-categoria');
		$response = new CategoryDataResponse($request->get($data));

		if (!$response) {
			return false;
		}

		$result = $response->get_data();
		//set_transient($transient_key, $result, HOUR_IN_SECONDS * 2);
		return $result;
	}

	public function get_detalhes_do_produto($produto)
	{
		// $transient_key = 'mp_product_detail_'.store_ip_identification().'_'.$produto.'_'.user()->getId();
		// if( $transient_value = get_transient($transient_key) ) {
		// 	if ( $transient_value !== 'Ocorreu um erro' ) {
		// 		return $transient_value;
		// 	}
		// }

		$data = [ 'codigoProduto' => $produto, 'codigoCliente' => user()->getId() ];
		$request = new Request('produto/get-detalhes-do-produto');
		$response = new ProductCategoriesResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}
		$result = $response->get_data();
		//set_transient($transient_key, $result, HOUR_IN_SECONDS * 3);

		return $response->get_data();
	}

	public function get_preco_do_produto($produto, $quantidade, $acabamentos = [])
	{
		if ( is_array($acabamentos) ) {
			$acabamentos = implode(',', $acabamentos);
		}

		$data = [
			'codigoCliente' => user()->getId(),
			'codigoProduto' => $produto,
			'quantidade' => $quantidade,
			'acabamentos' => $acabamentos,
		];
		$request = new Request('produto/get-preco-do-produto');
		$response = new ProductCategoriesResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function get_produtos_relacionados($client_id, $product_id)
	{
		$data = [
			'codigoCliente' => $client_id,
			'codigoProduto' => $product_id,
		];

		$request = new Request('produto/get-produtos-relacionados');
		$response = new ProductRelatedResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function get_categorias_mais_visitadas($client_id = 'null')
	{
		$transient_key = 'mp_categories_most_visited';
		if( $transient_value = get_transient($transient_key) ) {
			return $transient_value;
		}
		$data = [ 'codigoCliente' => $client_id];

		$request = new Request('produto/get-categorias-mais-visitadas');
		$response = new ProductCategoriesMostVisitedResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		$result = $response->get_data();
		set_transient($transient_key, $result, HOUR_IN_SECONDS * 2);

		return $result;
	}

	public function get_categorias_lancamentos($client_id = 'null')
	{
		$transient_key = 'mp_categories_releases';
		if( $transient_value = get_transient($transient_key) ) {
			return $transient_value;
		}
		$data = [ 'codigoCliente' => $client_id];

		$request = new Request('produto/get-categorias-lancamentos');
		$response = new ProductCategoriesReleasesResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		$result = $response->get_data();
		set_transient($transient_key, $result, HOUR_IN_SECONDS * 2);
		return $result;
	}

	public function get_categorias_ofertas($client_id = 'null')
	{
		$transient_key = 'mp_categories_offers';
		if( $transient_value = get_transient($transient_key) ) {
			return $transient_value;
		}
		$data = [ 'codigoCliente' => $client_id];

		$request = new Request('produto/get-categorias-ofertas');
		$response = new ProductCategoriesOffersResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		$result = $response->get_data();
		set_transient($transient_key, $result, HOUR_IN_SECONDS * 2);
		return $result;
	}
}
