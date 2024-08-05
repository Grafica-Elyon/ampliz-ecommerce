<?php
namespace MisterPrint\Ajax;

use MisterPrint\BO\Cliente;

class CadastroIncompleto extends Ajax
{
	private $client;
	private $expects;
	private $data = [];

	public function init()
	{
		$this->client       = new Cliente();

		$this->expects      = isset($_POST['expects']) ? $_POST['expects'] : false;
		$this->data = [
			'nome'          => isset($_POST['nome']) ? $_POST['nome'] : false,
			'email'         => isset($_POST['email']) ? $_POST['email'] : false,
			'telefone'      => isset($_POST['telefone']) ? $_POST['telefone'] : false,
			'profissao'     => isset($_POST['profissao']) ? $_POST['profissao'] : false,
			'cep'           => isset($_POST['cep']) ? $_POST['cep'] : false,
			'comoConheceu'  => isset($_POST['comoConheceu']) ? $_POST['comoConheceu'] : false,
		];

	}

	public function handle()
	{
		$this->init();
		$ajax_return = 'handle';

		switch ($this->expects) {
			case 'add':
				$ajax_return = $this->client->salvar_cadastro_incompleto($this->data);
				break;
		}

		return $ajax_return;
	}

}
