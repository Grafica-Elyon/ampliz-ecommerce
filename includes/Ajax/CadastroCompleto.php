<?php
namespace MisterPrint\Ajax;

use MisterPrint\BO\Cliente;

class CadastroCompleto extends Ajax
{
	private $client;
	private $expects;
	private $data = [];

	public function init()
	{
		$this->client       = new Cliente();
		$this->expects      = isset($_POST['expects']) ? $_POST['expects'] : false;

		$this->data = [
			'dadosCliente' => [
				'customers_recadastro'              => 1,
						'customers_agree'           => 1,
				'customers_agree_notfinal'          => 1,
						'customers_firstname'       => isset($_POST['customers_firstname']) ? $_POST['customers_firstname'] : false,
						'customers_email_address'   => isset($_POST['customers_email_address']) ? $_POST['customers_email_address'] : false,
						'customers_celular'         => isset($_POST['customers_celular']) ? preg_replace('/[^\d]/', '', $_POST['customers_celular']) : false,
						'customers_password'        => isset($_POST['customers_password']) ? $_POST['customers_password'] : false,
						'customers_conheceu'        => isset($_POST['customers_conheceu']) ? $_POST['customers_conheceu'] : false,
						'customers_obs'             => isset($_POST['customers_obs']) ? $_POST['customers_obs'] : false,
						'customers_loja'            => isset($_POST['customers_loja']) ? $_POST['customers_loja'] : false,
				'customers_bloqueado'               => '0',
				'customers_novo'                    => '1',
						'customers_company'         => isset($_POST['entry_company']) ? $_POST['entry_company'] : false,
						'customers_gender'          => isset($_POST['entry_gender']) ? $_POST['entry_gender'] : false,
						'customers_dob'             => isset($_POST['customers_dob']) ? date("Y-m-d", $_POST['customers_dob']) . ' 00:00:00' : false,
						'customers_telephone'       => isset($_POST['customers_telephone']) ? preg_replace('/[^\d]/', '', $_POST['customers_telephone']) : false,
						'customers_newsletter'      => isset($_POST['email_newsletter']) ? $_POST['email_newsletter']: false,
				'customers_cpf_cnpj'                => '30405592817',
						'customers_cpf'             => isset($_POST['entry_cpf']) ? $_POST['entry_cpf'] : false,
						'customers_cnpj'            => isset($_POST['entry_cnpj']) ? $_POST['entry_cnpj'] : false,
				'customers_ie'                      => 'teste',
				'customers_regiao'                  => 'T.',
				'customers_preference'              => 'test',
				'customers_lat'                     => '-163557994',
				'customers_long'                    => '-907882716',
				'is_incompleto'                     => 1,
				'customers_subdominio'              => 'Mister',
				'customers_descricao'               => 'Perferendis quo corrupti rerum ut sint.'
			],
			'dadosEndereco' => [
				'entry_firstname'                   => isset($_POST['customers_firstname']) ? $_POST['customers_firstname'] : false,
						'entry_postcode'            => isset($_POST['entry_postcode']) ? $_POST['entry_postcode'] : false,
				'entry_country_id'                  => '+55',
						'entry_gender'              => isset($_POST['entry_gender']) ? $_POST['entry_gender'] : false,
						'entry_company'             => isset($_POST['entry_company']) ? $_POST['entry_company'] : false,
						'entry_street_address'      => isset($_POST['entry_street_address']) ? $_POST['entry_street_address'] : false,
						'entry_street_number'       => isset($_POST['entry_street_number']) ? $_POST['entry_street_number'] : false,
						'entry_suburb'              => isset($_POST['entry_suburb']) ? $_POST['entry_suburb'] : false,
						'entry_city'                => isset($_POST['entry_city']) ? $_POST['entry_city'] : false,
						'entry_state'               => isset($_POST['entry_state']) ? $_POST['entry_state'] : false,
				'entry_zone_id'                     => -3,
				'entry_cpf_cnpj'                    => '30405592817',
						'entry_cpf'                 => isset($_POST['entry_cpf']) ? $_POST['entry_cpf'] : false,
						'entry_cnpj'                => isset($_POST['entry_cnpj']) ? $_POST['entry_cnpj'] : false,
				'entry_ie'                          => 'teste',
						'entry_rg'                  => isset($_POST['entry_rg']) ? $_POST['entry_rg'] : false,
				'entry_city_id'                     => 0
			],
			'dadosComunicacao' => [
						'celular'                   => isset($_POST['celular']) ? preg_replace('/[^\d]/', '', $_POST['celular']) : false,
						'telefone'                  => isset($_POST['telefone']) ? preg_replace('/[^\d]/', '', $_POST['telefone']) : false,
						'aparelho'                  => isset($_POST['aparelho']) ? $_POST['aparelho'] : false,
						'operadora'                 => isset($_POST['operadora']) ? $_POST['operadora'] : false,
						'facebook'                  => isset($_POST['facebook']) ? $_POST['facebook'] : false,
						'twitter'                   => isset($_POST['twitter']) ? $_POST['twitter'] : false,
						'skype'                     => isset($_POST['skype']) ? $_POST['skype'] : false,
						'email_newsletter'          => isset($_POST['email_newsletter']) ? ($_POST['email_newsletter'] === 1 ? $_POST['email_newsletter'] : ''): false,
				'influencia'                        => 'teste'
			],
			'dadosEmpresa' => [
						'profissao'                 => isset($_POST['profissao']) ? $_POST['profissao'] : false,
						'cargo'                     => isset($_POST['cargo']) ? $_POST['cargo'] : false,
						'atividade'                 => isset($_POST['atividade']) ? $_POST['atividade'] : false,
						'qtd_funcionarios'          => isset($_POST['qtd_funcionarios']) ? $_POST['qtd_funcionarios'] : false,
						'e_commerce'                => 'teste',
						'isencao'                   => 0
			]
		];
	}
	public function handle()
	{
		$this->init();
		$ajax_return = 'handle';

		switch ($this->expects) {
			case 'add':
				$ajax_return = $this->client->salvar_cadastro_completo($this->data);
				break;
		}
		return $ajax_return;
	}

}
