<?php

namespace MisterPrint\BO;

use MisterPrint\Request;
use MisterPrint\Response\CelularExistsResponse;
use MisterPrint\Response\CepResponse;
use MisterPrint\Response\ClientInfoResponse;
use MisterPrint\Response\ClosestFreightResponse;
use MisterPrint\Response\CreditResponse;
use MisterPrint\Response\EmailExistsResponse;
use MisterPrint\Response\SubscriptionResponse;
use MisterPrint\Response\ValidateCellPhoneResponse;
use MisterPrint\Response\ShippingGetAddressResponse;
use MisterPrint\Response\ShippingEditAddressResponse;
use MisterPrint\Response\ShippingAddAddressResponse;
use MisterPrint\Response\ShippingDellAddressResponse;
use Illuminate\Support\Facades\Config;

/**
 * Função para obter o valor de um cookie pelo nome.
 *
 * @param string $name Nome do cookie.
 * @return string Valor do cookie.
 */

require_once 'FranquiaUtil.php';


function getCookie($name)
{
	return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
}

class Cliente
{
	protected $message;
	protected $data;

	public function get_message()
	{
		return $this->message;
	}

	public function get_data()
	{
		return $this->data;
	}

	public function verifica_email_existente($email)
	{
		$data = ['email' => $email];

		$request = new Request('cliente/verifica-email-existente', $data);
		$response = new EmailExistsResponse($request->get());

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function verifica_celular_existente($number)
	{
		$data = ['celular' => $number];
		$request = new Request('cliente/verifica-celular-existente', $data);
		$response = new CelularExistsResponse($request->post());

		if (!$response->is_positive()) {
			return false;
		}

		return true;
	}

	public function salva_favorito($data)
	{
		$data['idFranquia'] = FranquiaUtil::getIdFranquia();
		$request = new Request('cliente/salvar-favorito', $data);
		$response = new CelularExistsResponse($request->post());
		return $response->body['success'];
	}

	public function buscar_favoritos()
	{
		$data = [
			'codigoCliente' => user()->getId(),
			'idFranquia' => FranquiaUtil::getIdFranquia(),
		];
		$request = new Request('cliente/buscar-favoritos', $data);
		$response = $request->post();

		$result = $response['body'];

		return $result;
	}

	public function remove_favorito($data)
	{
		$data['idFranquia'] = FranquiaUtil::getIdFranquia();
		$request = new Request('cliente/remover-favorito', $data);
		$response = new CelularExistsResponse($request->post());
		return $response->body['success'];
	}

	public function valida_celular_com_sms($cell_phone, $email)
	{
		$data = [
			'celular' => $cell_phone,
			'email' => $email,
			'idFranquia' => FranquiaUtil::getIdFranquia(),
		];

		$request = new Request('cliente/valida-celular-com-sms', $data);
		$response = new ValidateCellPhoneResponse($request->post());

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function get_dados_do_cliente($client_id)
	{

		if (!$client_id) {
			return false;
		}

		$data = ['codigoCliente' => $client_id];

		$request = new Request('cliente/get-dados-do-cliente');
		$response = new ClientInfoResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		// Grava a informação
		$result = $response->get_data();

		if (isset($result['dadosCliente']['franquia_id'])) {
			$dadoCli = $result['dadosCliente']['franquia_id'];

			$_SESSION['app_franquia'] = $dadoCli;
		}

		// Grava por meia hora
		//set_transient($transient_key, $result, 10 * MINUTE_IN_SECONDS);

		return $result;
	}

	public function get_conta_corrente_do_cliente($client_id)
	{

		if (!$client_id) {
			return false;
		}

		$data = [
			'codigoCliente' => $client_id,
			'idFranquia' => FranquiaUtil::getIdFranquia(),
		];

		$request = new Request('cliente/get-conta-corrente-do-cliente');
		$response = new CreditResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}
		return $response->get_data();
	}

	public function editar_dados_do_cliente($data)
	{
		$oldData['customers_cnpj'] = '00.000.000/0000-00';
		$data['cnpj'] = str_replace('.', '', $data['cnpj']);
		$data['cnpj'] = str_replace(',', '', $data['cnpj']);
		$data['cnpj'] = str_replace('/', '', $data['cnpj']);
		$data['cnpj'] = str_replace('-', '', $data['cnpj']);
		if (empty($data['cnpj'])) {
			$data['cnpj'] = null;
		}

		$data['telefone'] = $output = preg_replace('/[^0-9]/', '', $data['telefone']);
		$data['celular'] = $output = preg_replace('/[^0-9]/', '', $data['celular']);

		$oldData = $this->get_dados_do_cliente(user()->getId());
		$oldData['codigoCliente'] = user()->getId();
		$oldData['dadosCliente']['franquia_id'] = FranquiaUtil::getIdFranquia();
		$oldData['dadosCliente']['customers_firstname'] = $data['name'];
		$oldData['dadosCliente']['customers_lastname'] = $data['apelido'];
		$oldData['dadosCliente']['customers_cpf_cnpj'] = $data['emitir_nota_como'];
		$oldData['dadosCliente']['customers_cnpj'] = $data['cnpj'];
		$oldData['dadosCliente']['customers_company'] = $data['razao-social'];
		$oldData['dadosCliente']['customers_telephone'] = $data['telephone'];
		$oldData['dadosCliente']['customers_celular'] = $data['celular'];
		$oldData['dadosCliente']['customers_dob'] = $data['nascimento'];
		$oldData['dadosCliente']['customers_gender'] = strtolower($data['sexo']);
		$oldData['dadosEndereco']['entry_postcode'] = $data['cep'];
		$oldData['dadosEndereco']['entry_state'] = $data['state'];
		$oldData['dadosEndereco']['entry_city'] = $data['city'];
		$oldData['dadosEndereco']['entry_suburb'] = $data['neighborhood'];
		$oldData['dadosEndereco']['entry_street_address'] = $data['street'];
		$oldData['dadosEndereco']['entry_street_number'] = $data['number'] == null ? "SN" : $data['number'];
		$oldData['dadosEndereco']['complemento'] = $data['complement'];


		// Classificação
		$oldData['dadosCliente']['customers_software'] = $data['info-software'];
		$oldData['dadosCliente']['customers_consumo'] = $data['info-faturamento'];
		$oldData['dadosCliente']['customers_has_physical_store'] = $data['info-loja-fisica'];
		$oldData['dadosCliente']['customers_final'] = $data['info-uso'];
		$oldData['dadosCliente']['customers_occupation'] = $data['ocupacao'];
		$oldData['dadosCliente']['customers_activity'] = $data['area_atuacao'];
		$oldData['dadosCliente']['company_position_id'] = $data['cargo'];
		$oldData['dadosCliente']['company_department_id'] = $data['departamento'];

		$oldData['dadosEmpresa'] = $oldData['dadosEmpresa'][0];
		$oldData['dadosEmpresa']["qtd_funcionarios"] = $data['info-funcionarios'];

		if ($data['password']) {
			$oldData['dadosCliente']['customers_password'] = $data['password'];
		}

		delete_transient('mp_dados_cliente_' . ($oldData['codigoCliente']));

		$request = new Request('cliente/editar', $oldData);
		$response = new ClientInfoResponse($request->post());
		$response->data = $oldData;
		return $response;

		if (!$response->is_positive()) {
			return false;
		}

		return true;
	}

	public function get_dados_de_cobranca_cliente($client_id)
	{
		$data = [
			'codigoCliente' => $client_id,
			'idFranquia' => FranquiaUtil::getIdFranquia(),
		];

		$request = new Request('cliente/get-dados-de-cobranca-cliente');
		$response = new ClienteBillingDataResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function verifica_frete_mais_proximo($cep)
	{
		$data = [
			'cep' => $cep,
			'idFranquia' => FranquiaUtil::getIdFranquia(),
		];
		$request = new Request('cliente/verifica-frete-mais-proximo', $data);
		$response = new ClosestFreightResponse($request->post());

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}


	public function salvar_cadastro_incompleto($data)
	{
		$data['idFranquia'] = FranquiaUtil::getIdFranquia();
		$request = new Request('cliente/registrar-cadastro-incompleto', $data);

		$response = new SubscriptionResponse($request->post());
		if (!$response->is_positive()) {
			$this->message = $response->get_message('Não foi possível realizar o cadastro.');
			return false;
		}

		$this->message = $response->get_message('Cadastro inserido com sucesso.');
		$this->data = $response->get_data();

		return true;
	}

	public function salvar_cadastro_completo($data)
	{
		//Validação da Abrangência do Franquiado
		//if (getCookie('abrangencia_relacionado') == 0) {
		if (isset($_COOKIE['abrangencia_relacionado'])) {
			$data['idFranquia'] = getCookie('abrangencia_franquia');
			$data['abrangencia_relacionado'] = "0";
			$data['abrangencia_lat'] = getCookie('abrangencia_lat');
			$data['abrangencia_long'] = getCookie('abrangencia_long');
		}
		else{
			$data['idFranquia'] = FranquiaUtil::getIdFranquia();
		}

		$data['facebook_id'] = ($_SESSION['cadastroSocial'] === 'F') ? $_SESSION['userData_face']['id'] : null;
		$data['google_id'] = ($_SESSION['cadastroSocial'] === 'G') ? $_SESSION['userData_google']['sub'] : null;

		$request = new Request('cliente/registrar-cadastro', $data);
		$response = new SubscriptionResponse($request->post());

		if (!$response->is_positive()) {
			$this->message = $response->get_message('Não foi possível realizar o cadastro.');
			return false;
		}

		$this->message = $response->get_message('Cadastro inserido com sucesso.');
		$this->data = $response->get_data();
		session_start();
		$_SESSION['cadastroSocial'] = null;
		$_SESSION['credential_google'] = null;
		$_SESSION['userData_google'] = null;
		$_SESSION['access_token_face'] = null;
		$_SESSION['userData_face'] = null;
		return true;
	}

	public function get_endereco_entrega_do_cliente($client_id)
	{
		$data = [
			'codigoCliente' => $client_id,
			'idFranquia' => FranquiaUtil::getIdFranquia(),
		];
		$request = new Request('cliente/get-endereco-entrega-do-cliente');
		$response = new ShippingGetAddressResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function get_endereco_entrega_selecionado($client_id)
	{
		$data = [
			'codigoCliente' => $client_id,
			'idFranquia' => FranquiaUtil::getIdFranquia(),
		];
		$request = new Request('cliente/get-endereco-entrega-selecionado');
		$response = new ShippingGetAddressResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}

		return $response->get_data();
	}

	public function get_endereco_do_cliente($client_id)
	{
		$data = [
			'codigoCliente' => $client_id,
			'idFranquia' => FranquiaUtil::getIdFranquia(),
		];
		$request = new Request('cliente/get-endereco-do-cliente');
		$response = new ShippingGetAddressResponse($request->get($data));

		if (!$response->is_positive()) {
			return false;
		}
		return $response->get_data();
	}

	public function editar_endereco_de_entrega($data)
	{
		$data['codigoCliente'] = user()->getId();
		$data['codigoEnd'] = $data['id'];
		$data['idFranquia'] = FranquiaUtil::getIdFranquia();
		$request = new Request('cliente/editar-endereco-de-entrega', $data);
		$response = new ShippingEditAddressResponse($request->post());

		if (!$response->is_positive()) {
			$this->message = $response->get_message('Não foi possível editar o endereço.');
			return false;
		}

		$this->message = $response->get_message('Endereço editado com sucesso.');
		$this->data = $response->get_data();

		return true;
	}

	public function criar_endereco_de_entrega($data)
	{
		$data['codigoCliente'] = user()->getId();
		$data['idFranquia'] = FranquiaUtil::getIdFranquia();
		$request = new Request('cliente/criar-endereco-de-entrega', $data);
		$response = new ShippingAddAddressResponse($request->post());
		if (!$response->is_positive()) {
			$this->message = $response->get_message('Não foi possível adicionar o endereço.');
			return false;
		}

		$this->message = $response->get_message('Endereço adicionado com sucesso.');
		$this->data = $response->get_data();

		return true;
	}

	public function remover_endereco_de_entrega($data)
	{
		$data['codigoCliente'] = user()->getId();
		$data['codigoEnd'] = (int) $data['codigoEnd'];
		$data['idFranquia'] = FranquiaUtil::getIdFranquia();
		$request = new Request('cliente/remover-endereco-de-entrega', $data);
		$response = new ShippingDellAddressResponse($request->delete());
		return true;
	}

	public function login($data)
	{
		$request = new Request('user/login', $data);
		$response = new LoginResponse($request->post());

		if (!$response->is_positive()) {
			$this->message = $response->get_message('Email/Senha inválidos.');
			return false;
		}

		$this->message = $response->get_message('Login realizado com sucesso.');
		$this->data = $response->get_data();

		return true;
	}

	public function auto_completar_endereco($data)
	{
		$data['idFranquia'] = FranquiaUtil::getIdFranquia();
		$request = new Request('cliente/auto-completar-endereco', $data);
		$response = new CepResponse($request->post());
		return $response->get_data();
	}

	public function get_saldo($client_id)
	{
		$data = [
			'codigoCliente' => $client_id,
			'idFranquia' => FranquiaUtil::getIdFranquia(),
		];
		$request = new Request('conta-corrente/get-saldo');
		$response = new CreditResponse($request->get($data));
		return $response->get_data();
	}

	public function validar_Abrangencia_Franquia($client_id)
	{
		if ($client_id === null || $client_id === '') {
			// Não faz nada e retorna true, indicando que a função foi "bem-sucedida"
			return true;
		}

		if (getCookie('abrangencia_relacionado') == 0) {
			$abrangencia = [];
			$abrangencia['customers_id'] = $client_id;
			$abrangencia['abrangencia_cep'] = getCookie('abrangencia_cep');
			$abrangencia['abrangencia_lat'] = getCookie('abrangencia_lat');
			$abrangencia['abrangencia_long'] = getCookie('abrangencia_long');
			$abrangencia['abrangencia_franquia'] = getCookie('abrangencia_franquia');
			$abrangencia['abrangencia_relacionado'] = getCookie('abrangencia_relacionado');

			if (
				$abrangencia['abrangencia_cep'] === null ||
				$abrangencia['abrangencia_lat'] === null ||
				$abrangencia['abrangencia_long'] === null ||
				$abrangencia['abrangencia_franquia'] === null
			) {
				return true;
			}

			if (
				$abrangencia['abrangencia_relacionado'] === "0" ||
				$abrangencia['abrangencia_relacionado'] === null
			) {
				$request = new Request('cliente/validar-Abrangencia-Franquia', $abrangencia);
				$response = new SubscriptionResponse($request->post());

				if (!$response->is_positive()) {
					$this->message = $response->get_message('Não foi possível realizar a verificação do cadastro.');
					return false;
				}
				$this->message = $response->get_message('Verificação realizada com sucesso.');
				$this->data = $response->get_data();

			}
		}
		return true;
	}
}
