<?php

namespace MisterPrint\Support;

abstract class HttpRequest
{
	protected $url;

	protected $body = [];

	protected $headers = [];

	const TIMEOUT = 90;

	public function post() {

		$temArquivos = false;
		array_walk_recursive(
			$this->body,
			function( $var ) use ( &$temArquivos ) {
				if ( is_object($var) && get_class( $var ) == 'CURLFile') {
					$temArquivos = true;
				}
			}
		);

		if ( $temArquivos ) {

			// initialise the curl request
			$request = curl_init($this->url);

			$headers = [
				'Content-Type: multipart/form-data',
			];
			foreach($this->headers as $key => $header) {
				$headers[] = $key.': '.$header;
			}
			// send a file
			curl_setopt($request, CURLOPT_POST, true);
			curl_setopt($request, CURLOPT_POSTFIELDS, $this->body);
			curl_setopt($request, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($request, CURLOPT_FOLLOWLOCATION, false);

			// output the response
			curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($request);

			$code = curl_getinfo($request, CURLINFO_HTTP_CODE);

			// close the session
			curl_close($request);

			return [
				'body' => $response,
				'response' => [
					'code' => $code,
					'message' => $code
				]
			];
		}

		$args = [
			'timeout' => self::TIMEOUT,
			'headers' => $this->headers,
			'body'    => json_encode( $this->body ),
		];

		return wp_remote_post( $this->url, $args );

	}

	 public function get( $params = [] ) {

		$headers = array_merge([
			'Content-Type' => 'application/json',
			'Accept' => 'application/json'],
			$this->headers
		);

		$args = [
			'headers' => $headers,
			'timeout' => self::TIMEOUT,
		];

		return wp_remote_get(add_query_arg( $params, esc_url_raw( $this->url ) ), $args);
	}

	public function delete() {
		$args = [
			'method'  => 'DELETE',
			'timeout' => self::TIMEOUT,
			'headers' => $this->headers,
			'body'    => json_encode($this->body),
		];

		return wp_remote_request($this->url, $args);
	}

	public function postFile($params = [], $file = []) {
		// initialise the curl request
		$request = curl_init($this->url);

		$headersArray = $this->headers;

		$headersArray['Content-Type'] = 'multipart/form-data';
		$params['codigoEmpresa'] = $this->codEmpresaId;

		$headers = [];
		foreach($headersArray as $key => $header) {
			$headers[] = $key.': '.$header;
		}

		$fileName = realpath($file['tmp_name']);
		$fileSize = $file['size'];

		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$finfo = finfo_file($finfo, $fileName);

		$cFile = new \CURLFile($fileName, $finfo, basename($fileName));

		$params = array_merge($params, [
			'idFranquia' => config("plugin", "franquia"),
			'comprovante' => $cFile
		]);

		// send a file
		curl_setopt($request, CURLOPT_POST, true);
		curl_setopt($request, CURLOPT_POSTFIELDS, $params);
		curl_setopt($request, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($request, CURLOPT_FOLLOWLOCATION, false);

		// output the response
		curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($request);

		$code = curl_getinfo($request, CURLINFO_HTTP_CODE);


		// close the session
		curl_close($request);

		return [
			'body' => json_decode($response, true)
		];
	}

	public function put($url, $body = [], $headers = []) {

		$headers = array_merge([
			'Content-Type' => 'application/json',
			'Accept' => 'application/json'
		], $headers);

		$args = [
			'method'  => 'PUT',
			'timeout' => self::TIMEOUT,
			'headers' => $headers,
			'body'    => json_encode($body),
		];

		$response = wp_remote_request($url, $args);
		$code = wp_remote_retrieve_response_code($response);
		$success = [200, 201];

		if ( ! in_array( $code, $success ) ) {
			throw new \Exception($code . ' - ' . \wp_remote_retrieve_response_message( $response ) );
		}

		return [
			'body'    => json_decode( wp_remote_retrieve_body( $response ), true ),
			'headers' => wp_remote_retrieve_headers( $response )
		];
	}
}
