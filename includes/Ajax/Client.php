<?php

namespace MisterPrint\Ajax;

use MisterPrint\BO\Cliente;
use MisterPrint\Helper\User;

class Client extends Ajax
{

	private $client;
	private $expects;
	private $data = [];
	private $codigoEndereco;

	public function init()
	{
		$this->client           = new Cliente();
		$this->expects          = isset($_POST['expects']) ? $_POST['expects'] : false;
		$this->codigoEndereco   = isset($_POST['codigoEnd']) ? $_POST['codigoEnd'] : false;

		$this->data = [
			'codigoCliente'     => User::getId(),
			'rua'               => isset($_POST['rua']) ? $_POST['rua'] : false,
			'numero'            => isset($_POST['numero']) ? $_POST['numero'] : false,
			'cep'               => isset($_POST['cep']) ? $_POST['cep'] : false,
			'bairro'            => isset($_POST['bairro']) ? $_POST['bairro'] : false,
			'cidade'            => isset($_POST['cidade']) ? $_POST['cidade'] : false,
			'estado'            => isset($_POST['estado']) ? $_POST['estado'] : false,
			'pais'              => isset($_POST['pais']) ? $_POST['pais'] : false,
			'telefone'          => isset($_POST['telefone']) ? $_POST['telefone'] : false,
		];
	}

	public function handle()
	{

		$this->init();
		$shipping_address = false;
		$dados_do_cliente = $this->client->get_dados_do_cliente(User::getId());

		switch ($this->expects) {

			case 'add':
				$shipping_address = $this->client->criar_endereco_de_entrega($this->data);
				break;

			case 'get':
				$shipping_address = array_map(function ($adresses) use (&$dados_do_cliente) {
					return array_merge($adresses, ['client' => $dados_do_cliente['dadosCliente']['customers_firstname']]);
				}, $this->client->get_endereco_entrega_do_cliente(User::getId()));
				break;

			case 'edit':
				$this->data["codigoEnd"] = $this->codigoEndereco;
				$shipping_address = $this->client->editar_endereco_de_entrega($this->data);
				break;

			case 'del':
				$this->data = [];
				$this->data['codigoCliente'] = User::getId();
				$this->data["codigoEnd"] = $this->codigoEndereco;
				$shipping_address = $this->client->remover_endereco_de_entrega($this->data);
				break;
		}

		return $shipping_address;

	}
}
