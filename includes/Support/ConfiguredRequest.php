<?php
namespace MisterPrint\Support;

use MisterPrint\Response\Response;
use MisterPrint\Request;

class ConfiguredRequest extends Response
{
	protected static $transient_key  = null;
	protected static $transient_time = null;

	protected static $request_url    = null;
	protected static $request_method = null;

	public const REQUEST_METHOD_GET  = 'get';
	public const REQUEST_METHOD_POST = 'post';

	private const TROW_ERROR_ON_FAIL = false;

	public static function get( $data = [], $forceRequest = false, $attempts = 0 )
	{
		// Caso não seja uma requisição forçada, tenta pegar o valor em cache
		if ( !$forceRequest && static::$transient_key && static::$transient_time ) {
			// Pega o valor
			$storedValue = get_transient(static::$transient_key);
			// Verifica que se é valido e o retorna
			if ( $storedValue ) {
				return $storedValue;
			}
		}

		// Para iniciar a requisição, cria uma nova instancia do próprio objeto
		$instance = new static( $data );

		// Verifica se a requisição foi conclulida com sucesso
		if ( $instance->is_positive() ) {
			// Coleta a resposta
			$data = $instance->get_data();
			// Armazena em cache
			if ( static::$transient_key && static::$transient_time ) {
				set_transient(static::$transient_key, $data,  static::$transient_time);
			}
			// Retorna para o cliente
			return $data;
		}
		else {
			// Caso não seja bem sucedida e uma requisição forçada, coleta do cache
			if ( $forceRequest && static::$transient_key && static::$transient_time ) {
				$storedValue = get_transient(static::$transient_key);
				if ( $storedValue ) {
					return $storedValue;
				}
			}
		}

		// Caso não funcione, verifica se precisa tentar novamente
		if ( $attempts ) {
			return static::get( $forceRequest, $attempts-1 );
		}

		// Caso nada funcione, gera um erro ou retorna vazio
		if ( self::TROW_ERROR_ON_FAIL ) {
			throw new \Exception("Error Processing Request", 1);
		}
		else {
			return false;
		}
	}

	public function __construct( $data = [] )
	{
		// Caso não configurado a url de
		if ( static::$request_url === null ) {
			throw new \Exception("Error While Configuring Request: url", 1);
		}

		// Cria a requisição
		$request = new Request( static::$request_url, $data );

		// Realiza a requisição de acordo com o metodo feito
		switch (static::$request_method) {
			case self::REQUEST_METHOD_GET:
				$request = $request->get();
				break;
			case self::REQUEST_METHOD_POST:
				$request = $request->post();
				break;

			// Caso o método da requisição não seja válido, da erro
			default:
				throw new \Exception("Error While Configuring Request: method selection", 1);
				break;
		}

		// Completa o construtor da classe Response
		parent::__construct( $request );
	}

	public function is_positive()
	{
		if ( ! $this->is_valid() ) {
			return false;
		}
		return true;
	}
}
