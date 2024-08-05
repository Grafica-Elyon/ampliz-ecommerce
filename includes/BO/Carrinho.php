<?php

namespace MisterPrint\BO;

use MisterPrint\Response\CouponResponse;
use MisterPrint\Support\Request;
use MisterPrint\Response\CartItemResponse;
use MisterPrint\Response\CartResponse;

class Carrinho
{
	public function get_dados_carrinho_de_compras($client_id)
	{
		$data = [
			'codigoCliente' => $client_id,
			'idFranquia' => FranquiaUtil::getIdFranquia(),
		];

		$request = new Request('carrinho/get-carrinho-de-compras');
		$response = new CartResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function limpar_carrinho($clientId)
	{
		$data = ['codigoCliente' => $clientId];
		$request = new Request('carrinho/limpar-carrinho', $data);
		$response = new CartItemResponse($request->post());

		if (!$response->is_positive()) {
			return false;
		}

		return true;
	}

	public function duplicar_item_carrinho($clientId, $cartItemId, $quantidade = 1)
	{
		$data = [
			'codigoCliente' => $clientId,
			'codigoItem' => $cartItemId,
			'quantidade' => $quantidade,
			'idFranquia' => FranquiaUtil::getIdFranquia(),
		];


		$request = new Request('carrinho/duplicar-item-carrinho', $data);
		$response = new CartItemResponse($request->post());

		if (!$response->is_positive()) {
			return false;
		}

		return true;
	}

	public function adicionar_item_carrinho($client_id, $product_id, $amount = 1, $art = null, $acabamentos = [], $sobMedidaInfo = [], $categoria = null)
	{
		$data = [
			'codigoCliente' => $client_id,
			'codigoProduto' => (int) $product_id,
			'qtd' => $amount,
			'acabamentos' => $acabamentos,
			'idFranquia' => FranquiaUtil::getIdFranquia(),
		];

		if ($data['qtd'] != 1) {
			$data['qtd_customizada'] = true;
		}
		$data['categoria'] = $categoria;

		if (is_array($data['acabamentos'])) {
			$data['acabamentos'] = implode(',', $data['acabamentos']);
		}

		if (!is_null($art)) {
			$data['tipoEnvioArte'] = $art;
		}

		if (isset($sobMedidaInfo['valor'])) {
			$data['valorSobMedida'] = $sobMedidaInfo['valor'];
		}

		if (isset($sobMedidaInfo['formato']) && $sobMedidaInfo['formato'] != 'x' && $sobMedidaInfo['formato'] != '0.00x0.00') {
			$data['formatoSobMedida'] = $sobMedidaInfo['formato'];
		}

		if (isset($sobMedidaInfo['peso']) && $sobMedidaInfo['peso']) {
			$data['pesoSobMedida'] = $sobMedidaInfo['peso'];
		}
		if (isset($sobMedidaInfo['modulos']) && $sobMedidaInfo['modulos']) {
			$data['qtdModulosSobMedida'] = $sobMedidaInfo['modulos'];
		}

		$request = new Request('carrinho/adicionar-item-carrinho', $data);
		$response = new CartItemResponse($request->post());

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function remover_item_carrinho($client_id, $product_id)
	{
		$data = [
			'codigoCliente' => $client_id,
			'id' => $product_id,
			'idFranquia' => FranquiaUtil::getIdFranquia(),
		];

		$request = new Request('carrinho/remover-item-carrinho', $data);
		$response = new CartItemResponse($request->delete());

		if (!$response->is_positive()) {
			return false;
		}

		return true;
	}

	public function aplicar_cupom_de_desconto($client_id, $coupon)
	{
		$data = [
			'codigoCliente' => $client_id,
			'cupom' => $coupon,
		];

		$request = new Request('carrinho/aplicar-cupom-de-desconto', $data);
		$response = new CouponResponse($request->post());
		return $response->get_data();
	}

	public function registrar_arte_carrinho($item_do_carrinho, $arquivo)
	{
		$data = [
			'codigoItem' => $item_do_carrinho,
			'file' => $arquivo,
			'idFranquia' => FranquiaUtil::getIdFranquia(),
		];

		$request = new Request('carrinho/registrar-arte', $data);
		$response = new CouponResponse($request->post());
		return $response->get_data();
	}
}
