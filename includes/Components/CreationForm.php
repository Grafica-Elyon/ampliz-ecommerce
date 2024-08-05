<?php

namespace MisterPrint\Components;

use MisterPrint\BO\Pedido;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;
use Carbon\Carbon;

class CreationForm extends Component
{
	protected $name = 'Formulário de criação de arte';
	protected $description = 'Componente para controlar o envio de informações para criação de arte';
	protected $base = 'vc_mp_creation_form';

	public function render()
	{
		$data = $_POST['data'];

		$pedido = $data['pedido'];
		$pedido = (new Pedido())->get_detalhes_do_pedido( $pedido );

		$pedido['items'] = array_filter($pedido['produtosPedido'], function($item) {
			return $item['is_creation'] && $item['need_upload'];
		});

		$item = $data['item'];
		// Verifica se algum item foi informado
		if ( $item ) {
			$item = @array_filter(
				$pedido['items'],
				function( $pedidoItem ) use ( $item ) {
					return $pedidoItem['orders_products_id'] == $item;
				}
			);
			if ( count( $item ) == 1 ) {
				$item = array_values($item)[0];
			} else {
				$item = null;
			}
		}
		// Se não foi informado e tem apenas um, pega esse único
		else if ( count( $pedido['items'] ) == 1 ) {
			$item = array_values($pedido['items'])[0];
		}

		if ( $item ) {
			return (new View('user/creation-form-integrator', [
				'params' => $this->getParams(),
				'pedido' => $pedido,
				'item' => $item ?: null
			]))->get();
		} else {
			return (new View('user/creation-select', [
				'params' => $this->getParams(),
				'pedido' => $pedido
			]))->get();
		}
	}

	public function component()
	{
		$_POST['data'] = [
			'pedido' => $_GET['pedido'],
			'item' => $_GET['item'],
		];
		return '<div data-ajax="0" data-component="' . $this->base . '">'. $this->render() .'</div><div class="loader"></div>';
	}

	public static function submit()
	{
		return function () {
			return \MisterPrint\Response\CreationArtSubmit::send( $_POST['data']['orders_id'], $_POST['data']['orders_products_id'] );
		};
	}

	public function setParams()
	{
		parent::setParams();
		$this->addParams([
			Vc::paramText('Form Id', 'criacao-arte-form')
		]);
	}
}
