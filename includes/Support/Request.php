<?php

namespace MisterPrint\Support;

use MisterPrint\Helper\Url;

class Request extends HttpRequest
{
	const COD_EMPRESA = 'codigoEmpresa';
	protected $codEmpresaId;

	public function __construct($method, $body = [], $headers = [], $base_url = null)
	{
		if ($base_url === null) {
			$base_url = config('plugin', 'api') ?: 'http://localhost:8000/v3/';
		}
		$this->url = $base_url . $method;

		//pegando id de empresa no bd
		global $wpdb;
		$id = preg_replace('/\D+/', '', $wpdb->prefix);
		$this->codEmpresaId = $id == "" ? 1 : intval($id);

		$this->body = array_merge([
			self::COD_EMPRESA => $this->codEmpresaId,
			'idFranquia' => isset($_SESSION['app_franquia']) ? $_SESSION['app_franquia'] : config("app", "franquia"),
			'session_id'   => uniqid(),
			'date'         => current_time('Y-m-d H:i:s'),
			'remote_addr'  => $_SERVER['REMOTE_ADDR'],
			'subdomain'    => Url::getSubdomain(),
		], $body);

		$funcionario = \MisterPrint\Support\SessionSupport::get('login-funcionario');
		if ($funcionario) {
			$this->body['funcionary'] = $funcionario['email'];
		}

		$this->headers = array_merge([
			'Content-Type'  => 'application/json',
			'Accept'        => 'application/json',
			'User-Agent'    => $_SERVER['HTTP_HOST'],
			'Authorization' => 'Basic ' . base64_encode(config('credentials', 'email') . ':' . config('credentials', 'password')),
		], $headers);
	}

	public function get($params = [])
	{
		if (!isset($params[self::COD_EMPRESA])) {
			$params[self::COD_EMPRESA] = $this->codEmpresaId;
		}

		$params = array_merge($this->body, $params);

		// Starting clock time in seconds
		$start_time = microtime(true);

		$request = parent::get($params);
		$this->log($this->getLogData($request, $params, microtime(true) - $start_time));
		return $request;
	}

	public function post($params = [])
	{
		if (!isset($params[self::COD_EMPRESA])) {
			$params[self::COD_EMPRESA] = $this->codEmpresaId;
		}

		$params = array_merge($this->body, $params);

		// Starting clock time in seconds
		$start_time = microtime(true);

		$request = parent::post($params);
		$this->log($this->getLogData($request, $params, microtime(true) - $start_time));
		return $request;
	}

	public function getLogData($request, $params, $timeInSeconds)
	{
		$request = json_decode(json_encode($request), true);

		return [
			'url' => $this->url,
			'status' => $request['response']['code'],
			'time' => $timeInSeconds . 's',
			'params' => $params,
			'body' => $request['body'],
		];
	}


	public function log($data)
	{
		if (config('plugin', 'debug') == false) {
			return;
		}
		$ips = config('plugin', 'debug.log_request_ips');
		if ($ips !== true && !in_array($_SERVER['REMOTE_ADDR'], $ips)) {
			return;
		}
		$file = __DIR__ . '/../../request.json';
		$log = json_decode(file_get_contents($file), true);
		if (!is_array($log)) {
			$log = [];
		}
		$serverTime = date('m/d h:i:s.u', $_SERVER['REQUEST_TIME_FLOAT']);
		if (!isset($log[$serverTime])) {
			$log[$serverTime] = [
				// '$_SERVER' => $_SERVER,
				'REQUEST' => [
					'SERVER' => "{$_SERVER['REQUEST_METHOD']} {$_SERVER['SERVER_NAME']}{$_SERVER['REQUEST_URI']}",
					'post' => $_POST,
					'get' => $_GET,
				],
				'requests' => []
			];
			unset($log[$serverTime]['REQUEST']['post']['params']);
			krsort($log);
		}
		array_unshift($log[$serverTime]['requests'], $data);
		file_put_contents($file, json_encode($log, JSON_PRETTY_PRINT));
	}

	public function getFranquiaIdFromAPI($codEmpresaId)
	{
		try {
			$franquia_id = 1;
			if (!is_null($codEmpresaId)) {
				$endpoint = 'get-FranquiaId-cliente'; 
				$url = "cliente/$endpoint?codEmpresaId=$codEmpresaId";

				$request = new HttpRequest();
				$response = $request->get($url);	

				if (is_string($response)) {
					$data = json_decode($response, true);
					$franquia_id = isset($data['response']) ? $data['response'] : 1;
				} else {
					throw new \Exception('A resposta da API não é uma string válida.');
				}
			}
		} catch (\Exception $e) {
			$franquia_id = 1;
		}

		return $franquia_id;
	}
}
