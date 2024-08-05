<?php
namespace MisterPrint\BO;

use MisterPrint\Request;
use MisterPrint\Response\LoginResponse;
use MisterPrint\Support\SessionSupport;
use MisterPrint\Helper\Url;

class User
{
	protected $message;
	protected $data;

	/**
	 * @return string
	 */
	public function get_message()
	{
		return $this->message;
	}

	/**
	 * @return array
	 */
	public function get_data()
	{
		return $this->data;
	}

	public function get_is_balcony()
	{
		$request = new Request('user/get-is-balcony', [
			'local_url' => $_SERVER['REMOTE_ADDR'],
			'dominio'    => Url::getSubdomain()
		]);
		$requestBody = $request->post()['body'] == "1" ? true : false;
		return $requestBody;
	}
	/**
	 * @return number
	 */
	public function get_orders_quant()
	{
		$data = [
			'user_id' => user()->getId()
		];

		$request = new Request('user/get-orders-quant', $data);
		$requestBody = $request->post()['body'];
		$requestValue1 = explode(":", $requestBody);
		$requestValueFinal = (int) $requestValue1[1][0];
		if (isset($request->post()['error'])) {
			return [
				'quantidade' => 1000,
				'message' => 'Não foi possível realizar a consulta'
			];
		}

		return [
			'quantidade' => $requestValueFinal
		];
	}

	/**
	 * @return bool
	 */
	public function login($email, $senha)
	{

		$data = [
			'email' => $email,
			'senha' => $senha
		];

		$request = new Request('user/login', $data);
		$response = new LoginResponse($request->post());


		if (!$response->is_positive()) {
			return [
				'id' => false,
				'message' => $response->get_message('Email/Senha inválidos.')
			];
		}

		return [
			'id' => $response->get_id(),
		];
	}

	/**
	 * @return bool
	 */
	public function loginFacebook($facebookId)
	{
		$data = [
			'facebook_id' => $facebookId
		];

		$request = new Request('user/loginFacebook', $data);
		$response = new LoginResponse($request->post());

		if (!isset($response->body['login']) || !$response->body['login']) {
			return [
				'id' => false,
				'message' => isset($response->body['message']) ? $response->body['message'] : 'Erro ao efetuar login via Facebook.'
			];
		}
		return [
			'id' => $response->body['id']
		];
	}

	/**
	 * @return bool
	 */
	public function loginGoogle($googleId)
	{
		$data = [
			'google_id' => $googleId
		];

		$request = new Request('user/loginGoogle', $data);
		$response = new LoginResponse($request->post());

		session_start();
		$_SESSION['permissionG'] = null;
		if (!isset($response->body['login']) || !$response->body['login']) {
			return [
				'id' => false,
				'message' => isset($response->body['message']) ? $response->body['message'] : 'Erro ao efetuar login via Google.'
			];
		}
		$_SESSION['permissionG'] = 'G';
		return [
			'id' => $response->body['id']
		];
	}



	/**
	 * @return bool
	 */
	public function funcionaryLogin($emailFuncionario, $senha, $usuarioCliente)
	{

		$data = [
			'email-funcionario' => $emailFuncionario,
			'senha-funcionario' => $senha,
			'login-cliente' => $usuarioCliente
		];

		$request = new Request('user/login-funcionario', $data);
		$response = new LoginResponse($request->post());


		if (!$response->is_positive()) {
			return [
				'id' => false,
				'message' => $response->get_message('Não foi possível realizar o login')
			];
		}

		return $response->get_data();
	}
}
