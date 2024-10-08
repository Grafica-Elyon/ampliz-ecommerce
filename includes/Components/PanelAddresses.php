<?php

namespace MisterPrint\Components;

use MisterPrint\BO\Cliente;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;

class PanelAddresses extends PanelComponent
{
	protected $name = 'Painel de endereços';
	protected $description = 'Painel com os endereços do usuário';
	protected $base = 'vc_mp_panel_addresses';

	public function render()
	{
		return (new View('user/panel-addresses', [
			'params' => $this->getParamsAjax(),
		]))->get();
	}

	public static function get_addresses()
	{
		return function () {
			$user = new Cliente();
			return $user->get_endereco_entrega_do_cliente(user()->getId());
		};
	}

	public static function save_address()
	{
		return function () {
			$user = new Cliente();
			$data = array_reduce($_POST['data'], function ($prev, $field) {
				$prev[$field['name']] = $field['value'];
				return $prev;
			}, []);
			return $user->criar_endereco_de_entrega($data);
		};
	}

	public static function edit_address()
	{
		return function () {
			$user = new Cliente();
			$data = array_reduce($_POST['data'], function ($prev, $field) {
				$prev[$field['name']] = $field['value'];
				return $prev;
			}, []);
			return $user->editar_endereco_de_entrega($data);
		};
	}

	public static function remove_address()
	{
		return function () {
			$user = new Cliente();
			$data = $_POST['data'];
			return $user->remover_endereco_de_entrega($data);
		};
	}

	public function setParams()
	{
		parent::setParams();
		$this->addParams([
			Vc::paramText('Titulo painel', 'Meus endereços'),
			Vc::paramText('Painel endereço', 'Endereço'),
			Vc::paramText('Painel telefone', 'Telefone'),
			Vc::paramText('Painel ações', 'Ações'),
			Vc::paramText('Botão adicionar endereço', 'Adicionar endereço'),
			Vc::paramText('Formulario titulo', 'Cadastre seu endereço de entrega no formulário abaixo'),
			Vc::paramText('Formulario rua', 'Endereço'),
			Vc::paramText('Formulario bairro', 'Bairro'),
			Vc::paramText('Formulario CEP', 'CEP'),
			Vc::paramText('Formulario numero', 'Numero'),
			Vc::paramText('Formulario complemento', 'Complemento'),
			Vc::paramText('Formulario estado', 'Estado'),
			Vc::paramText('Formulario cidade', 'Cidade'),
			Vc::paramText('Formulario telefone', 'Telefone'),
			Vc::paramText('Formulario botão', 'Salvar endereço de entrega'),
			Vc::paramText('Posição da sidebar', 'left'),
		]);
	}
}
