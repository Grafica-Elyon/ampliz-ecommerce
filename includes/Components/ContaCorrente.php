<?php

namespace MisterPrint\Components;

use MisterPrint\BO\Cliente;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;

class ContaCorrente extends PanelComponent
{
	protected $name = 'extrato conta corrente do usuário';
	protected $description = 'painel com o extrato da conta corrente do usuário';
	protected $base = 'vc_mp_panel_conta_corrente';

	public function render()
	{
		$response = new Cliente();

		return (new View('user/panel-Conta-Corrente', [
			'params' => $this->getParamsAjax(),
			'credit_extract' => $response->get_conta_corrente_do_cliente(user()->getId()),

			  ]))->get();
	}

	public static function get_ContaCorrente()
	{
		return function () {
			$user = new Cliente();
			return $user->get_conta_corrente_do_cliente(user()->getId());
		};
	}

	public function setParams()
	{
		parent::setParams();
		$this->addParams([
			Vc::paramText('Titulo painel', 'Minha Conta corrente'),
			Vc::paramText('Formulario Pedido', 'Pedido'),
			Vc::paramText('Formulario Historico', 'Historico'),
			Vc::paramText('Formulario credito', 'credito(R$)'),
			Vc::paramText('Formulario debito', 'debito(R$)'),
			Vc::paramText('Formulario Saldo', 'Saldo(R$)'),
			Vc::paramText('Formulario Data', 'Data')


		]);
	}
}