<?php

namespace MisterPrint\Components;

use MisterPrint\BO\Cliente;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;

class PanelData extends PanelComponent
{
	protected $name = 'Painel de dados do usuário';
	protected $description = 'Painel com os dados do usuário';
	protected $base = 'vc_mp_panel_data';

	public function render()
	{
		$data['params'] = $this->getParamsAjax();
		$data['params']['formulario_como_conheceu'] = \MisterPrint\Response\CustomerReferers::get();
		$data['params']['formulario_atuacao_valores'] = \MisterPrint\Response\CustomerActivities::get();
		$data['params']['formulario_ocupacoes_valores'] = \MisterPrint\Response\CustomerOccupations::get();
		$data['params']['formulario_cargos_valores'] = \MisterPrint\Response\CustomerPositions::get();
		$data['params']['formulario_depatamentos_valores'] = \MisterPrint\Response\CustomerDepartments::get();
		$data['params']['formulario_ramos_atividades_valores'] = \MisterPrint\Response\CustomerBusinessSectors::get();
		return (new View('user/panel-data', [
			'params' => $data['params'],
		]))->get();
	}

	public static function get_data()
	{
		return function () {
			$user = new Cliente();
			return $user->get_dados_do_cliente(user()->getId());
		};
	}

	public static function edit_data()
	{
		return function () {
			$user = new Cliente();
			$data = array_reduce($_POST['data'], function ($prev, $field) {
				$prev[$field['name']] = $field['value'];
				return $prev;
			}, []);
			$data['nascimento'] = implode('-', array_reverse(explode('/', $data['nascimento'])));
			return $user->editar_dados_do_cliente($data);
		};
	}

	public function setParams()
	{
		parent::setParams();
		$this->addParams([
			Vc::paramText('Titulo painel', 'Meus dados'),
			Vc::paramText('Formulario nome social', 'Nome Social / Apelido'),
			Vc::paramText('Formulario nome', 'Nome'),
			Vc::paramText('Formulario CPF', 'CPF'),
			Vc::paramText('Formulario telefone', 'Telefone'),
			Vc::paramText('Formulario celular', 'Celular'),
			Vc::paramText('Formulario email', 'E-mail'),
			Vc::paramText('Formulario senha', 'Senha'),
			Vc::paramText('Formulario senha confirmação', 'Confirmar senha'),
			Vc::paramText('Formulario dados endereço', 'Dados de endereço'),
			Vc::paramText('Formulario rua', 'Rua'),
			Vc::paramText('Formulario bairro', 'Bairro'),
			Vc::paramText('Formulario CEP', 'CEP'),
			Vc::paramText('Formulario numero', 'Numero'),
			Vc::paramText('Formulario complemento', 'Complemento'),
			Vc::paramText('Formulario estado', 'Estado'),
			Vc::paramText('Formulario cidade', 'Cidade'),
			Vc::paramText('Botão alterar dados', 'Alterar meus dados'),
			Vc::paramText('Formulario dados empresa', 'Dados de empresa'),
			Vc::paramText('Formulario nome razao social', 'Razao Social/Nome'),
			Vc::paramText('Formulario cnpj', 'CNPJ'),
			Vc::paramText('Formulario nascimento', 'Data de Nascimento'),
			Vc::paramText('Formulario emitir nota como', 'Dados para emissão de Nota Fiscal'),
			Vc::paramText('Formulario emitir nota cpf', 'Pessoa Física'),
			Vc::paramText('Formulario emitir nota cnpj', 'Pessoa Jurídica'),
			Vc::paramText('Formulario sexo', 'Sexo'),
			Vc::paramText('Formulario sexo masculino', 'Masulino'),
			Vc::paramText('Formulario sexo feminino', 'Feminino'),
			Vc::paramText('Formulario sexo outros', 'Outros'),
			Vc::paramText('Formulario prefiro nao dizer', 'Prefiro não dizer'),
			Vc::paramText('Formulario info software valores', 'Creative Cloud (Adobe);CorelDraw;Afinnity;Outros'),
			Vc::paramText('Formulario info referrer', 'Onde nos conheceu?'),
			Vc::paramText('Formulario info referrer placeholder', 'Selecione uma opção'),
			Vc::paramText('Formulario ocupacao', 'Ocupação'),
			Vc::paramText('Formulario ocupacao placeholder', ''),
			Vc::paramText('Formulario area atuacao', 'Área de Atuação'),
			Vc::paramText('Formulario area atuacao placeholder', ''),
			Vc::paramText('Formulario cargo', 'Cargo'),
			Vc::paramText('Formulario departamento', 'Departamento'),

		]);
	}
}
