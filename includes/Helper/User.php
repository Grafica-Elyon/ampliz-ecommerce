<?php
namespace MisterPrint\Helper;
use MisterPrint\BO\Carrinho;
use MisterPrint\Support\SessionSupport;
use MisterPrint\BO\Cliente;

class User
{
	private $session;

	public function __construct() {
		$this->session = new SessionSupport();
	}

	public function login_user($id, $email)
	{
		if(strpos($_SERVER['HTTP_HOST'], "localhost") != false){
			unset($_SESSION);
		}
		$this->session->set('user_id', $id);
		$this->session->set('user_login', $email);

		return $this->isLogged();
	}

	public function isLogged()
	{
		if($this->session->exists('user_id') && $this->session->exists('user_login')) {
			return true;
		}
		return false;
	}

	public function logout()
	{
		if(strpos($_SERVER['HTTP_HOST'], "localhost") != false){
			unset($_SESSION);
		}
		$this->session->delete('user_id');
		$this->session->delete('user_login');
		return true;
	}

	public function getId()
	{
		if($this->session->exists('user_id')) {
			return $this->session->get('user_id');
		}
		return null;
	}

	public function getEmail()
	{
		if($this->session->exists('user_login')) {
			return $this->session->get('user_login');
		}
		return null;
	}

	public function getData( $force = false )
	{
		if ($this->session->exists('user_id')) {
			$id = $this->getId();
			$transient_key = 'user_data_'.$id;
			if(!$force && $transient_value = get_transient($transient_key)) {
				return $transient_value;
			}
			$user = new Cliente();
			$data = $user->get_dados_do_cliente($id);
			set_transient($transient_key, $data,  5 * MINUTE_IN_SECONDS);
			return $data;
		}
		return false;
	}

	public function isRecadastro()
	{
		$data = $this->getData( true );
		if ( !$data ) {
			return false;
		}
		else {
			return $data['dadosCliente']['customers_recadastro'] == '0';
		}
	}

	public function hasProductInCart()
	{
		if ($this->isLogged()) {
			$cart = $this->getCart();
			return count($cart) > 0;
		}
		return false;
	}

	public function hasShipping()
	{
		$checkout_shipping = SessionSupport::get('checkout-shipping');
		if(isset($checkout_shipping['shipping']) && !empty($checkout_shipping['shipping'])) {
			return true;
		}

		return false;
	}

	public function getCart()
	{
		if ($this->isLogged()) {
			$id = $this->getId();
			// $transient_key = 'user_cart_'.$id;
			// if( $transient_value = get_transient($transient_key) ) {
			// 	return $transient_value;
			// }

			$cartBO = new Carrinho();
			$cart = $cartBO->get_dados_carrinho_de_compras($id);
			$cart = is_array($cart) ? $cart : [];
			$cart = array_map(function ($item) {

				if ( !empty($item['acabamentos']) ) {
					$item['acabamentos'] = array_map(
						function ($acabamento) {
							return $acabamento['nome'];
						},
						$item['acabamentos']
					);
				}

				return [
					'id' => $item['id'],
					'product_id' => $item['produtoId'],
					'name' => $item['nomeProduto'],
					'preco_total' => number_format($item['preco'] + $item['valorEnvioArte'], 2, ',', ''),
					'value' => $item['preco'],
					'valorEnvioArte' => $item['valorEnvioArte'],
					'discount' => $item['discount'],
					'preco_previo' => $item['preco_previo'],
					'weight' => $item['peso'],
					'model' => $item['modelo'],
					'quant' => $item['quantidade'],
					'category' => $item['categoria'],
					'min_quant' => $item['quantidadeMinima'],
					'color' => $item['cor'],
					'cover' => $item['cobertura'],
					'substrate' => $item['substratoDescricao'],
					'format' => $item['formato'],
					'prazo' => $item['prazo'],
					'finishings' => (!empty($item['acabamentos'])) ? $item['acabamentos'] : ['Sem Acabamentos'],
					'images' => isset($item['imagemProduto']) ? [$item['imagemProduto']] : [],
					'art' => $item['tipoEnvio']['title'],
					'imagem' => $item['imagem']
				];
			}, $cart);

			//set_transient($transient_key, $cart, HOUR_IN_SECONDS);

			return $cart;
		}
		return false;
	}

	public function getCartForGtm()
	{
		$cart = $this->getCart();
		return array_map(
			function ($item) {
				return [
					"name" => "{$item['name']} {$item['substrate']} {$item['color']}",
					"id" => $item['product_id'],
					"price" => (float) str_replace(',','.',$item['price']),
					"brand" => "Mister Print",
					"category" => $item['name']
				];
			},
			$cart
		);
	}

	public function getAddress()
	{
		if ($this->isLogged()) {
			$id = $this->getId();
			$transient_key = 'user_address_'.$id;
			if( $transient_value = get_transient($transient_key) ) {
				return $transient_value;
			}
			$address = (new Cliente())->get_endereco_do_cliente($id);
			if($address) {
				set_transient($transient_key, $address, DAY_IN_SECONDS);
			}
			return $address;
		}
		return false;

	}

	public function clearCart()
	{
		if ($this->isLogged()) {
			$transient_key = 'user_cart_'.$this->getId();
			delete_transient( $transient_key );
		}
	}

	public function getIp()
	{
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			//check ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			//to check ip is pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return apply_filters( 'wpb_get_ip', $ip );
	}
}
